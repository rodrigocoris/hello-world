document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggle-articles');
    const hiddenArticles = document.getElementById('hidden-articles');
    const buttonText = toggleBtn.querySelector('.button-text');
    const iconToggle = toggleBtn.querySelector('.icon-toggle');
    let isExpanded = false;

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            isExpanded = !isExpanded;
            
            if (isExpanded) {
                // Mostrar más artículos
                hiddenArticles.style.display = 'block';
                hiddenArticles.classList.add('show'); // Añadimos clase para la animación
                buttonText.textContent = 'Mostrar menos';
                iconToggle.classList.remove('fa-chevron-down');
                iconToggle.classList.add('fa-chevron-up');
                
                // Animación para mostrar
                const articles = hiddenArticles.querySelectorAll('.card');
                articles.forEach((article, index) => {
                    article.style.opacity = '0';
                    article.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        article.style.transition = 'all 0.5s ease';
                        article.style.opacity = '1';
                        article.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            } else {
                // Ocultar artículos
                hiddenArticles.classList.remove('show');
                setTimeout(() => {
                    hiddenArticles.style.display = 'none';
                }, 300);
                buttonText.textContent = 'Mostrar más';
                iconToggle.classList.remove('fa-chevron-up');
                iconToggle.classList.add('fa-chevron-down');
                
                // Scroll suave hacia arriba
                window.scrollTo({
                    top: document.getElementById('visible-articles').offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    }
});
