<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas'
    ];

    public function detailUsers()
    {
        return $this->hasMany(DetailUser::class, 'kelas_id', 'id_kelas');
    }

    public function praktikum()
    {
        return $this->hasMany(Praktikum::class, 'kelas_id', 'id_kelas');
    }
}