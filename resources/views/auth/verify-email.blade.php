@extends('layouts.layout')

@section('title', 'Hello World - Verificación de correo electrónico')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<!-- Defining the AJAX path and token csrf -->
<script>
    var getResendTimeUrl = "{{ route('auth.get-resend-time') }}";
    var csrfToken = "{{ csrf_token() }}";
</script>

<!-- Get resend time AJAX -->
<script src="{{ asset('js/get-resend-time.js') }}"></script>

<main class="container-login">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">

    <div class="container-login-structure">
        <section class="container-login-box">
            <div class="gradiant-sing-up" data-aos="fade-right" data-aos-duration="1000">
                <div class="container-info-gradiant">
                    <h2>Introduce el código de verificación</h2>
                    <form action="{{ route('auth.validate-code') }}" method="post" id="otp-input">
                        @csrf
                        <div class="container-recovery">
                            @for ($i = 0; $i < 5; $i++)
                                <input class="form-control input-recovery" name="validate-code[]" placeholder="_" type="number" maxlength="1" step="1" min="0" max="9" autocomplete="off" pattern="\d*" />
                            @endfor
                        </div>
                        <input type="hidden" name="input_request" value="verify">
                        <input type="hidden" name="extenced_token" value="{{ $verification->extenced_token }}">
                        <button type="submit" class="button-7 mg-top-25 mg-bottom-5" id="submit-validation">Validar código</button>
                    </form>
                </div>
            </div>
            <div class="container-login-form">
                <div class="login-form">
                    <h2>Código de verificación enviado</h2>
                    <form action="{{ route('auth.resend-code') }}" method="post" id="resend-code-form">
                        @csrf
                        <input type="hidden" name="extenced_token" value="{{ $verification->extenced_token }}" id="extenced_token" >
                        <input type="hidden" name="input_request" value="verify">
                        <p class="mg-top-25">Revisa tu bandeja de entrada de <span style="color: var(--color-2);">{{ $verification->user->email }}</span> en correo electrónico.</p>
                        <p class="mg-top-15 mg-bottom-15" id="resend-timer" style="display:none;">Puede reenviar el código en <span id="timer" class="color-2"></span> segundos.</p>
                        <button type="submit" id="resend-code-button" class="button-8">Reenviar código</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

@endsection
