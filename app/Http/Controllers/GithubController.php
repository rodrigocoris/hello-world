<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GithubController extends Controller
{
    public function redirectToGithubLogin()
    {
        session(['github_action' => 'login']);
        return Socialite::driver('github')->redirect();
    }

    public function redirectToGithubRegister()
    {
        session(['github_action' => 'register']);
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $github_user = Socialite::driver('github')->user();
            $action = session()->pull('github_action');

            // Verificar si el usuario ya existe
            $user = User::where('email', $github_user->email)->first();

            if ($user) {
                return $this->handleExistingUser($user, $action);
            }

            // Si no existe y la acción es registro, crear un nuevo usuario
            if ($action === 'register') {
                return $this->registerNewUser($github_user);
            }

            // Si la acción es login pero el usuario no existe, redirigir con error
            return redirect()->route('auth.login')->with('error', 'El correo electrónico no está registrado. Por favor, regístrate primero.');
        } catch (\Exception $e) {
            // Guardar el error en la base de datos
            save_log('error', 'Error en la autenticación con GitHub', 500, [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
                'github_user' => isset($github_user) ? $github_user->email : 'No disponible',
                'action' => isset($action) ? $action : 'No disponible',
            ]);

            return redirect()->route('auth.login')->with('error', 'Ocurrió un error durante la autenticación con GitHub. Por favor, intenta nuevamente.');
        }
    }

    private function handleExistingUser($user, $action)
    {
        // Verificar si el usuario ya está registrado con GitHub
        if ($user->external_auth !== 'github') {
            return redirect()->route('auth.login')->with('error', 'El correo electrónico ya está registrado. Por favor, inicia sesión usando tu correo y contraseña.');
        }

        // Iniciar sesión automáticamente
        Auth::login($user);

        save_log('success', 'Inicio de sesión exitoso con GitHub', 200, [
            'email' => $user->email,
            'action' => $action ?? 'login',
        ]);

        return redirect()->route('dashboard');
    }

    private function registerNewUser($github_user)
    {
        // Generar una contraseña aleatoria y encriptarla
        $random_password = Str::random(24);

        // Guardar los datos del usuario de GitHub en la sesión
        Session::put('github_user_data', [
            'external_key'  => $github_user->token,
            'username'      => $github_user->name,
            'email'         => $github_user->email,
            'external_id'   => $github_user->id,
            'external_auth' => 'github',
            'password'      => $random_password,
        ]);

        save_log('success', 'Registro exitoso con GitHub', 200, [
            'email' => $github_user->email,
            'action' => 'register',
        ]);

        return redirect()->route('auth.sing-up')->with('info', 'A continuación tendrás que elegir cuál suscripción quieres en <span style="color:#E61A4F">Hello-World</span>, si tienes dudas de cuál se adecua a tus necesidades, puedes dar clic en el botón de <a href="' . config('app.url') . '/suscripciones" target="_blank"><span style="color:#E61A4F">más información</span></a>.');
    }
}
