@extends('layouts.layout')

@section('title','Hello World - Ejercicios')

<meta name="difficulty-data" content="{{ json_encode($difficultyData) }}">

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<img src="{{ asset('images/figures/square-1.png') }}" id="bol-1">
<img src="{{ asset('images/figures/square-2.png') }}" id="square-2">

<main class="dashboard-container">
    <div class="container mt-4">
        <div class="row g-4">
            <!-- Exercises Column -->
            <div class="col-md-9">
                @foreach ($exercises as $exercise)
                <div class="exercise-card completed" onclick="redirectTo(`{{ url('/ejercicio/'.$exercise->exercise_token) }}`)">
                    <h2 class="exercise-title">{{ $exercise->exercise }}</h2>
                    <p><b>Lección:</b> {{ $exercise->lesson->lesson }}</p>
                    <span class="badge bg-difficult-{{ $exercise->difficulty_id }}">{{ $exercise->difficulties->level }}</span>
                    <p class="status unlocked">Completed</p>
                </div>
                @endforeach
            </div>
            <!-- Calendar and Graph Column -->
            <div class="col-md-3">
                <!-- Graph -->
                <div class="calendar-container">
                    <h4 class="text-center">Dificultad de ejercicios</h4>
                    <canvas id="difficultyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Obtener datos de dificultades desde el meta tag
            const rawDifficultyData = document.querySelector('meta[name="difficulty-data"]').getAttribute('content');
            let difficultyData = [];

            try {
                difficultyData = JSON.parse(rawDifficultyData); // Parsear el JSON
                console.log(difficultyData);
            } catch (error) {
                console.error("Error parsing difficulty data:", error);
                return;
            }

            // Colores predefinidos mapeados por ID
            const difficultyColors = {
                1: '#62C4F3', // Fácil (Azul Claro)
                2: '#32C766', // Moderado (Verde Claro)
                3: '#E6DB74', // Intermedio (Amarillo Claro)
                4: '#5F58FF', // Difícil (Azul Violeta)
                5: '#E61A4F', // Hacker (Rojo)
            };

            // Generar etiquetas, datos y colores
            const labels = difficultyData.map(item => item.level); // Nombres de las dificultades
            const data = difficultyData.map(item => item.count); // Conteo de cada dificultad
            const backgroundColors = difficultyData.map(item => difficultyColors[item.difficulty_id]); // Colores según ID

            // Crear el gráfico de Pie usando Chart.js
            const ctx = document.getElementById('difficultyChart').getContext('2d');
            const difficultyChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels, // Etiquetas (Fácil, Medio, etc.)
                    datasets: [{
                        data: data, // Conteo de dificultades
                        backgroundColor: backgroundColors, // Colores dinámicos según ID
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#212529',
                            },
                        },
                    },
                },  
            });
        });
    </script>
</main>

@endsection