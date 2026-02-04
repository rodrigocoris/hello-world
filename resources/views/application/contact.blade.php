@extends('layouts.layout')

@section('title', 'Hello World - Contact')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
<img src="{{ asset('images/figures/square-1.png') }}" id="square-5">

<form action="{{ route('contact.sendEmail') }}" method="POST" class="needs-validation" id="reCAPTCHA-form" data-aos="fade-up" data-aos-duration="1000">
    @csrf
    <div class="background">
        <div class="container">
            <div class="screen">
                <div class="screen-header">
                    <div class="screen-header-left">
                        <div class="screen-header-button close"></div>
                        <div class="screen-header-button maximize"></div>
                        <div class="screen-header-button minimize"></div>
                    </div>
                    <div class="screen-header-right">
                        <div class="screen-header-ellipsis"></div>
                        <div class="screen-header-ellipsis"></div>
                        <div class="screen-header-ellipsis"></div>
                    </div>
                </div>
                <div class="screen-body">
                    <div class="screen-body-item left">
                        <div class="app-title">
                            <span>Contactanos</span>
                        </div>
                        <div class="app-contact">Contacto : {{ config('app.business.email') }}</div>
                    </div>
                    <div class="screen-body-item">
                        <div class="app-form">
                            <div class="app-form-group">
                                <input class="app-form-control" type="text" name="name" placeholder="Nombre" required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu nombre.
                                </div>
                            </div>
                            <div class="app-form-group">
                                <input class="app-form-control" type="email" name="email" placeholder="Correo" required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu correo electrónico.
                                </div>
                            </div>
                            <div class="app-form-group message">
                                <input class="app-form-control" type="text" name="message" placeholder="Mensaje" required>
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu mensaje.
                                </div>
                            </div>
                            <div class="app-form-group buttons">
                                <button class="app-form-button" type="submit">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection