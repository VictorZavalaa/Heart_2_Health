<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Http\Resources\PacienteResource;



class PacienteController extends Controller
{

    public function index()
    {
        $pacientes = Paciente::all();
        return PacienteResource::collection($pacientes);
    }

    public function store(StorePacienteRequest $request)
    {

        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $paciente = Paciente::create($data);

        return response(new PacienteResource($paciente), 201);
    }

    public function show(Paciente $paciente)
    {
        return new PacienteResource($paciente);
    }


    public function update(UpdatePacienteRequest $request, Paciente $paciente)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $paciente->update($data);

        return new PacienteResource($paciente);
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete(); // Eliminamos el usuario de la base de datos
        
        return response('', 204); // Retornamos una respuesta vacía
    
    }


}
