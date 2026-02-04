<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CetiStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CetiController extends Controller
{
    /**
     * Redirects the user to the CETI login view.
     * Stores the action in session for later use (login).
     *
     * @return \Illuminate\View\View
     */
    public function redirectToCetiLogin()
    {
        session(['ceti_action' => 'login']);
        return view('auth.ceti-auth');
    }

    /**
     * Redirects the user to the CETI register view.
     * Stores the action in session for later use (register).
     *
     * @return \Illuminate\View\View
     */
    public function redirectToCetiRegister()
    {
        session(['ceti_action' => 'register']);
        return view('auth.ceti-auth');
    }

    /**
     * Handles the callback from CETI after authentication.
     * Verifies the user credentials and either logs in or registers the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleCetiCallback(Request $request)
    {
        // Get the registration data and password from the request
        $register = $request->input('register');
        $password = $request->input('password');
        
        $action = session()->pull('ceti_action');

        try {
            // Authenticate the user with CETI using the provided credentials
            $ceti_user = $this->authenticateWithCeti($register, $password);

            // Check if the user already exists in the database
            $user = User::where('email', $ceti_user['institutional_mail'])->first();

            if ($user) {
                return $this->handleExistingUser($user, $action);
            }

            if ($action === 'register') {
                return $this->registerNewUser($ceti_user);
            }

            return redirect()->route('auth.login')->with('error', 'Ese registro no se encontró en nuestros registros. Por favor, regístrate primero.');
        } catch (\Exception $e) {
            save_log('error', 'Error en la autenticación con CETI', 500, [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('auth.login')->with('error', 'Ocurrió un error durante la autenticación con CETI. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Authenticates the user with CETI.
     * Sends a POST request to the CETI API for authentication.
     *
     * @param string $register
     * @param string $password
     * @return array
     * @throws \Exception
     */
    private function authenticateWithCeti($register, $password)
    {
        $client = new Client();
        $response = $client->post(config('app.ceti') . '/login', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'register' => $register,
                'password' => $password,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error en la autenticación con CETI.');
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Handles the case when the user already exists.
     * If the user is authenticated with CETI, logs them in, otherwise, redirects with an error.
     *
     * @param \App\Models\User $user
     * @param string $action
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleExistingUser($user, $action)
    {
        // If the user is not authenticated via CETI, ask them to log in manually
        if ($user->external_auth !== 'ceti') {
            return redirect()->route('auth.login')->with('error', 'El correo ya está registrado. Por favor, inicia sesión usando tu correo y contraseña.');
        }

        Auth::login($user);

        save_log('success', 'Inicio de sesión exitoso con CETI', 200, [
            'email' => $user->email,
            'action' => $action ?? 'login',
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Registers a new user based on the data received from CETI.
     * Creates a new user and a corresponding CETI student record.
     *
     * @param array $ceti_user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function registerNewUser($ceti_user)
    {
        // Create a new user in the database
        $user = User::create([
            'user_token'        => Str::uuid(),
            'username'          => $ceti_user['name'],
            'email'             => $ceti_user['institutional_mail'],
            'verified_at'       => now(),
            'password'          => Hash::make(Str::random(24)),
            'role_id'           => 2, // Vip role ID as default for CETI users
            'organization_id'   => 1, // Ceti organization ID
            'external_id'       => $ceti_user['register'],
            'external_auth'     => 'ceti',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        CetiStudent::create([
            'user_id'           => $user->user_id,
            'register'          => $ceti_user['register'],
            'name'              => $ceti_user['name'],
            'institutional_mail'=> $ceti_user['institutional_mail'],
            'major'             => $ceti_user['major'],
            'campus'            => $ceti_user['campus'],
            'education_level'   => $ceti_user['education_level'],
            'group'             => $ceti_user['group'],
            'level'             => $ceti_user['level'],
            'shift'             => $ceti_user['shift'],
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        Auth::login($user);

        save_log('success', 'Registro exitoso con CETI', 200, [
            'email' => $ceti_user['institutional_mail'],
            'action' => 'register',
        ]);

        return redirect()->route('dashboard')->with('success', 'Registro exitoso con CETI.');
    }
}