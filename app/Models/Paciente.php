<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Paciente extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'paciente'; // Nombre de la tabla

    protected $primaryKey = 'id'; //

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'NomPac',
        'ApePatPac',
        'ApeMatPac',
        'FechNacPac',
        'GenPac',
        'DirPac',
        'TelPac',
        'FechPac',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'FechNacPac' => 'datetime',
        'FechPac' => 'datetime',
        'password' => 'hashed',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id');
    }
}
