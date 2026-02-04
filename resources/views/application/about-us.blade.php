@extends('layouts.layout')

@section('title', 'Hello World - Acerca de nosotros')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<main class="main-container">

    <!-- Titulo y 3 cosas-->
    <section class="cid-qIoWJUOnqf  mbr-parallax-background">
        <div class="container text-content">
            <h1 class="pb-3 align-center display-3" style="color: var(--color-1);">
                Hello World
            </h1>
            <p class="pb-3 ff-Helvetica align-center display-8 lh-base" style="color: var(--color-1);">
                En Hello World, entendemos que aprender a programar no es solo acerca de escribir código, sino de pensar de manera lógica y resolver problemas de forma creativa. Por eso, nos enfocamos en brindarte un entorno de aprendizaje dinámico donde puedas practicar tus habilidades a tu propio ritmo, enfrentarte a desafíos reales y obtener retroalimentación instantánea. Con nuestro enfoque estructurado, no solo dominarás el lenguaje de programación, sino que también desarrollarás la confianza para aplicar tus conocimientos en proyectos del mundo real.
            </p>
        </div>
    </section>

    <!-- Mision-->
    <section class="cid-qIp7KFGlXe" id="content7-8" data-sortbtn="btn-primary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 align-center">
                    <h2 class="mbr-section-title align-center mbr-bold display-6"
                        style="color: var(--color-2);">
                        Nuestra Mision</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="features16 cid-qIp0qVn2Fg" id="features16-5" data-sortbtn="btn-primary">
        <div class="container">
            <div class="row main align-items-center">
                <div class="col-md-6 image-element">
                    <div class="img-wrap">
                        <img src="{{ asset('assets/images/accesible.jpg') }}" alt="" title="">
                    </div>
                </div>
                <div class="col-md-6 text-element">
                    <div class="text-content">
                        <div class="mbr-section-text">
                            <p class="mbr-text pt-3 mbr-light ff-Helvetica align-left display-8">
                                Integramos tecnología avanzada y herramientas innovadoras (IA),
                                ayudamos a nuestros usuarios a comprender y dominar la lógica de programación,
                                facilitando un entorno seguro.

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4 Razones-->
    <section class="features18 cid-qIoZwj9I6L mbr-parallax-background" id="features18-4" data-sortbtn="btn-primary">
        <div class="mbr-overlay" style="opacity: 0.8; background-color: rgb(35, 35, 35);">
        </div>
        <div class="container">
            <div class="row justify-content-center content-row">
                <div class="col-md-6 content-column">
                    <h2 class="mbr-title pt-2 align-left mbr-white display-6"
                        style="color: var(--color-2);">
                        4 Razones para Elegir Hello World
                    </h2>
                    <p class="mbr-text mbr-section-text pt-3 ff-Helvetica align-left mbr-white display-8">
                        Descubre por qué Hello World es la plataforma ideal para dominar la lógica de programación y
                        avanzar en tus habilidades de codificación.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <span class="num mbr-bold display-3">01.</span>
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Aprendizaje Interactivo
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Participa en una variedad de ejercicios lógicos en un entorno dinámico. Nuestro IDE
                                    interactivo y la terminal virtual te proporcionan una mejor experiencia.
                                </p>
                            </div>
                        </div>
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <span class="num mbr-bold display-3">02.</span>
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Asistencia con IA
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Benefíciate del soporte en tiempo real con nuestro asistente de IA. Ofrece
                                    retroalimentación para mejorar tus habilidades de codificación.
                                </p>
                            </div>
                        </div>
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <span class="num mbr-bold display-3">03.</span>
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Currículo Integral
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Sigue un camino de aprendizaje estructurado con etapas, secciones y lecciones.
                                    Adquiere competencia a través de ejercicios y desafíos.
                                </p>
                            </div>
                        </div>
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <span class="num mbr-bold display-3">04.</span>
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Mejores precios
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Ya sea que estés empezando en el mundo de la programación o busques mejorar
                                    habilidades avanzadas, nuestras planes se adaptan a tus necesidades de aprendizaje.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision -->
    <section class="cid-qIp7KFGlXe" id="content7-8" data-sortbtn="btn-primary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 align-center">
                    <h2 class="mbr-section-title align-center mbr-bold display-6"
                        style="color: var(--color-2);">
                        Nuestra Visión
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section class="features16 cid-qIp0qVn2Fg" id="features16-5" data-sortbtn="btn-primary">
        <div class="container">
            <div class="row main align-items-center">
                <div class="col-md-6 image-element">
                    <div class="img-wrap">
                        <img src="{{ asset('assets/images/futuro.jpg') }}" alt="" title="">
                    </div>
                </div>
                <div class="col-md-6 text-element">
                    <div class="text-content">
                        <div class="mbr-section-text">
                            <p class="mbr-text pt-3 mbr-light ff-Helvetica align-left display-8">
                                Llegar a ser una plataforma reconocida por su capacidad de hacer que el desarrollo de la
                                lógica de programación
                                sea accesible y enriquecedor para todos. Continuaremos innovando con tecnologías
                                avanzadas como inteligencia artificial,
                                siendo una plataforma de desarrollo segura, transformando la forma en que las personas
                                aprenden y aplican la programación en un entorno global.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Valores-->
    <section class="cid-qIoZwj9I6L2 mbr-parallax-background" id="features18-4" data-sortbtn="btn-primary">
        <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(35, 35, 35);">
        </div>
        <div class="container">
            <div class="row justify-content-center content-row">
                <div class="col-md-6 content-column">
                    <h2 class="mbr-title pt-2 align-left mbr-white display-6">
                        Nuestros Valores
                    </h2>
                    <p class="mbr-text mbr-section-text pt-3 ff-Helvetica align-left mbr-white display-8">
                        Conoce los principios fundamentales que guían nuestra plataforma y definen nuestra misión de
                        transformar el aprendizaje en programación.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Innovación Continua
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Nos dedicamos a integrar las últimas tecnologías para mantener nuestros recursos y
                                    herramientas actualizados.
                                </p>
                            </div>
                        </div>
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Inclusividad
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Fomentamos un entorno de aprendizaje accesible para todos, sin importar sus
                                    conocimientos, habilidades o formacion.
                                </p>
                            </div>
                        </div>
                        <div class="card p-3 col-md-6">
                            <div class="card-box">
                                <div class="title">
                                    <h4 class="card-title m-0 mbr-bold mbr-white display-8">
                                        Compromiso con la Calidad
                                    </h4>
                                </div>
                                <p class="mbr-text card-text ff-Helvetica mbr-white display-8">
                                    Priorizamos la excelencia en cada aspecto de nuestra plataforma, garantizando que
                                    nuestros usuarios reciban contenido relevante y de alta calidad.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Equipo -->
    <section class="teams1 cid-qIoZsmrGyp" id="teams2-3" data-sortbtn="btn-primary">
        <div class="container">
            <h2 class="mbr-section-title align-center mbr-black display-6">Conoce a nuestro equipo
            </h2>
            <div class="row justify-content-center flip-card pt-4">
                <div class="col-md-4 col-lg-3 card-wrap">
                    <div class="image-wrap">
                        <img src="{{ asset('assets/images/davi.jpg') }}" alt="">
                        <div class="social-media align-center">
                            <ul>
                                <li>
                                    <a class="icon-transition" href="https://www.facebook.com/Mobirise">
                                        <span class="mbr-iconfont mbr-black socicon-github socicon"></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="icon-transition" href="https://twitter.com/mobirise">
                                        <span class="mbr-iconfont mbr-black socicon-linkedin socicon"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="img-overlay"></div>
                    </div>
                    <h4 class="mbr-name align-left pt-4 mbr-bold">
                        David Loera
                    </h4>

                    <p class="ff-Helvetica mbr-text align-left pt-1">
                        Frontend and Backend Developer
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 card-wrap">
                    <div class="image-wrap">
                        <img src="{{ asset('assets/images/carlos.jpg') }}" alt="">
                        <div class="img-overlay"></div>
                        <div class="social-media align-center">
                            <ul>
                                <li>
                                    <a class="icon-transition" href="https://www.facebook.com/Mobirise">
                                        <span class="mbr-iconfont mbr-black socicon-github socicon"></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="icon-transition" href="https://twitter.com/mobirise">
                                        <span class="mbr-iconfont mbr-black socicon-linkedin socicon"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h4 class="mbr-name align-left pt-4 mbr-bold">
                        Carlos Lopez
                    </h4>

                    <p class="ff-Helvetica mbr-text align-left pt-1">
                        CEO & CCO
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 card-wrap">
                    <div class="image-wrap">
                        <img src="{{ asset('assets/images/rodri.jpg') }}" alt="">
                        <div class="img-overlay"></div>
                        <div class="social-media align-center">
                            <ul>
                                <li>
                                    <a class="icon-transition" href="https://www.facebook.com/Mobirise">
                                        <span class="mbr-iconfont mbr-black socicon-github socicon"></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="icon-transition" href="https://twitter.com/mobirise">
                                        <span class="mbr-iconfont mbr-black socicon-linkedin socicon"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h4 class="mbr-name align-left pt-4 mbr-bold">
                        Rodrigo Ramos
                    </h4>

                    <p class="ff-Helvetica mbr-text align-left pt-1">
                        Contributor
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Separador final-->
    <section class="cid-qIpcXer6tV2 mbr-parallax-background" id="content9-a" data-sortbtn="btn-primary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 align-center">
                    <h2 class="mbr-section-title align-left mbr-bold mbr-white display-6"style="color: var(--color-2);">We are Hello World</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog -->

    <section class="features19 cid-qIpf9Jg0yJ" id="features12-b" data-sortbtn="btn-primary">


        <div class="container">
            <h2 class="mbr-section-title align-left mbr-bold display-6">Lee mas sobre nuestras actualizaciones y novedades en nuestro Blog</h2>

            <div class="row justify-content-center align-items-start mt-5">

                @foreach ($blogs as $blog)
                    <div class="col-md-4 w-dyn-item">
                        <div class="card">
                        <div class="margin_bottom-32">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="thumbnail-wrapper w-inline-block post-thumbnail">
                                <img loading="lazy" width="380" height="220"
                                    src="{{ asset('storage/' . $blog->image) }}"
                                    alt="{{ $blog->title }}"
                                    class="thumbnail post-img-thumbnail" />
                            </a>
                        </div>
                        <div class="card_content">
                            <a class="post-thumbnail" href="{{ route('blog.show', $blog->slug) }}"
                                class="card_content-link w-inline-block">
                                <h2 class="heading-style-h3 ff-Arial fw-bold color-11 mb-2 mt-2">{{ $blog->title }}</h2>
                                <div class="text-size-small ff-Helvetica color-11 mb-2 mt-2">{{ $blog->excerpt }}</div>
                            </a>
                            <div class="d-flex gap-2 card_author">
                                <img loading="lazy" width="48" height="48" alt=""
                                    src="{{ asset('images/Hello-World-Logo.png') }}"
                                    class="card_author-avatar" />
                                <aside class="card_author-info">
                                    <div class="ff-Helvetica">Por </div>
                                    <div class="ff-Helvetica">{{ $blog->author }}</div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            
            </div>
        </div>
    </section>
</main>

@endsection