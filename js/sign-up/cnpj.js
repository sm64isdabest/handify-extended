document.addEventListener('DOMContentLoaded', function () {
  const cnpjInput = document.getElementById('cnpj');
  if (cnpjInput) {
    const cnpjMaskOptions = {
      mask: '00.000.000/0000-00'
    };
    IMask(cnpjInput, cnpjMaskOptions);

    console.log("cnpj.js loaded");
  }
});