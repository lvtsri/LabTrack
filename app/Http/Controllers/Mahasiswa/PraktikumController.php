<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Praktikum;

class PraktikumController extends Controller
{
    public function index()
    {
        $praktikum = Auth::user()
            ->praktikum()
            ->with('dosen')
            ->get();

        return view('mahasiswa.praktikum.index', compact('praktikum'));
    }
}