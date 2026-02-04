const plan_id = document.querySelector('meta[name="plan_id"]').getAttribute('content');
const user_token = document.querySelector('meta[name="user_token"]').getAttribute('content');
const base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
const api_url = document.querySelector('meta[name="api-url"]').getAttribute('content');
const success_url = `${base_url}/suscripcion-exitosa`;
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Evitar reintentos si el proceso ya fue exitoso
if (sessionStorage.getItem('subscription-success')) {
    redirectToSuccess();
}

paypal.Buttons({
    createSubscription: function(data, actions) {
        return actions.subscription.create({
            'plan_id': plan_id
        });
    },
    onApprove: async function(data, actions) {
        try {
            console.log('Subscription ID:', data.subscriptionID);
            const apiUrl = `${api_url}/api/v1/paypal/subscription/${data.subscriptionID}/${user_token}`;

            const response = await fetch(apiUrl);
            if (!response.ok) {
                throw new Error(`Error en la solicitud. Código de estado: ${response.status}`);
            }

            const json = await response.json();
            console.log('Respuesta de la API:', json);

            // Almacenar que la suscripción fue exitosa
            sessionStorage.setItem('subscription-success', true);

            // Mostrar alerta de éxito no cerrable
            let timer = 5;
            const swalTimer = Swal.fire({
                imageUrl: `${base_url}/images/assistant/assistant-success.png`,
                title: '¡Suscripción exitosa!',
                html: `Tu suscripción se ha completado correctamente.<br><br>
                       Serás redirigido en <b><span id="swal-timer">${timer}</span></b> segundos.`,
                customClass: {
                    image: 'custom-swal-image',
                    htmlContainer: 'swal2-html-container-custom',
                },
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: true,
                confirmButtonText: 'Continuar',
                didOpen: () => {
                    // Actualizar contador cada segundo
                    const swalInterval = setInterval(() => {
                        timer -= 1;
                        document.getElementById('swal-timer').textContent = timer;
                        if (timer <= 0) {
                            clearInterval(swalInterval);
                            redirectToSuccess();
                        }
                    }, 1000);
                },
            });

            swalTimer.then((result) => {
                if (result.isConfirmed) {
                    redirectToSuccess();
                }
            });
        } catch (error) {
            console.error('Error fetching subscription details:', error.message);

            // Mostrar error al usuario
            Swal.fire({
                imageUrl: `${base_url}/images/assistant/assistant-failed.png`,
                title: 'Error en la suscripción',
                html: `<p>No se pudo completar el proceso de suscripción.</p><p>Detalle: ${error.message}</p>`,
                customClass: {
                    image: 'custom-swal-image',
                    htmlContainer: 'swal2-html-container-custom',
                },
            });
        }
    },
    onError: function(err) {
        console.error('PayPal SDK Error:', err);

        Swal.fire({
            imageUrl: `${base_url}/images/assistant/assistant-warning.png`,
            title: 'Proceso cancelado',
            text: 'El proceso de suscripción se canceló o no pudo completarse.',
            customClass: {
                image: 'custom-swal-image',
                htmlContainer: 'swal2-html-container-custom',
            },
        });
    },
    onCancel: function(data) {
        console.warn('Suscripción cancelada por el usuario:', data);

        Swal.fire({
            imageUrl: `${base_url}/images/assistant/assistant-info.png`,
            title: 'Suscripción cancelada',
            text: 'Has cancelado el proceso de suscripción. Si fue un error, puedes intentarlo nuevamente.',
            customClass: {
                image: 'custom-swal-image',
                htmlContainer: 'swal2-html-container-custom',
            },
        });
    },
}).render('#paypal-button-container');

// Función para redirigir al éxito
function redirectToSuccess() {
    // Borra el sessionStorage después de completar el flujo
    sessionStorage.removeItem('subscription-success');
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = success_url;

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = 'user_token';
    tokenInput.value = user_token;
    form.appendChild(tokenInput);

    const planInput = document.createElement('input');
    planInput.type = 'hidden';
    planInput.name = 'plan_id';
    planInput.value = plan_id;
    form.appendChild(planInput);

    document.body.appendChild(form);
    form.submit();
}