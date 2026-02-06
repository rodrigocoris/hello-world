document.addEventListener("DOMContentLoaded", function() {
    const loader = document.getElementById('terminalLoader');
    let loaderTimeout;

    // Show loader
    loader.style.display = 'flex';

    // Ensure the CSS has loaded completely
    window.onload = function() {
        clearTimeout(loaderTimeout); // Cancel any previous timeout

        // Ensure the loader disappears smoothly
        loaderTimeout = setTimeout(() => {
            loader.style.opacity = '0';

            setTimeout(() => {
                loader.style.display = 'none';
            }, 800); // Time equal to the CSS transition
        }, 0); // Short delay to avoid interruptions
    };
});
