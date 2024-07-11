<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory;

    // Sesuaikan dengan nama tabel yang digunakan untuk data_admin jika perlu
    protected $table = 'users';

    // Definisikan field yang dapat diisi
    protected $fillable = [
        'username',
        'password',
        'last_login',
        'last_logout',
        'role',
        'device',
        'dToken',
        'mToken',
    ];

    // Field yang tidak boleh diambil
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
