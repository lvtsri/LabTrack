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

    public function praktikum()
    {
        return $this->belongsTo(
            Praktikum::class,
            'praktikum_id',
            'id_praktikum'
        );
    }

    public function materi()
    {
        return $this->hasMany(
            Materi::class,
            'pertemuan_id',
            'id_pertemuan'
        );
    }

    public function laporan()
    {
        return $this->hasMany(
            Laporan::class,
            'pertemuan_id',
            'id_pertemuan'
        );
    }
}
