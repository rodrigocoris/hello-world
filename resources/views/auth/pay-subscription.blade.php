@extends('layouts.layout')

@section('title', 'Hello World - Pagar suscripción')

<meta name="plan_id" content="{{ $accountData['subscriptionDetails']['plan_token'] }}">
<meta name="user_token" content="{{ Session::get('user_token') ?? Session::get('account_creation_data')['user_token'] }}">
<meta name="success_url" content="{{ route('auth.success-subscription') }}">

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<script src="https://www.paypal.com/sdk/js?client-id={{ $clientId }}&vault=true&intent=subscription"></script>

<main class="container-login">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">
    
    <div class="container-login-structure">
        <section class="container-login-box">
            <div class="container-login-form">
                <div class="login-form">
                    <form class="needs-validation" id="reCAPTCHA-form" novalidate>
                        @csrf
                        <a href="{{ url('/planes') }}">
                            <div class="d-flex container-goback">
                                <div class="p-2 goback-icon">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </div>
                                <div class="container-logo-goback">
                                    <img src="{{ asset('images/Hello-World-Extended-Logo.png') }}" id="goback-logo" alt="Hello World Logo Extendido">
                                    <span id="goback-text">Seleccionar otro plan</span>
                                </div>
                            </div>
                        </a>
                        <h2>Suscripción <span class="color-2">{{ $accountData['subscriptionDetails']['name'] }}</span> para Hello World</h2>
                        <p class="pt-4 pb-4"><span class="color-2">{{ $accountData['username'] }}</span>, al confirmar tu suscripción, autorizas a <span class="color-2 ff-Formula-1">Hello World</span> con <span class="fw-bold fst-italic" style="color: #012169;">Pay</span><span class="fw-bold fst-italic" style="color: #009cde;">Pal</span> a cobrarte futuros pagos según sus condiciones. Siempre podrás cancelar tu suscripción cuando tú quieras.</p>
                        
                        <!-- MeracadoPago button container  -->
                        <div style="height: 100px; width: 85%; background-color: transparent; margin: auto; margin-top: 20px; margin-bottom: 25px;">
                            <div id="paypal-button-container"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="gradiant-login" data-aos="fade-left" data-aos-duration="1000">
                <div class="container-info-gradiant">
                    <div class="container-payment-details">
                        <h2 class="center-text">Datos de la operación</h2>
                        <div class="container-monto">
                            <p>Monto</p>
                            <h2>${{ $accountData['subscriptionDetails']['price'] }}<span class="fs-15">{{ $accountData['subscriptionDetails']['currency'] }}</span></h2>
                            <div class="payment-contact-info">
                                <p>Información de contacto:</p>
                                <p>Email: <span class="gradient-text-highlighting"><span>{{ $accountData['email'] }}</span></span></p>
                            </div>
                            <table class="color-1">
                                <thead>
                                    <tr>
                                        <th><p class="fs-20">Plan {{ $accountData['subscriptionDetails']['name'] }}</p></th>
                                        <th><p class="fs-20">${{ $accountData['subscriptionDetails']['price'] }}<span class="fs-10">{{ $accountData['subscriptionDetails']['currency'] }}</span></p></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 2px solid white;">
                                        <td><p class="fs-15">{{ $accountData['subscriptionDetails']['description'] }}</p></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><p class="fs-20">Total</p></th>
                                        <th><p class="fs-20">${{ $accountData['subscriptionDetails']['price'] }}<span class="fs-10">{{ $accountData['subscriptionDetails']['currency'] }}</span></p></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script src="{{ asset('js/paypal-suscription.js') }}"></script>

@endsection