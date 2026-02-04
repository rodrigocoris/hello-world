<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="{{ config('app.url') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Clase JS</title>
</head>
<body>
    <div class="container" style="width: 95vw; height: 95vh; margin: auto;">
        <canvas id="nodes-container" width="100%" height="100%">
            <!-- Canvas will be filled with JavaScript -->
        </canvas>
    </div>

    <!-- Aquí Laravel genera la ruta correcta -->
    <script type="module" src="{{ asset('js/nodes/main.js') }}"></script>
</body>
</html>
