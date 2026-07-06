<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('detailUser.kelas.praktikum');

        $praktikumOptions = $user->detailUser?->kelas?->praktikum ?? collect();

        $laporanQuery = Laporan::query()
            ->with(['pertemuan.praktikum'])
            ->where('mahasiswa_id', $user->id)
            ->latest('tanggal_upload');

        if ($request->filled('praktikum_id')) {
            $laporanQuery->whereHas('pertemuan', function ($query) use ($request) {
                $query->where('praktikum_id', $request->praktikum_id);
            });
        }

        if ($request->filled('status')) {
            $laporanQuery->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;

            $laporanQuery->where(function ($query) use ($search) {
                $query->whereHas('pertemuan.praktikum', function ($praktikumQuery) use ($search) {
                    $praktikumQuery->where('nama_praktikum', 'like', '%'.$search.'%');
                })->orWhereHas('pertemuan', function ($pertemuanQuery) use ($search) {
                    $pertemuanQuery->where('judul', 'like', '%'.$search.'%')
                        ->orWhere('sesi', 'like', '%'.$search.'%');
                });
            });
        }

        $laporan = $laporanQuery->get();

        $arsipGroups = [
            'Hari ini' => $laporan->filter(fn ($item) => $item->tanggal_upload?->isToday()),
            'Seminggu yang lalu' => $laporan->filter(function ($item) {
                return $item->tanggal_upload
                    && $item->tanggal_upload->isBefore(today())
                    && $item->tanggal_upload->isAfter(now()->subWeek());
            }),
            'Sebulan yang lalu' => $laporan->filter(function ($item) {
                return $item->tanggal_upload
                    && $item->tanggal_upload->isBefore(now()->subWeek())
                    && $item->tanggal_upload->isAfter(now()->subMonth());
            }),
        ];

        $olderReports = $laporan->filter(fn ($item) => $item->tanggal_upload?->isBefore(now()->subMonth()));

        if ($olderReports->isNotEmpty()) {
            $arsipGroups['Lebih lama'] = $olderReports;
        }

        return view('mahasiswa.arsip.index', compact('arsipGroups', 'praktikumOptions'));
    }
}
