<?php

namespace App\Http\Controllers;

use App\Http\Requests\SintomaRegisterRequest;
use Illuminate\Http\Request;

use App\Models\Sintoma;

class SintomaAuthController extends Controller
{
    public function registerSintoma(SintomaRegisterRequest $request)
    {
        $data = $request->validated();

        $sintoma = Sintoma::create([
            'NomSintoma' => $data['NomSintoma'],
            'DescSintoma' => $data['DescSintoma'],
        ]);

        return response()->json([
            'sintoma' => $sintoma
        ]);

    }

}
