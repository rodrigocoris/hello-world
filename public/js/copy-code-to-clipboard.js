// Function to copy the code to the clipboard
function copyCodeToClipboard(editorName) {
    var copyButton = document.getElementById("copyButton-" + editorName);
    var originalIcon = copyButton.innerHTML;
    var originalText = copyButton.innerText;

    var code = window["editor_" + editorName].getValue();
    navigator.clipboard.writeText(code)
        .then(() => {
            copyButton.innerHTML = '<i class="fas fa-copy"></i> Código copiado';
            copyButton.setAttribute("disabled", true);

            // Después de 2 segundos, vuelve al estado original
            setTimeout(function() {
                copyButton.innerHTML = originalIcon;
                copyButton.removeAttribute("disabled");
            }, 2000);
        })
        .catch(err => {
            console.error('Error al copiar el código:', err);
        });
}