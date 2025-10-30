<?php
session_start();

require_once '../Controller/UserController.php';
use Controller\UserController;

$controller = new UserController();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if (empty($email) || empty($password)) {
    $message = "Preencha todos os campos!";
  } else {
    if ($controller->login($email, $password)) {
      $userName = $controller->getUserNameByEmail($email);

      setcookie('userName', urlencode($userName), [
        'expires' => time() + 7 * 24 * 60 * 60,
        'path' => '/',
        'secure' => false,
        'httponly' => false,
        'samesite' => 'Lax'
      ]);

      header('Location: ../index.php');
      exit;
    } else {
      $message = "Email ou senha incorretos.";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>login - Handify</title>
  <link rel="stylesheet" href="../css/login.css" />
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <header>
    <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
    <nav>
      <ul>
        <li><a href="../../index.php">Produtos</a></li>
        <li><a href="about.php#footer">Contato</a></li>
        <li><a href="about.php">Sobre</a></li>
        <li style="display: none;"><a href="login.php" class="entrar"><i class="bi bi-person"></i>Entrar</a></li>
        <li class="user-logged" style="display: none;"><i class="bi bi-person"></i> placeholder</li>
      </ul>
      <button id="list"><i class="bi bi-list"></i></button>
    </nav>
    <div id="popup-menu">
      <ul class="popup-list">
        <li style="display: none;"><a href="login.php" class="entrar-mobile"><i class="bi bi-person"></i> Entrar</a>
        </li>
        <li class="user-logged-mobile" style="display: none;"><i class="bi bi-person"></i> placeholder</li>
        <li><a href="about.php">Sobre</a></li>
        <li><a href="about.php#footer">Contato</a></li>
        <li><a href="../../index.php">Home</a></li>
      </ul>
    </div>
  </header>

  <main>
    <section class="cadastro-container">
      <div class="image-container">
        <img src="../images/fundos/objetos_artesanais.png" alt="Objetos Artesanais" />
      </div>
      <div class="form-container">
        <h1>Login</h1>
        <h3>Seja bem-vindo! Logue sua conta e comece a mostrar, divulgar e vender seu artesanato com a gente.</h3>

        <form method="POST" action="">
          <label id="labelUserEmail" for="userEmail">
            <i class="bi bi-envelope"></i>
            <input type="email" id="userEmail" name="email" autocomplete="username" placeholder="Email" required />
          </label>

          <label id="labelUserPass" for="userPass">
            <i class="bi bi-key"></i>
            <input type="password" id="userPass" name="password" placeholder="Insira sua senha" />
          </label>

          <?php if (!empty($message)): ?>
            <span style="color:red; display:block;"><?= htmlspecialchars($message) ?></span>
          <?php endif; ?>

          <div class="buttons">
            <button type="submit" class="active">Entrar</button>
          </div>

          <div class="linkCadastro">
            <h5>Não tem conta? <a href="sign-up.php" class="link-primary">Cadastrar-se</a></h5>
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

  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

  <script src="../js/mobile-pop-up.js"></script>
  <script src="../js/login/input-span-show.js"></script>
  <script src="../js/logged-in.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>