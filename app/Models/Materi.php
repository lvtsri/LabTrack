<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';

    protected $primaryKey = 'id_materi';

    protected $fillable = [
        'pertemuan_id',
        'nama_materi',
        'file_path',
        'link_materi',
        'tipe'
    ];

    public function pertemuan()
    {
        return $this->belongsTo(
            Pertemuan::class,
            'pertemuan_id',
            'id_pertemuan'
        );
    }

    public function getUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/'.$this->file_path);
        }

        return $this->link_materi;
    }

    public function getIconAttribute()
    {
        return match($this->tipe){
            'pdf' => 'fa-file-pdf',
            'video' => 'fa-circle-play',
            'link' => 'fa-link',
            default => 'fa-file-lines'
        };
    }
}