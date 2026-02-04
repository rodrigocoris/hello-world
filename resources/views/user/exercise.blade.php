@extends('layouts.layout')

@section('title','Hello World - ' . $exercise->exercise)

<meta name="execute_url" content="{{ route('exercise.execute') }}">
<meta name="improve_url" content="{{ route('assistant.improve') }}">
<meta name="explain_url" content="{{ route('assistant.explain') }}">
<meta name="body_code" content="{{ $exercise->body_code }}">

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<main class="dashboard-container dark-mode">
    <!-- Contenedor principal -->
    <div id="container">
        <!-- Panel izquierdo para el enunciado del ejercicio -->
        <div id="panel-left" class="exercise-panel">
            <div class="panel-header">
                <a href="#" class="panel-link"><i class="fa-solid fa-align-left" style="color: var(--color-16);"></i><span> Descripción</span></a>
                <a href="{{ url('/modulo/' . $exercise->lesson->module->module) }}" target="_blank" class="panel-link"><i class="fa-solid fa-book" style="color: var(--color-17);"></i><span> Lección</span></a>
            </div>
            <div class="panel-content">
                {!! $exercise->description !!}
            </div>
        </div>

        <div class="editor-container">
            <!-- Panel superior para el editor de código -->
            <div id="panel-top" class="exercise-panel">
                <div class="panel-header">
                    <!-- Nombre del archivo -->
                    <div class="panel-title">
                        <span class="panel-link">
                            <i class="fa-solid fa-file-code" style="color: var(--color-13);"></i>
                            <span> {{ $exerciseSlug }}.cpp</span>
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
                    <div class="panel-actions">
                        <button id="copyButton-exercise" class="header-ide-copy" onclick="copyCodeToClipboard('exercise')"><i class="fa-regular fa-clone"></i> Copiar</button>
                        <button class="button-9 ff-inter" id="assistant-button">
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
                            <span>Ocultar asistente</span>
                        </button>
                    </div>
                </div>
                <div class="panel-content">
                    <div id="code-editor"></div>
                </div>
            </div>

            <!-- Panel inferior para la consola de salida -->
            <div id="panel-bottom" class="exercise-panel">
                <div class="panel-header">
                    <!-- Enlaces alineados a la izquierda -->
                    <div class="panel-links">
                        <a href="#" id="switch-to-input" class="panel-link">
                            <i class="fa-solid fa-keyboard" style="color: var(--color-20);"></i>
                            <span> Entrada</span>
                        </a>
                        <a href="#" id="switch-to-console" class="panel-link">
                            <i class="fa-solid fa-terminal" style="color: var(--color-21);"></i>
                            <span> Consola de Salida</span>
                        </a>
                    </div>

                    <!-- Acciones alineadas a la derecha -->
                    <div class="panel-actions">
                        <span id="terminal-run-time"></span>
                        <button class="button-11" id="execute-button">
                            <i class="fa-solid fa-play"></i>
                            <span> Correr</span>
                        </button>
                    </div>
                </div>
                <div class="panel-content">
                    <!-- Entrada -->
                    <div id="input-view" class="view hidden">
                        <label for="user-input">
                            Entrada:
                        </label>
                        <input
                            type="text"
                            id="user-input"
                            placeholder="Escribe la entrada en formato de lista (ejemplo: [1, 2, 3])"
                            value="{{ $exercise->test_cases ?? '' }}" />
                    </div>
                    <!-- Consola de Salida -->
                    <div id="console-view" class="view">
                        <div id="terminal-output">
                            <span id="code_text">execute@hello-world:<span>~$</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('layouts.assistant')

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/split.js/1.6.0/split.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/theme-molokai.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/mode-c_cpp.js"></script>
<script src="{{ asset('js/exercise.js') }}"></script>

@endsection