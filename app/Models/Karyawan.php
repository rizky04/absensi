<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'karyawans';
    protected $primaryKey = "nik";
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jabatan',
        'email',
        'no_hp',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        // ...
    ];
}
