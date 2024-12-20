<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    //Campos que se pueden llenar de manera masiva
    protected $fillable = [
        'name',
        'email',
        'password',

        //Campos nuevos agregados
       'firstLastName',
        'secondLastName',
        'curp',
        'birthDate',
        'phone',
        'state',
        'municipality',
        'colony',
        'code_postal',
        'street',
        'rfc',
        ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
