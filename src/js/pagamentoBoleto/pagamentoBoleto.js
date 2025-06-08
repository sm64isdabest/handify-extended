function copyBoletoCode() {
    const boletoCodeInput = document.getElementById('boletoCode');
    boletoCodeInput.select();
    boletoCodeInput.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(boletoCodeInput.value).then(() => {
        alert('Código do boleto copiado para a área de transferência!');
    }, () => {
        alert('Falha ao copiar o código do boleto. Por favor, copie manualmente.');
    });
}
