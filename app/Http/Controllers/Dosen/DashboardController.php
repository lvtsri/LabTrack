<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Praktikum;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dosenId = $request->user()->id;

        // Praktikum dosen
        $praktikum = Praktikum::with('kelas')
            ->where('dosen_id', $dosenId)
            ->get();

        $praktikumIds = $praktikum->pluck('id_praktikum');

        // Laporan Masuk
        $totalLaporan = Laporan::whereHas('pertemuan', function ($query) use ($praktikumIds) {
            $query->whereIn('praktikum_id', $praktikumIds);
        })->count();

        // Belum direview
        $belumDireview = Laporan::where('status', 'belum_direview')
            ->whereHas('pertemuan', function ($query) use ($praktikumIds) {
                $query->whereIn('praktikum_id', $praktikumIds);
            })
            ->count();

        // Jumlah praktikum
        $jumlahPraktikum = $praktikum->count();

        // Laporan terbaru
        $laporanTerbaru = Laporan::with([
                'mahasiswa',
                'pertemuan.praktikum.kelas'
            ])
            ->whereHas('pertemuan', function ($query) use ($praktikumIds) {
                $query->whereIn('praktikum_id', $praktikumIds);
            })
            ->latest('tanggal_upload')
            ->take(5)
            ->get();

        return view('dosen.dashboard.index', compact(
            'totalLaporan',
            'belumDireview',
            'jumlahPraktikum',
            'praktikum',
            'laporanTerbaru'
        ));
    }
}