<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RegistrationFlow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validRoutesCase1 = [
            'auth.verify-email',
            'auth.get-resend-time',
            'auth.resend-code',
            'auth.validate-code',
            'auth.update-account-data',
            'auth.logout'
        ];
        
        $validRoutesCase2 = [
            'plans',
            'auth.pay-subscription',
            'auth.select-plan',
            'auth.payment.process',
            'auth.update-account-data',
            'auth.success-subscription',
            'auth.logout'
        ];

        // If the user has not verified their email and is not in the valid routes, redirect back
        if (Session::exists('email_verified') && !in_array($request->route()->getName(), $validRoutesCase1)) {
            return redirect()->route('auth.verify-email');
        }

        else if (Session::exists('complete_payment') && !in_array($request->route()->getName(), $validRoutesCase2) ) {
            return redirect()->route('auth.pay-subscription');
        }

        return $next($request);
    }
}
