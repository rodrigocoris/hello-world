// Nodes.js
import { Canvas } from "./Canvas.js";

export class Nodes {
    constructor(xPos, yPos, width, height, radius, type, level, title, description, image) {
        this.xPos = xPos;
        this.yPos = yPos;
        this.width = width;
        this.height = height;
        this.radius = radius;
        this.border_color = "#EEEDED";
        this.linear_gradient = [];
        this.type = type;
        this.level = level;
        this.title = title;
        this.description = description;
        this.image = image;
    }

    draw(ctx, offsetX, offsetY) {
        // Pasamos todos los atributos del nodo a la clase Canvas
        const canvasNode = new Canvas(
            ctx, 
            this.xPos, 
            this.yPos, 
            this.width, 
            this.height, 
            this.radius, 
            this.border_color, 
            offsetX, 
            offsetY, 
            this.type, 
            this.level, 
            this.title, 
            this.description, 
            this.image
        );
        canvasNode.draw(); // Llamamos al método draw
    }
}
