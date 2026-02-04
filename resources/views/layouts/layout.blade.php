<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Load loader.css and loader.js --> 
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <script src="{{ asset('js/loader.js') }}"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Meta blade values -->
    <meta name="base-url" content="{{ config('app.url') }}">
    
    <!-- Ensures optimal rendering on mobile devices. -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google site verification -->
    <meta name="google-site-verification" content="xiJ0-qMZ8qPLU_1fSE0KElcUWTcw_1fAhNjobBfRVTo" />

    <!-- General Meta Tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ config('app.url') }}">
    <meta name="api-url" content="{{ config('app.api') }}">

    <title>@yield('title')</title>

    <!-- Add Marked.js -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <!-- Add Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Add JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Add Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Add SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.2/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.2/dist/sweetalert2.all.min.js"></script>

    <!-- Add el JS y el CSS de ACE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ext-language_tools.js"></script>

    <!-- Add Vanilla Calendar Pro -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/styles/index.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/index.js" defer></script>

    <!-- Add AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Add Tippy.js -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">

    <!-- reCAPTCHA V3 -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    
    <!-- Scripts Section -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/copy-code-to-clipboard.js') }}"></script>

    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9040768563286183" crossorigin="anonymous"></script>

    <!-- Add Estilo CSS -->
    <link rel="stylesheet" href="{{ asset('css/david.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hottaco.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rodri.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/animate/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/perfect-scrollbar/perfect-scrollbar.css') }}">

    @if (Request::is('planes'))
        <link rel="stylesheet" href="{{ asset('css/f-table.css') }}">
        <link rel="stylesheet" href="{{ asset('css/until.css') }}">
    @endif

    @if(Request::is('nosotros'))
        <link rel="stylesheet" href="{{ asset('assets/socicon/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/mobirise/css/mbr-additional.css') }}" type="text/css">
    @endif

    @if(Request::is('blog') || Request::is('post/*'))
        <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
    @endif

    @if (Request::is('contacto'))
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}" type="text/css">
    @endif

    @if (Request::is('ejercicio/*') || Request::is('ejercicio/cpp/demo'))
        <link rel="stylesheet" href="{{ asset('css/code-style.css') }}">
    @endif
</head>
<body>
    <!-- Terminal Loader Section -->
    <div class="container-terminal-loader" id="terminalLoader">
        <div class="terminal-loader">
            <div class="terminal-header">
                <div class="terminal-controls">
                    <div class="control close"></div>
                <div class="control minimize"></div>
                <div class="control maximize"></div>
                </div>
                <div class="terminal-title"><span>www.helloworld.com.mx/</span>{{ path_formated() }}.html</div>
            </div>
            <div class="text">Cargando...</div>
        </div>
    </div>

    <!-- Navbar Section -->
    <div class="modal-background"></div>

    <div class="lateral-menu">
        <div class="lateral-menu-container">
            <ul>
                @php
                    $sections = [];
                    if (Request::is('inicio'))
                        $sections = ['inicio' => 'Inicio', 'explora' => 'Explora', 'practica' => 'Practica', 'contenido' => 'Contenido'];
                    elseif (!Request::is('inicio') && !Auth::check())
                        $sections = ['inicio' => 'Inicio', 'explora' => 'Explora', 'practica' => 'Practica', 'contenido' => 'Contenido'];
                    else 
                        $sections = ['panel' => 'Panel', 'modulos' => 'Modulos'/*, 'tienda' => 'Tienda', 'desafios' => 'Desafios'*/];
                @endphp
                @foreach($sections as $section => $label)
                    @if (Request::is('inicio'))
                        <li><a href="javascript:scrollToSection('{{ $section }}');">{{ $label }}</a></li>
                    @elseif (!Request::is('inicio') && !Auth::check())
                        <li><a href="javascript:redirectToWithScroll(`{{ url('/') }}`, '{{ $section }}');">{{ $label }}</a></li>
                    @else
                        <li><a href="javascript:redirectTo(`{{ url('/' . $section) }}`);">{{ $label }}</a></li>
                    @endif
                @endforeach    
                @if (Auth::check() && Auth::user()->role_id === 1)
                    <li><a href="javascript:redirectTo(`{{ url('/mejorar-plan') }}`);"><span>Hello World ++</span></a></li>
                @endif
            </ul>
            <ul>
                @if(Auth::check())
                    <li><button class="button-2 mb-0" onclick="redirectTo(`{{ url('/mi-perfil') }}`)"><i class="fa-solid fa-user-astronaut pe-1"></i> {{ Auth::user()->username }}</button></li>
                    <li><button class="button-2 mt-0" onclick="redirectTo(`{{ route('auth.logout') }}`)"><i class="fa-solid fa-right-from-bracket pe-1"></i> Cerrar sesión</button></li>
                @else
                    <li><button class="button-2 mb-0" onclick="redirectTo(`{{ url('/iniciar-sesion') }}`)">Iniciar sesión</button></li>
                    <li><button class="button-2 mt-0" onclick="redirectTo(`{{ url('/registrarse') }}`)"><i class="fa-solid fa-right-to-bracket"></i> Registrarse</button></li>
                @endif
                <li><a href="{{ url('/planes') }}">Planes</a></li>
                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <li><a href="{{ url('/nosotros') }}">Nosotros</a></li>
                <li><a href="{{ url('/ayuda') }}">Ayuda</a></li>
            </ul>
        </div>
    </div>

    <nav>
        <div class="nav-info-top">
            <ul>
                @if(Auth::check())
                    <li><button class="button-4" onclick="redirectTo(`{{ route('auth.logout') }}`)"><i class="fa-solid fa-right-from-bracket pe-1"></i> Cerrar sesión</button></li>
                    <li><button class="button-1" onclick="redirectTo(`{{ url('/mi-perfil') }}`)"><i class="fa-solid fa-user-astronaut pe-1"></i> {{ Auth::user()->username }}</button></li>
                @else
                    <li><button class="button-4" onclick="redirectTo(`{{ url('/registrarse') }}`)"><i class="fa-solid fa-right-to-bracket pe-1"></i> Registrarse</button></li>
                    <li><button class="button-1" onclick="redirectTo(`{{ url('/iniciar-sesion') }}`)">Iniciar sesión</button></li>
                @endif
                <li style="font-size: 26px; font-weight: normal; margin-top: -1px;">|</li>
                <li><a href="{{ url('/ayuda') }}">Ayuda</a></li>
                <li><a href="{{ url('/nosotros') }}">Nosotros</a></li>
                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <li><a href="{{ url('/planes') }}">Planes</a></li>
            </ul>
            <i class="fa-solid fa-caret-up triangle"></i>
        </div>
        <div class="nav-info-bottom">
            <div class="info-bottom">
                <div class="lateral-menu-button">
                    <div class="menu-toggle first">
                        <i></i>
                    </div>
                </div>
                <div class="logo-container">
                    <a href="{{ url('/inicio') }}">
                        <div class="logo-container-span">
                            <img src="{{ asset('images/Hello-World-Logo.png') }}" class="logo-nav-bar" alt="Hello World Logo">
                            <span id="hello-world"></span>
                        </div>
                    </a>
                </div>
                <div class="bottom-buttons">
                    <ul>
                        @foreach($sections as $section => $label)
                            @if (Request::is('inicio'))
                                <li><a href="javascript:scrollToSection('{{ $section }}');">{{ $label }}</a></li>
                            @elseif (!Request::is('inicio') && !Auth::check())
                                <li><a href="javascript:redirectToWithScroll(`{{ url('/') }}`, '{{ $section }}');">{{ $label }}</a></li>
                            @else
                                <li><a href="javascript:redirectTo(`{{ url('/' . $section) }}`);">{{ $label }}</a></li>
                            @endif
                        @endforeach
                        @if (Auth::check() && Auth::user()->role_id === 1)
                            <li><a href="javascript:redirectTo(`{{ url('/mejorar-plan') }}`);"><span class="hello-world-pp">Hello World ++</span></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>        
    </nav>
    <div class="separador-nav"></div>

    <!-- Content Section -->
    @yield('content')

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3 style="line-height: 40px;">Contacto</h3>
                <p>¿Tienes preguntas?</p>
                <button onclick="redirectTo(`{{ url('/contacto') }}`)" class="button-3" style="margin: 45px 0; height: 58px;">Formulario de contacto</button>
            </div>
            <div class="footer-column">
                <h3 style="line-height: 40px;">Redes Sociales</h3>
                <p>Ponte en contacto con nosotros a través de las redes sociales.</p>
                <div class="row-social">
                    <button class="button-3 nb" style="margin: 20px 0;" onclick="redirectToBlank(`{{ config('app.social.facebook') }}`)"><i class="fa-brands fa-facebook-f"></i></button>
                    <button class="button-3 nb" style="margin: 20px 0;" onclick="redirectToBlank(`{{ config('app.social.instagram') }}`)"><i class="fa-brands fa-instagram"></i></button>
                    <button class="button-3 nb" style="margin: 20px 0;" onclick="redirectToBlank(`{{ config('app.social.twitter') }}`)"><i class="fa-brands fa-twitter"></i></button>
                    <button class="button-3 nb" style="margin: 20px 0;" onclick="redirectToBlank(`{{ config('app.social.youtube') }}`)"><i class="fa-brands fa-youtube"></i></button>
                    <button class="button-3 nb" style="margin: 20px 0;" onclick="redirectToBlank(`{{ config('app.social.patreon') }}`)"><i class="fa-brands fa-patreon"></i></button>
                </div>
            </div>
            <div class="footer-column f-del"></div>
        </div>
        <div class="footer-container">
            <div class="footer-column">
                <h3 style="line-height: 40px;">Empresa</h3>
                <ul style="padding: 0;">
                    <li><a href="{{ url('/nosotros') }}">Acerca de nosotros</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 style="line-height: 40px;">Aviso de Privacidad</h3>
                <ul style="padding: 0;">
                    <li><a href="{{ url('/terminos-de-servicio') }}">Términos de servicio</a></li>
                    <li><a href="{{ url('/politicas-de-privacidad') }}">Políticas de privacidad</a></li>
                </ul>
            </div>
            <div class="footer-column f-del"></div>
        </div>
    </footer>    
      
    <!-- Scripts Section -->
    <script src="{{ asset('js/use_strict.js') }}"></script>
    <script src="{{ asset('js/david.js') }}"></script>

    @if (Request::is('registrarse') || Request::is('iniciar-sesion') || Request::is('cambiar-contraseña/*'))
        <script src="{{ asset('js/show-password.js') }}"></script>
    @endif

    @if (Request::is('verificar-correo-electronico') || Request::is('recuperar-contraseña'))
        <script src="{{ asset('js/otp-input.js') }}"></script>
    @endif

    @if (Request::is('planes'))
        <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
        <script src="{{ asset('js/f-table.js') }}"></script>
    @endif

    @if(Request::is('nosotros'))
        <script src="{{ asset('assets/sociallikes/social-likes.js') }}"></script>
        <script src="{{ asset('assets/theme/js/script.js') }}"></script>
    @endif

    @if(Request::is('inicio'))
        <!-- Initialize IDE rendering in the landing page header -->
        <script src="{{ asset('js/ace-renders/ace-fibonacci-series-preview.js') }}"></script>
        <script src="{{ asset('js/ace-renders/ace-sum-of-two-numbers-preview.js') }}"></script>
    @endif

    <!-- Initialize AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Initialize Tippy.js -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <!-- Initialize AOS -->
    <script>
        AOS.init();
    </script>
</body>
</html>