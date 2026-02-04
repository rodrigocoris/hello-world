@extends('layouts.layout')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<img src="{{ asset('images/figures/square-1.png') }}" id="bol-1">
<img src="{{ asset('images/figures/square-2.png') }}" id="square-2">

    <!-- Hero Section -->
    <div class="hero-section bg-gradient-pink">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="display-5 fw-semibold mb-4 text-white">¿Cómo podemos ayudarte?</h2>
                    <div class="search-wrapper position-relative">
                        <input type="text" 
                            id="searchInput" 
                            class="form-control form-control-lg rounded-pill ps-5" 
                            placeholder="🔍 Buscar">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3"></i>
                        
                        <!-- Resultados de búsqueda -->
                        <div id="searchResults" class="position-absolute w-100 mt-2 rounded-3 bg-white shadow-sm d-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="container" style="margin-top: 80px;">
        <div class="row g-4 px-4 px-md-5">
            <div class="col-lg-10 col-md-12 mx-auto">
                <div class="row g-4">
                    @foreach([
                        ['icon' => 'user-plus', 'title' => '¿Cómo empezar?', 'count' => 'Registrar una cuenta en Hello World'],
                        ['icon' => 'code', 'title' => 'Ejercicios', 'count' => 'Empezar a practicar en los ejercicios'],
                        ['icon' => 'robot', 'title' => 'Asistente Virtual', 'count' => 'Respuestas a tus dudas sobre tu codigo'],
                        ['icon' => 'terminal', 'title' => 'Compilador', 'count' => 'Compilacion de tu codigo en tiempo real'],
                        ['icon' => 'shield-alt', 'title' => 'Seguridad', 'count' => 'Proteccion de datos'],
                        ['icon' => 'crown', 'title' => 'Planes', 'count' => 'Metodos de pago de Hello World'],
                        ['icon' => 'user-cog', 'title' => 'Perfil', 'count' => 'Configura tu perfil'],
                        ['icon' => 'headset', 'title' => 'Soporte', 'count' => 'Comunicate con nuestro equipo'],
                    ] as $category)
                    <div class="col-lg-6 col-md-6">
                        <a href="{{ url('/categoria/' . urlencode($category['title']) . '/' . urlencode($category['count'])) }}" 
                        class="text-decoration-none">
                            <div class="card custom-card help-card h-100 border-0 shadow-sm">
                                <div class="card-body p-4 d-flex align-items-center">
                                    <div class="icon-wrapper me-3">
                                        <i class="fas fa-{{ $category['icon'] }} fs-3"></i>
                                    </div>
                                    <div>
                                        <h4 class="card-title h5 mb-1">{{ $category['title'] }}</h4>
                                        <p class="card-text text-muted mb-0">{{ $category['count'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container section-spacing">
        <div class="row justify-content-center mb-6">
            <div class="col-lg-6 text-center">
                <h2 class="fw-bold mb-4">Preguntas frecuentes</h2>
                <p class="text-muted">Todo lo que necesita saber sobre Hello World</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion custom-accordion" id="faqAccordion">
                    @foreach([
                        ['question' => '¿Si soy estudiante de CETI puedo tener todos los beneficios de una suscripcion VIP?', 'answer' => 'Sí, Hello World ofrece una suscripcion gratuita para estudiantes de CETI. Ademas de que puedes registrarte con tu correo institucional.'],
                        ['question' => '¿Puedo cambiar mi plan más tarde?', 'answer' => '¡Sí! Puede actualizar o cambiar su plan en cualquier momento desde la configuración de su cuenta.'],
                        ['question' => '¿Qué lenguajes de programación puedo aprender en Hello World?', 'answer' => 'Actualmente solo ofrecemos módulos en C++ pero contamos con nuevos lenguajes en desarrollo como Python, Java y más'],
                        ['question' => '¿Los ejercicios tienen un límite de tiempo para completarse?', 'answer' => 'No, puedes completar los ejercicios a tu propio ritmo.'],
                        ['question' => '¿Qué pasa si encuentro un error en mi código o no entiendo un ejercicio?', 'answer' => 'Puedes usar la asistencia inteligente que te da pistas sobre cómo corregir los errores, además de consultar la sección de contenido'],
                    ] as $index => $faq)
                    <div class="accordion-item border-0 mb-3">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed shadow-sm rounded" 
                                    type="button" 
                                    onclick="toggleAccordion({{ $index }})">
                                {{ $faq['question'] }}
                            </button>
                        </h3>
                        <div id="faq{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body pt-0">
                                <p class="text-muted mb-0">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Still Have Questions Section con espacio adicional -->
    <div class="container section-spacing mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="fw-bold mb-4">¿Tiene alguna pregunta?</h2>
                <p class="text-muted mb-5">¿No encuentra la respuesta que estas buscando? Por favor, comunicate con nuestro equipo de soporte.</p>
                <a href="{{ url('/contacto') }}" class="button-6">Ponerse en contacto</a>
            </div>
        </div>
    </div>

<script src="{{ asset('js/help.js') }}"></script>

@endsection