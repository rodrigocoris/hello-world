@extends('layouts.layout')

@section('title','Panel de usuario')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')


@section('content')
    <style>
        body {
            margin-top: 0;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;    
        }
        .main-body {
            padding-top: 20;
            padding-bottom: 15px;
            padding-left: 15px;
            padding-right: 15px;
        }
        .card {
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #f8f9fa;
            background-clip: border-box;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
        }
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }
        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }
        .gutters-sm>.col, .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }
        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }
        .bg-gray-300 {
            background-color: #e2e8f0;
        }
        .h-100 {
            height: 100%!important;
        }
        .shadow-none {
            box-shadow: none!important;
        }
        .form-control {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }
        .progress {
            background-color: #e9ecef;
            border-radius: 0.5rem;
        }
        .button-5, .button-6 {
            margin-top: 20px;
            padding: 8px 12px;
            font-size: 13px;
            min-height: 25px;
        }
        .button-6 {
            margin-left: 10px;
            padding: 8px 12px;
            font-size: 13px;
            min-height: 25px;
        }
        .button-6[type="submit"] {  /* Específico para el botón de guardar */
            padding: 10px 15px;      /* Reduce el padding interno */
            font-size: 14px;        /* Reduce el tamaño de la fuente */
            height: auto;           /* Altura automática */
            min-height: 30px;       /* Altura mínima */
            width: auto;            /* Ancho automático basado en el contenido */
        }
        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .progress {
            background-color: #e9ecef;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 0.6s ease;
        }
        .progress-text {
            min-width: 40px;
        }
        .list-group-item {
            transition: background-color 0.3s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;  /* Espacio entre el título y la barra */
        }
        .progress {
            background-color: #e9ecef;
            border-radius: 0.5rem;
            overflow: hidden;
            flex-grow: 1;     /* La barra ocupará todo el espacio disponible */
        }
        .progress-bar {
            transition: width 0.6s ease;
        }
        .progress-text {
            min-width: 45px;
            text-align: right;
        }
        .module-title {
            display: flex;
            align-items: center;
        }
        .list-group-item {
            transition: background-color 0.3s ease;
            padding: 15px 20px;  /* Aumentado el padding para mejor espaciado */
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        /* Para alinear el icono con el texto */
        .icon-inline {
            margin-right: 8px;
            vertical-align: middle;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 15px 20px;
        }
        .card-header h5 {
            color: #333;
            font-weight: 500;
            margin: 0;
        }
        .module-card {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 15px;
            height: 100%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .progress {
            background-color: #e9ecef;
            border-radius: 0.5rem;
            overflow: hidden;
            flex-grow: 1;
        }
        .progress-bar {
            transition: width 0.6s ease;
            background-color: #E61A4F !important;
        }
        .progress-text {
            min-width: 45px;
            text-align: right;
        }
        .module-title {
            display: flex;
            align-items: center;
        }
        .module-title h6 {
            font-size: 0.9rem;
            line-height: 1.2;
            margin-bottom: 0;
        }
        .icon-inline {
            margin-right: 8px;
            vertical-align: middle;
        }
        @media (min-width: 768px) {
            .card-body .row {
                margin-right: -10px;
                margin-left: -10px;
            }
            
            .card-body .col-md-6 {
                padding-right: 10px;
                padding-left: 10px;
            }
        }
        .module-card {
            padding: 12px;
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;  /* Línea separadora */
            margin-bottom: 15px;               /* Más espacio entre módulos */
        }

        /* Estilo para el último módulo de cada card */
        .module-card:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .module-title h6 {
            font-size: 0.85rem;
            color: #666;
            margin: 0;
            padding-bottom: 8px;    /* Espacio entre título y barra de progreso */
        }

        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .progress {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            flex-grow: 1;
        }

        .progress-bar {
            background-color: #E61A4F !important;
            transition: width 0.6s ease;
        }

        .progress-text {
            min-width: 35px;
            text-align: right;
            font-size: 0.75rem;
        }

        .icon-inline {
            margin-right: 4px;
            vertical-align: -3px;
        }

        .card-body {
            padding: 1.25rem;      /* Aumentado el padding del card-body */
        }

        /* Agregar un sutil efecto hover */
        .module-card:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .col-12 {
            margin-bottom: 7px;  /* Espacio entre módulos */
            padding: 0 10px;      /* Padding horizontal */
        }

        .col-12:last-child {
            margin-bottom: 0;     /* Eliminar margen del último módulo */
        }

        .module-card {
            background-color: #fff;
            padding: 15px;        /* Padding interno del módulo */
            border-radius: 5px;   /* Bordes redondeados */
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);  /* Sutil sombra */
        }

        .module-title h6 {
            font-size: 0.85rem;
            color: #666;
            margin: 0;
            padding-bottom: 8px;
        }

        .progress-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .progress {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            flex-grow: 1;
        }

        .progress-bar {
            background-color: #E61A4F !important;
            transition: width 0.6s ease;
        }

        .progress-text {
            min-width: 35px;
            text-align: right;
            font-size: 0.75rem;
        }

        .icon-inline {
            margin-right: 4px;
            vertical-align: -3px;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Efecto hover */
        .module-card:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        /* Estilos adicionales para el título */
        .text-muted {
            color: #6c757d !important;
        }

        /* Ajustar el espaciado */
        .mb-3 {
            margin-bottom: 1rem !important;
        }

        /* Asegurar que las cards tengan la misma altura */
        .card.h-100 {
            height: 100% !important;
        }
    </style>

<img src="{{ asset('images/figures/square-1.png') }}" id="square-2">
<img src="{{ asset('images/figures/square-1.png') }}" id="square-5">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-id" content="{{ Auth::id() }}">

<!-- <h1>Mi perfil {{ Auth::user()->username }}</h1>-->

<div class="container">
    <div class="main-body">
            <!-- Breadcrumb -->
            <!-- <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>-->
            <!-- /Breadcrumb -->
        
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Perfil de Usuario</h5>
                    </div>
                    <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="images/Hello-World-Logo.png" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-5">
                        <h4>{{ Auth::user()->username }}</h4>
                        <p class="text-secondary mb-1"><h6>{{ Auth::user()->email }}</h6></p>
                        <p class="text-muted font-size-md">cuenta creada desde<h6>{{ Auth::user()->created_at}}</h6></p>
                        <div class="mt-3">
                            <button class="button-5">Ejercicios</button>
                            <button class="button-6">Modulos</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Username</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" value="{{ Auth::user()->username }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Password</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" class="form-control" value="{{ Auth::user()->password }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Tipo de Plan</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select class="form-control">
                                        <option value="{{ Auth::user()->role_id }}">Plan actual</option>
                                        <option value="1">Plan Básico</option>
                                        <option value="2">Plan Premium</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Organización</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" value="{{ Auth::user()->organization_id }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="button-5">Editar</button>
                                    <button class="button-6">Eliminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                
                </div>
                
                <div class="row gutters-sm">
                    <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                                <h5 class="mb-0">Módulos Básicos</h5>
                            </div>
                            <div class="card-body">
                                <div class="row" id="modules-progress-1">
                                    <!-- Los primeros 5 módulos se generarán aquí -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Módulos Avanzados</h5>
                        </div>
                        <div class="card-body">
                            <div class="row" id="modules-progress-2">
                                <!-- Los últimos 5 módulos se generarán aquí -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            
            </div>
        </div>
            
            </div>
        </div>

        <script src="{{ asset('js/profile.js') }}"></script>

@endsection
