<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecomendacionRegisterRequest;

use App\Models\Recomendacion;

use Illuminate\Http\Request;



class RecomendacionAuthController extends Controller
{
    
    public function registerRecomendacion(RecomendacionRegisterRequest $request)
    {

        $data = $request->validated();

        $recomendacion = Recomendacion::create([
            'DesRec' => $data['DesRec'],
            'FechRec' => $data['FechRec'],
            'idCita' => $data['idCita'],
        ]);

        return response()->json([
            'recomendacion' => $recomendacion
        ]);
    }

}
