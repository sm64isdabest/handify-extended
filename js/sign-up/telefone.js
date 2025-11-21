document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        const phoneMaskOptions = {
            mask: [
                { mask: '(00) 0000-0000' },
                { mask: '(00) 00000-0000' }
            ]
        };
        IMask(phoneInput, phoneMaskOptions);
        console.log("telefone.js");
    }

    const modalPhoneInput = document.getElementById('cardPhone');
    if (modalPhoneInput) {
        const phoneMaskOptions = {
            mask: [
                { mask: '(00) 0000-0000' },
                { mask: '(00) 00000-0000' }
            ]
        };
        IMask(modalPhoneInput, phoneMaskOptions);
        console.log("telefone.js/modal loaded");
    }
});
