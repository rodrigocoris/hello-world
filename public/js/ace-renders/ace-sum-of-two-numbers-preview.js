// Initialize ACE Editor
var editor_sample = ace.edit("editor-preview-practice");
editor_sample.setTheme("ace/theme/monokai");
editor_sample.session.setMode("ace/mode/c_cpp");

// Adds the C++ auto-completion extension
ace.require("ace/ext/language_tools");
editor_sample.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true
});

// Sets the initial content
editor_sample.setValue(
`#include <iostream>

int main() {
    std::cout << "Ingrese el rango [a, b]:";
    int a, b, sum = 0; 
    std::cin >> a >> b;

    for (int i = a; i <= b; ++i) {
        if (i % 2 == 0)
            sum += i;
    }

    std::cout << "La suma de los números pares en el rango [" << a << ", " << b << "] es:" << sum << std::endl;
    return 0;
}`);

editor_sample.gotoLine(4);
editor_sample.setFontSize("16px");