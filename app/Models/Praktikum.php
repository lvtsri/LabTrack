<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Praktikum extends Model
{
    protected $table = 'praktikum';

    protected $primaryKey = 'id_praktikum';

    protected $fillable = [
        'nama_praktikum',
        'kelas_id',
        'dosen_id',
        'semester'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(
            User::class,
            'praktikum_mahasiswa',
            'praktikum_id',
            'mahasiswa_id',
            'id_praktikum',
            'id'
        );
    }

    public function pertemuan()
    {
        return $this->hasMany(Pertemuan::class, 'praktikum_id', 'id_praktikum');
    }
}