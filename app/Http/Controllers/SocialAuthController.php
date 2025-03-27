<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Redirige a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Maneja la respuesta de Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Buscar usuario por email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Crear usuario si no existe
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()), // Generar una contraseña aleatoria
                ]);
            }

            // Iniciar sesión
            Auth::login($user);

            return redirect()->intended('/home');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Ocurrió un error al iniciar sesión con Google.');
        }
    }
}
