<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Laporan;
use App\Models\Pertemuan;
use App\Models\Praktikum;

class PraktikumController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load(
            'detailUser.kelas.praktikum.dosen'
        );

        $praktikum = $user->detailUser?->kelas?->praktikum ?? collect();

        return view(
            'mahasiswa.praktikum.index',
            compact('praktikum')
        );
    }

    public function show(Request $request, Praktikum $praktikum)
    {
        $praktikum->load([
            'dosen',
            'kelas',
            'pertemuan' => function($query){
                $query->orderBy('sesi');
            },
            'pertemuan.materi',
            'pertemuan.laporan' => function ($query) use ($request) {
                $query->where('mahasiswa_id', $request->user()->id);
            },
        ]);

        return view('mahasiswa.praktikum.show', compact('praktikum'));
    }

    public function uploadLaporan(Request $request, Praktikum $praktikum, Pertemuan $pertemuan)
    {
        abort_unless((int) $pertemuan->praktikum_id === (int) $praktikum->id_praktikum, 404);
        abort_unless((bool) $pertemuan->wajib_laporan, 403);

        $user = $request->user()->load('detailUser');
        abort_unless((int) $praktikum->kelas_id === (int) $user->detailUser?->kelas_id, 403);

        $validated = $request->validate([
            'file_laporan' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'file_laporan.required' => 'Pilih file laporan terlebih dahulu.',
            'file_laporan.mimes' => 'File laporan wajib berformat PDF.',
            'file_laporan.max' => 'Ukuran file laporan maksimal 10 MB.',
        ]);

        $laporan = Laporan::where('pertemuan_id', $pertemuan->id_pertemuan)
            ->where('mahasiswa_id', $user->id)
            ->first();

        if ($laporan?->file_laporan) {
            Storage::disk('public')->delete($laporan->file_laporan);
        }

        $originalName = $validated['file_laporan']->getClientOriginalName();
        $safeName = preg_replace('/[\/\\\\:*?"<>|]/', '-', $originalName);

        $path = $validated['file_laporan']->storeAs(
            'laporan/'.$user->id.'/pertemuan-'.$pertemuan->id_pertemuan,
            $safeName,
            'public'
        );

        Laporan::updateOrCreate(
            [
                'pertemuan_id' => $pertemuan->id_pertemuan,
                'mahasiswa_id' => $user->id,
            ],
            [
                'file_laporan' => $path,
                'status' => 'belum_direview',
                'tanggal_upload' => now(),
            ]
        );

        return back()->with('success', 'Laporan berhasil diupload.');
    }
}
