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
        if (!$this->tanggal_pertemuan || !$this->jam_mulai || !$this->jam_selesai) {
            return 'terjadwal';
        }

        $timezone = config('app.timezone', 'Asia/Jakarta');
        $now = now($timezone);

        $tanggal = $this->tanggal_pertemuan->format('Y-m-d');
        $jamMulai = $this->jam_mulai instanceof \Carbon\CarbonInterface
            ? $this->jam_mulai->format('H:i:s')
            : $this->jam_mulai;
        $jamSelesai = $this->jam_selesai instanceof \Carbon\CarbonInterface
            ? $this->jam_selesai->format('H:i:s')
            : $this->jam_selesai;

        $mulai = \Carbon\Carbon::parse($tanggal.' '.$jamMulai, $timezone);
        $selesai = \Carbon\Carbon::parse($tanggal.' '.$jamSelesai, $timezone);

        if ($now->lt($mulai)) {
            return 'terjadwal';
        }

        if ($now->gt($selesai)) {
            return 'selesai';
        }

        return 'berlangsung';
    }
}
