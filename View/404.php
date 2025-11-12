<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - Handify</title>
    <link rel="stylesheet" href="../css/404.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body>
    <header>
        <div class="header-container">
            <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
            <div class="search-bar">
                <input type="text" autocomplete="off" placeholder="Buscar produtos..." id="searchInput" />
                <i class="bi bi-search" id="searchButton"></i>
                <ul id="autocomplete-list" class="autocomplete-items"></ul>
            </div>
            <div class="menu_clc">
                <button id="cartIconMobile">
                    <i class="bi bi-cart"></i>
                </button>
                <button id="listToggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            <nav id="mainNav">
                <ul>
                    <li><a href="../../index.php" class="nav-link" data-target="produtos">Produtos</a></li>
                    <li><a href="about.php#footer" class="nav-link" data-target="contatos">Contato</a></li>
                    <li><a href="about.php" class="nav-link" data-target="sobre">Sobre</a></li>
                    <li><a href="login.php" class="entrar" data-target="entrar"><i class="bi bi-person"></i>Entrar</a>
                    </li>
                    <li class="user-logged" style="display: none;">
                        <i class="bi bi-person"></i> placeholder
                    </li>
                </ul>
            </nav>
        </div>
        <div class="menu-bar">
            <div>
                <button class="menu-bar-btn" id="categoriasBtn">Categorias</button>
                <button class="menu-bar-btn" id="ofertasBtn">Ofertas</button>
                <button class="menu-bar-btn" id="vender-btn"
                    onclick="window.location.href = './sell.php'">Vender</button>
                <button class="menu-bar-btn" id="historicoBtn">Histórico</button>
            </div>
            <button class="cart-btn" id="cartIconDesktop"><i class="bi bi-cart"></i></button>
        </div>
        <div id="popup-menu">
            <ul class="popup-list">
                <header class="pop_up">
                    <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
                    <i class="bi bi-cart3"></i>
                    <p>Carrinho de compra</p>
                    <button class="sair_pop"><i class="bi bi-box-arrow-right"></i></button>
                </header>
            </ul>
            <div class="pag_pop"></div>
        </div>
        <div id="popup-menu-list">
            <ul class="popup-list-mob">
                <li>
                    <a href="login.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
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

    <script type="module" src="../js/product/icon-pop-up.js"></script>
    <script type="module" src="../js/product/menu-list-pop-up.js"></script>
    <script type="module" src="../js/product/add-to-cart.js"></script>
    <script type="module" src="../js/product/switch-product.js"></script>
    <script type="module" src="../js/search.js"></script>
    <script src="../js/logged-in.js"></script>
</body>

</html>