<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogleLogin()
    {
        session(['google_action' => 'login']);
        return Socialite::driver('google')->redirect();
    }

    public function redirectToGoogleRegister()
    {
        session(['google_action' => 'register']);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $action = session()->pull('google_action');

            // Verificar si el usuario ya existe
            $user = User::where('email', $google_user->email)->first();

            if ($user) {
                return $this->handleExistingUser($user, $action);
            }

            // Si no existe y la acción es registro, crear un nuevo usuario
            if ($action === 'register') {
                return $this->registerNewUser($google_user);
            }

            // Si la acción es login pero el usuario no existe, redirigir con error
            return redirect()->route('auth.login')->with('error', 'El correo electrónico no está registrado. Por favor, regístrate primero.');
        } catch (\Exception $e) {
            // Guardar el error en la base de datos
            save_log('error', 'Error en la autenticación con Google', 500, [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
                'google_user' => isset($google_user) ? $google_user->email : 'No disponible',
                'action' => isset($action) ? $action : 'No disponible',
            ]);

            return redirect()->route('auth.login')->with('error', 'Ocurrió un error durante la autenticación con Google. Por favor, intenta nuevamente.');
        }
    }

    private function handleExistingUser($user, $action)
    {
        // Verificar si el usuario ya está registrado con Google
        if ($user->external_auth !== 'google') {
            return redirect()->route('auth.login')->with('error', 'El correo electrónico ya está registrado. Por favor, inicia sesión usando tu correo y contraseña.');
        }

        // Iniciar sesión automáticamente
        Auth::login($user);

        save_log('success', 'Inicio de sesión exitoso con Google', 200, [
            'email' => $user->email,
            'action' => $action ?? 'login',
        ]);

        return redirect()->route('dashboard');
    }

    private function registerNewUser($google_user)
    {
        // Generar una contraseña aleatoria y encriptarla
        $random_password = Str::random(24);

        // Guardar los datos del usuario de Google en la sesión
        Session::put('google_user_data', [
            'external_key'  => $google_user->token,
            'username'      => $google_user->name,
            'email'         => $google_user->email,
            'external_id'   => $google_user->id,
            'external_auth' => 'google',
            'password'      => $random_password,
        ]);

        save_log('success', 'Registro exitoso con Google', 200, [
            'email' => $google_user->email,
            'action' => 'register',
        ]);

        return redirect()->route('auth.sing-up')->with('info', 'A continuación tendrás que elegir cuál suscripción quieres en <span style="color:#E61A4F">Hello-World</span>, si tienes dudas de cuál se adecua a tus necesidades, puedes dar clic en el botón de <a href="' . config('app.url') . '/suscripciones" target="_blank"><span style="color:#E61A4F">más información</span></a>.');
    }
}