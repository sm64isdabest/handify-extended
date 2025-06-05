document.addEventListener('DOMContentLoaded', function () {
    const botaoVoltar = document.querySelector('.botao-voltar');
    if (botaoVoltar) {
        botaoVoltar.addEventListener('click', function () {
            window.history.back();
        });
    }

    const inputNumeroCartao = document.getElementById('numeroCartao');
    const inputNomeTitular = document.getElementById('nomeTitular');
    const displayNumeroCartao = document.getElementById('numeroCartaoDisplay');
    const displayNomeCartao = document.getElementById('nomeCartaoDisplay');
    const iconeInputCartao = document.getElementById('iconeInputCartao');

    // Format card number input with spaces every 4 digits
    function formatarNumeroCartao(valor) {
        return valor.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim();
    }

    inputNumeroCartao.addEventListener('input', function () {
        // Format input value
        this.value = formatarNumeroCartao(this.value);

        // Update card preview number
        displayNumeroCartao.textContent = this.value || '4725  8768  04  ••  ••••';

        // Optionally, change card icon based on number prefix (simplified)
        if (this.value.startsWith('4')) {
            iconeInputCartao.src = '../images/icones/visa-logo.png';
            iconeInputCartao.alt = 'Logo Visa';
        } else if (this.value.startsWith('5')) {
            iconeInputCartao.src = '../images/icones/Mastercard.png';
            iconeInputCartao.alt = 'Logo Mastercard';
        } else {
            iconeInputCartao.src = '../images/icones/Mastercard.png';
            iconeInputCartao.alt = 'Ícone do Cartão';
        }
    });

    inputNomeTitular.addEventListener('input', function () {
        displayNomeCartao.textContent = this.value || 'Seu nome aqui';
    });
});
