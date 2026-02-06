// Variables globales
let currentLessonIndex = 0;
let lessons = [];
let completedLessons = new Set();
let isIndex = true;
let moduleData = {};
let utterance;
let isPaused = false;
let isPlaying = false;

/**
 * Fix this hardcoded values!!!!!!
 * 
 * @todo: Get this values from the database
 */
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

// Función para sincronizar con la base de datos
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

// Configurar el observador de localStorage
const originalSetItem = localStorage.setItem;
localStorage.setItem = function(key, value) {
    const event = new Event('itemInserted');
    event.key = key;
    event.value = value;
    document.dispatchEvent(event);
    originalSetItem.apply(this, arguments);
};

// Escuchar cambios en localStorage
document.addEventListener('itemInserted', function(e) {
    const userId = document.querySelector('meta[name="user-id"]').content;
    if (e.key.startsWith(`${userId}_`) && e.key.endsWith('_completedLessons')) {
        const moduleName = e.key.replace(`${userId}_`, '').replace('_completedLessons', '');
        const completed = JSON.parse(e.value);
        const total = moduleTotals[moduleName];
        const progress = Math.round((completed.filter(lesson => lesson > 0).length / total) * 100);
        
        syncProgressWithDB(moduleName, progress);
    }
});

function initializeLessons(config) {
    // ID del lenguaje de programación seleccionado y la categoría
    var language_id = config.language_id;
    var module = config.module;

    // URL de la API
    var api_url = `${config.api_url}/api/v1/lessons/${language_id}/${module}`;
    console.log(api_url);

    function calculateReadingTime(text) {
        const wordCount = text.split(/\s+/).length;
        const easyWPM = 230;
        const mediumWPM = 200;
        const hardWPM = 180;

        const easyTime = Math.ceil(wordCount / easyWPM);
        const mediumTime = Math.ceil(wordCount / mediumWPM);
        const hardTime = Math.ceil(wordCount / hardWPM);

        return Math.ceil((easyTime + mediumTime + hardTime) / 3);
    }

    function calculateProgress(currentIndex, totalLessons) {
        if (currentIndex === 0) return 0;
        return Math.round((currentIndex) / (totalLessons - 1) * 100);
    }

    function updateProgressBar(completedCount, totalLessons) {
        const adjustedTotalLessons = totalLessons - 1;
        const adjustedCompletedCount = Math.max(0, Math.min(completedCount - 1, adjustedTotalLessons));
        const progressPercentage = Math.min(100, Math.round((adjustedCompletedCount / adjustedTotalLessons) * 100));
        const progressBar = document.querySelector('.progress-barr .progress-fill');
        const progressText = document.querySelector('.progress-containerr .progress-text');
        
        progressBar.style.width = `${progressPercentage}%`;
        progressText.textContent = `${progressPercentage}% completado`;
    }

    function saveProgress(index, lesson) {
        const userId = document.querySelector('meta[name="user-id"]').content;
        const storageKey = `${userId}_${module}_completedLessons`;
        const currentPositionKey = `${userId}_${module}_currentPosition`;
        
        localStorage.setItem(storageKey, JSON.stringify(Array.from(completedLessons)));
        localStorage.setItem(currentPositionKey, index.toString());
    }

    function loadProgress() {
        const userId = document.querySelector('meta[name="user-id"]').content;
        const storageKey = `${userId}_${module}_completedLessons`;
        const currentPositionKey = `${userId}_${module}_currentPosition`;
        const savedCompletedLessons = localStorage.getItem(storageKey);
        const savedPosition = localStorage.getItem(currentPositionKey);
        
        return {
            index: savedPosition ? parseInt(savedPosition) : 0,
            lesson: '',
            completedLessons: savedCompletedLessons ? new Set(JSON.parse(savedCompletedLessons)) : new Set()
        };
    }

    function markLessonAsCompleted() {
        if (!completedLessons.has(currentLessonIndex)) {
            completedLessons.add(currentLessonIndex);
            saveProgress(currentLessonIndex, lessons[currentLessonIndex].lesson);
            
            document.querySelectorAll('#lesson-list li').forEach((li, index) => {
                if (index <= currentLessonIndex || completedLessons.has(index)) {
                    li.classList.remove('locked');
                }
            });

            updateSkipButtonState();
            updateProgressBar(completedLessons.size, lessons.length);
            
            if (!isIndex && currentLessonIndex < lessons.length - 1) {
                unlockNextLesson();
                localStorage.setItem(`${module}_next_lesson_unlocked`, (currentLessonIndex + 1).toString());
            }
        }
    }

    function unlockNextLesson() {
        const userId = document.querySelector('meta[name="user-id"]').content;
        if (currentLessonIndex < lessons.length - 1) {
            const nextLesson = document.querySelectorAll('#lesson-list li')[currentLessonIndex + 1];
            if (nextLesson) {
                nextLesson.classList.add('unlocking');
                nextLesson.classList.remove('locked');
                setTimeout(() => {
                    nextLesson.classList.remove('unlocking');
                }, 1000);
            }
            localStorage.setItem(`${userId}_${module}_next_lesson_unlocked`, (currentLessonIndex + 1).toString());
        }
    }

    function updateSkipButtonState() {
        const skipButton = document.querySelector('.button-6');
        skipButton.disabled = false;
    }

    function goToNextLesson() {
        if (completedLessons.has(currentLessonIndex)) {
            if (currentLessonIndex < lessons.length - 1) {
                const nextLesson = document.querySelectorAll('#lesson-list li')[currentLessonIndex + 1];
                if (nextLesson) {
                    nextLesson.classList.add('unlocking');
                    nextLesson.classList.remove('locked');
                    setTimeout(() => {
                        nextLesson.classList.remove('unlocking');
                    }, 1000);
                }
                
                currentLessonIndex++;
                updateUI(lessons[currentLessonIndex], currentLessonIndex, lessons.length);
            } else if (moduleData.nextModule) {
                const baseUrl = window.location.pathname.split('/contenido/')[0] + '/contenido/';
                const encodedNextModule = encodeURIComponent(moduleData.nextModule.module);
                window.location.href = baseUrl + encodedNextModule;
            } else {
                showAlert('¡Felicitaciones!', '¡Has completado todos los módulos disponibles!', 'success', true);
            }
        } else {
            showAlert('¡Atención!', 'Completa la lectura actual antes de continuar.', 'error');
        }
    }

    function checkScrollToBottom() {
        const contentElement = document.querySelector('.right-panel');
        if (contentElement.scrollHeight <= contentElement.clientHeight || 
            contentElement.scrollHeight - contentElement.scrollTop <= contentElement.clientHeight + 5) {
            markLessonAsCompleted();
        }
    }

    function updateUI(lesson, index, totalLessons) {
        stopContent();

        document.getElementById('lesson-lesson').textContent = lesson.lesson;
        document.getElementById('lesson-description').innerHTML = lesson.description;
        let lessonReadingTime = calculateReadingTime(lesson.lesson + ' ' + lesson.description);
        document.getElementById('reading-time').querySelector('span').textContent = 
            `${lessonReadingTime} minuto${lessonReadingTime !== 1 ? 's' : ''} de lectura`;
        document.getElementById('lesson-name').textContent = lesson.module;
        document.getElementById('lesson-language').textContent = lesson.language;

        document.querySelectorAll('#lesson-list li').forEach((li, i) => {
            if (i === index) {
                li.classList.add('selected');
            } else {
                li.classList.remove('selected');
            }
        });

        isIndex = index === 0;
        currentLessonIndex = index;
        saveProgress(index, lesson.lesson);
        updateSkipButtonState();
        updateProgressBar(completedLessons.size, totalLessons);

        document.querySelector('.right-panel').scrollTop = 0;

        if (window.speechSynthesis.speaking || isPaused) {
            isPaused = false;
            playContent();
        }

        setTimeout(() => {
            checkScrollToBottom();
        }, 0);
    }

    function initializeProgressBar() {
        const progress = loadProgress();
        const progressBar = document.querySelector('.progress-fill');
        const progressText = document.querySelector('.progress-text');
        
        if (progress.completedLessons && progress.completedLessons.size > 0) {
            const percentage = Math.round((progress.completedLessons.size - 1) / (lessons.length - 1) * 100);
            progressBar.style.width = `${percentage}%`;
            progressText.textContent = `${percentage}% completado`;
        } else {
            progressBar.style.width = '0%';
            progressText.textContent = '0% completado';
        }
    }

    fetch(api_url)
        .then(response => response.json())
        .then(data => {
            lessons = data.moduleSection.filter(lesson => 
                !lesson.lesson.toLowerCase().includes('ejercicio de refuerzo')
            );
            moduleData = {
                currentModule: data.currentModule,
                nextModule: data.nextModule
            };
            
            var lessonList = document.getElementById('lesson-list');
            lessonList.innerHTML = '';

            let progress = loadProgress();
            currentLessonIndex = progress.index;
            completedLessons = new Set(progress.completedLessons);

            const userId = document.querySelector('meta[name="user-id"]').content;
            const nextUnlockedLesson = parseInt(localStorage.getItem(`${userId}_${module}_next_lesson_unlocked`));

            lessons.forEach((lesson, index) => {
                var listItem = document.createElement('li');
                listItem.innerHTML = `
                    <i class="fas fa-lock lock-icon"></i>
                    <span>${lesson.lesson}</span>
                `;
                
                listItem.addEventListener('click', function () {
                    if (!listItem.classList.contains('locked')) {
                        updateUI(lesson, index, lessons.length);
                    }
                });

                if (completedLessons.has(index) || index <= currentLessonIndex || index === nextUnlockedLesson) {
                    listItem.classList.remove('locked');
                } else {
                    listItem.classList.add('locked');
                }

                lessonList.appendChild(listItem);
            });

            if (lessons[currentLessonIndex]) {
                updateUI(lessons[currentLessonIndex], currentLessonIndex, lessons.length);
            }

            updateProgressBar(completedLessons.size, lessons.length);

            const skipButton = document.querySelector('.button-6');
            skipButton.addEventListener('click', goToNextLesson);

            const contentElement = document.querySelector('.right-panel');
            contentElement.addEventListener('scroll', checkScrollToBottom);

            const nextChapterButton = document.querySelector('.button-6-new');
            nextChapterButton.addEventListener('click', function() {
                if (moduleData.nextModule) {
                    const baseUrl = window.location.pathname.split('/contenido/')[0] + '/contenido/';
                    const encodedNextModule = encodeURIComponent(moduleData.nextModule.module);
                    window.location.href = baseUrl + encodedNextModule;
                } else {
                    showAlert('¡Felicitaciones!', '¡Has completado todos los módulos disponibles!', 'success', true);
                }
            });

            document.querySelector('.progress-text').style.visibility = 'visible';
        })
        .catch(error => console.error('Error al cargar las lecciones:', error));
}

// Funciones globales para el control de audio
window.togglePlay = function() {
    const icon = document.getElementById('playPauseIcon');
    
    if (!isPlaying) {
        if (!window.speechSynthesis.speaking) {
            playContent();
        } else {
            window.speechSynthesis.resume();
        }
        isPlaying = true;
        icon.classList.remove('fa-play');
        icon.classList.add('fa-pause');
    } else {
        window.speechSynthesis.pause();
        isPlaying = false;
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-play');
    }
}

window.restartContent = function() {
    window.speechSynthesis.cancel();
    isPlaying = true;
    const icon = document.getElementById('playPauseIcon');
    icon.classList.remove('fa-play');
    icon.classList.add('fa-pause');
    playContent();
}

function playContent() {
    if (!window.speechSynthesis.speaking) {
        const lessonLesson = document.getElementById('lesson-lesson').textContent;
        const lessonDescription = document.getElementById('lesson-description').innerHTML;
        const textToRead = `${stripHTML(lessonLesson)}. ${stripHTML(lessonDescription)}`;

        utterance = new SpeechSynthesisUtterance(textToRead);
        utterance.onend = () => { 
            isPlaying = false;
            utterance = null;
            const icon = document.getElementById('playPauseIcon');
            icon.classList.remove('fa-pause');
            icon.classList.add('fa-play');
        };
        window.speechSynthesis.speak(utterance);
    }
}

function stopContent() {
    window.speechSynthesis.cancel();
    isPlaying = false;
    utterance = null;
    const icon = document.getElementById('playPauseIcon');
    icon.classList.remove('fa-pause');
    icon.classList.add('fa-play');
}

function stripHTML(html) {
    const div = document.createElement('div');
    div.innerHTML = html;

    function processNode(node) {
        let result = '';
        
        node.childNodes.forEach(child => {
            if (child.nodeType === 3) {
                result += child.textContent.trim() + ' ';
            } else if (child.nodeType === 1) {
                if (child.tagName.toLowerCase() === 'code') {
                    result += child.textContent.trim() + ' ';
                }
                else if (!['pre', 'style', 'script'].includes(child.tagName.toLowerCase())) {
                    result += processNode(child);
                }
            }
        });
        
        return result;
    }

    return processNode(div)
        .replace(/\s+/g, ' ')
        .trim();
}

function showAlert(lesson, message, icon = 'error', redirect = false) {
    if (!redirect) {
        Swal.fire({
            lesson: lesson,
            text: message,
            icon: icon,
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#dc3545',
            customClass: {
                confirmButton: 'custom-swal-button'
            }
        });
    } else {
        Swal.fire({
            lesson: lesson,
            text: message,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: 'Empezar de nuevo',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            customClass: {
                confirmButton: 'custom-swal-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const baseUrl = window.location.pathname.split('/contenido/')[0] + '/contenido/';
                const encodedFirstModule = encodeURIComponent('Introducción a la Programación');
                window.location.href = baseUrl + encodedFirstModule;
            }
        });
    }
}

// Inicialización automática cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    initializeLessons({
        language_id: 1,
        module: document.querySelector('meta[name="lesson"]').content,
        api_url: document.querySelector('meta[name="api-url"]').content
    });
}); 