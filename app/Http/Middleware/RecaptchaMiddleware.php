<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecaptchaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // We take the hidden token from the form
        $recaptchaResponse = $request->captcha_token;

        // Initialize a cURL session
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($cu, CURLOPT_POST, 1);
        // Set the POST fields to include the secret key and the response token
        curl_setopt($cu, CURLOPT_POSTFIELDS, http_build_query(array('secret' => config('services.recaptcha.secret_key'), 'response' => $recaptchaResponse)));
        // Return the transfer as a string instead of outputting it directly
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
        $curl_exec = curl_exec($cu);
        curl_close($cu);
        
        // Decode the JSON response into an associative array
        $response = json_decode($curl_exec, true);

        // Check if the reCAPTCHA validation was successful and the score is above the threshold
        if(!$response['success'] == 1 || $response['score'] < 0.5){
            return redirect()->back()->with('error', 'Error de validación de reCAPTCHA, por favor intenta de nuevo.');
        } 

        // Proceed with the request
        return $next($request);
    }
}
