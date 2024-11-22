<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'cita'; // Nombre de la tabla

    protected $primaryKey = 'id'; // Cambia esto si es necesario


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'FechaYHoraInicioCita',
        'FechaYHoraFinCita',
        'MotivoCita',
        'EstadoCita',
        'idPaciente',
        'idDoctor',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'idPaciente');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'idDoctor');
    }

    public function recomendaciones()
    {
        return $this->hasMany(Recomendacion::class, 'idCita');
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'idCita');
    }



    protected $casts = [
        'FechaYHoraInicioCita' => 'datetime',
        'FechaYHoraFinCita' => 'datetime',
    ];
}
