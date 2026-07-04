<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index(){
        return view('mahasiswa.arsip.index');
    }
}
