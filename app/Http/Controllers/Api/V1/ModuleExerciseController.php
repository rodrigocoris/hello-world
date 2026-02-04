<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Exercise;

class ModuleExerciseController extends Controller
{
    /**
     * This method returns all exercises of a specific module by its token.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($token)
    {
        // Step 1: Find the module by its token
        $module = Module::where('token', $token)->first();

        // Step 2: If the module does not exist, return 404
        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        // Step 3: Load all the lessons for this module
        $lessons = Lesson::where('module', $module->module)->get();

        // Step 4: Retrieve all exercises related to these lessons, with their difficulty level and node exercises
        $exercises = Exercise::with(['lesson', 'difficultyLevel', 'nodeExercises'])
            ->whereIn('lesson_id', $lessons->pluck('lesson_id'))
            ->get();

        // Step 5: Return the exercises data in a structured JSON response
        return response()->json([
            'module' => $module->module,
            'exercises' => $exercises->map(function ($exercise) {
                return [
                    'exercise_id' => $exercise->exercise_id,
                    'lesson' => $exercise->lesson,
                    'description' => $exercise->description,
                    'body_code' => $exercise->body_code,
                    'difficulty' => $exercise->difficultyLevel->level,
                    'lesson' => [
                        'lesson_id' => $exercise->lesson->lesson_id,
                        'lesson' => $exercise->lesson->lesson,
                        'language' => $exercise->lesson->language,
                    ],
                    'node_exercises' => $exercise->nodeExercises->map(function ($node) {
                        return [
                            'node_id' => $node->node_id,
                            'token' => $node->token,
                            'vertex' => $node->vertex,
                            'type' => $node->type,
                            'edges' => $node->edges,
                            'x' => $node->x,
                            'y' => $node->y,
                        ];
                    }),
                ];
            }),
        ]);
    }
}
