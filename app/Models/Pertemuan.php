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
        'tanggal_pertemuan',
        'jam_mulai',
        'jam_selesai',
        'wajib_laporan',
        'deadline'
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'deadline' => 'datetime',
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

    public function getJumlahLaporanMasukAttribute()
    {
        return $this->laporan()->count();
    }

    public function getStatusAttribute()
    {
        if (!$this->deadline) {
            return 'draft';
        }

        if (now()->lt($this->created_at)) {
            return 'terjadwal';
        }

        if (now()->gt($this->deadline)) {
            return 'selesai';
        }

        return 'berlangsung';
    }
}
