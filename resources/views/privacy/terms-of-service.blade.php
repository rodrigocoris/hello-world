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
    <h1>Términos de Servicio de <span class="ff-Formula-1">Hello World</span></h1>

    <h2>1. Introducción</h2>
    <p>Bienvenido a Hello World. Al usar nuestro sitio web, usted acepta cumplir y estar sujeto a los siguientes términos y condiciones de uso, que junto con nuestra política de privacidad, rigen la relación de Hello World con usted en relación con este sitio web. Si no está de acuerdo con alguna parte de estos términos, por favor no use nuestro sitio web.</p>

    <h2>2. Definiciones</h2>
    <p><strong>Plataforma:</strong> El sitio web Hello World y sus aplicaciones asociadas.</p>
    <p><strong>Usuario:</strong> Cualquier persona que utilice la plataforma.</p>
    <p><strong>Cuenta Institucional:</strong> Una cuenta creada o vinculada a través de una institución educativa, empresarial u organizacional autorizada para acceder a la plataforma.</p>
    <p><strong>Contenido:</strong> Todo el texto, información, gráficos y otros materiales disponibles a través de la plataforma.</p>

    <h2>3. Uso de la Plataforma</h2>
    <p><strong>Cuenta de Usuario:</strong> Para acceder a ciertas funciones, debe crear una cuenta proporcionando información precisa y completa.</p>
    <p><strong>Cuentas Institucionales:</strong> Si inicia sesión con una cuenta institucional, usted confirma que tiene la autorización necesaria de dicha institución para usar la plataforma. Su acceso y uso de la plataforma estarán sujetos a los términos y condiciones adicionales establecidos por la institución, además de los presentes términos de Hello World.</p>
    <p><strong>Responsabilidad del Usuario:</strong> Usted es responsable de mantener la confidencialidad de su cuenta y contraseña, así como de todas las actividades que ocurran bajo su cuenta.</p>
    <p><strong>Uso Prohibido:</strong> No debe usar la plataforma para ninguna actividad ilegal o no autorizada según las leyes de México.</p>

    <h2>4. Pagos y Suscripciones</h2>
    <p><strong>Planes de Suscripción:</strong> Ofrecemos planes mensuales y anuales. Los pagos se procesan a través de la API de PayPal.</p>
    <p><strong>Cancelaciones y Reembolsos:</strong> Las políticas de cancelación y reembolso están disponibles en la sección correspondiente de nuestra plataforma. Puede cancelar su suscripción en cualquier momento, sin embargo, no se reembolsará ningún pago ya efectuado.</p>

    <h2>5. Modificaciones del Servicio</h2>
    <p>Nos reservamos el derecho de modificar o descontinuar la plataforma, temporal o permanentemente, con o sin previo aviso. No seremos responsables ante usted ni ante terceros por cualquier modificación, suspensión o interrupción del servicio.</p>

    <h2>6. Terminación</h2>
    <p>Podemos suspender o terminar su cuenta y acceso a la plataforma en cualquier momento, sin previo aviso, por violación de estos términos. En caso de terminación, sus derechos de uso de la plataforma cesarán de inmediato.</p>

    <h2>7. Limitación de Responsabilidad</h2>
    <p>En la medida máxima permitida por la ley aplicable, Hello World no será responsable de ningún daño indirecto, incidental, especial, consecuente o punitivo, o cualquier pérdida de ingresos, ganancias, datos o uso, incluso si se ha advertido de la posibilidad de tales daños.</p>

    <h2>8. Ley Aplicable</h2>
    <p>Estos términos se regirán e interpretarán de acuerdo con las leyes de México. Cualquier disputa relacionada con estos términos estará sujeta a la jurisdicción exclusiva de los tribunales de México.</p>

    <h2>9. Contacto</h2>
    <p>Si tiene alguna pregunta sobre estos términos, contáctenos a través de <a href="mailto:{{ config('app.business.email') }}">{{ config('app.business.email') }}</a>.</p>
</div>

@endsection