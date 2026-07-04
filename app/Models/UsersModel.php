<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'nim',
        'nip',
        'email',
        'personal_email',
        'password',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'phone',
        'profile_photo',
        'role'
    ];
}
