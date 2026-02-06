// main.js
import { Nodes } from './Nodes.js';
import { Graph } from './Graph.js';

// Get the base URL from the meta tag
const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

// Node currently under the mouse
let hoveredNode = null;

function createGraph() {
    const graph = new Graph();

    let title = "Título del nodo";
    let description = "Descripción del nodo";

    graph.addVertex("A", "theory", "Nivel\nBásico", title, description, 400, 250);
    graph.addVertex("B", "exercise", "Nivel\nBásico", title, description, 800, -150);
    graph.addVertex("C", "theory", "Nivel\nIntermedio", title, description, 800, 250);
    graph.addVertex("D", "exercise", "Nivel\nAvanzado", title, description, 800, 650);
    graph.addVertex("E", "exercise", "Nivel\nIntermedio", title, description, 1200, -150);
    graph.addVertex("F", "exercise", "Nivel\nAvanzado", title, description, 1300, 250);
    graph.addVertex("G", "exercise", "Nivel\nExperto", title, description, 1700, 250);
    graph.addVertex("H", "exercise", "Nivel\nHacker", title, description, 2200, -150);
    graph.addVertex("I", "theory", "Nivel\nBásico", title, description, 1200, 650);

    graph.addEdge("A", "B", "C", "D");
    graph.addEdge("B", "A");
    graph.addEdge("C", "A");
    graph.addEdge("D", "A");
    graph.addEdge("E", "C", "H");
    graph.addEdge("F", "C");
    graph.addEdge("G", "F");
    graph.addEdge("H", "G");
    graph.addEdge("I", null);

    return graph;
}

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
        const isHovered = hoveredNode && hoveredNode.x === pos.x && hoveredNode.y === pos.y; // Check if the node is hovered
        const node = new Nodes(pos.x, pos.y, 300, 240, 15, pos.type, pos.level, pos.title, pos.description, image);

        // If the node is being hovered, apply the effect
        if (isHovered) {
            node.border_color = "#FF5733"; // Change the color here to your preferred hover color (e.g., "#FF5733")
        } else {
            node.border_color = "#EEEDED"; // Default color
        }

        node.draw(ctx, offsetX, offsetY, pos.type);
    }
}

function resizeCanvas(canvas) {
    const container = canvas.parentNode;
    canvas.width = container.clientWidth;
    canvas.height = container.clientHeight;
}

// Detect clicks on the node
function detectNodeInteraction(graph, mouseX, mouseY, offsetX, offsetY) {
    for (let vertex in graph.positions) {
        const pos = graph.positions[vertex];
        const nodeXStart = pos.x - offsetX;
        const nodeXEnd = pos.x + 300 - offsetX; // 300 = width of the node
        const nodeYStart = pos.y - offsetY;
        const nodeYEnd = pos.y + 240 - offsetY; // 240 = height of the node

        if (mouseX >= nodeXStart && mouseX <= nodeXEnd && mouseY >= nodeYStart && mouseY <= nodeYEnd) {
            return pos; // Returns the node if the mouse is within its bounds
        }
    }
    return null;
}

const canvas = document.getElementById('nodes-container');
const ctx = canvas.getContext('2d');

const image = new Image();
image.src = "./images/assets/exercise-cpp.png";

image.onload = () => {
    const graph = createGraph();

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

    // Click event to redirect based on the node
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

    // Event to detect hover
    canvas.addEventListener("mousemove", (e) => {
        const rect = canvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;

        const newHoveredNode = detectNodeInteraction(graph, mouseX, mouseY, offsetX, offsetY);

        // Change the cursor and apply hover only if the node changes
        if (newHoveredNode !== hoveredNode) {
            hoveredNode = newHoveredNode;

            if (hoveredNode) {
                canvas.style.cursor = 'pointer';
            } else {
                canvas.style.cursor = 'default';
            }

            draw(); // Redraw to apply or remove the hover effect
        }
    });

    // Eventos del mouse para controlar el arrastre
    canvas.addEventListener("mousedown", startDragging);
    canvas.addEventListener("mousemove", drag);
    canvas.addEventListener("mouseup", stopDragging);
    canvas.addEventListener("mouseleave", stopDragging);

    // Dibuja el gráfico al cargar la página y ajustar el tamaño de la ventana
    window.addEventListener('load', () => {
        resizeCanvas(canvas);
        draw();
    });

    window.addEventListener('resize', () => {
        resizeCanvas(canvas);
        draw();
    });

    draw();
};