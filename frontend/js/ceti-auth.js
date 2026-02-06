document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const registerInput = document.getElementById("register");
    const passwordInput = document.getElementById("password");
    const submitBtn = document.getElementById("submitBtn");
    const loader = document.getElementById("loader");

    // Oculta el loader inicialmente
    loader.style.display = "none";

    // Función para limpiar mensajes de error
    function clearErrors() {
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach((error) => error.remove());

        const inputs = document.querySelectorAll(".floating-label input");
        inputs.forEach((input) => input.classList.remove("input-error"));
    }

    // Función para mostrar un mensaje de error
    function displayError(inputElement, message) {
        const errorElement = document.createElement("span");
        errorElement.textContent = message;
        errorElement.classList.add("error-message");
        inputElement.classList.add("input-error");
        inputElement.parentElement.appendChild(errorElement);
    }

    // Evento de envío del formulario
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        // Limpia los mensajes de error previos
        clearErrors();

        let hasErrors = false;

        // Verifica si los inputs están vacíos
        if (registerInput.value.trim() === "") {
            displayError(
                registerInput,
                "El campo de Registro no puede estar vacío."
            );
            hasErrors = true;
        }

        if (passwordInput.value.trim() === "") {
            displayError(
                passwordInput,
                "El campo de Contraseña no puede estar vacío."
            );
            hasErrors = true;
        }

        // Si hay errores, no continuar
        if (hasErrors) {
            return;
        }

        // Si el formulario es válido, procede con el envío
        const formData = {
            register: registerInput.value,
            password: passwordInput.value,
        };

        // Deshabilita el botón y muestra el loader
        submitBtn.disabled = true;
        loader.style.display = "block";

       
        // Opcionalmente, envía el formulario real:
        form.submit(); 
    });
});
