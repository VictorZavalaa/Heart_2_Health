<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SintomaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Diagnostico_SintomaController;

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\PacienteAuthController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\SeguimientoController;


use App\Http\Controllers\DatabaseExportController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\RecomendacionController;
use App\Http\Controllers\RestoreController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Prueba


Route::middleware('auth:sanctum, role:admin')->group(function () { //Rutas para administrador


    //Para obtener los datos del administrador autenticado
    Route::get('/administrador', function (Request $request) {
        return response()->json($request->user());
    });


    // Para hacer operaciones CRUD de administradores, doctores
    Route::apiResource('/administradores', AdministradorController::class);
    Route::apiResource('/doctores', DoctorController::class);


    //Cerrar sesión administrador
    Route::post('/logoutAdmin', [AdminController::class, 'logoutAdmin']);













    // Para obtener las citas (solo accesible por administradores)
    Route::get('citas', [CitaController::class, 'getCitas']);
});


Route::middleware(['auth:sanctum, role:doctor'])->group(function () { //Rutas para doctor


    //Para obtener los datos del doctor autenticado
    Route::get('/doctor', function (Request $request) {
        return response()->json($request->user());
    });


    //Obtener citas de un doctor
    Route::get('/doctores/{id}/citas', [CitaController::class, 'getCitasPorDoctor']);


    //Cerrar sesión doctor
    Route::post('/logoutDoctor', [DoctorAuthController::class, 'logoutDoctor']);


    //Para hacer operaciones CRUD de citas, seguimientos y diagnósticos de sintoma
    Route::apiResource('/citas', CitaController::class);
    Route::apiResource('/seguimientos', SeguimientoController::class);
    Route::apiResource('/diagnostico_sintoma', Diagnostico_SintomaController::class);
    Route::apiResource('/recomendaciones', RecomendacionController::class);

    //Obtener datos del usuario autenticado (doctor)
    Route::get('/auth/user', function () {
        return auth()->user(); // Devuelve los datos del usuario autenticado
    });

    //Obtener nombre y id del paciente por la cita
    Route::get('/doctor/citas/{idC}', [CitaController::class, 'getPacienteDeCita']);

    //Update de cita
    Route::put('/doctor/citas/{idC}/seguimientos/{id}', [SeguimientoController::class, 'update']);


    //Obtener seguimientos de una cita
    Route::get('/doctor/citas/{idC}/seguimientos/{id}', [SeguimientoController::class, 'show']);


    //Obtener seguimientos de una cita
    Route::get('/doctor/citas/{id}/seguimientos', [SeguimientoController::class, 'getSeguimientosPorCita']);

    //Obtener recomendaciones de una cita
    Route::get('/doctor/citas/{idC}/recomendaciones/{id}', [RecomendacionController::class, 'show']);
    
    //Obtener recomendaciones de una cita
    Route::get('/doctor/citas/{id}/recomendaciones', [RecomendacionController::class, 'getRecomendacionesPorCita']);

    //Update recomendacion
    Route::put('/doctor/citas/{idC}/recomendaciones/{id}', [RecomendacionController::class, 'update']);

});


Route::middleware('auth:sanctum, role:paciente')->group(function () { //Rutas para paciente

    //Para obtener los datos del paciente autenticado
    Route::get('/paciente', function (Request $request) {
        return response()->json($request->user());
    });


    //Obtener citas de un paciente
    Route::get('/pacientes/{id}/citas', [CitaController::class, 'getCitasPorPaciente']);

    //Obtener recomendaciones de un paciente
    Route::get('/paciente/citas/{id}/recomendaciones', [RecomendacionController::class, 'getRecomendacionesPorCita']);

    //Obtener el historial clinico de un paciente
    Route::get('/historialClinico', [HistorialClinicoController::class, 'getHistorialClinicoPaciente']);


    //Cerrar sesión paciente
    Route::post('/logoutPaciente', [PacienteAuthController::class, 'logoutPaciente']);
});



Route::middleware('auth:sanctum, role:admin | doctor')->group(function () { //Rutas para doctor y administrador (Compartidas)

    //Para hacer operaciones CRUD de pacientes, sintomas
    Route::apiResource('/pacientes', PacienteController::class);
    Route::apiResource('/sintomas', SintomaController::class);


    //Para obtener historial clinico de un paciente
    Route::get('/historialClinico/{id}', [HistorialClinicoController::class, 'getHistorialClinico']);
});

//Para login administrador, doctor y paciente
Route::post('loginAdmin', [AdminController::class, 'loginAdmin']);
Route::post('loginPaciente', [PacienteAuthController::class, 'loginPaciente']);
Route::post('loginDoctor', [DoctorAuthController::class, 'loginDoctor']);


//Reportes
Route::get('/reporte/administradores', [ReportController::class, 'generateAdminReport']);
Route::get('/reporte/pacientes', [ReportController::class, 'generatePacientesReport']);
Route::get('/reporte/porcentaje-pacientes-hom-y-muj', [ReportController::class, 'generarPorcentajePacientesHomYMujReport']);
Route::get('/reporte/porcentaje-porc-enfermedades', [ReportController::class, 'generarPorcPorEnfermedadesReport']);
Route::post('/reporte/citas-por-rango-fecha', [ReportController::class, 'reporteCitasPorRangoFecha']);


//Operaciones DB
Route::get('/backup', [BackupController::class, 'downloadBackup']);
Route::post('/uploadSQL', [RestoreController::class, 'restoreBackup']);
