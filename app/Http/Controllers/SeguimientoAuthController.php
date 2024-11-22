<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeguimientoRegisterRequest;

use App\Models\Seguimiento;

use Illuminate\Http\Request;

class SeguimientoAuthController extends Controller
{
    
    public function registerSeguimiento(SeguimientoRegisterRequest $request)
    {

        $data = $request->validated();

        $seguimiento = Seguimiento::create([
            'FechSeg' => $data['FechSeg'],
            'DetalleSeg' => $data['DetalleSeg'],
            'Glucosa' => $data['Glucosa'],
            'Ritmo_Cardiaco' => $data['Ritmo_Cardiaco'],
            'Presion' => $data['Presion'],
            'idCita' => $data['idCita'],
        ]);

        return response()->json([
            'seguimiento' => $seguimiento
        ]);


    }


}
