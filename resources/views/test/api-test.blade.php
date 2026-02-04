<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            width: 100%;
        }

        .left-panel {
            width: 30%;
            background-color: #f0f0f0;
            padding: 20px;
            border-right: 1px solid #ccc;
            overflow-y: auto;
        }

        .right-panel {
            width: 70%;
            padding: 20px;
            overflow-y: auto;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #ccc;
        }

        li:hover {
            background-color: #e0e0e0;
        }

        .description {
            font-size: 18px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Panel izquierdo (títulos) -->
        <div class="left-panel">
            <h2>Lecciones</h2>
            <ul id="lesson-list">
                <!-- Aquí se llenarán los títulos -->
            </ul>
        </div>

        <!-- Panel derecho (descripción) -->
        <div class="right-panel">
            <h2>Descripción de la Lección</h2>
            <p id="lesson-description" class="description">Selecciona una lección para ver la descripción aquí.</p>
        </div>
    </div>

    <script>
        // ID del lenguaje de programación seleccionado y la categoría
        var language_id = 1; //language_id = 1 porque solo esta c++
        var module = "{{ $lesson }}";

        // URL de la API
        var api_url = `{{ config('app.api_url') }}/api/v1/lessons/${language_id}/${module}`;
        console.log(api_url);

        // Hacer la solicitud a la API
        fetch(api_url)
            .then(response => response.json())
            .then(data => {
                // Obtener la lista de lecciones de la respuesta
                var lessons = data.moduleSection;

                // Referencias a los elementos del DOM
                var lessonList = document.getElementById('lesson-list');
                var lessonDescription = document.getElementById('lesson-description');

                // Limpiar la lista de lecciones
                lessonList.innerHTML = '';

                lessons.forEach(lesson => {
                    var listItem = document.createElement('li');
                    listItem.textContent = lesson.title;
                    listItem.addEventListener('click', function () {
                        // Mostrar la descripción de la lección al hacer clic
                        lessonDescription.innerHTML = lesson.description; // Usar innerHTML en lugar de textContent
                    });

                    // Agregar el ítem a la lista
                    lessonList.appendChild(listItem);
                });

            })
            .catch(error => console.error('Error al cargar las lecciones:', error));
    </script>

</body>

</html>