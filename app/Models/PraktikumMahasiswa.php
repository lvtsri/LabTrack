<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraktikumMahasiswa extends Model
{
    protected $table = 'praktikum_mahasiswa';

    protected $primaryKey = 'id_praktikum_mhs';

    protected $fillable = [
        'praktikum_id',
        'mahasiswa_id'
    ];
}