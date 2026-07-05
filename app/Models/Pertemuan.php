<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'pertemuan';

    protected $primaryKey = 'id_pertemuan';

    protected $fillable = [
        'praktikum_id',
        'sesi',
        'judul',
        'deskripsi',
        'wajib_laporan',
        'deadline'
    ];
}