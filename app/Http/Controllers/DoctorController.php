<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;


use App\Http\Resources\DoctorResource;


class DoctorController extends Controller
{

    public function index()
    {
        $doctores = Doctor::all();
        return DoctorResource::collection($doctores);
    }

    public function store(StoreDoctorRequest $request)
    {

        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $doctor = Doctor::create($data);

        return response(new DoctorResource($doctor), 201);
    }

    public function show(Doctor $doctore)
    {
        return new DoctorResource($doctore);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctore)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $doctore->update($data);

        return new DoctorResource($doctore);
    }

    public function destroy(Doctor $doctore)
    {
        $doctore->delete(); // Eliminamos el usuario de la base de datos
        
        return response('', 204); // Retornamos una respuesta vacía
    
    }

}
