<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitaRequest;
use App\Http\Resources\CitaResource;
use App\Http\Requests\UpdateCitaRequest;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{

    public function getCitas()
    {
        //$citas = Cita::with(['paciente', 'doctor'])->get(); // Si se quiere obtener los datos de las relaciones
        $citas = Cita::all(['FechaYHoraInicioCita as start', 'FechaYHoraFinCita as end', 'MotivoCita as title']);
        return response()->json($citas);
    }


    //Obtener las citas de un paciente con un id específico
    public function getCitasPorPaciente($id)
    {
        $citas = Cita::where('idPaciente', $id)
            ->with(['doctor:id,NomDoc', 'paciente:id,NomPac'])
            ->get()
            ->map(function ($cita) {
                return [
                    'id' => $cita->id,
                    'motivo' => $cita->MotivoCita,
                    'start' => $cita->FechaYHoraInicioCita,
                    'end' => $cita->FechaYHoraFinCita,
                    'title' => $cita->MotivoCita,
                    'Doc' => $cita->doctor->NomDoc,
                    'Pac' => $cita->paciente->NomPac,
                    'Estado' => $cita->EstadoCita,
                ];
            });

        return response()->json($citas);
    }




    //Obtener las citas de un doctor con un id específico con los nombres del doctor y paciente
    public function getCitasPorDoctor($id)
    {
        $citas = Cita::where('idDoctor', $id)
            ->with(['doctor:id,NomDoc', 'paciente:id,NomPac'])
            ->get()
            ->map(function ($cita) {
                return [
                    'id' => $cita->id,
                    'motivo' => $cita->MotivoCita,
                    'start' => $cita->FechaYHoraInicioCita,
                    'end' => $cita->FechaYHoraFinCita,
                    'title' => $cita->MotivoCita,
                    'Doc' => $cita->doctor->NomDoc,
                    'Pac' => $cita->paciente->NomPac,
                    'Estado' => $cita->EstadoCita,
                ];
            });

        return response()->json($citas);
    }

    //Obtener nombre y id del paciente de una cita
    public function getPacienteDeCita($id)
    {
        $citas = Cita::where('id', $id)
            ->with('paciente:id,NomPac')
            ->get()
            ->map(function ($cita) {
                return [
                    'idPaciente' => $cita->paciente->id,
                    'NomPac' => $cita->paciente->NomPac,
                ];
            });

        return response()->json($citas);
    }



    /*

    //Sencilla

    //Obtener las citas de un doctor con un id específico
    public function getCitasPorDoctor($id)
    {
        $citas = Cita::where('idDoctor', $id)->get();
        return response()->json($citas);
    }

    */

    public function index()
    {
        $citas = Cita::all();
        return response()->json($citas);
    }

    public function store(StoreCitaRequest $request)
    {
        $data = $request->all();

        $cita = Cita::create($data);

        return response(new CitaResource($cita), 201);
    }

    public function show(Cita $cita)
    {
        return new CitaResource($cita);
    }

    public function update(UpdateCitaRequest $request, Cita $cita)
    {
        $data = $request->validated();

        $cita->update($data);

        return new CitaResource($cita);
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();

        return response('', 204);
    }
}
