var editor_header = ace.edit("editor-preview");

document.addEventListener("DOMContentLoaded", () => {
    // Configuración inicial
    editor_header.setTheme("ace/theme/monokai"); // Tema por defecto
    editor_header.session.setMode("ace/mode/c_cpp");

    ace.require("ace/ext/language_tools");
    editor_header.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true,
    });

    // Sets the initial content
    editor_header.setValue(
`#include <iostream>
    
// Función para calcular la serie de Fibonacci
int fibonacci(int n) {
    if (n <= 1)
        return n;
    
    return fibonacci(n - 1) + fibonacci(n - 2);
}
    
int main() {
    int terms = 10; // Imprimir términos de Fibonacci
    std::cout << "Fibonacci series:" << std::endl;
    for (int i = 0; i < terms; ++i) {
        std::cout << fibonacci(i) << " ";
    }
    
    std::cout << std::endl;
    return 0;
}`);
    editor_header.setFontSize("14px");
    editor_header.gotoLine(4);

    // Cambiar tema del editor
    const themeSelect = document.getElementById("select-theme");

    themeSelect.addEventListener("change", (event) => {
        const selectedTheme = event.target.value;
        editor_header.setTheme(`ace/theme/${selectedTheme}`);
    });

    // Resto de la configuración...
    if (tabletQuery.matches) {
        document.getElementById("panel-top").style.height = "500px";
        initRowLayout();
    } else {
        document.getElementById("panel-top").style.height = "";
        initColumnLayout();
    }
});