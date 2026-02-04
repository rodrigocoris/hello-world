@extends('layouts.layout')

@section('title','Error - 404')

@section('content')

@php save_log('error', 'Página no encontrada', 404, ['ruta' => url()->current()]); @endphp

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<div class="container-error-404">
    <h1>Error - <span class="letters">404</span></h1>
    <h2><span class="letters">P</span>AGINA <span class="letters">N</span>O <span class="letters">E</span>NCONTRADA</h2>
    <h6><a href="{{ url('/inicio') }}">Volver a la página principal.</a></h6>
    <div class="image-container-effect">
        <img src="{{ asset('images/error/effect.png') }}" alt="">
    </div>
</div>
<div class="image-container-astro">
    <img src="{{ asset('images/error/astro.png') }}" alt="">
</div>

@endsection
