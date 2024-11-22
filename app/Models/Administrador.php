<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Administrador extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'administrador';

    protected $primaryKey = 'idAdmin'; // Cambia esto si es necesario


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'NomAdmin',
        'ApePatAdmin',
        'ApeMatAdmin',
        'FechaNacAdmin',
        'TelAdmin',
        'FechAdmin',
        'email',
        'password',
        'role',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'FechaNacAdmin' => 'datetime',
        'FechAdmin' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Indica el nombre del campo de identificación para la autenticación.
     *
     * @return string
     */
}
