document.addEventListener('DOMContentLoaded', () => {
    // Agregar funcionalidad de "mostrar contraseña" de forma dinámica
    document.body.addEventListener('change', (event) => {
        // Verificar si el evento proviene de un checkbox con clase 'show-password'
        if (event.target.matches('.show-password')) {
            const checkbox = event.target;
            const inputField = checkbox.closest('.form-floating').querySelector('input[type="password"], input[type="text"]');
            const icon = checkbox.nextElementSibling;

            if (inputField) {
                // Alternar el tipo del campo y el ícono
                if (checkbox.checked) {
                    inputField.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    inputField.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            }
        }
    });
});
