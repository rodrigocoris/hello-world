@extends('layouts.layout')

@section('title', 'Hello World - Blog')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<div class="page-wrapper mt-5">
    <main class="main blog-content">
        <section class="section_hero">
            <div class="wrapper">
                <div class="w-dyn-list">
                    <div role="list" class="w-dyn-items">
                        <div role="listitem" class="w-dyn-item">
                            <div class="card is-featured">
                                <div class="card_featured-content">
                                    <div class="card_featured-info">
                                        <div class="card_content">
                                            <a href="{{ route('blog.show', $featuredBlog->slug) }}"
                                                class="card_content-link is-featured w-inline-block">
                                                <h1 class="fw-bolder">{{ $featuredBlog->title }}</h1>
                                                <div class="text-size-large lh-1-5">
                                                    <p class="ff-PT-Root-UI fw-light">{{ $featuredBlog->excerpt }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card_author is-featured">
                                        <img loading="lazy" width="48" height="48" alt=""
                                            src="{{ asset('images/Hello-World-Logo.png') }}"
                                            class="card_author-avatar" />
                                        <div class="card_author-info is-featured">
                                            <div>Por </div>
                                            <div>{{ $featuredBlog->author }}</div>
                                            <div class="card_time">
                                                <div>{{ spanish_date($featuredBlog->published_at) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('blog.show', $featuredBlog->slug) }}" class="thumbnail-wrapper is-featured w-inline-block">
                                    <img loading="lazy" width="380" height="220"
                                        alt="featured article image"
                                        src="{{ asset('storage/' . $featuredBlog->image) }}"
                                        sizes="(max-width: 479px) 93vw, (max-width: 767px) 96vw, (max-width: 1279px) 45vw, 548.0078125px"
                                        class="thumbnail" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section_large bg-gradient-pink">
            <div class="wrapper">
                <div class="flex-h center-space-between">
                    <a href="{{ url('/registrarse') }}" class="button-primary w-inline-block">
                        <div>Prueba Gratis</div>
                    </a>
                    <div class="heading-style-h2 text-end">Bienvenido a Hello World<br />Aprende, Codifica y Mejora</div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="wrapper">
                <div class="w-dyn-list">
                    <div class="card-cms_grid-col-3 w-dyn-items">
                        @foreach ($blogs as $blog)
                        <div class="w-dyn-item">
                            <div class="card">
                                <div class="margin_bottom-32">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="thumbnail-wrapper w-inline-block">
                                        <img loading="lazy" width="380" height="220"
                                            src="{{ asset('storage/' . $blog->image) }}"
                                            alt="{{ $blog->title }}"
                                            class="thumbnail" />
                                    </a>
                                </div>
                                <div class="card_content">
                                    <a href="{{ route('blog.show', $blog->slug) }}"
                                        class="card_content-link w-inline-block">
                                        <h2 class="heading-style-h3">{{ $blog->title }}</h2>
                                        <div class="text-size-small">{{ $blog->excerpt }}</div>
                                    </a>
                                    <div class="card_author">
                                        <img loading="lazy" width="48" height="48" alt=""
                                            src="{{ asset('images/Hello-World-Logo.png') }}"
                                            class="card_author-avatar" />
                                        <aside class="card_author-info">
                                            <div>Por </div>
                                            <div>{{ $blog->author }}</div>
                                        </aside>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

@endsection