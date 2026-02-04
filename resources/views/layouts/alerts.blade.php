@if ($message = Session::get('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                imageUrl: '{{ asset("images/assistant/assistant-base.png") }}',
                title: '¡Listo!',
                html: `{!! $message !!}`,
                confirmButtonText: 'Entendido',
                iconColor: '#00ff00',
                confirmButtonColor: '#3085d6',
                customClass: {
                    image: 'custom-swal-image',
                    htmlContainer: 'swal2-html-container-custom',
                }
            });
        });
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                imageUrl: '{{ asset("images/assistant/assistant-failed.png") }}',
                title: 'Error',
                html: `{!! $message !!}`,
                confirmButtonText: 'Entendido',
                iconColor: '#ff0000',
                confirmButtonColor: '#d33',
                customClass: {
                    image: 'custom-swal-image',
                    htmlContainer: 'swal2-html-container-custom',
                }
            });
        });
    </script>
@endif

@if ($message = Session::get('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                imageUrl: '{{ asset("images/assistant/assistant-warning.png") }}',
                title: '¡Advertencia!',
                html: `{!! $message !!}`,
                confirmButtonText: 'Entendido',
                iconColor: '#ffa500',
                confirmButtonColor: '#f0ad4e',
                customClass: {
                    image: 'custom-swal-image',
                    htmlContainer: 'swal2-html-container-custom',
                }
            });
        });
    </script>
@endif

@if ($message = Session::get('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                imageUrl: '{{ asset("images/assistant/assistant-info.png") }}',
                html: `{!! $message !!}`,
                confirmButtonText: 'Entendido',
                iconColor: '#3E97FF',
                confirmButtonColor: '#2059F0',
                customClass: {
                    image: 'custom-swal-image',
                    htmlContainer: 'swal2-html-container-custom',
                }
            });
        });
    </script>
@endif