document.addEventListener('DOMContentLoaded', function () {
    const botaoVoltar = document.querySelector('.botao-voltar');
    if (botaoVoltar) {
        botaoVoltar.addEventListener('click', function () {
            window.history.back();
        });
    }

    const inputNumeroCartao = document.getElementById('numeroCartao');
    const inputNomeTitular = document.getElementById('nomeCartao');
    const displayNumeroCartao = document.getElementById('numeroCartaoDisplay');
    const displayNomeCartao = document.getElementById('nomeCartaoDisplay');
    const iconeInputCartao = document.getElementById('iconeInputCartao');

    // Format card number input with dashes in pattern xxxx-xxxx-xx-xx
    function formatarNumeroCartao(valor) {
        let v = valor.replace(/\D/g, '');
        let parts = [];
        if (v.length > 0) parts.push(v.substring(0, 4));
        if (v.length > 4) parts.push(v.substring(4, 8));
        if (v.length > 8) parts.push(v.substring(8, 10));
        if (v.length > 10) parts.push(v.substring(10, 12));
        return parts.join('-');
    }

    inputNumeroCartao.addEventListener('input', function () {
        // Format input value
        this.value = formatarNumeroCartao(this.value);

        // Update card preview number with same format
        displayNumeroCartao.textContent = this.value || '4725-8768-04-••';

        // Optionally, change card icon based on number prefix (simplified)
        const val = this.value.replace(/-/g, '');
        if (
            val.startsWith('4011') || val.startsWith('4312') || val.startsWith('4389') ||
            val.startsWith('4514') || val.startsWith('4576') || val.startsWith('5041') ||
            val.startsWith('5066') || val.startsWith('5090') || val.startsWith('6277') ||
            val.startsWith('6362') || val.startsWith('6363')
        ) {
            iconeInputCartao.src = '../images/icones/Logo-ELO.png';
            iconeInputCartao.alt = 'Logo Elo';
        } else if (val.startsWith('4')) {
            iconeInputCartao.src = '../images/icones/visa-logo.png';
            iconeInputCartao.alt = 'Logo Visa';
        } else if (val.startsWith('5')) {
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

    const inputValidade = document.getElementById('validade');

    // Format validade input as MM/YY
    function formatarValidade(valor) {
        let v = valor.replace(/\D/g, '');
        if (v.length > 2) {
            v = v.substring(0, 2) + '/' + v.substring(2, 4);
        }
        return v;
    }

    inputValidade.addEventListener('input', function () {
        this.value = formatarValidade(this.value);
    });
});
