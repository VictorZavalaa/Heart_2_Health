<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    use HasFactory;

    protected $table = 'recomendacion'; // Nombre de la tabla
    protected $primaryKey = 'id'; //
    public $timestamps = false; // Para no crear los campos created_at y updated_at


    protected $fillable = [
        'DesRec',
        'FechRec',
        'idCita',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'idCita');
    }

    protected $casts = [
        'FechRec' => 'datetime',
    ];

}
