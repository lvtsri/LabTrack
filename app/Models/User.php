<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Praktikum;
use App\Models\DetailUser;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function detailUser()
    {
        return $this->hasOne(DetailUser::class, 'user_id');
    }

    public function praktikum()
    {
        return $this->belongsToMany(
            Praktikum::class,
            'praktikum_mahasiswa',
            'mahasiswa_id',
            'praktikum_id',
            'id',
            'id_praktikum'
        );
    }

    public function hasCompletedAcademicData(): bool
    {
        return filled($this->detailUser?->nim)
            && filled($this->detailUser?->program_studi)
            && filled($this->detailUser?->kelas_id);
    }
}
