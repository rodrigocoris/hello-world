<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public $chatgpt_api_key;
    private $max_tokens = 100;

    public function __construct()
    {
        $this->chatgpt_api_key = config('services.chatgpt.api_key');
    }

    public function improve(Request $request)
    {
        $codigo = $request->input('codigo');

        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Eres un experto en desarrollo de software. Proporciona sugerencias para mejorar este código C++ en formato markdown. Sé claro y conciso. Usa un estilo profesional, no generes codigo, solo sugerencias y no más de {$this->max_tokens} palabras."
                ],
                [
                    'role' => 'user',
                    'content' => $codigo
                ]
            ],
        ];

        $response = $this->sendToChatGPT($data);

        if ($response) {
            return response()->json(['success' => true, 'suggestions' => $response]);
        }

        return response()->json(['success' => false, 'message' => 'Error al procesar la solicitud.']);
    }

    public function explain(Request $request)
    {
        $error = $request->input('error');

        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Eres un experto en depuración y enseñanza de programación. Explica este error en C++ y da una posible solución paso a paso en formato markdown. Sé claro y directo, usando lenguaje comprensible y no más de {$this->max_tokens} palabras."
                ],
                [
                    'role' => 'user',
                    'content' => $error
                ]
            ],
        ];

        $response = $this->sendToChatGPT($data);

        if ($response) {
            return response()->json(['success' => true, 'explanation' => $response]);
        }

        return response()->json(['success' => false, 'message' => 'Error al procesar la solicitud.']);
    }

    protected function sendToChatGPT(array $data)
    {
        $apiKey = $this->chatgpt_api_key;

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['choices'][0]['message']['content'] ?? null;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
