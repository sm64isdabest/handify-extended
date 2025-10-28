<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Confirmação de pagamento | Handify</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/payment_confirmed.css" />
</head>

<body>
  <header>
    <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
    <nav>
      <ul>
        <li><a href="../../index.php">Home</a></li>
        <li><a href="about.php#footer">Contato</a></li>
        <li><a href="about.php">Sobre</a></li>
        <li style="display: none;">
          <a href="sign-up.php" class="entrar"><i class="bi bi-person"></i>Entrar</a>
        </li>
        <li class="user-logged" style="display: none;">
          <i class="bi bi-person"></i> placeholder
        </li>
      </ul>
      <button id="list"><i class="bi bi-list"></i></button>
    </nav>
    <div id="popup-menu">
      <ul class="popup-list">
        <li style="display: none;">
          <a href="sign-up.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
        </li>
        <li class="user-logged-mobile" style="display: none;">
          <i class="bi bi-person"></i> placeholder
        </li>
        <li><a href="about.php">Sobre</a></li>
        <li><a href="about.php#footer">Contato</a></li>
        <li><a href="../../index.php">Produtos</a></li>
      </ul>
    </div>
  </header>

  <main>
    <div class="confirmacao-container" id="tela-confirmar" style="display: block">
      <button class="botao-voltar" onclick="history.back()">
        <i class="bi bi-arrow-left"></i>
      </button>
      <h2 class="titulo-pagamento">Confirmação de pagamento</h2>
      <p>Você está prestes a realizar um pagamento com cartão de crédito.</p>
      <div class="botoes-confirmacao">
        <button class="botao-confirmar" id="botao-comprar">Comprar</button>
        <button class="botao-cancelar" onclick="history.back()">Cancelar</button>
      </div>
    </div>

    <div class="confirmacao-container" id="tela-confirmado" style="display: none">
      <button class="botao-voltar" id="voltar-confirmacao">
        <i class="bi bi-arrow-left"></i>
      </button>
      <h2 class="titulo-pagamento">Pagamento confirmado</h2>
      <img src="../images/icones/logo-confirmado.png" alt="Pagamento confirmado" class="icone-confirmado" />
      <p class="mensagem-agradecimento">Obrigado por confiar na gente! <span>😉</span></p>
      <div class="botoes-confirmacao">
        <button class="botao-confirmar" onclick="window.location.href='../index.php'">Ir para o Início</button>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 HANDIFY. Todos os direitos reservados.</p>
    <div class="social-icons">
      <a href="https://web.whatsapp.com/" target="_blank"><i class="bi bi-whatsapp"></i></a>
      <a href="https://www.youtube.com/" target="_blank"><i class="bi bi-youtube"></i></a>
      <a href="https://x.com/" target="_blank"><i class="bi bi-twitter-x"></i></a>
      <a href="https://www.instagram.com/" target="_blank"><i class="bi bi-instagram"></i></a>
    </div>
  </footer>

  <!-- VLIBRAS -->
  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>

  <script type="module" src="../js/logged-in.js"></script>
  <script src="../js/payment-confirmed/payment-confirmed.js"></script>
</body>

</html>
