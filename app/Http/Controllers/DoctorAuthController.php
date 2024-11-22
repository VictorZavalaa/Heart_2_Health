<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Requests\DoctorLogoutRequest;

use App\Models\Doctor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class DoctorAuthController extends Controller
{

    public function loginDoctor(DoctorLoginRequest $request)
    {
        $data = $request->validated();

        // Intentamos autenticar al usuario con las credenciales proporcionadas
        if (!Auth::guard('doctor')->attempt($data)) {
            // Si las credenciales no son válidas, retornamos un mensaje de error
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Obtenemos el usuario autenticado
        $user = Auth::guard('doctor')->user();

        // Log para depuración
        Log::info('Usuario autenticado', ['user' => $user]);

        // Verificamos si el usuario es válido
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        // Creamos un token para el usuario
        try {
            $token = $user->createToken('main')->plainTextToken;

            Log::info('Token creado', ['token' => $token]);
        } catch (\Exception $e) {

            // Retornamos el usuario y el token en formato JSON al cliente

            Log::error('Error al crear el token', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al crear el token'
            ], 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function registerDoctor(DoctorRegisterRequest $request)
    {
        $data = $request->validated();

        $doctor = Doctor::create([
            'NomDoc' => $data['NomDoc'],
            'ApePatDoc' => $data['ApePatDoc'],
            'ApeMatDoc' => $data['ApeMatDoc'],
            'FechNacDoc' => $data['FechNacDoc'],
            'GenDoc' => $data['GenDoc'],
            'DirDoc' => $data['DirDoc'],
            'TelDoc' => $data['TelDoc'],
            'Especialidad' => $data['Especialidad'],
            'FechDoc' => $data['FechDoc'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'doctor',
        ]);

        $token = $doctor->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $doctor,
            'token' => $token
        ]);
    }

    public function logoutDoctor(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'No authenticated user'], 401);
        }

        $user = $request->user(); //Obtenemos el usuario autenticado
        $user->currentAccessToken()->delete(); //Eliminamos el token actual del usuario

        return response()->json(['message' => 'User logged out'], 200);
    }
}
