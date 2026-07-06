<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Pertemuan;
use App\Models\Praktikum;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('detailUser');
        $kelasId = $user->detailUser?->kelas_id;

        $praktikumQuery = Praktikum::query()
            ->with('dosen')
            ->when($kelasId, fn ($query) => $query->where('kelas_id', $kelasId));

        $praktikumAktif = (clone $praktikumQuery)->count();

        $praktikumTerbaru = (clone $praktikumQuery)
            ->latest('updated_at')
            ->take(3)
            ->get();

        $praktikumIds = (clone $praktikumQuery)->pluck('id_praktikum');

        $totalLaporanDikumpulkan = Laporan::where('mahasiswa_id', $user->id)->count();

        $laporanBelumDikumpulkan = Pertemuan::whereIn('praktikum_id', $praktikumIds)
            ->where('wajib_laporan', true)
            ->whereDoesntHave('laporan', function ($query) use ($user) {
                $query->where('mahasiswa_id', $user->id);
            })
            ->count();

        $deadlineMendatang = Pertemuan::with('praktikum')
            ->whereIn('praktikum_id', $praktikumIds)
            ->where('wajib_laporan', true)
            ->whereNotNull('deadline')
            ->where('deadline', '>=', now())
            ->whereDoesntHave('laporan', function ($query) use ($user) {
                $query->where('mahasiswa_id', $user->id);
            })
            ->orderBy('deadline')
            ->take(4)
            ->get();

        return view('mahasiswa.dashboard.index', compact(
            'praktikumAktif',
            'totalLaporanDikumpulkan',
            'laporanBelumDikumpulkan',
            'praktikumTerbaru',
            'deadlineMendatang'
        ));
    }
}
