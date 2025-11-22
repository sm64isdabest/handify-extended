<?php

session_start();
require_once __DIR__ . '/../Model/Store.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Category.php';
require_once __DIR__ . '/../Controller/ProductController.php';

use Model\Product;
use Controller\ProductController;
use Model\Store;
use Model\Category;

$productModel = new Product();
$storeModel = new Store();
$categoryModel = new Category();
$productController = new ProductController($productModel);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $price = $_POST['price'] ?? '';
    $id_category = $_POST['id_category'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['image']['tmp_name'];
        $origName = basename($_FILES['image']['name']);
        $ext = pathinfo($origName, PATHINFO_EXTENSION);
        $safeName = uniqid('prod_', true) . '.' . $ext;
        $destPath = $uploadDir . $safeName;

        if (move_uploaded_file($tmpName, $destPath)) {
            $imagePath = 'uploads/products/' . $safeName;

            $free_shipping = isset($_POST['free_shipping']) ? 1 : 0;

            $id_user_logado = $_SESSION['id'] ?? null;
            if (!$id_user_logado) {
                $message = 'Erro: usuário não autenticado. Faça login com a conta da empresa.';
            } else {
                $storeData = $storeModel->getStoreByUserId($id_user_logado);
                if (empty($storeData) || !isset($storeData['id_store'])) {
                    $message = 'Erro: loja não encontrada para este usuário. Cadastre ou associe a loja à conta.';
                } else {
                    $id_store_fk = (int) $storeData['id_store'];

                    $result = $productController->registerProduct(
                        $name,
                        $description,
                        $imagePath,
                        (int)$stock,
                        (string)$price,
                        $free_shipping,
                        $id_store_fk,
                        (int)$id_category
                    );

                    $message = $result ? 'Produto cadastrado com sucesso.' : 'Erro ao cadastrar produto.';
                }
            }
        } else {
            $message = 'Erro ao mover arquivo enviado.';
        }
    } else {
        $message = 'Imagem obrigatória ou falha no upload.';
    }
}

?>

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
                <li class="user-logged" style="display: none; position: relative;">
                    <i class="bi bi-person profile-btn" style="cursor: pointer; font-size: 1.5rem;"></i>
                    <span class="user-name"></span>
                    <div class="menu-popup">
                        <p class="user-name-popup"></p>
                        <button class="menu-item logout-btn">Sair</button>
                    </div>
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
        <!-- Form -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="container-produto">
                <div class="sidebar">
                    <button class="btn-back"> <i class="bi bi-arrow-left"> </i> </button>
                </div>

                <div class="imagem-produto">
                    <!-- trocar o botão por input file -->
                    <input type="file" id="image" name="image" accept="image/*" required />
                </div>
                <div class="info-produto">
                    <div class="nome-produto">
                        <input type="text" id="name" name="name" autocomplete="off" placeholder="Nome do produto"
                            required />
                    </div>
                    <div class="valor-produto">
                        <input type="number" id="price" name="price" placeholder="Preço" step="0.01" min="0" required />
                    </div>
                </div>
                <div class="destaque-produto">
                    <div class="titulo-destaque">Informações de destaque</div>
                    <div class="botoes-destaque">
                        <input id="free_shipping" name="free_shipping" type="checkbox">Frete grátis</input>
                        <!-- <p class="free-shipping">Frete grátis</p> -->
                    </div>
                    <div class="quantidade-produto">
                        <input type="number" id="stock" name="stock" placeholder="Quantidade" min="0" required />
                    </div>

                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" name="id_category">
                            <?php
                            $categorias = $categoryModel->getAllCategories();

                            foreach ($categorias as $c):
                                ?>
                                <option value="<?= $c['id_category'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="floatingSelect">Categoria</label>
                    </div>

                    <button class="comprar-agora" disabled>Comprar Agora</button>
                    <button class="adicionar-carrinho" disabled>Adicionar ao Carrinho</button>
                </div>
            </div>

            <div class="quadro-descricao">
                <textarea name="description" id="description" placeholder="Descrição do produto..." required></textarea>
            </div>

            <button type="submit" class="submit">Vender</button>
        </form>
        <!-- Form -->
        <?php if (!empty($message)): ?>
            <?php $isSuccess = ($message === 'Produto cadastrado com sucesso.'); ?>
            <div id="flash-message" role="status" aria-live="polite" style="
        position: fixed;
        top: 1rem;
        left: 50%;
        transform: translateX(-50%);
        background: <?= $isSuccess ? '#28a745' : '#dc3545' ?>;
        color: #fff;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.30);
        z-index: 9999;
        max-width: 90%;
        min-width: 240px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        ">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </div>
            <script>
                (function () {
                    const el = document.getElementById('flash-message');
                    if (!el) return;
                    // auto hide after 5s
                    setTimeout(() => {
                        el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        el.style.opacity = '0';
                        el.style.transform = 'translateX(-50%) translateY(-10px)';
                        setTimeout(() => el.remove(), 420);
                    }, 5000);
                })();
            </script>
        <?php endif; ?>
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