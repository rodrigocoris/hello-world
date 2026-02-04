// main.js
import { Nodes } from './Nodes.js';
import { Graph } from './Graph.js';

// Get the base URL from the meta tag
const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

// Node currently under the mouse
let hoveredNode = null;

// Obtener los ejercicios del módulo desde la API
async function fetchModuleExercises(token) {
    const response = await fetch(`/api/v1/module-exercises/${token}`);
    const data = await response.json();
    return data;
}

// Crear el grafo dinámicamente a partir de los datos de los ejercicios
function createGraph(exercises) {
    const graph = new Graph();

    exercises.forEach(exercise => {
        // Agregar vértices al grafo basados en los datos de los ejercicios
        exercise.node_exercises.forEach(node => {

            const title = exercise.title;
            const description = exercise.description;
            const level = `Nivel\n${exercise.difficulty}`;

            // Agregamos el vértice al grafo
            graph.addVertex(node.vertex, node.type, level, title, description, node.x, node.y);

            console.log("Vertex: " + node.vertex + "\nEdges: " + node.edges);
            console.log('--------------------------------');
            
            graph.addEdge(node.vertex,  node.edges);
        });
    });

    graph.showGraph();
    return graph;
}

// Función para dibujar el grafo
function drawGraph(graph, ctx, offsetX, offsetY, image) {
    for (let vertex in graph.adjacencyList) {
        for (let neighbor of graph.adjacencyList[vertex]) {
            const start = graph.positions[vertex];
            const end = graph.positions[neighbor];
            ctx.beginPath();
            ctx.moveTo((start.x + 150) - offsetX, (start.y + 120) - offsetY);
            ctx.lineTo((end.x + 150) - offsetX, (end.y + 120) - offsetY);
            ctx.lineWidth = 7.5;
            ctx.strokeStyle = "#E61A4F";
            ctx.stroke();
        }
    }

    for (let vertex in graph.positions) {
        const pos = graph.positions[vertex];
        const isHovered = hoveredNode && hoveredNode.x === pos.x && hoveredNode.y === pos.y;
        const node = new Nodes(pos.x, pos.y, 300, 240, 15, pos.type, pos.level, pos.title, pos.description, image);

        if (isHovered) {
            node.border_color = "#FF5733"; // Hover color
        } else {
            node.border_color = "#EEEDED"; // Default color
        }

        node.draw(ctx, offsetX, offsetY, pos.type);
    }
}

// Detectar interacciones con el nodo
function detectNodeInteraction(graph, mouseX, mouseY, offsetX, offsetY) {
    for (let vertex in graph.positions) {
        const pos = graph.positions[vertex];
        const nodeXStart = pos.x - offsetX;
        const nodeXEnd = pos.x + 300 - offsetX;
        const nodeYStart = pos.y - offsetY;
        const nodeYEnd = pos.y + 240 - offsetY;

        if (mouseX >= nodeXStart && mouseX <= nodeXEnd && mouseY >= nodeYStart && mouseY <= nodeYEnd) {
            return pos;
        }
    }
    return null;
}

const canvas = document.getElementById('nodes-container');
const ctx = canvas.getContext('2d');

const image = new Image();
image.src = "./images/assets/exercise-cpp.png";

image.onload = async () => {
    const token = "7e9fcf17-ff47-4fb7-a3e2-10edfee3c7a2";  // Token del módulo (puedes obtenerlo dinámicamente)
    
    // Fetch exercises from API
    const { exercises } = await fetchModuleExercises(token);

    // Redimensionar el canvas antes de dibujar
    resizeCanvas(canvas);

    const graph = createGraph(exercises);

    let isDragging = false;
    let lastX = 0;
    let lastY = 0;
    let offsetX = 0;
    let offsetY = 0;
    let isSpacePressed = false; 

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawGraph(graph, ctx, offsetX, offsetY, image);
    }

    function startDragging(e) {
        if (isSpacePressed && e.button === 0) {
            isDragging = true;
            lastX = e.clientX;
            lastY = e.clientY;
        }
    }

    function drag(e) {
        if (isDragging) {
            const deltaX = e.clientX - lastX;
            const deltaY = e.clientY - lastY;
    
            offsetX -= deltaX;
            offsetY -= deltaY;
    
            lastX = e.clientX;
            lastY = e.clientY;
    
            draw();
        }
    }

    function stopDragging() {
        isDragging = false;
    }

    window.addEventListener("keydown", (e) => {
        if (e.code === "Space") {
            isSpacePressed = true;
        }
    });

    window.addEventListener("keyup", (e) => {
        if (e.code === "Space") {
            isSpacePressed = false;
        }
    });

    canvas.addEventListener("click", (e) => {
        const rect = canvas.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const clickY = e.clientY - rect.top;

        const clickedNode = detectNodeInteraction(graph, clickX, clickY, offsetX, offsetY);

        if (clickedNode) {
            if (clickedNode.type === "exercise") {
                window.location.href = `${baseUrl}/ejercicio`;
            } else if (clickedNode.type === "theory") {
                window.location.href = `${baseUrl}/contenido`;
            }
        }
    });

    canvas.addEventListener("mousemove", (e) => {
        const rect = canvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;

        const newHoveredNode = detectNodeInteraction(graph, mouseX, mouseY, offsetX, offsetY);

        if (newHoveredNode !== hoveredNode) {
            hoveredNode = newHoveredNode;

            if (hoveredNode) {
                canvas.style.cursor = 'pointer';
            } else {
                canvas.style.cursor = 'default';
            }

            draw(); 
        }
    });

    canvas.addEventListener("mousedown", startDragging);
    canvas.addEventListener("mousemove", drag);
    canvas.addEventListener("mouseup", stopDragging);
    canvas.addEventListener("mouseleave", stopDragging);

    window.addEventListener('load', () => {
        draw(); // Asegurarse de dibujar al cargar la página
    });

    window.addEventListener('resize', () => {
        resizeCanvas(canvas);
        draw(); // Redibujar al redimensionar
    });

    draw(); // Dibujar al cargar la imagen
};

// Resize function for canvas
function resizeCanvas(canvas) {
    const container = canvas.parentNode;
    canvas.width = container.clientWidth;
    canvas.height = container.clientHeight;
}