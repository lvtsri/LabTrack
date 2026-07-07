<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Pertemuan;
use App\Models\Praktikum;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $praktikumOptions = Praktikum::where('dosen_id', $request->user()->id)
            ->orderBy('nama_praktikum')
            ->get();

        $pertemuanOptions = Pertemuan::whereHas('praktikum', function ($query) use ($request) {
                $query->where('dosen_id', $request->user()->id);
            })
            ->when($request->filled('praktikum_id'), function ($query) use ($request) {
                $query->where('praktikum_id', $request->praktikum_id);
            })
            ->orderBy('sesi')
            ->get();

        $laporanQuery = Laporan::with([
                'mahasiswa.detailUser',
                'pertemuan.praktikum',
            ])
            ->whereHas('pertemuan.praktikum', function ($query) use ($request) {
                $query->where('dosen_id', $request->user()->id);
            })
            ->latest('tanggal_upload');

        if ($request->filled('praktikum_id')) {
            $laporanQuery->whereHas('pertemuan', function ($query) use ($request) {
                $query->where('praktikum_id', $request->praktikum_id);
            });
        }

        if ($request->filled('pertemuan_id')) {
            $laporanQuery->where('pertemuan_id', $request->pertemuan_id);
        }

        if ($request->filled('status')) {
            $laporanQuery->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;

            $laporanQuery->where(function ($query) use ($search) {
                $query->whereHas('mahasiswa', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhereHas('detailUser', function ($detailQuery) use ($search) {
                            $detailQuery->where('nim', 'like', '%'.$search.'%');
                        });
                })->orWhereHas('pertemuan.praktikum', function ($praktikumQuery) use ($search) {
                    $praktikumQuery->where('nama_praktikum', 'like', '%'.$search.'%');
                });
            });
        }

        $laporan = $laporanQuery->get();

        return view('dosen.laporan.index', compact('laporan', 'praktikumOptions', 'pertemuanOptions'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $laporan->load('pertemuan.praktikum');
        abort_unless((int) $laporan->pertemuan?->praktikum?->dosen_id === (int) $request->user()->id, 403);

        $validated = $request->validate([
            'status' => 'required|in:belum_direview,acc',
        ]);

        $laporan->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
