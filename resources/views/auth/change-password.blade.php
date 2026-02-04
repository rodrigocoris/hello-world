@extends('layouts.layout')

@section('title', 'Hello World - Cambiar contraseña')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<main class="container-login">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">

    <div class="container-login-structure">
        <section class="container-login-box">
            <div class="container-login-form">
                <div class="login-form">
                    <form action="{{ route('auth.change-password.put') }}" method="post" class="needs-validation" id="reCAPTCHA-form" novalidate>
                        @csrf
                        {{ method_field('PUT') }}
                        <h2>Ingresa tu nueva contraseña</h2>
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating mb-3 mb-md-0">
                                <div class="show-password-container">
                                    <label for="show-password">
                                        <input type="checkbox" id="show-password" class="show-password" name="show-password">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </label>
                                </div>
                                <input class="form-control" id="password" name="password" type="password" placeholder="" value="" autocomplete="off" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" title="Debe contener al menos 8 caracteres, al menos una letra mayúscula (A-Z), al menos un dígito (0-9) y al menos un carácter especial (por ejemplo: !, @, #, $, %, ^, &, *)"/>
                                <label for="password">Nueva contraseña</label>
                                <div class="invalid-feedback">
                                    La contraseña debe ser mayor a 8 caracteres, al menos una letra mayúscula, al menos un dígito y al menos uno de estos carácteres especiales (!, @, #, $, %, ^, &, *).
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mg-top-25">
                            <div class="form-floating mb-3 mb-md-0">
                                <div class="show-password-container">
                                    <label for="show-password-confirmation">
                                        <input type="checkbox" id="show-password-confirmation" class="show-password" name="show-password-confirmation">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </label>
                                </div>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="" value="" autocomplete="off" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" title="Por favor, confirma tu contraseña."/>
                                <label for="password_confirmation">Confirmar contraseña</label>
                                <div class="invalid-feedback">
                                    Por favor, confirma tu contraseña.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mg-top-25">
                            <input type="hidden" name="user_email" value="{{ $user_email ?? '' }}">
                            <button type="submit" class="button-8">Cambiar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="gradiant-login" data-aos="fade-left" data-aos-duration="1000">
                <div class="container-info-gradiant">
                    <h2>La contraseña debe contener:</h2>
                    <div class="container-li-password">
                        <li id="taxt-disabled">Al menos 8 caracteres.</li>
                        <li id="taxt-disabled">Al menos una mayúscula (A-Z).</li>
                        <li id="taxt-disabled">Al menos un dígito (0-9).</li>
                        <li id="taxt-disabled">Al menos uno de estos carácteres especiales.
                            <ul>
                                <li>! @ # $ % ^ & *</li>
                            </ul>
                        </li>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

@endsection