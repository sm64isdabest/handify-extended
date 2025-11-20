<?php
require_once __DIR__ . '/../Model/Product.php';
use Model\Product;

$product = null;
if (isset($_GET['produto'])) {
    $slug = trim($_GET['produto']);
    $productModel = new Product();
    $product = $productModel->getProductBySlug($slug);
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $productModel = new Product();
    $product = $productModel->getProductById($id);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produto - Handify</title>
    <link rel="stylesheet" href="../css/product.css" />
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body>
    <header>
        <div class="header-container">
            <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" 
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
                    <li><a href="../../index.php" class="nav-link" data-target="produtos">Home</a></li>
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
                <li><a href="../../index.php">Home</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div class="product-page">
            <section class="product-gallery">
                <div class="main-image">
                    <img src="<?php
                        $imgPath = '../images/produtos/bolsas/bolsa-palha.png';
                        if (!empty($product['image'])) {
                            $img = $product['image'];
                            if (strpos($img, 'http') === 0 || strpos($img, '/') === 0) {
                                $imgPath = $img;
                            } else {
                                $imgPath = '../' . ltrim($img, '/');
                            }
                        }
                        echo htmlspecialchars($imgPath);
                    ?>" alt="<?php echo htmlspecialchars($product['name'] ?? 'Imagem do produto'); ?>" />

                    <h2 class="text_tablet">Estoque disponível</h2>
                    <p class="sub_text_tablet">Quantidade: <?php echo htmlspecialchars($product['stock'] ?? '0'); ?> (<?php echo htmlspecialchars($product['stock'] ?? '0'); ?> disponíveis)</p>
                </div>

            </section>

            <section class="product-details">
                <div class="avaliar">
                    <button class="sair"><i class="bi bi-arrow-left"></i></button> 4.8<span><i
                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                            class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></span>
                </div>
                <h1><?php echo htmlspecialchars($product['name'] ?? 'Produto não encontrado'); ?></h1>
                <?php
                    $rawPrice = $product['price'] ?? '';
                    $priceFormatted = is_numeric($rawPrice) ? 'R$ ' . number_format($rawPrice, 2, ',', '.') : $rawPrice;
                    $oldPrice = $product['original_price'] ?? '';
                    $oldPriceFormatted = is_numeric($oldPrice) ? 'R$ ' . number_format($oldPrice, 2, ',', '.') : $oldPrice;
                ?>
                <p class="price">
                    <span class="old-price"><?php echo htmlspecialchars($oldPriceFormatted); ?></span>
                    <span class="current-price"><?php echo htmlspecialchars($priceFormatted); ?></span>
                </p>
                <p class="installments">em 12x <?php echo htmlspecialchars($priceFormatted); ?>*</p>
                <a href="#" class="payment-methods">Ver meios de pagamentos</a>

                <div class="product-info">
                    <p>O que você precisa saber sobre esse produto</p>
                    <p><?php echo nl2br(htmlspecialchars($product['description'] ?? 'Descrição não disponível.')); ?></p>
                </div>
                <div class="disponiveis_clc">
                    <h3>Estoque disponível</h3>
                    <p>Quantidade: <?php echo htmlspecialchars($product['stock'] ?? '0'); ?> (<?php echo htmlspecialchars($product['stock'] ?? '0'); ?> Disponível)</p>
                </div>
                <div class="botoes_adc">
                    <button class="btn_1" id="btn_1" onclick="window.location.href = 'payment-methods.php'">Comprar Agora</button>
                    <button class="add-to-cart">Adicionar ao Carrinho</button>
                </div>
            </section>

            <section class="purchase-info">
                <div class="delivery-info">
                    <p>
                        <span class="gratis">Chegará grátis amanhã</span><br />Comprando
                        dentro das próximas 16 h 28 min
                    </p>
                    <p>
                        <span class="compra">Frete Grátis</span><br />Comprando dentro das
                        próximas 16 h 28 min
                    </p>
                    <p>
                        <span class="devol">Devolução</span><br />Você tem 30 dias a
                        partir da data de recebimento.
                    </p>
                </div>

                <div class="stock-info">
                    <p><strong>Estoque disponível</strong></p>
                    <p>Quantidade: 1 (200 Disponível)</p>
                </div>

                <div class="purchase-buttons">
                    <button class="buy-now" id="buy-now" onclick="window.location.href = 'payment-methods.php'">Comprar Agora</button>
                    <button class="add-to-cart" data-index="1">Adicionar ao Carrinho</button>
                </div>
            </section>
        </div>

        <div class="ofertas">
            <section class="other-offers">
                <h2>Outras ofertas</h2>
                <div class="offers-container">
                    <div class="offer-item">
                        <div class="card">
                            <img src="../images/produtos/utensilios/faqueiro.png" class="card-img-top"
                                alt="Suporte de faqueiros" />
                            <div class="card-body">
                                <h5 class="card-title">Suporte de faqueiros</h5>
                                <p class="card-text">R$ 89,70 OFF</p>
                                <p class="sub-card-text">R$ 78,90</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="../images/produtos/decoracoes/Vaso.png" class="card-img-top"
                                alt="Vasos pintados" />
                            <div class="card-body">
                                <h5 class="card-title">Vasos pintados</h5>
                                <p class="card-text">R$ 199,90 OFF</p>
                                <p class="sub-card-text">R$ 99,99</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="../images/produtos/decoracoes/Quadro.png" class="card-img-top"
                                alt="Porta-retratos" />
                            <div class="card-body">
                                <h5 class="card-title">Porta-retratos</h5>
                                <p class="card-text">R$ 57,90 OFF</p>
                                <p class="sub-card-text">R$ 29,90</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="../images/produtos/utensilios/Colher.png" class="card-img-top"
                                alt="Colher de pau" />
                            <div class="card-body">
                                <h5 class="card-title">Colher de pau</h5>
                                <p class="card-text">R$ 25,99 OFF</p>
                                <p class="sub-card-text">R$ 15,99</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="descricao-produto">
                <h2>Sobre o produto</h2>
                <p>Bolsa de palha – estilo e versatilidade em cada detalhe</p>
                <p>
                    Com design artesanal e acabamento sofisticado, a bolsa de palha é a
                    escolha perfeita para quem busca leveza, charme e funcionalidade.
                    Ideal para compor looks casuais ou praianos, ela une beleza natural
                    com praticidade no uso diário.
                </p>
                <p>
                    Leve, espaçosa e resistente, conta com alças confortáveis e um
                    interior bem distribuído, sendo ideal para levar seus itens essenciais
                    com elegância. Um acessório que nunca sai de moda e combina com
                    diversas ocasiões, do passeio ao ar livre até eventos descontraídos.
                </p>
            </section>

            <section class="produto-reviews">
                <div class="reviews-container">
                    <div class="avaliações">
                        <h2>Avaliações</h2>
                        <p>4.8 <span><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-half"></i></span></p>
                        <p>123 avaliações</p>
                    </div>
                    <div class="reviews-destaque">
                        <p class="opn">Opinião em destaque</p>
                        <div class="review">
                            <p>
                                <picture>
                                    <img src="../images/icones/carla.png" alt="Foto de Carla" />
                                </picture>
                                <strong class="Foto">Carla</strong>
                            </p>
                            <p>
                                Ela é linda, o tamanho é ideal, o material de qualidade, e o
                                preço muito bom. Amei a cor. 👜
                            </p>
                        </div>
                        <div class="review">
                            <p>
                                <picture>
                                    <img src="../images/icones/renata.png" alt="Foto de Renata" />
                                </picture>
                                <strong class="Foto">Renata</strong>
                            </p>
                            <p>
                                Adorei a bolsa. Bem divertida. Cabe muita coisa. A cor também
                                gostei. Pode comprar sem medo.
                            </p>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <div class="Produtos-similares">
            <h1>Outros produtos similares</h1>
            <div class="carrossel-container">
                <button class="carrossel-arrow left">←</button>
                <div class="carrossel-cards">
                    <div class="card">
                        <img src="../images/produtos/utensilios/faqueiro.png" alt="Suporte de faqueiros" />
                        <h5>Suporte de faqueiros</h5>
                        <p class="card-text">R$ 87,90 OFF</p>
                        <p class="sub-card-text">R$ 78,90</p>
                    </div>
                    <div class="card">
                        <img src="../images/produtos/decoracoes/Vaso.png" alt="Vasos pintados" />
                        <h5>Vasos pintados</h5>
                        <p class="card-text">R$ 199,90 OFF</p>
                        <p class="sub-card-text">R$ 99,99</p>
                    </div>
                    <div class="card">
                        <img src="../images/produtos/decoracoes/Quadro.png" alt="Porta-retratos" />
                        <h5>Porta-retratos</h5>
                        <p class="card-text">R$ 57,90 OFF</p>
                        <p class="sub-card-text">R$ 29,90</p>
                    </div>
                    <div class="card">
                        <img src="../images/produtos/utensilios/Colher.png" alt="Colher de pau" />
                        <h5>Colher de pau</h5>
                        <p class="card-text">R$ 25,99 OFF</p>
                        <p class="sub-card-text">R$ 15,99</p>
                    </div>
                </div>
                <button class="carrossel-arrow right">→</button>
            </div>
            <section class="produtos">
                <div class="card">
                    <img src="../images/produtos/bolsas/bolsa-palha-clara.png" class="card-img-top"
                        alt="Bolsa De Palha Praia Feminina Bolsa Ombro Grande" />
                    <div class="card-body">
                        <h5>Bolsa De Palha Praia Feminina</h5>
                        <p class="sub-card-text">R$ 95,99</p>
                    </div>
                </div>
                <div class="card">
                    <img src="../images/produtos/bolsas/bolsa.png" class="card-img-top"
                        alt="Bolsa Praia Linda Palha Feminina Com Zíper + Pigente" />
                    <div class="card-body">
                        <h5>Bolsa Praia Linda Palha Feminina Com Zíper + Pigente</h5>
                        <p class="sub-card-text">R$ 42,99</p>
                    </div>
                </div>
                <div class="card">
                    <img src="../images/produtos/bolsas/bolsa-menor.png" class="card-img-top"
                        alt="Bolsa De Palha Feminina Clutch" />
                    <div class="card-body">
                        <h5>Bolsa De Palha Feminina Clutch </h5>
                        <p class="sub-card-text">R$ 46,99</p>
                    </div>
                </div>
                <div class="card">
                    <img src="../images/produtos/bolsas/bolsa-maior.png" class="card-img-top"
                        alt="Bolsa Feminina De Palha Meia Lua Grande" />
                    <div class="card-body">
                        <h5 class="card-title">Bolsa Feminina De Palha Meia Lua Grande</h5>
                        <p class="sub-card-text">R$ 78,99</p>
                    </div>
                </div>
            </section>
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