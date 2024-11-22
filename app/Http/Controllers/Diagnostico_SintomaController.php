<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDiagnostico_SintomaRequest;
use App\Http\Resources\Diagnostico_SintomaResource;
use Illuminate\Http\Request;
use App\Models\Diagnostico_Sintoma;

class Diagnostico_SintomaController extends Controller
{
    
    public function index()
    {
        $diagnostico_sintomas = Diagnostico_Sintoma::all();
        return response()->json($diagnostico_sintomas);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $diagnostico_sintoma = Diagnostico_Sintoma::create($data);
        return response(new Diagnostico_SintomaResource($diagnostico_sintoma), 201);

    }

    public function show(Diagnostico_Sintoma $diagnostico_sintoma)
    {
        return new Diagnostico_SintomaResource($diagnostico_sintoma);
    }

    public function update(UpdateDiagnostico_SintomaRequest $request, Diagnostico_Sintoma $diagnostico_sintoma)
    {
        $data = $request->validated();
        $diagnostico_sintoma->update($data);
        return new Diagnostico_SintomaResource($diagnostico_sintoma);
    }

    public function destroy(Diagnostico_Sintoma $diagnostico_sintoma)
    {
        $diagnostico_sintoma->delete();
        return response('', 204);
    }

}
