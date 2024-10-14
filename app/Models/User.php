<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $table = 'usuarios';
    protected $fillable = [
        'usuario',
        'email',
        'password',
        'rol',
        'profesor_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
