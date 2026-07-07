<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Praktikum;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Pertemuan;

class PraktikumController extends Controller
{
    public function index(Request $request)
    {
        $praktikum = Praktikum::where(
            'dosen_id',
            $request->user()->id
        )
        ->with('kelas')
        ->orderBy('semester')
        ->get();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view(
            'dosen.praktikum.index',
            compact('praktikum','kelas')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_praktikum'=>'required',
            'semester'=>'required|integer|min:1|max:8',
            'kelas_id'=>'required|exists:kelas,id_kelas'
        ]);

        $validated['dosen_id']=$request->user()->id;

        Praktikum::create($validated);

        return back()->with('success','Praktikum berhasil ditambahkan.');
    }

    public function update(Request $request, Praktikum $praktikum)
    {
        $this->authorizePraktikumOwner($request, $praktikum);

        $validated = $request->validate([
            'nama_praktikum' => 'required|max:150',
            'semester' => 'required|integer|min:1|max:8',
            'kelas_id' => 'required|exists:kelas,id_kelas',
        ]);

        $praktikum->update($validated);

        return back()->with('success', 'Praktikum berhasil diperbarui.');
    }

    public function show(Request $request, Praktikum $praktikum)
    {
        $this->authorizePraktikumOwner($request, $praktikum);

        $praktikum->load([
            'kelas',
            'dosen',
            'pertemuan' => function($query){
                $query->orderBy('sesi');
            },
            'pertemuan.materi',
            'pertemuan.laporan',
        ]);

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jumlahMahasiswa = $praktikum->kelas?->mahasiswa()->count() ?? 0;

        return view('dosen.praktikum.show', compact('praktikum', 'kelas', 'jumlahMahasiswa'));
    }

    public function createPertemuan(Request $request, Praktikum $praktikum)
    {
        $this->authorizePraktikumOwner($request, $praktikum);

        $validated = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'nullable',
            'tanggal_pertemuan' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'wajib_laporan' => 'required|boolean',
            'deadline' => 'nullable|date',
            'materi' => 'nullable|file|max:10240',
            'link_materi' => 'nullable|url',
        ]);

        $pertemuanData = collect($validated)->except(['materi', 'link_materi'])->all();
        $pertemuanData['praktikum_id'] = $praktikum->id_praktikum;
        $pertemuanData['sesi'] = ($praktikum->pertemuan()->max('sesi') ?? 0) + 1;

        $pertemuan = Pertemuan::create($pertemuanData);
        $this->storeMateriIfPresent($request, $pertemuan);

        return back()->with('success', 'Sesi berhasil ditambahkan.');
    }

    public function updatePertemuan(Request $request, Praktikum $praktikum, Pertemuan $pertemuan)
    {
        $this->authorizePraktikumOwner($request, $praktikum);
        abort_unless((int) $pertemuan->praktikum_id === (int) $praktikum->id_praktikum, 404);

        $validated = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'nullable',
            'tanggal_pertemuan' => 'nullable|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'wajib_laporan' => 'required|boolean',
            'deadline' => 'nullable|date',
            'materi' => 'nullable|file|max:10240',
            'link_materi' => 'nullable|url',
        ]);

        $pertemuan->update(
            collect($validated)->except(['materi', 'link_materi'])->all()
        );

        $this->storeMateriIfPresent($request, $pertemuan);

        return back()->with('success', 'Sesi berhasil diperbarui.');
    }

    public function showDetail(Request $request, Praktikum $praktikum, Pertemuan $pertemuan)
    {
        $this->authorizePraktikumOwner($request, $praktikum);
        abort_unless((int) $pertemuan->praktikum_id === (int) $praktikum->id_praktikum, 404);

        $praktikum->load('kelas');
        $pertemuan->load([
            'materi',
            'laporan.mahasiswa.detailUser',
        ]);

        $jumlahMahasiswa = $praktikum->kelas?->mahasiswa()->count() ?? 0;

        return view('dosen.praktikum.show-detail', compact('praktikum', 'pertemuan', 'jumlahMahasiswa'));
    }

    private function authorizePraktikumOwner(Request $request, Praktikum $praktikum): void
    {
        abort_unless((int) $praktikum->dosen_id === (int) $request->user()->id, 403);
    }

    private function storeMateriIfPresent(Request $request, Pertemuan $pertemuan): void
    {
        if ($request->hasFile('materi')) {
            $file = $request->file('materi');
            $path = $file->store('materi', 'public');
            $extension = strtolower($file->getClientOriginalExtension());

            Materi::create([
                'pertemuan_id' => $pertemuan->id_pertemuan,
                'nama_materi' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $path,
                'tipe' => match ($extension) {
                    'pdf' => 'pdf',
                    'mp4', 'mov', 'avi', 'mkv' => 'video',
                    default => 'dokumen',
                },
            ]);
        }

        if ($request->filled('link_materi')) {
            Materi::create([
                'pertemuan_id' => $pertemuan->id_pertemuan,
                'nama_materi' => 'Link Materi',
                'link_materi' => $request->link_materi,
                'tipe' => 'link',
            ]);
        }
    }

}
