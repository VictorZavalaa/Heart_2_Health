<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PacienteLoginRequest;
use App\Http\Requests\PacienteRegisterRequest;
use App\Http\Requests\PacienteLogoutRequest;


use App\Models\Paciente;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PacienteAuthController extends Controller
{
    public function loginPaciente(PacienteLoginRequest $request)
    {
        $data = $request->validated();

        // Intentamos autenticar al usuario con las credenciales proporcionadas
        if (!Auth::guard('paciente')->attempt($data)) {
            // Si las credenciales no son válidas, retornamos un mensaje de error
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Obtenemos el usuario autenticado
        $user = Auth::guard('paciente')->user();

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
        ], 200);
    }

    public function registerPaciente(PacienteRegisterRequest $request)
    {
        $data = $request->validated();

        $paciente = Paciente::create([
            'NomPac' => $data['NomPac'],
            'ApePatPac' => $data['ApePatPac'],
            'ApeMatPac' => $data['ApeMatPac'],
            'FechaNacPac' => $data['FechaNacPac'],
            'GenPac' => $data['GenPac'],
            'DirPac' => $data['DirPac'],
            'TelPac' => $data['TelPac'],
            'FechPac' => $data['FechPac'],
            'email' => $data['EmailPac'],
            'password' => bcrypt($data['password']),
            'role' => 'paciente',
        ]);

        $token = $paciente->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $paciente,
            'token' => $token,
        ]);
    }

    public function logoutPaciente(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'No authenticated user'], 401);
        }

        $user = $request->user(); //Obtenemos el usuario autenticado

        $user->currentAccessToken()->delete(); //Eliminamos el token actual del usuario

        return response()->json(['message' => 'User logged out'], 200);
    }
}
