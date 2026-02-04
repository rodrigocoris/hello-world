<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error404()
    {
        return view('errors.404');
    }

    public function error403()
    {
        return view('errors.403');
    }

    public function error500()
    {
        // Obtener el mensaje de error de la sesión
        $error = session('error', 'Ocurrió un error inesperado. Por favor, inténtelo de nuevo.');

        return view('errors.500', compact('error'));
    }
}
