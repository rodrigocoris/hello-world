@extends('layouts.layout')

@section('title', 'Hello World - Blog')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<div class="page-wrapper">
    <main class="main">
        <div class="blog-post mt-5">
            <section class="section_hero">
                <div class="wrapper">
                    <div class="post_wrapper">
                        <div id="w-node-b4637548-a9f1-aa70-a51d-79ba934a13a3-c2ab5980" class="post_toc ff-Helvetica">
                            
                        </div>
                        <div class="post_body">
                            <div class="margin_bottom-20">
                                <h1 class="fw-bolder ff-Inter">{{ $post->title }}</h1>
                            </div>
                            <div class="margin_bottom-20">
                                <div class="card_author is-featured"><img loading="lazy" width="48" height="48" alt=""
                                        src="{{ asset('images/Hello-World-Logo.png') }}"
                                        class="card_author-avatar" />
                                    <div class="card_author-info is-featured"><a href="../../profile/279195205.html" target="_blank"
                                            class="card_author-link text-weight-bold w-inline-block">
                                            <div>Por </div>
                                            <div>{{ $post->author }}</div>
                                        </a>
                                        <div class="div-block">
                                            <div class="text-block-4">Publicado el</div>
                                            <div class="text-block-5">{{ spanish_date($post->published_at) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="margin_bottom-20">
                                <div class="post_rich-text w-richtext">
                                    <p>{!! $post->excerpt !!}</p>
                                </div>
                            </div>
                            <div class="margin_bottom-48">
                                <div class="thumbnail-wrapper">
                                    <img loading="lazy" width="380" height="220" alt=""
                                        src="{{ asset('storage/' . $post->image) }}"
                                        sizes="(max-width: 479px) 93vw, (max-width: 991px) 96vw, (max-width: 1279px) 52vw, 730.830078125px"
                                        class="thumbnail" />
                                </div>
                            </div>
                            <div class="post_rich-text w-richtext">
                                {!! $post->content !!}
                            </div>
                        </div>
                        <div id="w-node-_345da83f-5aed-c428-4a4c-2bb9f781552a-c2ab5980" class="post_share"></div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="wrapper">
                    <div class="post_wrapper">
                        <div id="w-node-_9615335b-a717-1c0b-6b0b-9c642c75b6b2-c2ab5980" class="empty-div small"></div>
                        <div id="w-node-_9615335b-a717-1c0b-6b0b-9c642c75b6b3-c2ab5980" class="post_body">
                            <div class="margin_bottom-48">
                                <div class="post_author-wrapper"><img loading="lazy" width="48" height="48" alt=""
                                        src="{{ asset('images/Hello-World-Logo.png') }}"
                                        class="post_author-avatar" />
                                    <div class="post_author-info">
                                        <div class="opacity-50">
                                            <div>Por</div>
                                        </div>
                                        <div>{{ $post->author }}</div>
                                        <div class="text-size-small">Un desarrollador de software apasionado por la creación de soluciones tecnológicas innovadoras.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="w-node-_9615335b-a717-1c0b-6b0b-9c642c75b6e9-c2ab5980" class="empty-div"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

@endsection