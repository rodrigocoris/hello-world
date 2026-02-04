<?php

use App\Models\Log;
use Illuminate\Support\Facades\Request;

if (!function_exists('save_log')) {
    /**
     * Guarda un log en la base de datos.
     *
     * @param  string  $level
     * @param  string  $message
     * @param  int|null  $statusCode
     * @param  array  $context
     * @return bool
     */
    function save_log(string $level, string $message, int $statusCode = null, array $context = [])
    {
        try {
            return Log::create([
                'level' => $level,
                'status_code' => $statusCode,
                'message' => $message,
                'context' => json_encode($context),
            ]);
        } catch (\Exception $e) {
            // Manejar cualquier excepción aquí si es necesario
            return false;
        }
    }
}

if (!function_exists('spanish_date')) {
    function spanish_date($date)
    {
        // Array con los días de la semana en español
        $dias = [
            'Sunday' => 'Domingo',
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado'
        ];

        // Array con los meses en español
        $meses = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];

        // Convertir la fecha en un objeto DateTime
        $datetime = new DateTime($date);

        // Obtener día, mes y año
        $diaSemana = $datetime->format('l'); // Día de la semana (en inglés)
        $dia = $datetime->format('d');      // Día del mes
        $mes = $datetime->format('F');      // Mes (en inglés)
        $año = $datetime->format('Y');      // Año

        // Formatear la fecha en español
        $diaSemanaEsp = $dias[$diaSemana];
        $mesEsp = $meses[$mes];

        return "{$diaSemanaEsp} {$dia} de {$mesEsp} del {$año}";
    }
}

if (!function_exists('path_formated')) {
    function path_formated()
    {
        // Devolver la ruta formateada para que no sobre pase los 30 caracteres
        return substr(Request::path(), 0, 30);
    }
}
