@extends('layouts.layout')

@section('title','Hello World - Ejercicio de programación')

@section('content')

@include('layouts.user-stats')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<main class="dashboard-container">

    <div class="general-ide-container">
        <div class="split-pane">
            <div class="pane left-pane">
                <div class="pane-content">

                    <section class="pane-header">
                        <div style="text-align: center; margin-top: 10px;"> <!-- Centra el botón y añade margen superior -->
                            <button class="button-4" id="nextExerciseButton"><i class="fa-solid fa-code-branch"></i> Siguiente Ejercicio</button>
                            <p></p>
                        </div>
                        <div class="header-ide-title" style="display: inline-block; margin-right: 10px;">Módulo 1: Introducción a la Programación y C++</div>
                        <div style="clear: both;"></div> <!-- Asegura que el contenedor se ajuste correctamente -->
                    </section>

                    <section class="pane-body ide-height" style="font-family: Arial, sans-serif; font-size: 14px;" id="exerciseContent">

                        <b>
                            <h5>1. Conceptos básicos
                        </b></h5>

                        <ul>
                            <li><code>#include &lt;<span style="color: #c678dd;">librería</span>&gt;</code>: Permite incluir librerías que contienen funciones y objetos adicionales que puedes usar en tu programa.</li>
                            <li><code><span style="color: #c678dd;">int</span> main()</code>: Es la función principal del programa desde donde empieza la ejecución. Es obligatoria en C++.</li>
                            <li><code><span style="color: #61afef;">std::cout</span></code>: Permite mostrar información en la salida estándar (la pantalla).</li>
                            <li><code><span style="color: #56b6c2;">&lt;&lt;</span></code>: Es el operador de inserción, que se utiliza para enviar información a <span style="color: #61afef;">std::cout</span>.</li>
                            <li><code><span style="color: #61afef;">std::endl</span></code>: Añade un salto de línea después de imprimir el mensaje.</li>
                            <li><code><span style="color: #c678dd;">return 0;</span></code>: Indica que el programa terminó correctamente y devuelve este valor al sistema operativo.</li>
                        </ul>

                        <b>
                            <p>
                            <h5>2. Primer programa en C++: "Hola, Mundo".
                        </b></p>
                        </h5>
                        <h6>
                            <p><b>1. Ejercicio: Hola Mundo</b></p>
                        </h6>

                        <pre style="background-color: #282c34; color: #61dafb; padding: 15px; border-radius: 8px;">
<span style="color: #7f848e;">// Sintaxis:</span>
<span style="color: #c678dd;">#include</span> &lt;<span style="color: #61afef;">iostream</span>&gt;
<span style="color: #c678dd;">int</span> <span style="color: #61afef;">main</span>() {
    <span style="color: #61afef;">std::cout</span> <span style="color: #56b6c2;">&lt;&lt;</span> <span style="color: #98c379;">""</span> <span style="color: #56b6c2;">&lt;&lt;</span> <span style="color: #61afef;">std::endl</span>;
                                <span style="color: #c678dd;">return 0;</span>;
                            }
                    </pre>

                        <h6>
                            <p><b>Instrucciones:</b></b></p>
                        </h6>
                        <p>Escribe un programa que imprima en la consola el mensaje <span style="color: #E61A4F;">"Hola, Mundo"</span>. Este es el primer paso para aprender a programar. El objetivo es que te familiarices con la estructura básica de un programa y la salida de texto en pantalla.</p>

                        <h6>
                            <p><b>Ejemplo:</b></p>
                        </h6>
                        <p>El programa debe simplemente imprimir el mensaje <span style="color: #E61A4F;">"Hola, Mundo"</span> en la consola cuando se ejecute.</p>

                        <h6>
                            <p><b>Entrada:</b></p>
                        </h6>
                        <p>No se requiere ninguna entrada para este ejercicio.</p>

                        <h6>
                            <p><b>Salida:</b></p>
                        </h6>
                        <p>El programa debe mostrar el siguiente mensaje en la consola:</p>
                        <pre style="background-color: #282c34; color: #61dafb; padding: 15px; border-radius: 8px;">
                            <span style="color: #E61A4F;">Hola, Mundo</span>
                        </pre>

                        <h6>
                            <p><b>Ejemplo de entrada:</b></p>
                        </h6>
                        <pre style="background-color: #282c34; color: #E61A4F; padding: 15px; border-radius: 8px;">
                            // (No hay entrada requerida)
                        </pre>

                        <h6>
                            <p><b>Ejemplo de salida:</b></p>
                        </h6>
                        <pre style="background-color: #282c34; color: #E61A4F; padding: 15px; border-radius: 8px;">
                            Hola, Mundo
                        </pre>

                        <h6>
                            <p><b>Restricciones:</b></p>
                        </h6>
                        <ul>
                            <li>El mensaje debe coincidir exactamente con <span style="color: #E61A4F;">"Hola, Mundo"</span>, sin espacios adicionales o cambios en mayúsculas/minúsculas.</li>
                            <li>No se debe realizar ningún tipo de cálculo, solo la impresión del mensaje en la consola.</li>
                        </ul>

                        <h6>
                            <p><b>Notas Adicionales:</b></p>
                        </h6>
                        <p>Este ejercicio es fundamental para entender cómo funcionan los programas y familiarizarse con el entorno de desarrollo. No te preocupes si parece sencillo, es el primer paso en el camino para aprender a programar.</p>

                    </section>

                </div>
            </div>
            <div class="divider horizontal-divider"></div>
            <div class="pane right-pane">
                <!-- Incluir aqui otro splitpane, pero ahora que sea vertical -->
                <div class="split-pane-vertical">
                    <div class="pane-content">
                        <div class="header-ide">
                            <div class="container-title-header-ide">
                                <img src="{{ asset('images/cpp-icon.png') }}" alt="c++ icon">
                                <div class="header-ide-grid-container">
                                    <div class="header-ide-title">Ejercicio 1.cpp</div>
                                    <div class="header-ide-copy ff-Formula-1"><button id="copyButton-exercise" onclick="copyCodeToClipboard('exercise')"><i class="fa-regular fa-clone"></i> Copiar código</button></div>
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
                                            <span>Asistente virtual</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body-ide-exercise ide-height">
                            <section class="body-ide-container" id="editor-preview-exercise"></section>
                        </div>
                    </div>
                    <div class="pane-content">
                        <div class="header-ide">
                            <div class="container-title-header-ide">
                                <div class="sample-terminal-container">
                                    <div class="sample-terminal-title">Terminal de salida</div>
                                    <div class="sample-terminal-run-time" id="terminal-run-time"></div>
                                    <div class="sample-terminal-run">
                                        <button class="button-11" id="execute-button">
                                            <i class="fa-solid fa-play"></i>
                                            <span>Correr</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body-terminal">
                            <div class="code-output bg-11 ide-height terminal-border">
                                <code class="sample-output" id="terminal-output">
                                    <!-- Here the output will be showed -->
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('js/ace-renders/ace-exercise-preview.js') }}"></script>
<script>
    let button = document.getElementById("execute-button");
    let terminal = document.getElementById("terminal-output");
    let runtime = document.getElementById("terminal-run-time");
    terminal.innerHTML = '<br><br>';

    button.addEventListener("click", function() {
        var codigo = editor_exercise.getValue();

        // Enviar el código al controlador usando fetch()
        fetch("{{ route('exersice.get-user-code') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Indicamos que enviamos un JSON
                    'X-CSRF-TOKEN': "{{ @csrf_token() }}"
                },
                body: JSON.stringify({
                    codigo: editor_exercise.getValue()
                })
            })
            .then(response => response.json()) // Asegúrate de que esperas un JSON aquí
            .then(data => {
                console.log(data);
                runtime.innerHTML = `Tiempo de ejecución: ${data.execution_time_ms} ms`;
                terminal.innerHTML = `<p><span id="code_text">~$</span> ${data.output}</p>`;
                if (data.output === '') {
                    runtime.innerHTML = `Tiempo de ejecución: 0 ms`;
                    terminal.innerHTML = `<p><span id="code_text">~$</span> ${data.error_message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>

<script>
    document.getElementById("nextExerciseButton").addEventListener("click", function() {
        // Cambiar el contenido de la sección
        document.getElementById("exerciseContent").innerHTML = `
            <h5><p><b>1. Ejercicio: Suma de Enteros</b></p></h5>



<h6><p><b><span style="color: #E61A4F;">Instrucciones:</span></b></b></p></h6>
<p>Escribe un programa que solicite al usuario dos números enteros (int), y luego imprima la suma de esos dos números.</p>

<h6><p><b>Ejemplo:</b></p></h6>
<p>El programa debe solicitar dos números enteros al usuario, sumarlos e imprimir el resultado.</p>

<h6><p><b>Entrada:</b></p></h6>
<p>El programa recibirá dos números enteros.</p>

<h6><p><b>Salida:</b></p></h6>
<p>La salida debe ser la suma de los dos números proporcionados.</p>

<h6><p><b>Ejemplo de entrada:</b></p></h6>
<pre style="background-color: #282c34; color: #E61A4F; padding: 15px; border-radius: 8px;">
<p>3</p>
7
</pre>

<h6><p><b>Ejemplo de salida:</b></p></h6>
<pre style="background-color: #282c34; color: #E61A4F; padding: 15px; border-radius: 8px;">
La suma es: 10
</pre>

<h6><p><b>Restricciones:</b></p></h6>
<ul>
    <li>Ambos números deben ser enteros (sin decimales).</li>
    <li>El programa solo debe realizar una suma básica.</li>
</ul>

<h6><p><b>Notas Adicionales:</b></p></h6>
<p>Este ejercicio te ayudará a trabajar con el tipo de dato int y a realizar operaciones aritméticas simples.</p>

        `;
    });
</script>


@endsection