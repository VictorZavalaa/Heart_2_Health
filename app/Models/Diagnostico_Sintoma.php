<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico_Sintoma extends Model
{
    use HasFactory;

    protected $table = 'diagnostico_sintoma'; // Nombre de la tabla;
    protected $primaryKey = 'id'; // Cambia esto si es necesario
    public $timestamps = false; // Para no crear los campos created_at y updated_at

    protected $fillable = [
        'idPaciente',
        'idSintoma',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'idPaciente');

    }

    public function sintoma()
    {
        return $this->belongsTo(Sintoma::class, 'idSintoma');
    }

    


}
