<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Show the payment form for subscription.
     *
     * @return View|RedirectResponse
     */
    public function showPaymentForm(): View|RedirectResponse
    {
        // Check if the session has account creation data
        if (!Session::has('account_creation_data')) {
            // Redirect to the 403 page with an error message if no account data is found in the session
            return Redirect::to('/403')->withErrors(['error' => 'No se han encontrado datos para procesar una suscripción.']);
        }

        // Retrieve account creation data from the session
        $accountData = Session::get('account_creation_data');

        // Retrieve subscription details from the database
        $subscriptionDetails = SubscriptionPlan::where('plan_id', $accountData['plan_id'])->first()->toArray();

        // Merge subscription details with account data
        $accountData['subscriptionDetails'] = $subscriptionDetails;

        // Store "accountData" in a session variable to avoid changes.
        Session::put('accountData', $accountData);

        $clientId = config('services.paypal.mode') === 'sandbox'
            ? config('services.paypal.sandbox_client_id')
            : config('services.paypal.live_client_id');

        // Return the view with account data and preference
        return view('auth.pay-subscription', [
            'clientId'    => $clientId,
            'accountData' => $accountData,
        ]);
    }

    /**
     * Show the plans page.
     *
     * @return View|RedirectResponse
     */
    public function indexPlans(): View|RedirectResponse
    {
        $myPlanToken = null;

        if (Session::has('account_creation_data')) {
            $planId = Session::get('account_creation_data')['plan_id'];
            $myPlanToken = SubscriptionPlan::select('plan_token')->where('plan_id', $planId)->first();
        }

        return view('application.plans', [
            'myPlanToken' => $myPlanToken,
        ]);
    }

    public function successSubscription(): RedirectResponse
    {
        // Destruir la sesión de "complete_payment"
        Session::forget('complete_payment');

        // Validar existencia del usuario
        $user = User::where('user_token', request()->user_token)->first();
        if (!$user) {
            return redirect()->route('error.500')->with('error', 'Usuario no encontrado.');
        }

        // Validar existencia del plan de suscripción
        $subscriptionPlan = SubscriptionPlan::where('plan_token', request()->plan_id)->first();
        if (!$subscriptionPlan) {
            return redirect()->route('error.500')->with('error', 'Plan de suscripción no encontrado.');
        }

        // Verificar si el usuario ya está suscrito al plan
        $isUserSubscribed = UserSubscription::where('user_id', $user->user_id)
            ->where('plan_id', $subscriptionPlan->plan_id)
            ->first();

        if ($isUserSubscribed) {
            // Validar si el plan tiene un rol asociado
            $userRole = $subscriptionPlan->userRole; // Relación corregida
            if ($userRole) {
                $user->update(['role_id' => $userRole->role_id]);

                // Iniciar sesión del usuario
                Auth::login($user);

                return redirect()->route('dashboard')->with('success', '¡Suscripción exitosa!');
            } else {
                return redirect()->route('error.500')->with('error', 'El plan de suscripción no tiene un rol asociado.');
            }
        }

        // Retornar error si el usuario no está suscrito
        return redirect()->route('error.500')->with('error', 'No se pudo procesar la suscripción. Por favor, verifica tu pago.');
    }
}
