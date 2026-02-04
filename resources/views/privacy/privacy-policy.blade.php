@extends('layouts.layout')

@section('title', 'Términos de Servicio')

@section('content')

@include('layouts.alerts')

@include('layouts.reCAPTCHA')
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
    }

    h1 {
        font-size: 3.25rem;
        color: #333;
    }

    h2 {
        font-size: 2rem;
        color: #333;
    }

    p {
        margin: 10px 0;
        font-size: 1.25rem;
    }
</style>


<div class="container">

    <h1>Políticas de Privacidad de <span class="ff-Formula-1">Hello World</span></h1>

    <section>
        <h2>1. Introducción</h2>
        <p>En Hello World, respetamos su privacidad y estamos comprometidos a proteger la
            información
            personal que
            nos
            proporciona. Esta política de privacidad explica cómo recopilamos, usamos y
            protegemos su
            información,
            en
            cumplimiento con la Ley Federal de Protección de Datos Personales en Posesión de
            los
            Particulares de
            México.</p>
    </section>

    <section>
        <h2>2. Información que Recopilamos</h2>
        <p><strong>Información Personal:</strong> Recopilamos información como nombre de
            usuario, correo
            electrónico,
            contraseñas y datos de pago.</p>
        <p><strong>Datos de Uso:</strong> Recopilamos información sobre cómo accede y usa la
            plataforma,
            incluyendo
            su
            dirección IP, tipo de navegador, páginas visitadas y la fecha y hora de sus visitas.
        </p>
    </section>

    <section>
        <h2>3. Uso de la Información</h2>
        <p><strong>Proveer Servicios:</strong> Utilizamos su información para proporcionar y
            mejorar
            nuestros
            servicios,
            incluyendo la gestión de su cuenta y el procesamiento de pagos.</p>
        <p><strong>Comunicaciones:</strong> Podemos usar su información para enviarle
            actualizaciones,
            boletines y
            notificaciones importantes relacionadas con su uso de la plataforma.</p>
    </section>
    <section>
        <h2>4. Compartir su Información</h2>
        <p><strong>Con Terceros:</strong> Compartimos su información con terceros solo cuando es
            necesario
            para
            proporcionar
            nuestros servicios, como con la API de PayPal para el procesamiento de pagos. Nos
            aseguramos de
            que
            estos
            terceros cumplan con las regulaciones de protección de datos aplicables.</p>
        <p><strong>Requerimientos Legales:</strong> Podemos divulgar su información si es
            requerido por la
            ley o en
            respuesta a solicitudes legales por parte de autoridades públicas.</p>
    </section>

    <section>
        <h2>5. Seguridad de la Información</h2>
        <p>Implementamos medidas de seguridad técnicas y organizativas para proteger su
            información contra
            accesos
            no
            autorizados, alteraciones, divulgación o destrucción. Esto incluye el uso de cifrado
            y otros
            métodos de
            seguridad para proteger los datos sensibles.</p>
    </section>

    <section>
        <h2>6. Retención de Datos</h2>
        <p>Retenemos su información personal solo durante el tiempo que sea necesario para
            cumplir con los
            propósitos
            descritos en esta política de privacidad, salvo que la ley disponga lo contrario.
        </p>
    </section>

    <section>
        <h2>7. Derechos del Usuario</h2>
        <p><strong>Acceso y Corrección:</strong> Usted tiene derecho a acceder y corregir su
            información
            personal en
            cualquier momento. Puede actualizar su información a través de la configuración de
            su cuenta en
            la
            plataforma.
        </p>
        <p><strong>Eliminar Información:</strong> Puede solicitar la eliminación de su cuenta y
            datos
            personales
            contactándonos a través de <a
                href="mailto:{{ config('app.business.email') }}">{{ config('app.business.email') }}</a>.
            Procesaremos su
            solicitud de acuerdo con las leyes aplicables.</p>
    </section>

    <section>
        <h2>8. Cambios en la Política de Privacidad</h2>
        <p>Nos reservamos el derecho de modificar esta política de privacidad en cualquier
            momento.
            Cualquier cambio
            será
            publicado en esta página y, si los cambios son significativos, proporcionaremos un
            aviso más
            destacado.
        </p>
    </section>

    <section>
        <h2>9. Contacto</h2>
        <p>Si tiene alguna pregunta sobre esta política de privacidad o nuestras prácticas de
            protección de
            datos,
            contáctenos a través de <a
                href="mailto:{{ config('app.business.email') }}">{{ config('app.business.email') }}</a>.
        </p>
    </section>

</div>
@endsection