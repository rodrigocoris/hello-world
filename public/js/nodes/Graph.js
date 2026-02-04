// Graph.js
export class Graph {
    constructor() {
        this.adjacencyList = {};
        this.positions = {};
    }

    addVertex(vertex, type, level, title, description, x = 0, y = 0) {
        if (!this.adjacencyList[vertex]) {
            this.adjacencyList[vertex] = [];
            this.positions[vertex] = { x, y, type, level, title, description };
        }
    }

    addEdge(vertex, edges) {
        if (!this.adjacencyList[vertex]) {
            this.addVertex(vertex);
        }
    
        let nodes = Array.isArray(edges) ? edges : JSON.parse(edges);
    
        for (let node of nodes) {
            if (node === null) continue;
    
            if (!this.adjacencyList[node]) {
                this.addVertex(node);
            }
    
            if (!this.adjacencyList[vertex].includes(node)) {
                this.adjacencyList[vertex].push(node);
                this.adjacencyList[node].push(vertex);
            }
        }
    }    

    showGraph() {
        for (let vertex in this.adjacencyList) {
            console.log(`${vertex} -> ${this.adjacencyList[vertex].join(', ')}`);
        }
    }
}