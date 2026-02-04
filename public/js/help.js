// Comportamiento de búsqueda
document.querySelector('.search-wrapper input').addEventListener('focus', function() {
    this.parentElement.classList.add('shadow-lg');
});

document.querySelector('.search-wrapper input').addEventListener('blur', function() {
    this.parentElement.classList.remove('shadow-lg');
});

function toggleAccordion(index) {
    const accordionItems = document.querySelectorAll('.accordion-item');
    const clickedItem = document.querySelector(`#faq${index}`);
    const clickedButton = document.querySelector(`#faq${index}`).previousElementSibling.querySelector('.accordion-button');
    
    // Crear y añadir efecto ripple
    const ripple = document.createElement('div');
    ripple.classList.add('ripple');
    clickedButton.appendChild(ripple);
    
    // Remover el elemento ripple después de la animación
    setTimeout(() => {
        ripple.remove();
    }, 1000);
    
    // Resto del código del acordeón...
    accordionItems.forEach((item, i) => {
        const button = item.querySelector('.accordion-button');
        const collapse = item.querySelector('.accordion-collapse');
        
        if (`faq${index}` !== collapse.id) {
            button.classList.add('collapsed');
            if (collapse.classList.contains('show')) {
                collapse.style.maxHeight = collapse.scrollHeight + 'px';
                setTimeout(() => {
                    collapse.style.maxHeight = '0px';
                    collapse.classList.remove('show');
                }, 50);
            }
        }
    });
    
    clickedButton.classList.toggle('collapsed');
    if (!clickedItem.classList.contains('show')) {
        clickedItem.classList.add('show');
        clickedItem.style.maxHeight = '0px';
        setTimeout(() => {
            clickedItem.style.maxHeight = clickedItem.scrollHeight + 'px';
        }, 50);
    } else {
        clickedItem.style.maxHeight = '0px';
        setTimeout(() => {
            clickedItem.classList.remove('show');
        }, 600);
    }
}

// Inicializar los eventos
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.accordion-collapse').forEach(collapse => {
        collapse.style.maxHeight = '0px';
        collapse.style.overflow = 'hidden';
        collapse.style.transition = 'max-height 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
    });

    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    // Array de categorías disponibles
    const categories = [
        {
            title: '¿Cómo empezar?',
            description: 'Registrar una cuenta en Hello World',
            icon: 'user-plus'
        },
        {
            title: 'Ejercicios',
            description: 'Empezar a practicar en los ejercicios',
            icon: 'code'
        },
        {
            title: 'Asistente Virtual',
            description: 'Respuestas a tus dudas sobre tu codigo',
            icon: 'robot'
        },
        {
            title: 'Compilador',
            description: 'Compilacion de tu codigo en tiempo real',
            icon: 'terminal'
        },
        {
            title: 'Seguridad',
            description: 'Proteccion de datos',
            icon: 'shield-alt'
        },
        {
            title: 'Planes',
            description: 'Metodos de pago de Hello World',
            icon: 'crown'
        },
        {
            title: 'Perfil',
            description: 'Configura tu perfil',
            icon: 'user-cog'
        },
        {
            title: 'Soporte',
            description: 'Comunicate con nuestro equipo',
            icon: 'headset'
        }
    ];

    // Función para filtrar categorías
    function filterCategories(searchTerm) {
        return categories.filter(category => 
            category.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
            category.description.toLowerCase().includes(searchTerm.toLowerCase())
        );
    }

    // Función para mostrar resultados
    function displayResults(results) {
        if (results.length === 0) {
            searchResults.innerHTML = `
                <div class="p-3 text-muted">
                    No se encontraron resultados
                </div>
            `;
        } else {
            searchResults.innerHTML = results.map(category => `
                <a href="/categoria/${encodeURIComponent(category.title)}/${encodeURIComponent(category.description)}" 
                class="result-item d-flex align-items-center p-3 text-decoration-none text-dark border-bottom">
                <i class="fas fa-${category.icon} me-3 text-muted"></i>
                    <div>
                        <div class="fw-semibold">${category.title}</div>
                        <div class="small text-muted">${category.description}</div>
                    </div>
                </a>
            `).join('');
        }
    }

    // Event listener para el input de búsqueda
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.trim();
        
        if (searchTerm === '') {
            searchResults.classList.add('d-none');
            return;
        }

        const results = filterCategories(searchTerm);
        displayResults(results);
        searchResults.classList.remove('d-none');
    });

    // Cerrar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('d-none');
        }
    });

    // Event listener para el botón de contacto
    document.getElementById('contact-btn').addEventListener('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Contáctanos',
            html: `
                <form id="contactForm" class="text-start">
                    <div class="mb-3">
                        <label for="name" class="form-label small">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Tu nombre">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label small">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="tucorreo@ejemplo.com">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label small">Asunto</label>
                        <input type="text" class="form-control" id="subject" placeholder="Asunto del mensaje">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label small">Mensaje</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Tu mensaje"></textarea>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar mensaje',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-custom-pink',
                cancelButton: 'btn btn-outline-secondary'
            },
            buttonsStyling: false,
            showCloseButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const subject = document.getElementById('subject').value;
                const message = document.getElementById('message').value;

                if (!name || !email || !subject || !message) {
                    Swal.showValidationMessage('Por favor completa todos los campos');
                    return false;
                }

                if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    Swal.showValidationMessage('Por favor ingresa un correo electrónico válido');
                    return false;
                }

                return { name, email, subject, message };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí puedes enviar los datos al servidor
                Swal.fire({
                    icon: 'success',
                    title: '¡Mensaje enviado!',
                    text: 'Nos pondremos en contacto contigo pronto.',
                    customClass: {
                        confirmButton: 'btn btn-custom-pink'
                    },
                    buttonsStyling: false
                });
            }
        });
    });
});
