@extends('layouts.layout')

@section('title', 'Hello World - Planes')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<main class="main-container">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">

    <section class="section-landingpage mg-bottom-75 pt-lg-5">
        <h1 class="h1-inter pd-h1 center-text">Selecciona el plan perfecto para tí</h1>
        <div class="container-plan-comparison" id="plans-container">
            <!-- Planes se cargarán aquí dinámicamente -->
        </div>
    </section>

    <h2 class="h2-inter text-center">Comparación de los Planes</h2>
    <section class="container-table100">
        <div class="wrap-table100">
            <div class="table100">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th></th>
                            <th>
                                <div class="container-thead-plan">
                                    <h4>Básico</h4>
                                    <p><span class="color-2">$0.00</span> USD / De por vida</p>
                                </div>
                                <div class="container-button-thead" id="basic-thead-button">
                                    <button type="button" onclick="redirectToWithScroll(`{{ url('/registrarse') }}, ${1}`)" class="button-12 ff-Inter fw-bolder">¡Empezar ahora!</button>
                                </div>
                            </th>
                            <th>
                                <div class="container-thead-plan">
                                    <h4>VIP</h4>
                                    <p><span class="color-2" id="vip-thead-price">$7.99</span> USD / <span id="vip-thead-duration">Mes</span></p>
                                </div>
                                <div class="container-button-thead" id="vip-thead-button">
                                    <button type="button" onclick="redirectToWithScroll(`{{ url('/registrarse') }}, ${2}`)" class="button-15 ff-Inter fw-bolder">¡Empezar ahora!</button>
                                </div>
                            </th>
                            <th>
                                <div class="container-thead-plan">
                                    <h4>Organizacional</h4>
                                    <p><span class="color-2">$699.99</span> USD / Año</p>
                                </div>
                                <div class="container-button-thead" id="org-thead-button">
                                    <button type="button" onclick="redirectToWithScroll(`{{ url('/registrarse') }}, ${3}`)" class="button-12 ff-Inter fw-bolder">¡Empezar ahora!</button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="desciption-table-plan">Compilación en tiempo real</td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Sin anuncios</td>
                            <td><b>-</b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Ejercicios por día</td>
                            <td><b>Limitados</b></td>
                            <td><b>Ilimitados</b></td>
                            <td><b>Ilimitados</b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Asistente virtual</td>
                            <td><b>Limitados</b></td>
                            <td><b>Ilimitados</b></td>
                            <td><b>Ilimitados</b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Calidad del asistente virtual</td>
                            <td><b>Básica</b></td>
                            <td><b>Alta</b></td>
                            <td><b>Alta</b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Revision de código con IA</td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Pistas por ejercicio</td>
                            <td><b>1</b></td>
                            <td><b>3</b></td>
                            <td><b>3</b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Acceso a soluciones comunitarias</td>
                            <td><b>Limitado</b></td>
                            <td><b>Ilimitado</b></td>
                            <td><b>Ilimitado</b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Acceso a todas las lecciones</td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Contenido actualizado</td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Facil explicación de ejercicios</td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Acceso a explicaciones gráficas</td>
                            <td><b>-</b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Asociar múltiples licencias</td>
                            <td><b>-</b></td>
                            <td><b>-</b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                        <tr>
                            <td class="desciption-table-plan">Asistencia prioritaria</td>
                            <td><b>-</b></td>
                            <td><b>-</b></td>
                            <td><b><i class="fa-solid fa-check color-2"></i></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<script>
    var plansURL = "{{ config('app.api') }}/api/v1/subscription-plans";
</script>
<script src="{{ asset('js/render-plans.js') }}"></script>

@endsection