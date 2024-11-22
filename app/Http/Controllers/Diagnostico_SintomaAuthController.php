<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Diagnostico_SintomaRegisterRequest;

use App\Models\Diagnostico_Sintoma;

class Diagnostico_SintomaAuthController extends Controller
{
    public function registerDiagnostico_Sintoma(Diagnostico_SintomaRegisterRequest $request)
    {
        $data = $request->validated();

        $diagnostico_sintoma = Diagnostico_Sintoma::create([
            'idDiagnostico' => $data['idDiagnostico'],
            'idSintoma' => $data['idSintoma'],
        ]);

        return response()->json([
            'diagnostico_sintoma' => $diagnostico_sintoma
        ]);

    }
}
