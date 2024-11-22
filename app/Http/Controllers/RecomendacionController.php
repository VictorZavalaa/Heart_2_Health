<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecomendacionRequest;
use App\Http\Requests\UpdateRecomendacionRequest;
use App\Http\Resources\RecomendacionResource;
use App\Models\Recomendacion;


use Illuminate\Http\Request;

class RecomendacionController extends Controller
{

    public function getRecomendacionesPorCita($id)
    {
        $recomendaciones = Recomendacion::where('idCita', $id)
            ->get()
            ->map(function($recomendacion) {
                return [
                    'id' => $recomendacion->id,
                    'DesRec' => $recomendacion->DesRec,
                    'FechRec' => $recomendacion->FechRec,
                    'idCita' => $recomendacion->idCita,
                ];
            });
    
        return response()->json($recomendaciones);
        
    }
    
    public function index()
    {
        $recomendacione = Recomendacion::all();
        return response()->json($recomendacione);
    }

    public function store(StoreRecomendacionRequest $request)
    {
        $data = $request->validated();

        $recomendacione = Recomendacion::create($data);

        return response(new RecomendacionResource($recomendacione), 201);
    
    }

    public function show($idC, $id)
    {
        // Encuentra la recomendacion correspondiente a la cita
        $recomendacione = Recomendacion::where('idCita', $idC)->where('id', $id)->first();

        if (!$recomendacione) {
            return response()->json(['message' => 'Recomendación no encontrado'], 404);
        }

        return response()->json($recomendacione);
    }

    public function update(UpdateRecomendacionRequest $request, $idC, $id)
    {
        $recomendacione = Recomendacion::where('idCita', $idC)->where('id', $id)->first();

        if (!$recomendacione) {
            return response()->json(['message' => 'Recomendación no encontrado'], 404);
        }

        $data = $request->validated();

        $recomendacione->update($data);

        return new RecomendacionResource($recomendacione);
    }

    public function destroy(Recomendacion $recomendacione)
    {

        $recomendacione->delete();

        return response('', 204);
    }

}
