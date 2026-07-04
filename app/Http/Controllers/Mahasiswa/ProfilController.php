<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsersModel;

class ProfilController extends Controller
{
    public function index(){
            $user = UsersModel::find(5);

        return view('mahasiswa.profil.index', compact('user'));
    }

    // public function update(){
    //     return view('mahasiswa.profil.edit');
    // }
}
