@extends('layouts.layout')

@section('title', 'Hello World - Recuperar contraseña')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<!-- Defining the AJAX path and token csrf -->
<script>
    let getResendTimeUrl = "{{ route('auth.get-resend-time') }}";
    let csrfToken = "{{ csrf_token() }}";
</script>

<!-- Get resend time AJAX -->
<script src="{{ asset('js/get-resend-time.js') }}"></script>

<main class="container-login">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">

    <div class="container-login-structure">
        <section class="container-login-box">
            <div class="container-login-form">
                <div class="login-form">
                    <h2>Recuperación de contraseña</h2>
                    <form action="{{ route('auth.send-recovery-email.post') }}" method="post" class="needs-validation" id="reCAPTCHA-form" novalidate>
                        @csrf
                        @php
                            // Determine if the button should be disabled and add the appropriate class
                            $isEmailDisabled = !empty($verification->user->email);
                        @endphp
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="email" name="email" type="email" placeholder="" value="{{ $verification->user->email ?? old('email') ?? '' }}" autocomplete="off" required {{ $isEmailDisabled ? 'readonly' : '' }}/>
                                <label for="email">Correo electrónico</label>
                                <div class="invalid-feedback">
                                    Por favor, introduce una dirección de correo electrónico válida.
                                </div>
                            </div>
                        </div>
                        <p class="mg-top-25">Volver al <a class="simple-a" href="{{ url('/iniciar-sesion') }}">inicio de sesión</a></p>
                        @if(!$isEmailDisabled)
                            <button type="submit" class="button-8">Enviar al correo</button>
                        @else
                            <button type="button" class="button-8" onclick="redirectTo(`{{ url('/recuperar-contraseña') }}`)"><i class="fa-solid fa-delete-left"></i> Cambiar de correo</button>
                        @endif
                    </form>
                </div>
            </div>
            <div class="gradiant-login {{ !$isEmailDisabled ? 'gradiant-login-disabled' : '' }}" data-aos="fade-right" data-aos-duration="1000">
                <div class="container-info-gradiant">
                    <h2>Introduce el código de verificación</h2>
                    <p id="taxt-disabled" class="{{ $isEmailDisabled ? 'display-none' : '' }}">(Una vez recibas tu código de verificación se habilitará esta sección)</p>
                    <form id="otp-input" action="{{ $isEmailDisabled ? route('auth.validate-code') : '' }}" method="post">
                        @csrf
                        <div class="container-recovery">
                            @for ($i = 0; $i < 5; $i++)
                                <input class="form-control input-recovery" name="validate-code[]" placeholder="_" type="number" maxlength="1" step="1" min="0" max="9" autocomplete="off" pattern="\d*" {{ !$isEmailDisabled ? 'disabled' : '' }} />
                            @endfor
                            <input id="otp-value" placeholder="_" type="hidden" name="otp" />
                            <input type="hidden" name="extenced_token" value="{{ $verification->extenced_token ?? '' }}" id="extenced_token">
                            <input type="hidden" name="user_email" value="{{ $verification->user->email ?? '' }}">
                            <input type="hidden" name="input_request" value="recovery">
                        </div>
                        <p class="timer-text" id="resend-timer" style="display:none;">Puede reenviar el código en <span id="timer" class="color-21"></span> segundos.</p>
                        @if(!$isEmailDisabled)
                            <button type="submit" class="button-7 disabled" id="submit-validation" disabled>Validar código</button>
                        @else
                            <button type="submit" class="button-7" style="padding-right: 20px; padding-left: 20px; margin-right: 10px;" id="submit-validation">Validar código</button>
                            <button type="button" class="button-8" style="padding: 4px 20px; margin-left: 10px;" id="resend-code-button">Reenviar código</button>
                        @endif
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#resend-code-button').click(function() {
            // Establecer la acción del formulario y enviar el formulario
            $('#otp-input').attr('action', "{{ route('auth.resend-code') }}");
            $('#otp-input').submit();
        });
    });
</script>

@endsection
