@extends('layouts.layout')

@section('title','Error - 403')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<div class="container-error-403">
    <h1>Error - <span class="letters">403</span></h1>
    @if($errors->any())
        <h2><span class="letters">A</span>cceso <span class="letters">N</span>o <span class="letters">A</span>utorizado</h2>
        <div class="alert alert-danger m-5">
            <h3>{{ $errors->first() }}</h3>
        </div>
    @else
        <h2><span class="letters">A</span>cceso <span class="letters">N</span>o <span class="letters">A</span>utorizado</h2>
    @endif
    <h6><a href="{{ url('/inicio') }}">Volver a la página principal.</a></h6>
</div>

@endsection
