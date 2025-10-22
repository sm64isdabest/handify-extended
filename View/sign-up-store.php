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
  
    $cnpj = trim(strip_tags($_POST['cnpj'] ?? ''));
    $store_name = trim(strip_tags($_POST['storeName'] ?? ''));
    $address = trim(strip_tags($_POST['address'] ?? ''));
    $phone = trim(strip_tags($_POST['phone'] ?? ''));
    if ($password !== $passwordConfirm) {
        $message = "As senhas não conferem.";
    } else {
        $result = $controller->registerStoreUser(
            $user_fullname,
            $email,
            $password,
            $cnpj,
            $store_name,
            $address,
            $phone
        );

        if (is_array($result) && !empty($result['success'])) {
            header('Location: ../index.php');
            exit;
        } else {
            $message = $result['message'] ?? 'Erro ao realizar cadastro da loja.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro Loja - Handify</title>
  <link rel="stylesheet" href="../css/sign-up.css" />
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
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
      <!-- PARA DISPOSITIVOS MÓVEIS -->
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
        <h1>Cadastre sua Loja!</h1>
        <h3>Seja bem-vindo! Cadastre sua loja e comece a divulgar e vender seus produtos artesanais.</h3>

        <form method="POST" action="">
          <label for="userName">
            <i class="bi bi-person"></i>
            <input type="text" id="userName" name="userName" placeholder="Usuário" required />
          </label>

          <label for="userEmail">
            <i class="bi bi-envelope"></i>
            <input type="email" id="userEmail" name="userEmail" placeholder="E-mail" required />
          </label>

          <label for="userPass">
            <i class="bi bi-key"></i>
            <input type="password" id="userPass" name="userPass" placeholder="Senha" required />
          </label>

          <label for="userPassConfirm">
            <i class="bi bi-lock"></i>
            <input type="password" id="userPassConfirm" name="userPassConfirm" placeholder="Confirme sua senha"
              required />
          </label>

          <label for="cnpj">
            <i class="bi bi-building"></i>
            <input type="text" id="cnpj" name="cnpj" placeholder="CNPJ" required />
          </label>

          <label for="storeName">
            <i class="bi bi-shop"></i>
            <input type="text" id="storeName" name="storeName" placeholder="Nome da loja" required />
          </label>

          <label for="address">
            <i class="bi bi-geo-alt"></i>
            <input type="text" id="address" name="address" placeholder="Endereço" required />
          </label>

          <label for="phone">
            <i class="bi bi-telephone"></i>
            <input type="tel" id="phone" name="phone" placeholder="Telefone" required />
          </label>

          <div class="buttons">
            <button type="submit" class="active1">Cadastrar Loja</button>
          </div>
        </form>
        <button type="button" onclick="window.location.href='sign-up.php'">Para Consumidores</button>
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

  <script src="../js/sign-up/responsive-text.js"></script>
  <script src="../js/sign-up/input-span-show.js"></script>
  <script src="../js/logged-in.js"></script>
  <script src="../js/mobile-pop-up.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>