@extends('layouts.layout')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<img src="{{ asset('images/figures/square-1.png') }}" id="bol-1">
<img src="{{ asset('images/figures/square-2.png') }}" id="square-2">

@php
    $categoryIcons = [
        '¿Cómo empezar?' => 'user-plus',
        'Ejercicios' => 'code',
        'Asistente Virtual' => 'robot',
        'Compilador' => 'terminal',
        'Seguridad' => 'shield-alt',
        'Planes' => 'crown',
        'Perfil' => 'user-cog',
        'Soporte' => 'headset'
    ];

    $articles = [
        '¿Cómo empezar?' => [
            ['title' => '¿Cómo registrarse?', 'description' => 'Crea tu cuenta en Hello World mediante el botón "Registrarse" con tu correo electrónico y una contraseña segura.'],
            ['title' => '¿Cómo elegir un lenguaje de programación?', 'description' => 'Explora el lenguaje de programación C++, proximamente Python, java y más.empieza a aprender y practicar.'],
            ['title' => '¿Cómo navegar por las lecciones?', 'description' => 'Accede a la opcion "Lecciones" para ver los módulos disponibles y elige uno para empezar.'],
            ['title' => '¿Cómo realizar un seguimiento de mi progreso?', 'description' => 'Accede a "Mi perfil" para ver tus lecciones completadas y estadísticas de avance. Puedes revisar tu rendimiento en cada módulo.'],
            ['title' => '¿Cómo cambiar la configuración de mi cuenta?', 'description' => 'Accede a la sección "Mi perfil" de tu cuenta para modificar tu nombre, contraseña, plan, etc.'],
        ],
        'Ejercicios' => [
            ['title' => '¿Cómo acceder a los ejercicios?', 'description' => 'Ve a la sección de ejercicios desde las lecciones para practicar con tareas interactivas. Cada ejercicio está diseñado para ayudarte a reforzar lo aprendido en los módulos.'],
            ['title' => '¿Cómo obtener ayuda si me quedo atascado?', 'description' => 'Si no entiendes un ejercicio, utiliza el asistencia virtual que te ofrece sugerencias para resolverlo.'],
            ['title' => '¿Cómo enviar mi solución?', 'description' => 'Escribe tu código en el editor y haz clic en "Ejecutar" para validar tu respuesta..'],
            ['title' => '¿Qué tipos de ejercicios hay?', 'description' => 'Desde básicos de lógica hasta desafíos avanzados que integran estructuras y funciones.'],
            ['title' => '¿Cómo acceder a los ejercicios avanzados?', 'description' => 'Completa los ejercicios básicos del módulo para desbloquear los desafíos avanzados.']
        ],
        'Asistente Virtual' => [
            ['title' => '¿Qué es el asistente virtual?', 'description' => 'Es una herramienta inteligente que te ayuda con dudas sobre los ejercicios y tu código'],
            ['title' => '¿Cómo interactuar con el asistente?', 'description' => 'Al momento de compilar tu código, puedes interactuar con el asistente virtual para obtener sugerencias y ayudarte a resolver problemas.'],
            ['title' => '¿El asistente puede revisar mi código?', 'description' => 'Si tu codigo tiene algun error en automatico el asistente te señalará posibles errores o mejoras.'],
            ['title' => '¿Cómo puedo aprender de las sugerencias del asistente?', 'description' => 'Lee las explicaciones y aplícalas a tu código para entender mejor los conceptos y mejorar tus habilidades.'],
            ['title' => '¿Qué tipo de errores puede detectar?', 'description' => 'Desde problemas de sintaxis hasta errores lógicos básicos, el asistente te ayudará a corregirlos.']
        ],
        'Compilador' => [
            ['title' => '¿Qué es el compilador de Hello World?', 'description' => 'Es una herramienta en tiempo real que convierte tu código en resultados ejecutables para verificar tus soluciones.'],
            ['title' => '¿Qué lenguajes soporta el compilador?', 'description' => 'El compilador es compatible con los lenguajes disponibles en la plataforma, como C+, proximamente Python, java y más.'],
            ['title' => '¿Qué hacer si el compilador muestra un error?', 'description' => 'Revisa la línea del código indicada en el mensaje de error y consulta las pistas ofrecidas por el asistente virtual.'],
            ['title' => 'Facturación Automática', 'description' => 'Detalles sobre el proceso de renovación y cargos automáticos.'],
            ['title' => '¿Puedo probar código fuera de los ejercicios?', 'description' => 'Sí, utiliza el espacio libre del editor para escribir y ejecutar tus propios programas.']
        ],
        'Seguridad' => [
            ['title' => '¿Cómo protege Hello World mis datos personales?', 'description' => 'Implementamos medidas de seguridad avanzadas, como cifrado de datos y conexiones seguras mediante HTTPS, para garantizar que tu información esté protegida en todo momento.'],
            ['title' => '¿Por qué se utiliza un CAPTCHA en el inicio de sesión?', 'description' => 'El CAPTCHA previene accesos no autorizados mediante bots, asegurando que solo usuarios reales interactúen con la plataforma.'],
            ['title' => '¿Qué vulnerabilidades han sido solucionadas en el compilador?', 'description' => 'Hemos implementado validaciones estrictas para evitar la ejecución de código malicioso y garantizar que los usuarios solo puedan compilar código permitido por las políticas de la plataforma.'],
            ['title' => '¿Qué hago si sospecho de un intento de acceso no autorizado a mi cuenta?', 'description' => 'Cambia tu contraseña inmediatamente desde la configuración de tu perfil y contacta al soporte técnico para que puedan investigar el caso.'],
            ['title' => '¿Cómo se almacenan mis datos personales?', 'description' => 'Tus datos se almacenan en servidores seguros con cifrado de extremo a extremo, cumpliendo con estándares internacionales de privacidad.']
        ],
        'Planes' => [
            ['title' => '¿Cómo pueden los estudiantes del CETI obtener acceso gratuito?', 'description' => 'Los estudiantes del CETI solo necesitan registrarse con su correo institucional para acceder automáticamente al contenido de la plataforma sin costo.'],
            ['title' => '¿Qué métodos de pago aceptan para los planes?', 'description' => 'Para mayor seguridad por el momento solo aceptamos PayPal'],
            ['title' => '¿Puedo cambiar de un plan a otro?', 'description' => 'Sí, puedes actualizar o degradar tu plan en cualquier momento desde la sección de "Mi Perfil" de tu cuenta.'],
            ['title' => '¿Puedo pagar el Plan VIP de manera mensual o anual?', 'description' => 'Sí, ofrecemos opciones de pago mensual o anual para el Plan VIP, con descuentos especiales si eliges la opción anual.'],
            ['title' => '¿Hay pruebas gratuitas disponibles para los planes?', 'description' => 'Sí, ofrecemos una prueba gratuita con el plan basico']
        ],
        'Perfil' => [
            ['title' => '¿Qué puedo editar en mi perfil?', 'description' => 'Puedes editar tu nombre, contraseña, plan y nombre de usuario directamente desde la sección de perfil.'],
            ['title' => '¿Puedo ver mi progreso en los ejercicios?', 'description' => 'Sí, puedes ver tu progreso en los ejercicios directamente desde tu perfil, donde se muestra el porcentaje de completitud y tus logros alcanzados.'],
            ['title' => '¿Qué pasa si olvido mi contraseña?', 'description' => 'Si olvidas tu contraseña, puedes restablecerla mediante el enlace de "Olvidé mi contraseña" en la página de inicio de sesión, y recibirás instrucciones por correo electrónico para crear una nueva.'],
            ['title' => '¿Puedo eliminar mi cuenta en Hello World?', 'description' => 'Si, es posible elminar tu cuenta registrada y puedes volver cuando quieras'],
            ['title' => '¿Qué pasa si cambio mi nombre de usuario?', 'description' => 'Si cambias tu nombre de usuario, el cambio se reflejará en tu perfil y en las actividades realizadas, pero el resto de tu información, como los ejercicios completados, permanecerá igual.']
        ],
        'Soporte' => [
            ['title' => '¿Qué tipo de problemas puedo resolver con el soporte?', 'description' => 'El soporte está disponible para resolver problemas relacionados con el acceso a tu cuenta, problemas técnicos, errores en ejercicios, pagos y problemas con la actualización de tu plan.'],
            ['title' => '¿Puedo obtener soporte técnico para los ejercicios y lecciones?', 'description' => 'puedes encontrar asistencia sobre cualquier dificultad que se presente con los ejercicios y leccione.'],
            ['title' => '¿Puedo acceder a soporte si tengo una cuenta gratuita?', 'description' => 'Sí, todos los usuarios, independientemente del plan, tienen acceso al soporte técnico. Sin embargo, las consultas relacionadas con la gestión de cuentas premium tienen prioridad.'],
            ['title' => '¿En donde puedo obtener el soporte que necesito?', 'description' => 'En la seccion del pie de pagina encontraras un formulario para que puedas contactar con el soporte técnico.'],
            ['title' => '¿Cuanto tiempo tarda en dar respuesta?', 'description' => 'La solucion puede variar dependiendo de la complejidad del problema, pero nuestro equipo trabaja para brindarte una respuesta lo más pronto posible.']
        ]
    ];

    $categoryArticles = $articles[$title] ?? [];
    $currentIcon = $categoryIcons[$title] ?? 'file-alt';
@endphp

<!-- Hero Section -->
<div class="hero-section bg-gradient-pink">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-4 fw-bold text-white mb-4">{{ $title }}</h1>
                <p class="lead text-white-50 mb-0">Encuentra toda la información necesaria sobre este tema</p>
            </div>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="container my-5">
    <div class="row">
        <!-- Sidebar (Ahora a la izquierda) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <a href="{{ url('/ayuda') }}" class="btn btn-outline-custom w-100 mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    
                    <h5 class="fw-bold mb-3">Categorías</h5>
                    <ul class="list-unstyled sidebar-links">
                        @foreach([
                            ['icon' => 'user-plus', 'title' => '¿Cómo empezar?', 'count' => 'Registrar una cuenta en Hello World'],
                            ['icon' => 'code', 'title' => 'Ejercicios', 'count' => 'Empezar a practicar en los ejercicios'],
                            ['icon' => 'robot', 'title' => 'Asistente Virtual', 'count' => 'Respuestas a tus dudas sobre tu codigo'],
                            ['icon' => 'terminal', 'title' => 'Compilador', 'count' => 'Compilacion de tu codigo en tiempo real'],
                            ['icon' => 'shield-alt', 'title' => 'Seguridad', 'count' => 'Proteccion de datos'],
                            ['icon' => 'crown', 'title' => 'Planes', 'count' => 'Metodos de pago de Hello World'],
                            ['icon' => 'user-cog', 'title' => 'Perfil', 'count' => 'Configura tu perfil'],
                            ['icon' => 'headset', 'title' => 'Soporte', 'count' => 'Comunicate con nuestro equipo']
                        ] as $sidebarCategory)
                        <li class="mb-2">
                            <a href="{{ url('/categoria/' . urlencode($sidebarCategory['title']) . '/' . urlencode($sidebarCategory['count'])) }}" 
                            class="text-decoration-none text-muted d-flex align-items-center {{ $title === $sidebarCategory['title'] ? 'active' : '' }}">
                                <i class="fas fa-{{ $sidebarCategory['icon'] }} me-2"></i>
                                <span>{{ $sidebarCategory['title'] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content (Ahora a la derecha) -->
        <div class="col-lg-8">
            @php
                $visibleArticles = array_slice($categoryArticles, 0, 2); // Inicialmente solo 2 artículos
                $remainingArticles = array_slice($categoryArticles, 2); // Resto de artículos
            @endphp

            <!-- Artículos visibles inicialmente -->
            <div id="visible-articles">
                @foreach($visibleArticles as $article)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-3">
                            <span class="text-dark">{{ $article['title'] }}</span>
                        </h3>
                        <p class="text-muted mb-3">{{ $article['description'] }}</p>
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-2 rounded-circle bg-light p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-{{ $currentIcon }} text-muted"></i>
                            </div>
                            <div class="small text-muted">
                                <div>{{ $title }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Artículos ocultos -->
            <div id="hidden-articles" style="display: none;">
                @foreach($remainingArticles as $article)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="h4 mb-3">
                            <span class="text-dark">{{ $article['title'] }}</span>
                        </h3>
                        <p class="text-muted mb-3">{{ $article['description'] }}</p>
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-2 rounded-circle bg-light p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-{{ $currentIcon }} text-muted"></i>
                            </div>
                            <div class="small text-muted">
                                <div>{{ $title }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if(count($remainingArticles) > 0)
            <button id="toggle-articles" class="btn btn-outline-custom w-100 py-3">
                <span class="button-text">Mostrar más</span>
                <i class="fas fa-chevron-down ms-2 icon-toggle"></i>
            </button>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('js/help-category.js') }}"></script>

@endsection