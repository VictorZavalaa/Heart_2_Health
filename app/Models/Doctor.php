<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'doctor'; // Nombre de la tabla

    protected $primaryKey = 'id'; //

    protected $fillable = [
        'NomDoc',
        'ApePatDoc',
        'ApeMatDoc',
        'FechNacDoc',
        'GenDoc',
        'DirDoc',
        'TelDoc',
        'Especialidad',
        'FechDoc',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'FechNacDoc' => 'datetime',
        'FechDoc' => 'datetime',
        'password' => 'hashed',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id');
    }
}
