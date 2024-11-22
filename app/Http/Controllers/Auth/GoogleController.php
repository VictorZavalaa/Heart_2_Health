<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserGoogle;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'email', 'profile'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    //Manejar la respuesta de Google

    public function handleGoogleCallback()
    {

        try {
            //Obtener los datos del usuario desde Google
            $user = Socialite::driver('google')->stateless()->with(['access_type' => 'offline', 'prompt' => 'consent'])->user();

            //Verificar si el usuario ya existe en la base de datos

            $existingUser = UserGoogle::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($existingUser) {
                //Actualizar tokens

                $existingUser->update([
                    'access_token' => $user->token,
                    'refresh_token' => $user->refreshToken,
                ]);

                //Iniciar sesión
                auth()->login($existingUser);
            } else {

                // Crear un nuevo usuario con Google
                $newUser = UserGoogle::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'access_token' => $user->token,
                    'refresh_token' => $user->refreshToken,
                    'password' => bcrypt('random-password') // Puedes generar una contraseña random, pero no se usará
                ]);

                auth()->login($newUser);
            }

            // Redirigir a la página de inicio o donde desees
            return redirect()->intended('http://localhost:5173/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Error al iniciar sesión con Google');
        }
    }
}
