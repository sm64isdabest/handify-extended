function copyPixKey() {
    const pixKeyInput = document.getElementById('pixKey');
    pixKeyInput.select();
    pixKeyInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(pixKeyInput.value).then(() => {
        alert('Chave Pix copiada para a área de transferência!');
    }, () => {
        alert('Falha ao copiar a chave Pix. Por favor, copie manualmente.');
    });
}
