
document.addEventListener("DOMContentLoaded", () => {
  var botaoComprar = document.getElementById("botao-comprar");
  var telaConfirmar = document.getElementById("tela-confirmar");
  var telaConfirmado = document.getElementById("tela-confirmado");
  var voltarConfirmacao = document.getElementById("voltar-confirmacao");

  botaoComprar.addEventListener("click", () => {
    telaConfirmar.style.display = "none";
    telaConfirmado.style.display = "block";
  });

  voltarConfirmacao.addEventListener("click", () => {
    telaConfirmado.style.display = "none";
    telaConfirmar.style.display = "block";
  });
});
