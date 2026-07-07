<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kelas;

class DetailUser extends Model
{
    protected $table = 'detail_users';

    protected $fillable = [
        'user_id',
        'nip',
        'nim',
        'program_studi',
        'kelas_id',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'email_pribadi',
        'no_hp',
        'foto_profil',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }
}