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

require_once __DIR__ . '/partials/interface_produto.php';
require_once __DIR__ . '../../Model/Product.php';
use Model\Product;

$productModel = new Product();
$products = $productModel->getAllProducts();

if (!isset($product) || empty($product)) {
    header('Location: index.php');
    exit;
}

$otherProducts = array_filter($products, function ($p) use ($product) {
    return $p['id_product'] !== $product['id_product'];
});
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produto - Handify</title>
    <link rel="stylesheet" href="../css/product.css" />
    <link rel="stylesheet" href="../css/global.css" />
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body>
    <header>
        <nav>
            <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
            <div class="search-bar">
                <input type="text" id="searchInput" autocomplete="off" placeholder="Buscar produtos..." />
                <i id="searchButton" class="bi bi-search"></i>
                <ul id="autocomplete-list" class="autocomplete-items"></ul>
            </div>
            <ul>
                <li><a href="../index.php" class="scroll-link">Home</a></li>
                <li><a href="#footer">Contato</a></li>
                <li><a href="View/about.php">Sobre</a></li>
                <li>
                    <a href="View/login.php" class="entrar"><i class="bi bi-person"></i>Entrar</a>
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
                    <li><a href="pages/about.php">Sobre</a></li>
                    <li><a href="#footer">Contato</a></li>
                    <li><a href="index.php" class="scroll-link">Home</a></li>
                </ul>
            </div>
        </nav>
        <div class="menu-bar">
            <div>
                <li style="display: none;">
                    <a href="View/login.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
                </li>
                <a href="View/search.php" class="btn">Categorias</a>
                <a href="#main" class="scroll-link btn">Ofertas</a>
                <?php if ((isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'store') || (isset($_COOKIE['userType']) && $_COOKIE['userType'] === 'store')): ?>
                    <a href="View/sell.php" class="btn">Vender</a>
                <?php endif; ?>
                <button id="rastrear-btn">Rastrear</button>
            </div>
            <button class="cart"><i class="bi bi-cart"></i></button>
        </div>
    </header>

    <main>
        <div class="product-page">
            <section class="product-gallery">
                <div class="main-image">
                    <img src="../uploads/products/<?php echo htmlspecialchars(basename($product['image'])); ?>"
                        alt="<?php echo htmlspecialchars($product['name'] ?? 'Imagem do produto'); ?>" />
                    <h2 class="text_tablet">Estoque disponível</h2>
                    <p class="sub_text_tablet">Quantidade: <?php echo htmlspecialchars($stock); ?>
                        (<?php echo htmlspecialchars($stock); ?> disponíveis)</p>
                </div>
            </section>

            <section class="product-details">
                <div class="avaliar">
                    <button class="sair"><i class="bi bi-arrow-left"></i></button> 4.8<span><i
                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                            class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></span>
                </div>
                <h1><?php echo htmlspecialchars($product['name'] ?? 'Produto não encontrado'); ?></h1>
                <p class="price">
                    <span class="old-price"><?php echo htmlspecialchars($oldPriceFormatted); ?></span>
                    <span class="current-price"><?php echo htmlspecialchars($priceFormatted); ?></span>
                </p>
                <p class="installments">em <?php echo $installments; ?>x
                    <?php echo htmlspecialchars($installmentAmountFormatted); ?>*
                </p>
                <a href="#" class="payment-methods">Ver meios de pagamentos</a>

                <div class="disponiveis_clc">
                    <h3>Estoque disponível</h3>
                    <p>Quantidade: <?php echo htmlspecialchars($stock); ?> (<?php echo htmlspecialchars($stock); ?>
                        Disponível)</p>
                </div>
                <div class="botoes_adc">
                    <button class="add-to-cart" data-product='<?php echo json_encode([
                        "id" => $product['id'] ?? 0,
                        "name" => $product['name'] ?? '',
                        "price" => isset($product['price']) ? number_format((float) $product['price'], 2, '.', '') : 0,
                        "image" => $imagePath
                    ], JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>
                        Adicionar ao Carrinho
                    </button>
                </div>
            </section>

            <section class="purchase-info">
                <div class="delivery-info">
                    <p><span class="gratis">Chegará grátis amanhã</span><br />Comprando dentro das próximas 16 h 28 min
                    </p>
                    <p><span class="compra">Frete Grátis</span><br />Comprando dentro das próximas 16 h 28 min</p>
                    <p><span class="devol">Devolução</span><br />Você tem 30 dias a partir da data de recebimento.</p>
                </div>
                <div class="stock-info">
                    <p><strong>Estoque disponível</strong></p>
                    <p>Quantidade: <?php echo htmlspecialchars($stock); ?> (<?php echo htmlspecialchars($stock); ?>
                        Disponível)</p>
                </div>
                <div class="purchase-buttons">
                    <button class="add-to-cart" data-product='<?= json_encode([
                        "id" => $product['id'] ?? 0,
                        "name" => $product['name'] ?? '',
                        "price" => $product['price'] ?? 0,
                        "image" => !empty($product['image']) ? '../uploads/products/' . $product['image'] : ''
                    ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                        Adicionar ao Carrinho
                    </button>
                </div>
            </section>
        </div>
        <div class="ofertas">
            <section class="other-offers">
                <h2>Outras ofertas</h2>
                <div class="offers-container">
                    <?php foreach ($otherProducts as $other): ?>
                        <div class="produto">
                            <img src="<?= !empty($other['image']) ? '../uploads/products/' . htmlspecialchars($other['image']) : '../images/produtos/utensilios/Colher.png' ?>"
                                alt="<?= htmlspecialchars($other['name']) ?>" />
                            <span class="produto-nome"><?= htmlspecialchars($other['name']) ?></span>
                            <div class="produto-preco-bloco">
                                <div class="produto-preco-desconto-container">
                                    <?php if (!empty($other['old_price'])): ?>
                                        <span class="produto-preco-antigo">R$
                                            <?= number_format($other['old_price'], 2, ',', '.') ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($other['discount'])): ?>
                                        <span class="produto-desconto"><?= $other['discount'] ?>% OFF</span>
                                    <?php endif; ?>
                                </div>
                                <span class="produto-preco">R$ <?= number_format($other['price'], 2, ',', '.') ?></span>
                            </div>
                            <button class="produto-btn">Comprar</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="descricao-produto">
                <h2>Sobre o produto</h2>
                <p><?php echo nl2br(htmlspecialchars($product['description'] ?? 'Descrição não disponível.')); ?></p>
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
                            <p>Ela é linda, o tamanho é ideal, o material de qualidade, e o preço muito bom. Amei a cor.
                                👜</p>
                        </div>
                        <div class="review">
                            <p>
                                <picture>
                                    <img src="../images/icones/renata.png" alt="Foto de Renata" />
                                </picture>
                                <strong class="Foto">Renata</strong>
                            </p>
                            <p>Adorei a bolsa. Bem divertida. Cabe muita coisa. A cor também gostei. Pode comprar sem
                                medo.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div id="cart-popup" class="cart-popup">
        <div class="cart-content">
            <button class="cart-close">&times;</button>
            <div class="cart-header">
                <img src="../images/logo-handify.png" alt="Handify" class="cart-logo" />
                <h3>Meu Carrinho</h3>
            </div>
            <div class="cart-items"></div>
            <div class="cart-footer">
                <p>Total: <span class="cart-total">R$ 0,00</span></p>
                <button class="checkout-btn" onclick="window.location.href = 'payment-methods.php'">Ir para
                    Pagamento</button>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 HANDIFY. Todos os direitos reservados.</p>
        <div class="social-icons">
            <a href="https://web.whatsapp.com/" target="_blank"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.youtube.com/" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="https://x.com/" target="_blank"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/theme-loader.js"></script>
    <script type="module" src="../js/logged-in.js"></script>
    <script>
        const currentProduct = <?php echo json_encode($product); ?>;
    </script>
    <script type="module" src="../js/product/add-to-cart.js"></script>
    <script type="module" src="../js/product/icon-pop-up.js"></script>
    <script type="module" src="../js/search.js"></script>
</body>

</html>