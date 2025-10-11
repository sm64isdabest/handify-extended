<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender - Handify</title>
    <link rel="stylesheet" href="../css/sell.css">
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
        <div class="container-produto">
            <div class="sidebar">
                <button class="btn-add"><i class="bi bi-plus"></i></button>
                <button class="btn-back"> <i class="bi bi-arrow-left"> </i> </button>
            </div>
            <div class="imagem-produto">
                <button class="btn-add"><i class="bi bi-plus"></i></button>
            </div>
            <!-- para dispositivos móveis -->
            <button class="mobile btn-add"><i class="bi bi-plus"></i></button>
            <div class="info-produto">
                <div class="nome-produto">
                    <input type="text" placeholder="Nome do Produto" />
                </div>
                <div class="valor-produto">
                    <input type="text" placeholder="Valor do Produto" />
                </div>
                <div class="parcelas-produto">
                    <input type="text" placeholder="Parcelas" />
                </div>
                <div class="descricao-produto">
                    <input type="text" placeholder="Descrição do Produto" />
                </div>
            </div>
            <div class="destaque-produto">
                <div class="titulo-destaque">Informações De Destaque</div>
                <div class="botoes-destaque">
                    <button>+</button>
                    <button>+</button>
                    <button>+</button>
                    <button>+</button>
                </div>
                <div class="quantidade-produto">
                    <input type="text" placeholder="Quantidade" />
                </div>
                <button class="comprar-agora" disabled>Comprar Agora</button>
                <button class="adicionar-carrinho" disabled>Adicionar ao Carrinho</button>
            </div>
        </div>

        <div class="quadro-descricao">
            <input type="text" placeholder="Descrição do Produto" />
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

    <script src="../js/sell/sell-product.js"></script>
    <script src="../js/mobile-pop-up.js"></script>
    <script src="../js/logged-in.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>