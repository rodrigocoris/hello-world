<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    public function index()
    {
        return view('application.contact');
    }

    public function sendEmail(Request $request)
    {
        // Validación del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        // Construcción del mensaje
        $subject = 'Nuevo mensaje de contacto';
        $body = "
            <h1>Nuevo mensaje de contacto</h1>
            <p><strong>Nombre:</strong> {$validated['name']}</p>
            <p><strong>Correo:</strong> {$validated['email']}</p>
            <p><strong>Mensaje:</strong></p>
            <p>{$validated['message']}</p>
        ";

        // Enviar el correo con PHPMailer
        $result = $this->sendMail(config('app.business.email'), $subject, $body);

        // Redirección y mensajes de éxito/error
        if ($result === true) {
            return redirect()->route('contact.index')->with('success', '¡Mensaje enviado correctamente!');
        } else {
            return redirect()->route('contact.index')->with('error', 'Error al enviar el mensaje: ' . $result);
        }
    }

    public static function sendMail($to, $subject, $body, $fromEmail = null, $fromName = null)
    {
        $fromEmail = $fromEmail ?? config('mail.from.address');
        $fromName = $fromName ?? config('mail.from.name');

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor de correo
            $mail->SMTPDebug = 0; // Cambiar a 0 en producción
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = config('mail.mailers.smtp.port');

            // Remitente
            $mail->setFrom($fromEmail, $fromName);

            // Destinatario
            $mail->addAddress($to);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Enviar el correo
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Manejar errores
            return $mail->ErrorInfo;
        }
    }
}
