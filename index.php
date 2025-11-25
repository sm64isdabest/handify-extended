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

require_once __DIR__ . '/Model/Product.php';
require_once __DIR__ . '/Model/Category.php';
use Model\Product;
use Model\Category;

$productModel = new Product();
$products = $productModel->getAllProducts();
$categoryModel = new Category();
$allProducts = is_array($products) ? $products : [];
$allCategories = $categoryModel->getAllCategories() ?: [];

function getProductsByCategoryName(array $products, array $categories, string $searchName, int $limit = 5): array
{
  $searchName = mb_strtolower(trim($searchName));
  if ($searchName === '')
    return [];

  $matchedIds = [];
  foreach ($categories as $c) {
    $cname = mb_strtolower($c['name'] ?? '');
    if ($cname !== '' && mb_stripos($cname, $searchName) !== false) {
      $matchedIds[] = (int) ($c['id_category'] ?? 0);
    }
  }

  // filtra produtos por id_category_fk
  $out = [];
  foreach ($products as $p) {
    $catId = isset($p['id_category_fk']) ? (int) $p['id_category_fk'] : 0;
    if (in_array($catId, $matchedIds, true)) {
      $out[] = $p;
      if (count($out) >= $limit)
        break;
    }
  }
  return $out;
}

// BUSCA
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($searchTerm !== '') {
  $products = $productModel->searchByName($searchTerm);
} else {
  $products = $productModel->getAllProducts();
}

if ($products === false) {
  $products = [];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Handify - Página Principal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/global.css">
  <script src="js/theme-loader.js"></script>
  <link rel="stylesheet" href="css/track-pop-up.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
  <header>
    <nav>
      <img src="images/logo-handify.png" alt="Handify Logo" class="logo" />

      <!-- Funcionalidade de busca -->
      <div class="search-bar">
        <form method="GET" action="View/search.php">
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
        <li><a href="index.php" class="scroll-link">Home</a></li>
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
            <button class="menu-item" onclick="window.location.href='View/profile.php'">Meu Perfil</button>
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
        <?php if (
          (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'store') ||
          (isset($_COOKIE['userType']) && $_COOKIE['userType'] === 'store')
        ): ?>
          <a href="View/sell.php" class="btn">Vender</a>
        <?php endif; ?>
        <button id="rastrear-btn" onclick="window.location.href='View/profile.php'">Rastrear</button>
      </div>
      <button class="cart"><i class="bi bi-cart"></i></button>
    </div>
  </header>

  <div id="carouselExample" class="carousel slide">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/fundos/ofertabannernobkg1.png" class="d-block mx-auto" alt="" />
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <main id="main">
    <section id="produto" class="rounded-4 card produtos Cozinha">
      <h3 class="produtos-paraC">Produtos para cozinha</h3>
      <div class="produtos-lista">

        <?php
        $prodCozinha = getProductsByCategoryName($allProducts, $allCategories, 'Cozinha', 5);
        for ($i = 0; $i < 5; $i++):
          $prod = $prodCozinha[$i] ?? null;

          $rawImage = isset($prod['image']) ? $prod['image'] : '';
          // normaliza o caminho da imagem: se já contém 'uploads/' usamos ../ + campo; senão assumimos uploads/products/
          if (!empty($rawImage) && strpos($rawImage, 'uploads/') === 0) {
            $imagePath = '' . $rawImage;
          } elseif (!empty($rawImage)) {
            $imagePath = 'uploads/products/' . htmlspecialchars($rawImage);
          } else {
            $imagePath = 'images/icones/placeholder.png';
          }
          ?>
          <div class="produto">
            <?php if ($prod): ?>
              <a class="produto-link" href="View/product.php?id=<?= urlencode($prod['id_product'] ?? '') ?>">
            <?php endif; ?>
            <picture>
              <img src="<?= $imagePath ?>" class="card-img-top"
                alt="<?= $prod ? htmlspecialchars($prod['name']) : '' ?>" />
            </picture>
            <span class="produto-nome"><?= $prod ? htmlspecialchars($prod['name']) : '' ?></span>
            <div class="produto-preco-bloco">
              <span
                class="produto-preco"><?= $prod ? 'R$ ' . number_format((float) $prod['price'], 2, ',', '.') : '' ?></span>
            </div>
            <?php if ($prod): ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endfor; ?>

      </div>
    </section>

    <section class="rounded-4 produtos card Decorativos">
      <h3 class="produtos-decorativos">Produtos decorativos</h3>
      <div class="produtos-lista">

        <?php
        $prodCozinha = getProductsByCategoryName($allProducts, $allCategories, 'Decoração', 5);
        for ($i = 0; $i < 5; $i++):
          $prod = $prodCozinha[$i] ?? null;

          $rawImage = isset($prod['image']) ? $prod['image'] : '';
          // normaliza o caminho da imagem: se já contém 'uploads/' usamos ../ + campo; senão assumimos uploads/products/
          if (!empty($rawImage) && strpos($rawImage, 'uploads/') === 0) {
            $imagePath = '' . $rawImage;
          } elseif (!empty($rawImage)) {
            $imagePath = 'uploads/products/' . htmlspecialchars($rawImage);
          } else {
            $imagePath = 'images/icones/placeholder.png';
          }
          ?>
          <div class="produto">
            <?php if ($prod): ?>
              <a class="produto-link" href="View/product.php?id=<?= urlencode($prod['id_product'] ?? '') ?>">
            <?php endif; ?>
            <picture>
              <img src="<?= $imagePath ?>" class="card-img-top"
                alt="<?= $prod ? htmlspecialchars($prod['name']) : '' ?>" />
            </picture>
            <span class="produto-nome"><?= $prod ? htmlspecialchars($prod['name']) : '' ?></span>
            <div class="produto-preco-bloco">
              <span
                class="produto-preco"><?= $prod ? 'R$ ' . number_format((float) $prod['price'], 2, ',', '.') : '' ?></span>
            </div>
            <?php if ($prod): ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endfor; ?>

      </div>
    </section>

    <section class="rounded-4 card produtos Moveis">
      <h3 class="moveis">Móveis</h3>
      <div class="produtos-lista">

        <?php
        $prodCozinha = getProductsByCategoryName($allProducts, $allCategories, 'Móveis', 5);
        for ($i = 0; $i < 5; $i++):
          $prod = $prodCozinha[$i] ?? null;

          $rawImage = isset($prod['image']) ? $prod['image'] : '';
          // normaliza o caminho da imagem: se já contém 'uploads/' usamos ../ + campo; senão assumimos uploads/products/
          if (!empty($rawImage) && strpos($rawImage, 'uploads/') === 0) {
            $imagePath = '' . $rawImage;
          } elseif (!empty($rawImage)) {
            $imagePath = 'uploads/products/' . htmlspecialchars($rawImage);
          } else {
            $imagePath = 'images/icones/placeholder.png';
          }
          ?>
          <div class="produto">
            <?php if ($prod): ?>
              <a class="produto-link" href="View/product.php?id=<?= urlencode($prod['id_product'] ?? '') ?>">
            <?php endif; ?>
            <picture>
              <img src="<?= $imagePath ?>" class="card-img-top"
                alt="<?= $prod ? htmlspecialchars($prod['name']) : '' ?>" />
            </picture>
            <span class="produto-nome"><?= $prod ? htmlspecialchars($prod['name']) : '' ?></span>
            <div class="produto-preco-bloco">
              <span
                class="produto-preco"><?= $prod ? 'R$ ' . number_format((float) $prod['price'], 2, ',', '.') : '' ?></span>
            </div>
            <?php if ($prod): ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endfor; ?>

      </div>
    </section>

    <section class="ofertas">
      <div class="rounded-4 outras-ofertas card">
        <div class="outras-ofertas-header">
          <span class="outras-ofertas-titulo">Explore Mais</span>
        </div>
        <div class="outras-ofertas-lista">
          <?php
          // seleciona até 4 produtos aleatórios
          $candidates = array_values(array_filter($allProducts));
          if (!empty($candidates)) {
            shuffle($candidates);
            $random = array_slice($candidates, 0, 4);
          } else {
            $random = [];
          }

          foreach ($random as $rp):
            $rawImage = isset($rp['image']) ? $rp['image'] : '';
            if (!empty($rawImage) && strpos($rawImage, 'uploads/') === 0) {
              $imagePath = '' . $rawImage;
            } elseif (!empty($rawImage)) {
              $imagePath = 'uploads/products/' . htmlspecialchars($rawImage);
            } else {
              $imagePath = 'images/icones/placeholder.png';
            }
            ?>
            <div class="outras-produto-aleatorio">
              <?php if (!empty($rp['id_product'])): ?>
                <a class="produto-link" href="View/product.php?id=<?= urlencode($rp['id_product']) ?>">
              <?php endif; ?>
              <picture>
                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($rp['name'] ?? '') ?>" />
              </picture>
              <span class="spantext"><?= htmlspecialchars($rp['name'] ?? '') ?></span>
              <?php if (!empty($rp['id_product'])): ?>
                </a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <button class="oferta-btn"><a href="View/search.php">Veja mais</a></button>
      </div>
    </section>
  </main>

  <!-- Benefícios -->
  <section class="beneficios">
    <div class="rounded-4 beneficio card">
      <i class="bi bi-shield-check"></i>
      <h4>Segurança</h4>
      <p>
        Este site utiliza protocolos de segurança avançados para garantir a
        proteção de seus dados durante a navegação.
      </p>
    </div>
    <div class="rounded-4 beneficio card">
      <i class="bi bi-patch-check"></i>
      <h4>Confiável</h4>
      <p>
        Pode confiar: aqui tudo é feito com cuidado, segurança e respeito
        por você.
      </p>
    </div>
    <div class="rounded-4 beneficio card rounded">
      <i class="bi bi-truck"></i>
      <h4>Frete grátis</h4>
      <p>
        Do carrinho até a sua casa, com segurança, carinho e frete grátis.
      </p>
    </div>
  </section>

  <!-- Atendimento -->
  <section class="atendimento">
    <div class="rounded-4 atendimento-card card">
      <h4>Compre pelo telefone</h4>
      <p>
        Atendimento das 8h às 19h de segunda a sexta. 8h às 14h aos sábados.
      </p>
      <button>(71) 97534-4397</button>
      <button>0800-020-5243</button>
    </div>
    <div class="rounded-4 atendimento-card card">
      <h4>Atendimento ao cliente</h4>
      <p>Das 08h às 19h de segunda a sábado, exceto feriados.</p>
      <button>handifycontato@gmail.com</button>
      <button>0800-020-6639</button>
    </div>
    <div class="rounded-4 atendimento-card card">
      <h4>Compre pelo Whatsapp</h4>
      <p>
        Para todo o território nacional. Horário de atendimento sujeito à
        região.
      </p>
      <button><i class="bi bi-whatsapp"></i> (71) 9985-7897</button>
      <button><i class="bi bi-whatsapp"></i> (71) 9535-6332</button>
    </div>
  </section>

  <!-- Formas de pagamento -->
  <section class="pagamento card">
    <h4>Formas de pagamento</h4>
    <div class="pagamento-icones">
      <img src="images/icones/visa-logo.png" alt="Visa" />
      <img src="images/icones/Mastercard.png" alt="Mastercard" />
      <img src="images/icones/Logo-ELO.png" alt="Elo" />
      <img src="images/icones/Logo-PIX.png" alt="Pix" />
    </div>
  </section>

  <footer id="footer">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
  <script type="module" src="js/search.js"></script>
  <script type="module" src="js/logged-in.js"></script>
  <script type="module" src="js/index/go-to-product.js"></script>
</body>

</html>