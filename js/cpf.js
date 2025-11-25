document.addEventListener('DOMContentLoaded', function () {
    const cpfInput = document.getElementById('cardTaxId');

    if (cpfInput) {
        IMask(cpfInput, {
            mask: '000.000.000-00'
        });
    }
});