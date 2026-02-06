document.addEventListener("DOMContentLoaded", function() {
    
    function typeHelloWorld() {
        var container = document.getElementById("hello-world");
        var text = "Hello World";
        var index = 0;

        var interval = setInterval(function() {
            container.textContent += text[index];
            index++;
            
            if (index >= text.length) {
                clearInterval(interval);
            }
        }, 100);
    }

    typeHelloWorld();
});

$(document).ready(function () {
    $('.menu-toggle').click(function () {
        $(this).toggleClass('open');
        $('.lateral-menu').toggleClass('menu-open');
        $('.modal-background').fadeToggle(300);
    });

    $(document).click(function(event) {
        
        if (!$(event.target).closest('.lateral-menu').length && !$(event.target).closest('.menu-toggle').length) {
            
            $('.lateral-menu').removeClass('menu-open');
            $('.modal-background').fadeOut(300);
            $('.menu-toggle').removeClass('open');
        }
    });
});

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: 'smooth' });
}

function redirectTo(url) {
    location.href = url;
}

function redirectToBlank(url) {
    window.open(url, "_blank");
}

function redirectToWithScroll(url, sectionId) {
    // Guarda el ID de la sección en sessionStorage
    sessionStorage.setItem('scrollToSectionId', sectionId);
    // Redirige a la URL deseada
    location.href = url;
}

function redirectToWithToggle(url, planId) {
    toggleSelectionSingUp(`plan-${planId}`, planId);
    location.href = url;
}