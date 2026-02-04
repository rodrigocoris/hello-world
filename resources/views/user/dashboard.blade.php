@extends('layouts.layout')

@section('title','Hello World - Módulos')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<img src="{{ asset('images/figures/square-1.png') }}" id="bol-1">
<img src="{{ asset('images/figures/square-2.png') }}" id="square-2">

<main class="dashboard-container">
    <div class="container mt-4">
        <div class="row g-4">
            <!-- Calendar and Graph Column -->
            <div class="col-md-3">
                <div class="container-info-perfil" data-aos="fade-right" data-aos-duration="1000">
                    <div class="photo-container">
                        <img src="{{ asset('images/avatars/cool-bread.jpg') }}" class="img-avatar" alt="Avatar del usuario">
                        <div class="user-status-info">
                            <ul>
                                <li><h5 class="fw-bolder">{{ Auth::user()->username }}</h5></li>
                                <li><p class="fs-13-5 color-7">{{ Auth::user()->email }}</p></li>
                                <li class="li-separation-bar-1"></li>
                                <li><p class="fs-15 ff-Formula-1">Plan: <span class="color-7">{{ Auth::user()->userRole->role_name }}</span></p> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modules Column -->
            <div class="col-md-9">
                @foreach ($modules as $module)
                <div class="exercise-card {{ $module->state }}" onclick="redirectTo(`{{ url('/modulo/'.$module->module) }}`)" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="exercise-title">{{ $module->module }}</h2>
                    <p><b>Lenguaje:</b> {{ $module->language }}</p>
                    
                    <p><b>Progreso:</b> {{ $module->progress_percentage }}%</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $module->progress_percentage }}%" aria-valuenow="{{ $module->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="status mt-2">
                        @if ($module->state == 'disabled')
                            <i class="fa-solid fa-lock"></i> No iniciado
                        @elseif ($module->state == 'completed')
                            <i class="fa-solid fa-check"></i> Completado
                        @else
                            En progreso
                        @endif
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const shortLabels = ['D', 'L', 'Ma', 'Mi', 'J', 'V', 'S'];
    const data = {
        labels: shortLabels,
        datasets: [{
            label: '',
            data: [0, 100, 50, 150, 150, 250, 150],
            fill: true,
            borderColor: 'rgb(230, 26, 79)',
            backgroundColor: 'rgba(230, 26, 79, 0.05)',
            tension: 0.1
        }]
    };
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const label = labels[index];
                            const value = context.raw;
                            return `${label} ${value} niveles de xp`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, config);
});
</script>

@endsection