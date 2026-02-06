// Canvas.js
export class Canvas {
    constructor(ctx, xPos, yPos, width, height, radius, border_color, offsetX, offsetY, type, level, title, description, image) {
        this.ctx = ctx;
        this.xPos = xPos;
        this.yPos = yPos;
        this.width = width;
        this.height = height;
        this.radius = radius;
        this.border_color = border_color;
        this.offsetX = offsetX;
        this.offsetY = offsetY;
        this.type = type;
        this.level = level;
        this.title = title;
        this.description = description;
        this.image = image;

        this.linear_gradient = this.type === "exercise" ? ["#D24ABE", "#6258FE"] : ["#62C7F2", "#5F58FF"];
    }

    draw() {
        const ctx = this.ctx;
        ctx.save();

        // Node shadow
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 4;
        ctx.shadowBlur = 15;
        ctx.shadowColor = "rgba(0, 0, 0, 0.25)";

        // Draw the rounded rectangle of the node
        ctx.beginPath();
        ctx.moveTo(this.xPos - this.offsetX + this.radius, this.yPos - this.offsetY);
        ctx.lineTo(this.xPos - this.offsetX + this.width - this.radius, this.yPos - this.offsetY);
        ctx.quadraticCurveTo(this.xPos - this.offsetX + this.width, this.yPos - this.offsetY, this.xPos - this.offsetX + this.width, this.yPos - this.offsetY + this.radius);
        ctx.lineTo(this.xPos - this.offsetX + this.width, this.yPos - this.offsetY + this.height - this.radius);
        ctx.quadraticCurveTo(this.xPos - this.offsetX + this.width, this.yPos - this.offsetY + this.height, this.xPos - this.offsetX + this.width - this.radius, this.yPos - this.offsetY + this.height);
        ctx.lineTo(this.xPos - this.offsetX + this.radius, this.yPos - this.offsetY + this.height);
        ctx.quadraticCurveTo(this.xPos - this.offsetX, this.yPos - this.offsetY + this.height, this.xPos - this.offsetX, this.yPos - this.offsetY + this.height - this.radius);
        ctx.lineTo(this.xPos - this.offsetX, this.yPos - this.offsetY + this.radius);
        ctx.quadraticCurveTo(this.xPos - this.offsetX, this.yPos - this.offsetY, this.xPos - this.offsetX + this.radius, this.yPos - this.offsetY);
        ctx.closePath();

        // Fill with gradient
        const gradient = ctx.createLinearGradient(this.xPos - this.offsetX, this.yPos - this.offsetY, this.xPos - this.offsetX + this.width, this.yPos - this.offsetY + this.height);
        gradient.addColorStop(0, this.linear_gradient[0]);
        gradient.addColorStop(1, this.linear_gradient[1]);
        ctx.fillStyle = gradient;
        ctx.fill();

        // Draw the image of the node, if available
        if (this.image.complete) {
            ctx.drawImage(this.image, (this.xPos - this.offsetX + 7.5), (this.yPos - this.offsetY + 5), 180, 154);
        } else {
            this.image.onload = () => {
                ctx.drawImage(this.image, (this.xPos - this.offsetX + 7.5), (this.yPos - this.offsetY + 5), 180, 154);
            };
        }

        // Description container (lower rectangle)
        const descRectHeight = 80;
        const descRectRadius = this.radius;
        const descRectX = this.xPos - this.offsetX;
        const descRectY = this.yPos - this.offsetY + this.height - descRectHeight;
        const descRectWidth = this.width;

        ctx.beginPath();
        ctx.moveTo(descRectX + descRectRadius, descRectY + descRectHeight);
        ctx.lineTo(descRectX + descRectWidth - descRectRadius, descRectY + descRectHeight);
        ctx.quadraticCurveTo(descRectX + descRectWidth, descRectY + descRectHeight, descRectX + descRectWidth, descRectY + descRectHeight - descRectRadius);
        ctx.lineTo(descRectX + descRectWidth, descRectY);
        ctx.lineTo(descRectX, descRectY);
        ctx.lineTo(descRectX, descRectY + descRectHeight - descRectRadius);
        ctx.quadraticCurveTo(descRectX, descRectY + descRectHeight, descRectX + descRectRadius, descRectY + descRectHeight);
        ctx.closePath();

        // Fill and stroke of the description container
        ctx.fillStyle = "#FFFFFF";
        ctx.fill();
        ctx.strokeStyle = this.border_color;
        ctx.lineWidth = 1;
        ctx.stroke();

        // Draw the levels (text)
        const lines = this.level.split('\n');
        const lineHeight = 20;
        const lineSpacing = 10;
        const totalLineHeight = lineHeight + lineSpacing;

        ctx.fillStyle = this.border_color;
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.font = "20px 'Formula 1', Arial";

        lines.forEach((line, index) => {
            let color;
            if (line.includes("Básico"))          color = "#3FD630";
            else if (line.includes("Intermedio")) color = "#92D630";
            else if (line.includes("Avanzado"))   color = "#D6C730";
            else if (line.includes("Experto"))    color = "#D67430";
            else if (line.includes("Hacker"))     color = "#D63092";

            ctx.fillStyle = color;
            ctx.fillText(
                line,
                this.xPos - this.offsetX + (this.width / 2) + 80,
                this.yPos - this.offsetY + (this.height / 2) - 5 + (index - (lines.length - 1) / 2) * totalLineHeight
            );
        });

        // Show title and description below the node
        ctx.fillStyle = "#000000";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.font = "bold 16px Arial";
        ctx.fillText(this.title, this.xPos - this.offsetX + this.width / 2, this.yPos - this.offsetY + this.height - 60);
        ctx.font = "14px Arial";
        ctx.fillText(this.description, this.xPos - this.offsetX + this.width / 2, this.yPos - this.offsetY + this.height - 40);

        ctx.restore();
    }
}
