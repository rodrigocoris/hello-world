@extends('layouts.layout')

@section('title', 'Hello World - Aprende a programar')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<!-- Get the section ID from sessionStorage -->
<script src="{{ asset('js/scroll-to-landing.js') }}"></script>

<main class="main-container">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-1">
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-2">
    <img src="{{ asset('images/figures/square-3.png') }}" id="square-3">
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-6">

    <div class="landing-page-head" id="inicio">
        <div class="landing-title">
            <h1 class="h1-inter landing-title-h1" data-aos="fade-down">Los mejores programadores dejan que su código hable por sí mismo</h1>
            <h1 class="h1-inter alternative-h1" data-aos="fade-down">El mejor código habla por sí solo.</h1>
            <div class="container-objetivo" data-aos="fade-up">
                <p>Queremos ayudarte a desarrollar y mejorar tu lógica de programación. Bienvenido/a a Hello World, donde cada línea es el inicio de algo grandioso.</p>
            </div>
            <div class="landing-head-info-buttons">
                <button class="button-5" onclick="redirectTo(`{{ url('/registrarse') }}`)" data-aos="fade-up-right">¡Empezar Ahora!</button>
                <button class="button-6 m-sm-3" onclick="redirectTo('https://www.youtube.com/channel/UCeT5varh-07VRRhHi4MIx2g')" data-aos="fade-up-left">Video tutorial</button>
            </div>
        </div>
        <div class="landing-ide" data-aos="fade-up">
            <div id="panel-top" class="exercise-panel">
                <div class="panel-header">
                    <!-- Nombre del archivo -->
                    <div class="panel-title">
                        <span class="panel-link">
                            <i class="fa-solid fa-file-code" style="color: var(--color-13);"></i>
                            <span> fibonacci.cpp</span>
                        </span>
                        <label for="select-theme" class="ms-3">
                            <span class="color-7">Tema: </span>
                            <select name="select-theme" id="select-theme" class="panel-link select-theme">
                                <option value="monokai" selected>Monokai</option>
                                <option value="dracula">Dracula</option>
                                <option value="solarized_dark">Solarized Dark</option>
                                <option value="twilight">Twilight</option>
                                <option value="tomorrow_night">Tomorrow Night</option>
                                <option value="chaos">Chaos</option>
                                <option value="cobalt">Cobalt</option>
                                <option value="gruvbox">Gruvbox</option>
                                <option value="merbivore_soft">Merbivore Soft</option>
                                <option value="terminal">Terminal</option>
                            </select>
                        </label>
                    </div>

                    <!-- Botones alineados a la derecha -->
                    <div class="panel-actions me-3">
                        <button id="copyButton-header" class="header-ide-copy" onclick="copyCodeToClipboard('header')"><i class="fa-regular fa-clone"></i> Copiar</button>
                    </div>
                </div>
                <div class="panel-content body-ide-580">
                    <div class="body-ide-container" id="editor-preview"></div>
                </div>
            </div>
        </div>
    </div>

    <section class="section-landingpage" id="explora">
        <h1 class="h1-inter pd-h1 center-text" data-aos="fade-down">Aprende de una manera estructurada</h1>
        <div class="container-comparation">
            <div class="comparation" data-aos="fade-right">
                <h2 class="h2-f1">Sin Hello World</h2>
                <p>Innumerables guías dispersas. Navegando a través de lecciones anticuadas. Sumergido en océano de información abrumadora sobre programación.</p>
                <img src="{{ asset('images/learn-with-out-Hello-World.png') }}" alt="Aprendizaje sin Hello World">
            </div>
            <div class="comparation border-selected-1" data-aos="fade-left">
                <h2 class="h2-f1">Con <span style="color: #E61650;">Hello World</span></h2>
                <p>Simplifica tu aprendizaje con contenido actualizado y seleccionado. Domina la codificación con claridad y confianza a tu ritmo.</p>
                <img src="{{ asset('images/learn-with-Hello-World.png') }}" class="pd-top-25 learn-with-hello-world" alt="Aprendizaje con Hello World">
            </div>
        </div>
    </section>

    <section class="dark-background" id="practica">
        <section class="section-landingpage white-text">
            <h1 class="h1-inter pd-h1 center-text" data-aos="fade-down" data-aos="fade-right">Práctica tu lógica de programación</h1>
            <div class="container-sample-exercise">
                <div class="row-sample-exercise box-s-25" data-aos="fade-right">
                    <div class="header-sample-exercise">
                        <div><b style="text-align: left;">Suma de dos numeros</b></div>
                        <div class="justify-content-end align-items-center assistant-button-container">
                            <button style="text-align: center;" class="button-selected-1"><i class="fa-regular fa-file none-475"></i> Descripción</button>
                            <button style="text-align: center; margin-left: 10px;" class="button-10"><i class="fa-solid fa-code-branch none-475"></i> Lección</button>
                        </div>
                    </div>
                    <div class="body-sample-exercise">
                        <b class="caption-sample-exercise">Instrucciónes:</b>
                        <p>Escribe un programa que calcule la suma de todos los números pares dentro de un rango dado <span id="code_text">[a, b]</span>. El programa debe solicitar al usuario que ingrese los valores de <span id="code_text">a</span> y <span id="code_text">b</span>, y luego imprimir la suma de los números pares en ese rango.</p>
                        <b class="caption-sample-exercise">Ejemplo:</b>
                        <p>Supongamos que el usuario ingresa <span id="code_text">a = 1</span> y <span id="code_text">b = 10</span>. El programa debe calcular la suma de los números pares dentro de ese rango, que son <span id="code_text">2 + 4 + 6 + 8 + 10 = 30</span>, y luego imprimir ese valor.</p>
                        <b class="caption-sample-exercise">Entrada:</b>
                        <p>Dos números enteros separados por espacio: <span id="code_text">a</span> y <span id="code_text">b</span>, donde <span id="code_text">1 <= a <=b <=1000</span>.</p>
                        <b class="caption-sample-exercise">Salida:</b>
                        <p>Un único número entero que representa la suma de los números pares dentro del rango <span id="code_text">[a, b]</span>.</p>
                        <b class="caption-sample-exercise">Ejemplo de entrada:</b>
                        <div class="code-output"><code class="sample-output">1 10</code></div>
                        <b class="caption-sample-exercise">Ejemplo de salida:</b>
                        <div class="code-output"><code class="sample-output">30</code></div>
                        <b class="caption-sample-exercise">Restricciones:</b>
                        <div class="sample-exercise-list">
                            <ul>
                                <li>El programa debe calcular la suma de los números pares dentro del rango dado.</li>
                                <li>Debes utilizar estructuras de control como bucles y condicionales para resolver el problema.</li>
                                <li>Evita el uso de funciones o bibliotecas avanzadas que implementen la funcion solicitada.</li>
                            </ul>
                        </div>
                        <b class="caption-sample-exercise">Notas Adicionales:</b>
                        <div class="sample-exercise-list">
                            <ul>
                                <li>Asegúrate de leer cuidadosamente la entrada y salida esperadas.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row-sample-exercise">
                    <div class="container-sample-ide box-s-25" data-aos="fade-down-left">
                        <div class="header-ide">
                            <div class="container-title-header-ide">
                                <img src="{{ asset('images/cpp-icon.png') }}" alt="c++ icon">
                                <div class="header-ide-grid-container">
                                    <div class="header-ide-title">suma.cpp</div>
                                    <div class="justify-content-end align-items-center assistant-button-container">
                                        <div class="header-ide-copy ff-Formula-1"><button id="copyButton-sample" class="header-ide-copy me-3" onclick="copyCodeToClipboard('sample')"><i class="fa-regular fa-clone"></i> Copiar</button></div>
                                        <div class="header-ide-assistant">
                                            <button class="button-9">
                                                <svg fill="var(--color-1)" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <g>
                                                                <path d="M434.863,126.093V77.137h-48.956V0h-33.391v77.137h-42.083V0h-33.391v77.137h-42.083V0h-33.391v77.137h-42.083V0h-33.391 v77.137H77.137v48.956H0v33.391h77.137v42.083H0v33.391h77.137v42.083H0v33.391h77.137v42.083H0v33.391h77.137v48.956h48.956V512 h33.391v-77.137h42.083V512h33.391v-77.137h42.083V512h33.391v-77.137h42.083V512h33.391v-77.137h48.956v-48.956H512v-33.391 h-77.137v-42.083H512v-33.391h-77.137v-42.083H512v-33.391h-77.137v-42.083H512v-33.39H434.863z M401.473,401.471h-0.001H110.529 V110.529h290.944V401.471z"></path>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M375.773,229.532c0-22.913-14.194-42.903-34.426-51.239c-1.374-26.935-23.718-48.426-50.987-48.426 c-13.221,0-25.283,5.052-34.36,13.325c-9.077-8.273-21.139-13.325-34.36-13.325c-27.27,0-49.615,21.491-50.987,48.426 c-20.234,8.336-34.426,28.326-34.426,51.239c0,9.577,2.445,18.593,6.742,26.459c-4.391,8.051-6.742,17.113-6.742,26.478 c-0.001,23.125,14.25,42.974,34.428,51.253c1.381,26.928,23.722,48.411,50.986,48.411c13.221,0,25.283-5.052,34.36-13.325 c9.077,8.273,21.139,13.325,34.36,13.325c27.265,0,49.606-21.483,50.986-48.411c20.176-8.28,34.428-28.129,34.428-51.253 c0-9.366-2.351-18.428-6.742-26.478C373.328,248.124,375.773,239.108,375.773,229.532z M239.304,331.078 c0,9.74-7.924,17.664-17.664,17.664c-7.943,0-14.674-5.271-16.889-12.497c10.656-2.612,20.43-8.341,27.914-16.604l-24.749-22.417 c-4.226,4.667-10.018,7.237-16.308,7.237c-12.127,0-21.992-9.866-21.992-21.992c0-0.697,0.033-1.389,0.098-2.076 c6.719,2.904,14.12,4.521,21.895,4.521v-33.391c-12.127,0-21.992-9.866-21.992-21.993c-0.001-7.907,4.25-14.938,10.63-18.817 c5.774,8.031,13.85,14.415,23.463,18.021l11.727-31.264c-6.855-2.571-11.461-9.222-11.461-16.549 c0-9.74,7.924-17.664,17.664-17.664c9.74,0,17.664,7.924,17.664,17.664V331.078z M342.285,280.393 c0.065,0.687,0.098,1.379,0.098,2.076c0,12.127-9.866,21.992-21.993,21.992c-6.289,0-12.081-2.57-16.307-7.237l-24.748,22.417 c7.485,8.263,17.258,13.993,27.914,16.604c-2.215,7.227-8.947,12.497-16.889,12.497c-9.74,0-17.664-7.924-17.664-17.664V180.922 c0-9.74,7.924-17.664,17.664-17.664c9.739,0,17.664,7.924,17.664,17.664c0,7.327-4.606,13.978-11.461,16.549l11.727,31.264 c9.613-3.606,17.688-9.991,23.463-18.021c6.38,3.879,10.631,10.911,10.631,18.817c0,12.127-9.866,21.993-21.993,21.993v33.391 C328.164,284.915,335.566,283.297,342.285,280.393z"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                                <span>Asistente</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body-ide-420">
                            <section class="body-ide-container" id="editor-preview-practice"></section>
                        </div>
                    </div>
                    <div class="container-sample-output-terminal box-s-25" data-aos="fade-up-left">
                        <div class="header-ide">
                            <div class="container-title-header-ide">
                                <div class="sample-terminal-container">
                                    <div class="sample-terminal-title">Terminal de salida</div>
                                    <div class="justify-content-end align-items-center assistant-button-container">
                                        <div class="sample-terminal-run-time me-3">Tiempo de ejecución: 0.21 ms</div>
                                        <div class="sample-terminal-run">
                                            <button class="button-11">
                                                <i class="fa-solid fa-play"></i>
                                                <span>Correr</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body-terminal">
                            <div class="code-output bg-11">
                                <code class="sample-output">
                                    <p><span id="code_text">~$</span> Ingrese el rango [a, b]: 1 10</p>
                                    <p><span id="code_text">~$</span> La suma de los números pares en el rango [1, 10]: 30</p>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <section class="section-landingpage mg-bottom-75" id="contenido">
        <h1 class="h1-inter pd-h1 center-text" data-aos="fade-down">Contenido actualizado</h1>
        <div class="landing-container-content" data-aos="zoom-in">
            <div class="landing-content-header">
                <div class="landing-content-header-title">
                    <h1 class="ff-Inter mg-bottom-25">Introducción a C++</h1>
                    <h5 class="ff-Inter mg-bottom-15">0% Completado</h5>
                </div>
                <div class="landing-content-header-buttons">
                    <button class="button-6">Omitir</button>
                    <button class="button-5">Practicar</button>
                </div>
            </div>
            <div class="landing-content-body mg-top-25 ">
                <div class="ff-Inter">
                    <h5>Tabla de contenido</h5>
                    <div class="landing-content-text">
                        <ul class="landing-chapters-list">
                            <li><a href="#basic-concepts">Conceptos básicos</a></li>
                            <li class="option-locked"><span><i class="fa-solid fa-lock"></i> Tipos de datos</span></li>
                            <li class="option-locked"><span><i class="fa-solid fa-lock"></i> Variables</span></li>
                            <li class="option-locked"><span><i class="fa-solid fa-lock"></i> Operadores</span></li>
                            <li class="option-locked"><span><i class="fa-solid fa-lock"></i> Funciones</span></li>
                            <li class="option-locked"><span><i class="fa-solid fa-lock"></i> Algoritmos</span></li>
                        </ul>
                    </div>
                    <div class="landing-contentet-list-bottom">
                        <p>Proporcionado por:</p>
                        <b class="color-2">cppreference</b>
                    </div>
                </div>
                <div class="container-content ff-Inter">
                    <p><i class="fa-regular fa-clock"></i> 7 minutos de lectura</p>
                    <div class="landing-content-text text-content">
                        <h3>Conceptos básicos de programación</h3>
                        <p>La programación es el arte de escribir instrucciones que una computadora puede seguir para realizar una tarea específica. Es como darle un conjunto de pasos a una máquina para que realice una acción deseada. Para entender la lógica detrás de la programación, es importante comprender algunos conceptos básicos:</p>
                        <ul>
                            <li><strong>Secuencia de instrucciones:</strong> En programación, las instrucciones se ejecutan en secuencia, una después de la otra. Esto significa que el orden en que escribas las instrucciones es crucial, ya que determina el flujo de ejecución del programa.</li>
                            <li><strong>Estructuras de control:</strong> A medida que los programas se vuelven más complejos, es necesario tener la capacidad de tomar decisiones y repetir acciones. Las estructuras de control, como las declaraciones if, else y los bucles (for, while), permiten controlar el flujo de ejecución del programa.</li>
                            <li><strong>Abstracción:</strong> La abstracción es un concepto fundamental en programación que implica simplificar la complejidad al ocultar detalles innecesarios y centrarse en los aspectos relevantes para el problema en cuestión. Esto se logra mediante el uso de funciones y procedimientos, que permiten dividir el código en bloques más pequeños y manejables.</li>
                            <li><strong>Resolución de problemas:</strong> La programación es, en su núcleo, una forma de resolver problemas. Implica identificar un problema, descomponerlo en pasos más pequeños y luego escribir un conjunto de instrucciones para resolver cada paso de manera sistemática.</li>
                            <li><strong>Lenguajes de programación:</strong> Existen varios lenguajes de programación, cada uno con su propia sintaxis y reglas. Algunos ejemplos comunes son Python, Java, C++, JavaScript, entre otros. Cada lenguaje tiene sus propias fortalezas y debilidades, y es importante elegir el más adecuado para el tipo de problema que estás tratando de resolver.</li>
                            <li><strong>Depuración y prueba:</strong> Es inevitable que surjan errores (bugs) en los programas. La depuración es el proceso de encontrar y corregir estos errores. La prueba también es importante para asegurarse de que el programa funcione como se espera en una variedad de situaciones.</li>
                        </ul>
                        <p>En resumen, la programación es un proceso creativo que implica pensar de manera lógica y sistemática para resolver problemas utilizando un lenguaje de programación específico. Es una habilidad valiosa en la era digital, ya que permite automatizar tareas, desarrollar software y crear soluciones innovadoras para una amplia gama de problemas.</p>
                    </div>
                    <button class="button-6" style="margin-top: 15px; padding: 10px 25px;">Siguiente Capitulo</button>
                    <button class="button-5" style="margin-top: 15px; padding: 10px 25px;">Ayuda Del Asistente</button>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    var plansURL = "{{ config('app.api') }}/api/v1/subscription-plans";
</script>
<script src="{{ asset('js/render-plans.js') }}"></script>

@endsection