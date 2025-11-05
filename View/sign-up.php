<?php

session_start();

require_once '../controller/UserController.php';
use Controller\UserController;

$controller = new UserController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_fullname = trim(strip_tags($_POST['userName'] ?? ''));
  $email = trim(strip_tags($_POST['userEmail'] ?? ''));
  $password = $_POST['userPass'] ?? '';
  $passwordConfirm = $_POST['userPassConfirm'] ?? '';
  $phone = trim(strip_tags($_POST['phone'] ?? ''));
  $birthdate = trim(strip_tags($_POST['birthdate'] ?? ''));
  $address = trim(strip_tags($_POST['address'] ?? ''));

  if ($password !== $passwordConfirm) {
    $message = "As senhas não conferem.";
  } else {
    if (!empty($_POST['cnpj'])) {
      $cnpj = trim(strip_tags($_POST['cnpj'] ?? ''));
      $store_name = trim(strip_tags($_POST['storeName'] ?? ''));
      $result = $controller->registerStoreUser($user_fullname, $email, $password, $cnpj, $store_name, $address, $phone);
    } else {
      $result = $controller->registerCustomerUser($user_fullname, $email, $password, $phone, $birthdate, $address);
    }
    if (is_array($result) && !empty($result['success'])) {
      setcookie('userName', urldecode($user_fullname), time() + (7 * 24 * 60 * 60), '/');
      header('Location: ../index.php');
      exit;
    } else {
      if (is_array($result) && !empty($result['message'])) {
        $message = $result['message'];
      } else {
        $message = 'Erro ao realizar cadastro.';
      }
    }
  }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - Handify</title>
  <link rel="stylesheet" href="../css/sign-up.css" />
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
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
          <a href="login.php" class="entrar"><i class="bi bi-person"></i>Entrar</a>
        </li>
        <li class="user-logged" style="display: none;">
          <i class="bi bi-person"></i> placeholder
        </li>
      </ul>
      <!-- PARA DISPOSITIVOS MÓVEIS -->
      <button id="list"><i class="bi bi-list"></i></button>
    </nav>
    <div id="popup-menu">
      <ul class="popup-list">
        <li style="display: none;">
          <a href="login.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
        </li>
        <li class="user-logged-mobile" style="display: none;">
          <i class="bi bi-person"></i> placeholder
        </li>
        <li><a href="about.php">Sobre</a></li>
        <li><a href="about.php#footer">Contato</a></li>
        <li><a href="../../index.php">Home</a></li>
      </ul>
    </div>
  </header>
  <main>
    <section class="cadastro-container">
      <div class="image-container">
        <img src="../images/fundos/objetos_artesanais.png" alt="Objetos artesanais" />
      </div>
      <div class="form-container">
        <h1>Cadastrar-se</h1>
        <h3>
          Bem-vindo! Cadastre-se e descubra o melhor do artesanato, conectando-se com talentos únicos e produtos feitos
          à mão.
        </h3>
        <?php if (!empty($message)): ?>
          <div class="alert alert-danger">
            <?= htmlspecialchars($message) ?>
          </div>
        <?php endif; ?>
        <form method="POST" action="">
          <label id="labelUserName" for="userName">
            <i class="bi bi-person"></i>
            <input type="text" id="userName" name="userName" autocomplete="name" placeholder="Nome completo" required />
          </label>

          <label id="labelUserEmail" for="userEmail">
            <i class="bi bi-envelope"></i>
            <input type="email" id="userEmail" name="userEmail" autocomplete="email" placeholder="E-mail" required />
          </label>

          <label id="labelUserPass" for="userPass">
            <i class="bi bi-key"></i>
            <input type="password" id="userPass" name="userPass" placeholder="Insira sua senha" required />
          </label>

          <label id="labelUserPassConfirm" for="userPassConfirm">
            <i class="bi bi-lock"></i>
            <input type="password" id="userPassConfirm" name="userPassConfirm" placeholder="Confirme sua senha"
              required />
          </label>

          <label id="labelPhone" for="phone">
            <i class="bi bi-telephone"></i>
            <input type="text" id="phone" name="phone" placeholder="Telefone" />
          </label>

          <label id="labelBirthdate" for="birthdate">
            <i class="bi bi-calendar"></i>
            <input type="date" id="birthdate" name="birthdate" placeholder="Data de nascimento" />
          </label>

          <label id="labelAddress" for="address">
            <i class="bi bi-house"></i>
            <input type="text" id="address" name="address" placeholder="Endereço" />
          </label>

          <span>Por favor, preencha todos os campos!</span>

          <div class="buttons">
            <button type="submit" class="active" id="responsive-text">
              Cadastre-se
            </button>
            <button type="button" class="active1" onclick="window.location.href='sign-up-store.php'" id="btn_store">Para
              Lojas</button>
          </div>
        </form>
      </div>
    </section>
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

  <script src="../js/sign-up/responsive-text.js"></script>
  <script src="../js/sign-up/input-span-show.js"></script>
  <script src="../js/logged-in.js"></script>
  <script src="../js/mobile-pop-up.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>