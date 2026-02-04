@extends('layouts.layout')

@section('title', 'Hello World - Registra tu organización')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')

<main class="container-login">
    <!-- Background figures -->
    <img src="{{ asset('images/figures/square-2.png') }}" id="square-4">
    <img src="{{ asset('images/figures/square-1.png') }}" id="square-5">

    <div class="container-login-structure">
        <form action="{{ route('organization.store') }}" method="post" class="needs-validation container-login-box" id="reCAPTCHA-form" novalidate>
            @csrf
            <div class="container-login-form">
                <div class="login-form">
                    <h2>Registra tu organización</h2>

                    <div class="col-md-12 mg-top-15">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="name_organization" name="name_organization" type="text" placeholder="" value="{{ old('name_organization') }}" autocomplete="off" title="Por favor, introduce el nombre de la organización." required />
                            <label for="name_organization">Nombre de la organización <span class="text-danger">*</span></label>
                            <div class="invalid-feedback mb-2">
                                Por favor, introduce el nombre de la organización.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mg-top-15">
                        <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" id="org_category" name="org_category" required>
                                <option value="" selected disabled>Selecciona el tipo de organización</option>
                                @foreach ($orgCategories as $orgCategory)
                                <option value="{{ $orgCategory->id }}">{{ $orgCategory->org_category }}</option>
                                @endforeach
                            </select>
                            <label for="org_category">Tipo de organización <span class="text-danger">*</span></label>
                            <div class="invalid-feedback mb-2">
                                Por favor, selecciona el tipo de organización.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mg-top-15">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="email" name="email" type="email" placeholder="" value="{{ old('email') }}" autocomplete="off" title="Por favor, introduce tu nombre de usuario o correo electrónico." required />
                            <label for="email">Correo de contacto <span class="text-danger">*</span></label>
                            <div class="invalid-feedback mb-2">
                                Por favor, introduce tu correo de contacto.
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="button-8 g-recaptcha" style="margin-top: 15px;">Registrar</button>
                </div>
            </div>
            <div class="gradiant-login" data-aos="fade-left" data-aos-duration="1000">
                <div class="login-form">
                    <h2>Dirección de tu organización</h2>
                    <div class="row">
                        <div class="col-md-6 ps-1 pe-1">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="country" name="country" type="text" placeholder="" value="{{ old('country') }}" autocomplete="off" title="Por favor, introduce el país de la organización." required />
                                <label for="country">País <span class="text-danger">*</span></label>
                                <div class="invalid-feedback mb-2">
                                    Por favor, introduce el país de la organización.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-1 pe-1">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="state" name="state" type="text" placeholder="" value="{{ old('state') }}" autocomplete="off" title="Por favor, introduce el estado de la organización." required />
                                <label for="state">Estado <span class="text-danger">*</span></label>
                                <div class="invalid-feedback mb-2">
                                    Por favor, introduce el estado de la organización.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 ps-1 pe-1">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="city" name="city" type="text" placeholder="" value="{{ old('city') }}" autocomplete="off" title="Por favor, introduce la ciudad de la organización." required />
                                <label for="city">Ciudad <span class="text-danger">*</span></label>
                                <div class="invalid-feedback mb-2">
                                    Por favor, introduce la ciudad de la organización.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-1 pe-1">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="zip_code" name="zip_code" type="text" placeholder="" value="{{ old('zip_code') }}" autocomplete="off" title="Por favor, introduce el código postal de la organización." required />
                                <label for="zip_code">Código postal <span class="text-danger">*</span></label>
                                <div class="invalid-feedback mb-2">
                                    Por favor, introduce el código postal de la organización.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 ps-1 pe-1">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="street" name="street" type="text" placeholder="" value="{{ old('street') }}" autocomplete="off" title="Por favor, introduce la calle de la organización." required />
                                <label for="street">Calle y número <span class="text-danger">*</span></label>
                                <div class="invalid-feedback mb-2">
                                    Por favor, introduce la calle y número de la organización.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 ps-1 pe-1">
                            <div class="form-floating mb-3 mb-md-0 custom-floating-textarea">
                                <textarea class="form-control" id="description" name="description" placeholder="Descripción de la organización" autocomplete="off" title="Por favor, introduce la descripción de la organización." rows="4">{{ old('description') }}</textarea>
                                <label for="description">Descripción de la organización</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@endsection