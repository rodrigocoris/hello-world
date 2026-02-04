<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class PaypalController extends Controller
{
    private $paypalClientId;
    private $paypalSecret;
    public $baseUrl;

    /**
     * Class constructor.
     *
     * Initializes PayPal client credentials and base URL depending on the environment.
     *
     * @return void
     */
    public function __construct()
    {
        // Set PayPal credentials and base URL based on the environment (sandbox or live).
        $this->paypalClientId = config('services.paypal.mode') === 'sandbox' 
            ? config('services.paypal.sandbox_client_id') 
            : config('services.paypal.live_client_id');
        
        $this->paypalSecret = config('services.paypal.mode') === 'sandbox' 
            ? config('services.paypal.sandbox_secret') 
            : config('services.paypal.live_secret');
        
        $this->baseUrl = config('services.paypal.mode') === 'sandbox' 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
    }

    /**
     * Debug API
     * Retrieve the list of PayPal subscriptions with optional query parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPlans()
    {
        try {
            // Obtain the PayPal access token
            $accessToken = $this->getPayPalAccessToken();

            // Make a GET request to the PayPal API to retrieve the subscription details
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . "/v1/billing/plans");

            // Check if the request was successful
            if ($response->successful()) {
                save_log('info', 'Suscription recuperada exitosamente', 200, $response->json());
                return response()->json(['success' => true, 'message' => 'Datos de suscripción recuperados correctamente.', 'data' => $response->json()], 200);
            } else {
                // Return an error response if the request failed
                return response()->json(['success' => false, 'message' => 'Error al recuperar la suscripción de PayPal'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retrieve the details of a PayPal subscription.
     *
     * @param  string  $subscriptionId
     * @param  int  $userToken
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubscription($subscriptionId, $userToken)
    {
        try {
            // Obtain the PayPal access token
            $accessToken = $this->getPayPalAccessToken();

            // Make a GET request to the PayPal API to retrieve the subscription details
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . "/v1/billing/subscriptions/{$subscriptionId}");

            // Check if the request was successful
            if ($response->successful()) {
                // If successful, store the subscription data in the database
                $this->storeSubscription($response->json(), $userToken);
                save_log('info', 'Datos de suscripción almacenados correctamente', 200, $response->json());
                return response()->json(['success' => true, 'message' => 'Datos de suscripción almacenados correctamente.'], 200);
            } else {
                // Return an error response if the request failed
                save_log('error', 'Error al recuperar la suscripción de PayPal', 500, ['error' => $response->json()]);
                return response()->json(['success' => false, 'message' => 'Error al recuperar la suscripción de PayPal'], $response->status());
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            save_log('error', 'Error al recuperar la suscripción de PayPal', 500, ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store the subscription data in the database.
     *
     * @param  array  $json  The subscription data from PayPal
     * @param  int  $userToken  The ID of the user associated with the subscription
     * @return void
     */
    private function storeSubscription(array $json, $userToken)
    {
        // Retrieve the user model by ID
        $user = User::where('user_token', $userToken)->first();

        $start_at = Carbon::parse($json['start_time'])->format('Y-m-d H:i:s');
        $finish_at = Carbon::parse($json['billing_info']['next_billing_time'])->format('Y-m-d H:i:s');

        // Create a new subscription record in the user_subscriptions table
        UserSubscription::create([
            'user_id' => $user->user_id,
            'plan_id' => $this->getLocalPlanId($json['plan_id']),
            'paypal_subscription_id' => $json['id'],
            'paypal_plan_id' => $json['plan_id'],
            'status' => $json['status'],
            'status_update_time' => $json['status_update_time'],
            'start_at' => $start_at,
            'finish_at' => $finish_at,
            'end_at' => null,
            'last_payment_amount' => $json['billing_info']['last_payment']['amount']['value'] ?? null,
            'last_payment_time' => $json['billing_info']['last_payment']['time'] ?? null,
        ]);
    }

    /**
     * Map the PayPal plan ID to your local plan ID.
     *
     * @param  string  $paypalPlanId
     * @return int
     */
    private function getLocalPlanId($paypalPlanId)
    {
        $plan = SubscriptionPlan::where('plan_token', $paypalPlanId)->first();
        return $plan->plan_id;
    }

    /**
     * Obtain the PayPal access token.
     *
     * @return string
     */
    private function getPayPalAccessToken()
    {
        $clientId = (config('services.paypal.mode') === 'sandbox') ? config('services.paypal.sandbox_client_id') : config('services.paypal.live_client_id');
        $secret = (config('services.paypal.mode') === 'sandbox') ? config('services.paypal.sandbox_secret') : config('services.paypal.live_secret');

        $response = Http::asForm()->withBasicAuth($clientId, $secret)
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Unable to retrieve PayPal access token');
    }
}