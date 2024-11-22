<?php

namespace App\Http\Controllers;


use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLogoutRequest;

use App\Models\Administrador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{



    public function loginAdmin(AdminLoginRequest $request)
    {
        $data = $request->validated();

        // Intentamos autenticar al usuario con las credenciales proporcionadas
        if (!Auth::guard('admin')->attempt($data)) {
            // Si las credenciales no son válidas, retornamos un mensaje de error
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Obtenemos el usuario autenticado
        $user = Auth::guard('admin')->user();

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
            'token' => $token,
        ], 200);
    }



    public function registerAdmin(AdminRegisterRequest $request)
    {
        $data = $request->validated();

        $admin = Administrador::create([
            'NomAdmin' => $data['NomAdmin'],
            'ApePatAdmin' => $data['ApePatAdmin'],
            'ApeMatAdmin' => $data['ApeMatAdmin'],
            'FechaNacAdmin' => $data['FechaNacAdmin'],
            'TelAdmin' => $data['TelAdmin'],
            'FechAdmin' => $data['FechAdmin'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'admin',
        ]);

        $token = $admin->createToken('main')->plainTextToken;

        //Retornamos el usuario y el token en formato JSON al cliente
        return response()->json([
            'user' => $admin,
            'token' => $token,
        ]);
    }


    public function logoutAdmin(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'No authenticated user'], 401);
        }

        $user = $request->user(); //Obtenemos el usuario autenticado
        $user->currentAccessToken()->delete(); //Eliminamos el token actual del usuario

        return response()->json(['message' => 'User logged out'], 200);
    }
}
