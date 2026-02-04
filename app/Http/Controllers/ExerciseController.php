<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Exercise;
use App\Models\Lesson;

class ExerciseController extends Controller
{
    public $baseUrl;
    private $apiKey;

    /**
     * Class constructor.
     *
     *  Initializes the Hello-World-Hub API URL and API key.
     * 
     * @return void 
     */
    public function __construct()
    {
        $this->baseUrl = config('app.hub');
        $this->apiKey = config('services.hello_world_hub.api_key');
    }

    public function list($lesson_id)
    {
        $lesson = Lesson::where('lesson_id', $lesson_id)->first();
        $exercises = Exercise::where('lesson_id', $lesson->lesson_id)->get();

        // Selecciona las dificultades de los ejercicios de la lección y suma las repeticiones
        $difficultyData = Exercise::join('difficulties', 'exercises.difficulty_id', '=', 'difficulties.difficulty_id')
            ->select('difficulties.difficulty_id', 'difficulties.level', DB::raw('COUNT(*) as count'))
            ->where('lesson_id', $lesson->lesson_id)
            ->groupBy('difficulties.difficulty_id', 'difficulties.level')
            ->get();

        return view('user.exercises-list', [
            'exercises' => $exercises,
            'difficultyData' => $difficultyData
        ]);
    }

    public function show($exercise_token)
    {
        $exercise = Exercise::where('exercise_token', $exercise_token)->first();

        if (!$exercise) {
            return redirect()->route('user.dashboard')->with('error', 'Ejercicio no encontrado');
        }

        $exerciseSlug = $this->formatExerciseName($exercise->exercise);

        return view('user.exercise', [
            'exercise' => $exercise,
            'exerciseSlug' => $exerciseSlug
        ]);
    }

    public function execute(Request $request)
    {
        // Capturar el código enviado por el usuario
        $codigo = $request->input('codigo');

        // Validación simple para asegurarte de que se recibe el código
        if (!$codigo) {
            return response()->json([
                'status' => 'error',
                'message' => 'El campo código es requerido',
            ], 400); // Bad Request
        }

        // Obtener el input del campo "inputs"
        $inputs = $request->input('inputs');

        // Intentar decodificar como JSON
        if (is_string($inputs)) {
            $inputs = json_decode($inputs, true);
        }

        // Enviar el código a la API de Hello-World-Hub
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->post($this->baseUrl . "/api/v1/compile", [
                        'api_key' => $this->apiKey,
                        'status' => 'queued',
                        'compilation_token' => 'COFXP7FLJTKCECQDCWNEMO2SMU',
                        'language' => 'C++',
                        'source_code' => $codigo,
                        'inputs' => $inputs,
                    ]);

            // Verificar si la respuesta fue exitosa
            if ($response->successful()) {
                return response()->json($response->json(), 200);  // Asegurarse de retornar un JSON válido
            }

            save_log('error', 'Error en la API externa', $response->body());

            return response()->json([
                'status' => 'error',
                'message' => 'Error en la API externa',
                'error' => $response->body(),  // Captura el error de la API
            ], $response->status());

        } catch (\Exception $e) {
            // Manejar errores de excepción
            save_log('error', 'Error interno en el servidor', $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error interno en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function formatExerciseName($exercise)
    {
        if (strpos($exercise, 'Ejercicio') !== false) {
            $exercise = explode('Ejercicio', $exercise)[1];
            return Str::slug(explode('- ', $exercise)[1]);
        }

        return Str::slug($exercise);
    }

    public function demo() 
    {
        $exercise_token = 'JnJvqvGln2';
        $exercise = Exercise::where('exercise_token', $exercise_token)->first();

        if (!$exercise) {
            return redirect()->route('user.dashboard')->with('error', 'Ejercicio no encontrado');
        }

        $exerciseSlug = $this->formatExerciseName($exercise->exercise);

        return view('application.exercise-demo', [
            'exercise' => $exercise,
            'exerciseSlug' => $exerciseSlug
        ]);
    }
}
