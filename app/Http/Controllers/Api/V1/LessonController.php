<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();

        return response()->json([
            'lessons' => $lessons
        ]);
    }


    public function show($languageId, $moduleName)
    {
        // Obtener el lenguaje usando el language_id
        $language = Language::where('language_id', $languageId)->first();

        // Obtener el módulo actual basado en el nombre y lenguaje
        $currentModule = Module::where('module', $moduleName)
            ->where('language', $language->language)
            ->first();

        // Si no existe el módulo, devolver error
        if (!$currentModule) {
            return response()->json([
                'error' => 'Módulo no encontrado.'
            ], 404);
        }

        // Obtener las lecciones del módulo actual en orden de jerarquía
        $moduleSection = Lesson::where('module_id', $currentModule->module_id)
            ->orderBy('hierarchy', 'asc')
            ->get();

        // Obtener el siguiente módulo en la jerarquía
        $nextModule = Module::where('language', $language->language)
            ->where('hierarchy', '>', $currentModule->hierarchy)
            ->orderBy('hierarchy', 'asc')
            ->first();

        // Formatear la respuesta con el formato solicitado, incluyendo el siguiente módulo
        return response()->json([
            'moduleSection' => $moduleSection->map(function ($lesson) {
                return [
                    'lesson_id' => $lesson->lesson_id,
                    'language' => $lesson->module->language,
                    'module' => $lesson->module->module,
                    'hierarchy' => $lesson->hierarchy,
                    'lesson' => $lesson->lesson,
                    'description' => $lesson->description,
                    'created_at' => $lesson->created_at,
                    'updated_at' => $lesson->updated_at,
                ];
            }),
            'currentModule' => [
                'module' => $currentModule->module,
                'hierarchy' => $currentModule->hierarchy
            ],
            'nextModule' => $nextModule ? [
                'module' => $nextModule->module,
                'hierarchy' => $nextModule->hierarchy
            ] : null
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
