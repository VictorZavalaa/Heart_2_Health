<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sintoma extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'sintoma';
    protected $primaryKey = 'id';

    public $timestamps = false; // Para no crear los campos created_at y updated_at

    protected $fillable = [
        'NomSintoma',
        'DescSintoma',
    ];

    protected $casts = [
        'NomSintoma' => 'string',
        'DescSintoma' => 'string',
    ];

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico_Sintoma::class, 'idSintoma');
    }
}
