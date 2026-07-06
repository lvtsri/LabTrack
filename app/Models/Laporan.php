<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'pertemuan_id',
        'mahasiswa_id',
        'file_laporan',
        'status',
        'tanggal_upload',
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'pertemuan_id', 'id_pertemuan');
    }

    public function getStatusLabelAttribute()
    {
        return $this->status === 'acc' ? 'Selesai' : 'Belum direview';
    }
}
