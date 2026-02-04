<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\ModuleProgress;

class ModuleController extends Controller
{
    public function show($module)
    {
        $language = "C++"; // TODO: Obtener el lenguaje del usuario si es dinámico

        // Buscar el módulo por nombre
        $module = Module::where('module', $module)
            ->where('language', $language) // Filtrar por lenguaje
            ->first();

        if (!$module) {
            return abort(404);
        }

        // Verificar si el módulo está iniciado o es de jerarquía 1
        $moduleProgress = ModuleProgress::where('module_id', $module->module_id)
            ->where('user_id', Auth::user()->user_id)
            ->first();

        $isAccessible = $moduleProgress && $moduleProgress->progress > 0;

        // Permitir acceso si es el módulo de jerarquía 1 o está iniciado
        if ($isAccessible || $module->hierarchy == 1) {
            return view('user.module', ['module' => $module->module]);
        }

        // Si no cumple las condiciones, redirigir con mensaje
        return redirect()->back()->with('warning', 'No has llegado aún a este módulo');
    }

    public function list()
    {
        $userId = Auth::user()->user_id;
        $language = "C++"; // TODO: Obtener el lenguaje del usuario si es dinámico

        // Obtener módulos con su progreso y aplicar filtro por lenguaje
        $modules = Module::with(['progress' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
            ->where('language', $language) // Filtrar por lenguaje
            ->get();

        // Agregar progreso y calcular estado
        $modules = $modules->map(function ($module) {
            $progress = $module->progress->first();
            $progressPercentage = $progress ? $progress->progress : 0;

            // Calcular el estado basado en el progreso
            if ($progressPercentage == 0) {
                $module->state = 'disabled';
            } elseif ($progressPercentage == 100) {
                $module->state = 'completed';
            } else {
                $module->state = 'incompleted';
            }

            $module->progress_percentage = $progressPercentage;
            return $module;
        });

        // Buscar módulo con jerarquía 1 y asegurarlo como incompleto
        $hierarchyOneModule = $modules->firstWhere('hierarchy', 1);

        if ($hierarchyOneModule) {
            $hierarchyOneModule->state = 'incompleted';
            $hierarchyOneModule->progress_percentage = 0; // Si no tiene progreso, marcar 0%
        }

        return view('user.dashboard', ['modules' => $modules]);
    }
}
