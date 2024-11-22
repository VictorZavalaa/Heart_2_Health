<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeguimientoRequest;
use App\Http\Resources\SeguimientoResource;
use App\Models\Seguimiento;
use App\Http\Requests\UpdateSeguimientoRequest;


use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    
    

    public function getSeguimientosPorCita($id)
    {
        $seguimientos = Seguimiento::where('idCita', $id)
            ->with(['cita.doctor:id,NomDoc,ApePatDoc', 'cita.paciente:id,NomPac,ApePatPac,ApeMatPac'])
            ->get()
            ->map(function($seguimiento) {
                return [
                    'id' => $seguimiento->id,
                    'FechSeg' => $seguimiento->FechSeg,
                    'DetalleSeg' => $seguimiento->DetalleSeg,
                    'Glucosa' => $seguimiento->Glucosa,
                    'Ritmo_Cardiaco' => $seguimiento->Ritmo_Cardiaco,
                    'Presion' => $seguimiento->Presion,
                    'idPac' => $seguimiento->cita->paciente->id,  // Aquí accedes al idPaciente
                    'NomPac' => $seguimiento->cita->paciente->NomPac,  // Aquí accedes al nombre del paciente
                    'idCita' => $seguimiento->idCita,
                    'NomDoc' => $seguimiento->cita->doctor->NomDoc,  // Aquí accedes al nombre del doctor
                    'ApePatDoc' => $seguimiento->cita->doctor->ApePatDoc,  // Apellido del doctor
                ];
            });
    
        return response()->json($seguimientos);
    }

    public function index()
    {
        $seguimientos = Seguimiento::all();
        return response()->json($seguimientos);
    }

    public function store(StoreSeguimientoRequest $request)
    {
        $data = $request->validated();

        $seguimiento = Seguimiento::create($data);

        return response(new SeguimientoResource($seguimiento), 201);
    
    }

    public function show($idC, $id)
    {
        // Encuentra el seguimiento correspondiente a la cita
        $seguimiento = Seguimiento::where('idCita', $idC)->where('id', $id)->first();
    
        if (!$seguimiento) {
            return response()->json(['message' => 'Seguimiento no encontrado'], 404);
        }
    
        return response()->json($seguimiento);
    }
    

    public function update(UpdateSeguimientoRequest $request, $idC, $id)
    {
        // Buscar el seguimiento específico por ID
        $seguimiento = Seguimiento::where('id', $id)->where('idCita', $idC)->first();
    
        // Validar si el seguimiento existe
        if (!$seguimiento) {
            return response()->json(['error' => 'Seguimiento no encontrado'], 404);
        }
    
        // Obtener datos validados desde la solicitud
        $data = $request->validated();
    
        // Actualizar el seguimiento
        $seguimiento->update($data);
    
        // Devolver respuesta con el seguimiento actualizado
        return new SeguimientoResource($seguimiento);
    }
    


    public function destroy(Seguimiento $seguimiento)
    {
        $seguimiento->delete();

        return response('', 204);
    }


}
