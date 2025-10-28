// Quando clicar em "Comprar", troca a tela
document.addEventListener("DOMContentLoaded", () => {
  var botaoComprar = document.getElementById("botao-comprar");
  var telaConfirmar = document.getElementById("tela-confirmar");
  var telaConfirmado = document.getElementById("tela-confirmado");
  var voltarConfirmacao = document.getElementById("voltar-confirmacao");

  botaoComprar.addEventListener("click", () => {
    // Esconde a tela inicial e mostra a de confirmação
    telaConfirmar.style.display = "none";
    telaConfirmado.style.display = "block";
  });

  // Botão de voltar na tela de confirmação
  voltarConfirmacao.addEventListener("click", () => {
    telaConfirmado.style.display = "none";
    telaConfirmar.style.display = "block";
  });
});
