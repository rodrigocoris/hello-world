@extends('layouts.layout')

@section('lesson','Contenido')

@section('title','Hello World - ' . $module)

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<meta name="api-url" content="{{ config('app.api_url') }}">
<meta name="lesson" content="{{ $module }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-id" content="{{ Auth::id() }}">

<img src="{{ asset('images/figures/square-1.png') }}" id="bol-1">
<img src="{{ asset('images/figures/square-2.png') }}" id="square-2">

{{--
<section class="section-material" id="contenido">
    <div class="material-content">
        <h2>Aprende con el contenido didáctico de Hello World</h2>
        <div class="ff-Inter sublesson"> 
            <h5>Explora una amplia variedad de contenido disponible para ti. ¡Empieza ahora!</h5>
        </div>
        <h5 class="description-lesson">Descripción</h5>
        <div class="ff-Inter description-container">
            <h6>Este capítulo te guiará a través de los inicios en C++. Accede a la teoría básica y desarrolla tu primer programa.</h6>
            <p class="right-align"><i class="fa-regular fa-clock"></i> 4 Horas</p>
        </div>
        <div class="description-rect"></div>
    </div>
</section>
--}}

<section class="section-landingpage-new mg-bottom-75" id="contenido">
    <div class="landing-container-content-new">
        <div class="landing-content-header-new">
            <div class="landing-content-header-lesson-new">
                <!-- Elemento para el nombre de la lección -->
                <h1 id="lesson-name" class="mg-bottom-10"></h1>
                <h4 id="lesson-language" class="mg-bottom-10 color-2"></h4>
                <!-- Barra de progreso -->
                <div class="progress-containerr">
                    <span class="progress-text" style="visibility: hidden">0% completado</span>
                    <div class="progress-barr" id="lessonProgress">
                        <div class="progress-fill" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            <div class="landing-content-header-buttons-new">
                <button class="button-6">Siguiente</button>
                <button class="button-5">Ir a practicar</button>
            </div>
        </div>
        <div class="landing-content-body-new mg-top-25 ">
            <div class="ff-Inter">
                <h5>Tabla de contenido</h5>
                <div class="landing-content-text-new">
                    <ul class="landing-chapters-list-new">    
                        <!-- Panel izquierdo (títulos) -->
                        <div class="left-panel">
                            <ul id="lesson-list">
                                <!-- Aquí se llenarán los títulos -->
                            </ul>
                        </div>
                    </ul>
                </div>
                <div class="landing-contentet-list-bottom-new">
                    <p>Proporcionado por:</p>
                    <b class="color-2">cppreference</b>
                </div>
            </div>
            <div class="ff-Inter">
                <p id="reading-time"><i class="fa-regular fa-clock"></i> <span>Calculating...</span></p>
                <div class="landing-content-text-new">
                    <!-- Panel derecho (descripción) -->
                    <div class="right-panel">
                        <!-- Título dinámico de la lección seleccionada -->
                        <h3 id="lesson-lesson"></h3>
                        
                        <!-- Descripción dinámica de la lección seleccionada -->
                        <p id="lesson-description" class="description"></p>
                    </div>
                </div>
                <div class="button-container" style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
                    <button class="button-6-new" style="margin-top: 15px; padding: 10px 25px;">Siguiente Capitulo</button>
                    <button class="button-5 button-icon" onclick="togglePlay()" title="Reproducir/pausar">
                        <i class="fas fa-play" id="playPauseIcon"></i>
                    </button>
                    <button class="button-5 button-icon" onclick="restartContent()" title="Reiniciar audio">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/lesson.js') }}"></script>

@endsection
