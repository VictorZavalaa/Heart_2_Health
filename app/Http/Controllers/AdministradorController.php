<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

use App\Http\Resources\AdministradorResource;

use App\Models\Administrador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdministradorController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //PARA QUE SOLO ME REGRESE UN ADMINISTRADOR
        $administradores = Administrador::all();
        return AdministradorResource::collection($administradores);
    }


    public function indexPdf()
    {
        $administradores = DB::table('administrador')->get(); // Obtenemos todos los administradores de la base de datos

        $pdf = PDF::loadView('administradores', ['administradores' => $administradores]); // Creamos el PDF con los administradores

        //return $pdf->stream(); // Mostramos el PDF en el navegador

        return $pdf->download('administradores.pdf'); // Descargamos el PDF
    }










    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated(); // Validamos los datos obtenidos del request

        $data['password'] = bcrypt($data['password']); // Encriptamos la contraseña

        $admin = Administrador::create($data); // Creamos el usuario en la base de datos

        return response(new AdministradorResource($admin), 201); // Retornamos el usuario creado

    }

    /**
     * Display the specified resource.
     */
    public function show(Administrador $administradore)
    {
        return new AdministradorResource($administradore);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Administrador $administradore)
    {

        $data = $request->validated(); // Validamos los datos obtenidos del request

        // Si se envió una nueva contraseña, la encriptamos
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $administradore->update($data); // Actualizamos el usuario en la base de datos

        //Guardar en el log
        Log::info('Administrador actualizado', ['administradore' => $administradore]);

        return new AdministradorResource($administradore); // Retornamos el usuario actualizado
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Administrador $administradore)
    {
        $administradore->delete(); // Eliminamos el usuario de la base de datos
        
        return response('', status: 204); // Retornamos una respuesta vacía
    
    }

}
