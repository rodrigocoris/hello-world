<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LessonProgress;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        $lessonProgress = LessonProgress::where('user_id', $user_id)->get();
        return response()->json($lessonProgress);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lessonProgress = LessonProgress::create([
                'user_id' => $request->user_id,
                'lesson_id' => $request->lesson_id,
                'progress' => $request->progress,
            ]);

            return response()->json([
                'success' => true,
                'data' => $lessonProgress
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el progreso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id, $lesson_id)
    {
        $lessonProgress = LessonProgress::where('user_id', $user_id)->where('lesson_id', $lesson_id)->first();
        return response()->json($lessonProgress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'lesson_id' => 'required',
            'progress' => 'required',
        ]);

        $lessonProgress = LessonProgress::where('user_id', $request->user_id)->where('lesson_id', $request->lesson_id)->first();
        $lessonProgress->progress = $request->progress;
        $lessonProgress->save();
        if ($lessonProgress) {
            return response()->json(['success' => 'Progreso de la lección actualizado correctamente'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar el progreso de la lección'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
