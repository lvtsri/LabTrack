<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Kelas;

class LengkapiDataController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user()->load('detailUser');

        if ($user->hasCompletedAcademicData()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mahasiswa.lengkapi-data', compact('user', 'kelas'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:30'],
            'program_studi' => ['required', 'string', 'max:100'],
            'kelas_id' => ['required','exists:kelas,id_kelas'],
        ]);

        $user->detailUser()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('mahasiswa.dashboard');
    }
}