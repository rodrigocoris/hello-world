var bodyCode = document.querySelector('meta[name="body_code"]').getAttribute('content');
var editorExercise = ace.edit("code-editor");

document.addEventListener("DOMContentLoaded", () => {
    // Configuración inicial
    editorExercise.setTheme("ace/theme/monokai"); // Tema por defecto
    editorExercise.session.setMode("ace/mode/c_cpp");

    ace.require("ace/ext/language_tools");
    editorExercise.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true,
    });

    editorExercise.setValue(bodyCode, 1);
    editorExercise.setFontSize("14px");

    // Cambiar tema del editor
    const themeSelect = document.getElementById("select-theme");

    themeSelect.addEventListener("change", (event) => {
        const selectedTheme = event.target.value;
        editorExercise.setTheme(`ace/theme/${selectedTheme}`);
    });

    // Resto de la configuración...
    if (tabletQuery.matches) {
        document.getElementById("panel-top").style.height = "500px";
        initRowLayout();
    } else {
        document.getElementById("panel-top").style.height = "";
        initColumnLayout();
    }

    updatePaneVisibility();
    adjustHeaderScroll();
});


// Function to handle the visibility of the panes' content
function updatePaneVisibility() {
    const panels = [
        { id: "panel-left", size: horizontalSplit ? horizontalSplit.getSizes()[0] : 0 },
        { id: "panel-top", size: verticalSplit ? verticalSplit.getSizes()[0] : 0 },
        { id: "panel-bottom", size: verticalSplit ? verticalSplit.getSizes()[1] : 0 },
    ];

    panels.forEach(({ id, size }) => {
        const panel = document.getElementById(id);
        const content = panel.querySelector(".panel-content");
        const header = panel.querySelector(".panel-header");

        if (id === "panel-left") {
            if (size <= 4.48) {
                // Compact view: show only icons
                panel.classList.add("panel-hidden");
                content.style.overflow = "hidden";
                header.style.height = "100%";
                header.style.textAlign = "center";
                header.classList.add("icons-only");
                header.style.borderRadius = "var(--border-radius-2)";
            } else {
                // Full view: show icons with text
                panel.classList.remove("panel-hidden");
                content.style.overflow = "auto";
                header.style.height = "";
                header.style.textAlign = "left";
                header.classList.remove("icons-only");
                header.style.borderRadius = "var(--border-radius-2) var(--border-radius-2) 0 0";
            }
        }

        if (id === "panel-top" || id === "panel-bottom") {
            if (size <= 7.3) {
                panel.classList.add("panel-hidden");
                content.style.overflow = "hidden";
                if (header) {
                    header.style.borderRadius = "15px"; // Add border radius
                }
            } else {
                panel.classList.remove("panel-hidden");
                content.style.overflow = "auto";
                if (header) {
                    header.style.borderRadius = ""; // Reset border radius
                }
            }
        }
    });

    // Recalculate editorExercise size if visible
    editorExercise.resize();
}

// Split.js configurations
let horizontalSplit, verticalSplit;

// Function to initialize column layout (desktop)
function initColumnLayout() {
    destroySplits(); // Ensure previous splits are cleared

    // Reset dynamic styles from Split.js
    resetPanelStyles();

    horizontalSplit = Split(["#panel-left", ".editor-container"], {
        sizes: [25, 75],
        minSize: [40, 300],
        gutterSize: 10,
        onDrag: () => {
            updatePaneVisibility();
            adjustHeaderScroll();
            editorExercise.resize();
        },
    });

    verticalSplit = Split(["#panel-top", "#panel-bottom"], {
        direction: "vertical",
        sizes: [75, 25],
        minSize: [40, 40],
        gutterSize: 11,
        onDrag: () => {
            updatePaneVisibility();
            adjustHeaderScroll();
            editorExercise.resize();
        },
    });
}

// Function to initialize row layout (tablet)
function initRowLayout() {
    destroySplits(); // Ensure previous splits are cleared
    document.getElementById("panel-top").style.height = "500px";

    Split(["#panel-left", "#panel-top", "#panel-bottom"], {
        direction: "vertical",
        sizes: [33, 33, 34],
        minSize: [40, 40, 40],
        gutterSize: 10,
        onDrag: () => {
            updatePaneVisibility();
            adjustHeaderScroll();
            editorExercise.resize();
        },
    });
}

// Function to reset panel styles
function resetPanelStyles() {
    const panelLeft = document.getElementById("panel-left");
    const panels = [panelLeft];

    panels.forEach((panel) => {
        if (panel) {
            // Remove height style dynamically added by Split.js
            panel.style.removeProperty("height");
        }
    });
}

// Destroy existing Split.js configurations
function destroySplits() {
    if (horizontalSplit) {
        horizontalSplit.destroy();
        horizontalSplit = null;
    }
    if (verticalSplit) {
        verticalSplit.destroy();
        verticalSplit = null;
    }
}

// Function to adjust horizontal scroll for headers
function adjustHeaderScroll() {
    const headers = document.querySelectorAll(".panel-header");

    headers.forEach((header) => {
        // Check if content overflows container width
        if (header.scrollWidth > header.clientWidth) {
            header.style.overflowX = "auto";
        } else {
            header.style.overflowX = "hidden";
        }
    });
}

// Listen for changes in screen size
const tabletQuery = window.matchMedia("(max-width: 1024px)");
tabletQuery.addEventListener("change", (event) => {
    if (event.matches) {
        // Tablet view: use row layout
        initRowLayout();
    } else {
        // Desktop view: use column layout
        initColumnLayout();
    }
});

// Hacer el asistente movible
let assistantContainer = document.getElementById("assistant-container");
let isDragging = false;
let offsetX = 0;
let offsetY = 0;

// Manejo de eventos para ratón
assistantContainer.addEventListener("mousedown", (e) => {
    startDrag(e.clientX, e.clientY); // Usamos clientX/clientY para fixed
});

document.addEventListener("mousemove", (e) => {
    if (isDragging) {
        dragElement(e.clientX, e.clientY); // Usamos clientX/clientY para fixed
    }
});

document.addEventListener("mouseup", () => {
    stopDrag();
});

// Manejo de eventos para dispositivos táctiles
assistantContainer.addEventListener("touchstart", (e) => {
    const touch = e.touches[0]; // Primer dedo
    startDrag(touch.clientX, touch.clientY); // Usamos clientX/clientY para fixed
    e.preventDefault(); // Prevenir otras interacciones
});

document.addEventListener("touchmove", (e) => {
    if (isDragging) {
        const touch = e.touches[0]; // Primer dedo
        dragElement(touch.clientX, touch.clientY); // Usamos clientX/clientY para fixed
        e.preventDefault(); // Evitar desplazamiento de la pantalla
    }
});

document.addEventListener("touchend", () => {
    stopDrag();
});

// Prevenir copia y menú contextual
assistantContainer.addEventListener("copy", (event) => {
    event.preventDefault(); // Prevenir copia
});

assistantContainer.addEventListener("contextmenu", (event) => {
    event.preventDefault(); // Prevenir menú contextual
});

// Funciones para manejar el arrastre
function startDrag(clientX, clientY) {
    isDragging = true;
    const rect = assistantContainer.getBoundingClientRect();
    offsetX = clientX - rect.left; // Coordenada exacta dentro del contenedor
    offsetY = clientY - rect.top; // Coordenada exacta dentro del contenedor
    assistantContainer.style.cursor = "grabbing"; // Cambiar el cursor
}

function dragElement(clientX, clientY) {
    const x = clientX - offsetX; // Ajustamos posición horizontal
    const y = clientY - offsetY; // Ajustamos posición vertical

    assistantContainer.style.left = `${x}px`;
    assistantContainer.style.top = `${y}px`;
}

function stopDrag() {
    isDragging = false;
    assistantContainer.style.cursor = "grab"; // Restaurar el cursor
}

// Mostrar salida de mejoras o explicaciones en el texto
function updateAssistantText(content) {
    const assistantTextContent = document.getElementById("assistant-text-content");
    assistantTextContent.innerHTML = marked.parse(content); // Convertir markdown a HTML
}

// Initialize correct layout on page load
document.addEventListener("DOMContentLoaded", () => {
    if (tabletQuery.matches) {
        document.getElementById("panel-top").style.height = "500px";
        initRowLayout();
    } else {
        document.getElementById("panel-top").style.height = "";
        initColumnLayout();
    }

    updatePaneVisibility();
    adjustHeaderScroll();

    // Selección de elementos
    const switchToInput = document.getElementById("switch-to-input");
    const switchToConsole = document.getElementById("switch-to-console");
    const inputView = document.getElementById("input-view");
    const consoleView = document.getElementById("console-view");

    // Función para alternar entre vistas
    function switchView(view) {
        if (view === "input") {
            inputView.classList.remove("hidden");
            consoleView.classList.add("hidden");
        } else if (view === "console") {
            consoleView.classList.remove("hidden");
            inputView.classList.add("hidden");
        }
    }

    // Configurar los eventos de clic
    switchToInput.addEventListener("click", (e) => {
        e.preventDefault();
        switchView("input");
    });

    switchToConsole.addEventListener("click", (e) => {
        e.preventDefault();
        switchView("console");
    });

    // Vista predeterminada
    switchView("console"); // Muestra la consola al cargar

    let executeUrl = document.querySelector('meta[name="execute_url"]').getAttribute('content');
    let improveUrl = document.querySelector('meta[name="improve_url"]').getAttribute('content');
    let explainUrl = document.querySelector('meta[name="explain_url"]').getAttribute('content');
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let button = document.getElementById("execute-button");
    let terminal = document.getElementById("terminal-output");
    let runtime = document.getElementById("terminal-run-time");
    let inputs = document.getElementById("user-input");

    function typeEffect(element, text) {
        element.innerHTML = '';
        let renderedHTML = '';
    
        try {
            renderedHTML = marked.parse(text); // Procesa el texto con Marked.js
        } catch (e) {
            console.error('Error procesando markdown con Marked.js:', e);
            renderedHTML = text; // Usa el texto sin procesar como fallback
        }
    
        let index = 0;
    
        const interval = setInterval(() => {
            if (index < renderedHTML.length) {
                element.innerHTML = renderedHTML.substring(0, index);
                index++;
            } else {
                clearInterval(interval);
            }
        }, 15); // Velocidad del efecto
    }    
    
    button.addEventListener("click", function () {
        console.log("inputs", inputs.value);
    
        button.classList.add("button-loading");
        button.disabled = true;
        button.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Cargando...</span>`;
    
        fetch(executeUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                codigo: editorExercise.getValue(),
                inputs: inputs.value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                switchView("console");
    
                if (data.output) {
                    runtime.innerHTML = `${data.execution_time_ms.toFixed(2)} ms`;
                    terminal.innerHTML = `<span id="code_text">execute@hello-world:<span>~$</span> \n</span>${data.output}`;
    
                    // Si la ejecución es correcta, llama a improve
                    fetch(improveUrl, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({ codigo: editorExercise.getValue() }),
                    })
                        .then((res) => res.json())
                        .then((improveData) => {
                            if (improveData.success) {
                                const assistantTextContent = document.getElementById("assistant-text-content");
                                typeEffect(assistantTextContent, improveData.suggestions); // Usa typeEffect aquí
                            }
                        });
                } else {
                    runtime.innerHTML = `0.00 ms`;
                    terminal.innerHTML = `<span id="code_text">execute@hello-world:<span>~$</span> \n</span>${data.error_message}`;
    
                    // Si hay error, llama a explain
                    fetch(explainUrl, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({ error: data.error_message }),
                    })
                        .then((res) => res.json())
                        .then((explainData) => {
                            if (explainData.success) {
                                const assistantTextContent = document.getElementById("assistant-text-content");
                                typeEffect(assistantTextContent, explainData.explanation); // Usa typeEffect aquí
                            }
                        });
                }
            })
            .catch((error) => {
                runtime.innerHTML = `0.00 ms`;
                terminal.innerHTML = `<span id="code_text">execute@hello-world:<span>~$</span> \n</span>${error}`;
            })
            .finally(() => {
                button.classList.remove("button-loading");
                button.disabled = false;
                button.innerHTML = `<i class="fa-solid fa-play"></i> <span>Correr</span>`;
            });
    });    
});

// Referencias al botón y al contenedor del asistente
const assistantButton = document.getElementById("assistant-button");

// Estado inicial del asistente
let isAssistantVisible = true;

// Función para alternar la visibilidad del asistente
function toggleAssistant() {
    if (isAssistantVisible) {
        // Animación de salida
        assistantContainer.classList.add("hide-assistant");
        assistantContainer.classList.remove("show-assistant");
        setTimeout(() => {
            assistantContainer.style.display = "none";
        }, 500); // Tiempo de la animación (500ms)
        assistantButton.querySelector("span").textContent = "Mostrar asistente";
    } else {
        // Animación de entrada
        assistantContainer.style.display = "flex";
        setTimeout(() => {
            assistantContainer.classList.remove("hide-assistant");
            assistantContainer.classList.add("show-assistant");
        }, 10); // Pequeño retraso para asegurar que la animación se aplica
        assistantButton.querySelector("span").textContent = "Ocultar asistente";
    }
    isAssistantVisible = !isAssistantVisible;
}

// Asignar evento click al botón
assistantButton.addEventListener("click", toggleAssistant);