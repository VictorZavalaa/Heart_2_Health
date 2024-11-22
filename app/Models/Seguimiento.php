<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    use HasFactory;

    protected $table = 'seguimiento'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Cambia esto si es necesario

    public $timestamps = false; // Para no crear los campos created_at y updated_at


    protected $fillable = [
        'FechSeg',
        'DetalleSeg',
        'Glucosa',
        'Ritmo_Cardiaco',
        'Presion',
        'idCita',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'idCita');
    }

    protected $casts = [
        'FechSeg' => 'datetime',
        'Glucosa' => 'float',
        'Ritmo_Cardiaco' => 'float',
        'Presion' => 'string',
    ];

}
