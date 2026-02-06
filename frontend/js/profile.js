// Configuración de módulos
const moduleTotals = {
    'Introducción a la Programación': 4,
    'Variables y tipos de datos': 4,
    'Estructuras de control': 3,
    'Funciones': 4,
    'Arreglos y Ciclos Anidados': 3,
    'Punteros y Referencias': 3,
    'Cadenas de Caracteres': 3,
    'Introducción a la Programación Orientada a Objetos': 4,
    'Estructuras de Datos': 3,
    'Algoritmos y Resolución de Problemas': 3
};

const moduleIds = {
    'Introducción a la Programación': 1,
    'Variables y tipos de datos': 6,
    'Estructuras de control': 11,
    'Funciones': 15,
    'Arreglos y Ciclos Anidados': 20,
    'Punteros y Referencias': 24,
    'Cadenas de Caracteres': 28,
    'Introducción a la Programación Orientada a Objetos': 32,
    'Estructuras de Datos': 37,
    'Algoritmos y Resolución de Problemas': 41
};

function initializeProfile() {
    const modules = Object.keys(moduleTotals);
    const firstHalf = modules.slice(0, 5);
    const secondHalf = modules.slice(5);

    function generateModulesHTML(modulesList) {
        return modulesList.map(module => `
            <div class="col-12">
                <div class="module-card">
                    <div class="module-title">
                        <h6 class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book mr-2 icon-inline">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                            ${module}
                        </h6>
                    </div>
                    <div class="progress-indicator">
                        <div class="progress">
                            <div class="progress-bar progress-value" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-secondary progress-text">0%</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    document.getElementById('modules-progress-1').innerHTML = generateModulesHTML(firstHalf);
    document.getElementById('modules-progress-2').innerHTML = generateModulesHTML(secondHalf);

    async function syncProgressWithDB(moduleName, progress) {
        const userId = document.querySelector('meta[name="user-id"]').content;
        const moduleId = moduleIds[moduleName];

        try {
            const checkResponse = await fetch(`/api/v1/lesson-progress-show/${userId}/${moduleId}`);
            const existingProgress = await checkResponse.json();

            if (existingProgress) {
                await fetch('/api/v1/lesson-progress-update', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        lesson_id: moduleId,
                        progress: progress
                    })
                });
            } else {
                await fetch('/api/v1/lesson-progress-store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        lesson_id: moduleId,
                        progress: progress
                    })
                });
            }
        } catch (error) {
            console.error('Error syncing progress:', error);
        }
    }

    function updateProgress(container, modulesList) {
        const userId = document.querySelector('meta[name="user-id"]').content;
        
        modulesList.forEach((moduleName, index) => {
            const moduleElement = container.children[index];
            const storageKey = `${userId}_${moduleName}_completedLessons`;
            const completedLessons = localStorage.getItem(storageKey);
            
            if (completedLessons && moduleTotals[moduleName]) {
                const completed = JSON.parse(completedLessons);
                const completedCount = completed.filter(lesson => lesson > 0).length;
                const total = moduleTotals[moduleName];
                const progress = Math.round((completedCount / total) * 100);
                
                const progressBar = moduleElement.querySelector('.progress-value');
                const progressText = moduleElement.querySelector('.progress-text');
                
                if (progressBar && progressText) {
                    progressBar.style.width = `${progress}%`;
                    progressText.textContent = `${progress}%`;
                }

                syncProgressWithDB(moduleName, progress);
            }
        });
    }

    // Actualizar progreso inicial
    updateProgress(document.getElementById('modules-progress-1'), firstHalf);
    updateProgress(document.getElementById('modules-progress-2'), secondHalf);

    // Observar cambios en localStorage
    window.addEventListener('storage', function(e) {
        const userId = document.querySelector('meta[name="user-id"]').content;
        if (e.key && e.key.startsWith(`${userId}_`) && e.key.endsWith('_completedLessons')) {
            const firstHalf = Object.keys(moduleTotals).slice(0, 5);
            const secondHalf = Object.keys(moduleTotals).slice(5);
            updateProgress(document.getElementById('modules-progress-1'), firstHalf);
            updateProgress(document.getElementById('modules-progress-2'), secondHalf);
        }
    });
}

// Inicialización automática cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    initializeProfile();
});
