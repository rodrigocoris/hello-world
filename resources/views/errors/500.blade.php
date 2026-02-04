@extends('layouts.layout')

@section('title', 'Error - 500')

@section('content')

@include('layouts.reCAPTCHA')

<div class="container-error-500">
    <h1>Error - <span class="letters">500</span></h1>
    <h2>
        <span class="letters">E</span>RROR 
        <span class="letters">I</span>NTERNO 
        <span class="letters">D</span>EL 
        <span class="letters">S</span>ERVIDOR
    </h2>
    <h3>{{ $error }}</h3>
    <h6><a href="{{ url('/inicio') }}">Volver a la página principal.</a></h6>
</div>

@endsection
