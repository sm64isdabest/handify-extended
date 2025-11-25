<?php
session_start();

if (!isset($_SESSION['id']) && isset($_COOKIE['userId'], $_COOKIE['userName'], $_COOKIE['userType'])) {
  $_SESSION['id'] = $_COOKIE['userId'];
  $_SESSION['user_fullname'] = $_COOKIE['userName'];
  $_SESSION['user_type'] = $_COOKIE['userType'];
}

if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$userId = $_SESSION['id'];
$userName = $_SESSION['user_fullname'] ?? '';
$userType = $_SESSION['user_type'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Pagamento | Handify</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/payment-methods.css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>
  <header>
    <nav>
      <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />

      <ul>
        <li><a href="../index.php" class="scroll-link">Home</a></li>
        <li><a href="about.php#footer">Contato</a></li>
        <li><a href="about.php">Sobre</a></li>
        <li>
          <a href="login.php" class="entrar"><i class="bi bi-person"></i>Entrar</a>
        </li>
        <li class="user-logged" style="display: none; position: relative;">
          <i class="bi bi-person profile-btn" style="cursor: pointer; font-size: 1.5rem;"></i>
          <span class="user-name"></span>
          <div class="menu-popup">
            <p class="user-name-popup"></p>
            <button class="menu-item" onclick="window.location.href='profile.php'">Meu Perfil</button>
            <button class="menu-item logout-btn">Sair</button>
          </div>
        </li>
      </ul>
      <div id="popup-menu">
        <ul class="popup-list">
          <li>
            <a href="View/login.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
          </li>
          <li class="user-logged" style="display: none; position: relative;">
            <i class="bi bi-person profile-btn" style="cursor: pointer; font-size: 1.5rem;"></i>
            <span class="user-name"></span>
            <div class="menu-popup">
              <p class="user-name-popup"></p>
              <button class="menu-item logout-btn">Sair</button>
            </div>
          </li>
          <li><a href="about.php">Sobre</a></li>
          <li><a href="about.php#footer">Contato</a></li>
          <li><a href="../index.php" class="scroll-link">Home</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <div class="container-pagamento">
      <a onclick="history.back()" class="botao-voltar">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2 class="titulo-pagamento">Formas de pagamento</h2>
      <div class="meios-pagamento">
        <a href="payment-pix.php" class="opcao-pagamento" style="text-decoration: none; color: inherit">
          <span class="icone-pagamento">
            <img src="../images/icones/Logo-PIX.png" alt="Pix" />
          </span>
          <span class="rotulo-pagamento">Pix</span>
        </a>
        <a href="payment-card.php" class="opcao-pagamento" style="text-decoration: none; color: inherit">
          <span class="icone-pagamento">
            <i class="bi bi-credit-card"></i>
          </span>
          <span class="rotulo-pagamento">Cartão de Crédito</span>
        </a>
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
    new window.VLibras.Widget("https://vlibras.gov.br/app");
  </script>

  <script type="module" src="../js/logged-in.js"></script>
  <script type="module" src="../js/product/icon-pop-up.js"></script>
</body>

</html>