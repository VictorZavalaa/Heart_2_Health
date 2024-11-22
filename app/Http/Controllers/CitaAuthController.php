<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CitaRegisterRequest;

use App\Models\Cita;

class CitaAuthController extends Controller
{
    public function registerCita(CitaRegisterRequest $request)
    {
        $data = $request->validated();

        $cita = Cita::create([
            'FechaYHoraInicioCita' => $data['FechaYHoraInicioCita'],
            'FechaYHoraFinCita' => $data['FechaYHoraFinCita'],
            'MotivoCita' => $data['MotivoCita'],
            'EstadoCita' => $data['EstadoCita'],
            'idPaciente' => $data['idPaciente'],
            'idDoctor' => $data['idDoctor'],
        ]);

        return response()->json([
            'cita' => $cita
        ]);

    }
    
}
