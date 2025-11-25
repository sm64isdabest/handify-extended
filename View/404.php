<?php
session_start();

if (!isset($_SESSION['id']) && isset($_COOKIE['userId'], $_COOKIE['userName'], $_COOKIE['userType'])) {
    $_SESSION['id'] = $_COOKIE['userId'];
    $_SESSION['user_fullname'] = $_COOKIE['userName'];
    $_SESSION['user_type'] = $_COOKIE['userType'];
}

$userId = $_SESSION['id'] ?? null;
$userName = $_SESSION['user_fullname'] ?? '';
$userType = $_SESSION['user_type'] ?? '';

require_once __DIR__ . '../../Model/Product.php';
use Model\Product;

$productModel = new Product();
$products = $productModel->getAllProducts();

// BUSCA
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($searchTerm !== '') {
    $products = $productModel->searchByName($searchTerm);
} else {
    $products = $productModel->getAllProducts();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - Handify</title>
    <link rel="stylesheet" href="../css/404.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body>
    <header>
        <nav>
            <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />

            <!-- Funcionalidade de busca -->
            <div class="search-bar">
                <form method="GET" action="search.php">
                    <input type="text" id="searchInput" name="q" autocomplete="off" placeholder="Buscar produtos..."
                        value="<?= htmlspecialchars($searchTerm) ?>" />
                    <button type="submit">
                        <i id="searchButton" class="bi bi-search"></i>
                    </button>
                </form>

                <!-- <ul id="autocomplete-list" class="autocomplete-items" style="visibility: hidden">
        </ul> -->
            </div>
            <!-- Funcionalidade de busca -->

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

        <div class="menu-bar">
            <div>
                <li style="display: none;">
                    <a href="login.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
                </li>
                <a href="search.php" class="btn">Categorias</a>
                <a href="#main" class="scroll-link btn">Ofertas</a>
                <?php if (
                    (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'store') ||
                    (isset($_COOKIE['userType']) && $_COOKIE['userType'] === 'store')
                ): ?>
                    <a href="sell.php" class="btn">Vender</a>
                <?php endif; ?>
                <button id="rastrear-btn">Rastrear</button>
            </div>
            <button class="cart"><i class="bi bi-cart"></i></button>
        </div>
    </header>

    <main>
        <div>
            <h1>404</h1>
            <h2>Oops! Parece que a página que procura não existe ou está indisponível no momento.</h2>
            <button onclick="window.location.href='../index.php'">Voltar para o início</button>
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

    <!-- SCRIPTS -->

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <script type="module" src="../js/search.js"></script>
    <script src="../js/logged-in.js"></script>
</body>

</html>