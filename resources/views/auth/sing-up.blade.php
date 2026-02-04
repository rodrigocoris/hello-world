@extends('layouts.layout')

@section('title', 'Hello World - Registrarse')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<!-- Defining of the API path to obtain subscription plans -->
<script> var apiUrl   = "{{ config('app.api') . '/api/v1/subscription-plans' }}"; </script>
<script> var plansUrl = "{{ url('/planes') }}"; </script>
<script> var loginUrl = "{{ url('/iniciar-sesion') }}"; </script>
<script src="{{ asset('js/sing-up-subscription-plans.js') }}"></script>

<main class="container-login2">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">
    
    <div class="container-login-structure2">
        <section class="container-login-box2">
            <div class="gradiant-sing-up" data-aos="fade-right" data-aos-duration="1000">
                <div class="container-info-gradiant-sing-up" id="subscription-plans-container">
                    <!-- The subscription plans will be rendered here -->
                </div>
            </div>
            <div class="container-login-form2">
                <div class="login-form2">
                    <form action="{{ route('auth.get-sing-up-data.post') }}" method="post" class="needs-validation" id="reCAPTCHA-form" novalidate>
                        @csrf
                        @php
                            $account_data = match (true) {
                                session('account_creation_data') !== null => session('account_creation_data'),
                                
                                session('google_user_data') !== null => session('google_user_data'),
                                session('github_user_data') !== null => session('github_user_data'),
                                
                                default => null,
                            };

                            $is_account_data = ($account_data);
                        @endphp
                        @if (session('account_creation_data') !== null)
                            <script> var session_plan_id  = `{{$account_data['plan_id']}}`; </script>
                            <script src="{{ asset('js/auth/is-session-account-creation-data.js') }}"></script>
                        @endif
                        @if (!Session::get('external_auth_user'))
                            <h2>Registrate</h2>
                        @else
                            <h4 class="color-2 mt-2">¡Sesión iniciada previamente!</h4>
                            <h6>como: {{ Auth::user()->username }}</h6>
                        @endif
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="username" name="username" type="text" placeholder="" value="{{ old('username') ?? $account_data['username'] ?? '' }}" autocomplete="off" required title="Por favor, introduce tu nombre de usuario." {{ ($is_account_data && $account_data['external_auth'] ) ? 'readonly' : '' }}>
                                <label for="username">Nombre de usuario</label>
                                <div class="invalid-feedback">
                                    Por favor, introduce tu nombre de usuario.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="email" name="email" type="email" placeholder="" value="{{ old('email') ?? $account_data['email'] ?? '' }}" autocomplete="off" required title="Por favor, introduce una dirección de correo electrónico válida." {{ ($is_account_data && $account_data['external_auth'] ) ? 'readonly' : '' }}>
                                <label for="email">Correo electrónico</label>
                                <div class="invalid-feedback">
                                    Por favor, introduce una dirección de correo electrónico válida.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating mb-3 mb-md-0">
                                <div class="show-password-container">
                                    <label for="show-password">
                                        <input type="checkbox" id="show-password" class="show-password" name="show-password">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </label>
                                </div>
                                <input class="form-control" id="password" name="password" type="password" placeholder="Contraseña" autocomplete="off" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" title="Debe contener al menos 8 caracteres, al menos una letra mayúscula (A-Z), al menos un dígito (0-9) y al menos un carácter especial (por ejemplo: !, @, #, $, %, ^, &, *)" value="{{ old('password') ?? $account_data['password'] ?? '' }}" {{ ($is_account_data && $account_data['external_auth'] ) ? 'readonly' : '' }}>
                                <label for="password">Contraseña</label>
                                <div class="invalid-feedback">
                                    La contraseña debe ser mayor a 8 caracteres, al menos una letra mayúscula, al menos un dígito y al menos uno de estos carácteres especiales (!, @, #, $, %, ^, &, *).
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating">
                                <div class="show-password-container">
                                    <label for="show-password-confirmation">
                                        <input type="checkbox" id="show-password-confirmation" class="show-password" name="show-password-confirmation">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </label>
                                </div>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirmar contraseña" autocomplete="off" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" title="Por favor, confirma tu contraseña." value="{{ old('password_confirmation') ?? $account_data['password'] ?? '' }}" {{ ($is_account_data && $account_data['external_auth'] ) ? 'readonly' : '' }}>
                                <label for="password_confirmation">Confirmar contraseña</label>
                                <div class="invalid-feedback">
                                    Por favor, confirma tu contraseña.
                                </div>
                            </div>
                        </div>
                        <p class="mg-top-25">
                            <label for="terms" class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="terms" {{ ($is_account_data && $account_data['external_auth'] ) ? 'checked disabled' : 'required' }} {{ session('account_creation_data') != null ? 'checked' : '' }}>
                                Acepto los <a class="simple-a" href="{{ url('/terminos-de-servicio') }}">Términos de servicio</a> de Hello World y sus <a class="simple-a" href="{{ url('/politicas-de-privacidad') }}">Políticas de privacidad</a>
                            </label>
                            <div class="invalid-feedback">
                                Debes aceptar los términos y condiciones antes de enviar.
                            </div>
                        </p>
                        <input type="hidden" name="plan_id" id="plan_id">
                        <input type="hidden" name="payment_term" id="payment_term" value="monthly">

                        @if ($is_account_data) <button type="button" style="margin-right: 5px;" class="button-8" onclick="redirectTo(`{{ route('auth.reset-form') }}`)"><i class="fa-solid fa-arrow-left"></i> Atrás</button> @endif
                        <button type="submit" class="button-8" style="margin-right: 5px;">@if (!$is_account_data) Registrarme @else Continuar <i class="fa-solid fa-right-from-bracket ms-1"></i> @endif</button>
                        
                        @if(!$is_account_data)
                            <div class="separator-container">
                                <div class="separator-line"></div>
                                <b class="separator-text"> O </b>
                                <div class="separator-line"></div>
                            </div>
                            <!-- Botón para registrarte con Google -->
                            <button type="button" onclick="redirectTo(`{{ route('register.google') }}`)" class="button-1" style="padding: 11px; margin-left: 5px; margin-right: 5px; border-width: 2px; margin-top: 5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                                    <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                    <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                                    <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                                    <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                </svg>
                            </button>
                            <!-- Botón para registrarte con GitHub -->
                            <button type="button" onclick="redirectTo(`{{ route('register.github') }}`)" class="button-8 git-btn" style="padding: 11px; margin-left: 5px; margin-right: 5px; border-width: 2px; margin-top: 5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30">
                                    <path d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051 c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526 c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769 c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098 c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481C13.477,9.174,14.461,9,15.495,9 c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8c0.732,0.731,0.381,2.656,0.102,3.594 c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097C18.199,20.49,19,22.1,19,23.313v2.734 c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z"></path>
                                </svg>
                            </button>
                            <!-- Botón para registrarte con Ceti -->
                            <button type="button" onclick="redirectTo(`{{ route('register.ceti') }}`)" class="button-1" style="padding: 11px; margin-left: 5px; border-width: 2px; margin-top: 5px;">
                                <img src="{{ config('app.assets') }}/logo-ceti.svg" alt="Logo CETI" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                            </button>
                        @endif
                    </form>  
                </div>
            </div>
        </section>
    </div>
</main>

@endsection