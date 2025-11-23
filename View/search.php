<?php
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Category.php';

use Model\Product;
use Model\Category;

$productModel = new Product();
$categoryModel = new Category();

$categorias = $categoryModel->getAllCategories();
$categoryMap = [];
if (!empty($categorias)) {
  foreach ($categorias as $c) {
    $categoryMap[(int) $c['id_category']] = $c['name'];
  }
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
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesquisa - Handify</title>
  <link rel="stylesheet" href="../css/search.css" />
  <link rel="stylesheet" href="../css/global.css">
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body style="background-color: #faecce">
  <header>
    <nav>
      <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />

      <!-- Funcionalidade de busca -->
      <div class="search-bar">
        <form method="GET">
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
        <li><a href="../index.php">Home</a></li>
        <li><a href="#footer">Contato</a></li>
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
      <button id="cart"><i class="bi bi-cart"></i></button>
      <button id="list"><i class="bi bi-list"></i></button>
      <div id="popup-menu">
        <ul class="popup-list">
          <li style="display: none;">
            <a href="sign-up.php" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
          </li>
          <li class="user-logged-mobile" style="display: none;">
            <i class="bi bi-person"></i> placeholder
          </li>
          <li><a href="about.php">Sobre</a></li>
          <li><a href="#footer">Contato</a></li>
          <li><a href="../../index.php">Home</a></li>
        </ul>
      </div>
    </nav>

    <div class="menu-bar">
      <div>
        <button>Categorias</button>
        <button>Ofertas</button>
        <button id="vender-btn" onclick="window.location.href = './sell.php'">Vender</button>
        <button>Histórico</button>
      </div>
      <button class="cart"><i class="bi bi-cart"></i></button>
    </div>
  </header>

  <div id="carouselExample" class="carousel slide">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <img src="../images/fundos/ofertabannernobkg1.png" class="d-block mx-auto" alt="" />
      </div>
      <!-- <div class="carousel-item item2">
        <img src="../images/fundos/fretegratisbannernobkg2.png" class="d-block mx-auto" alt="" />
      </div> -->

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

  <main>
    <section class="filtros">
      <ul class="categorias">
        <h2>Categorias</h2>

        <li><button class="categoria-btn active" value="all">Todos</button></li>
        <?php foreach ($categorias as $c): ?>
          <li>
            <button class="categoria-btn"
              value="<?= (int) $c['id_category'] ?>"><?= htmlspecialchars($c['name']) ?></button>
          </li>
        <?php endforeach; ?>

      </ul>

      <ul class="preco">
        <h2>Preço</h2>
        <label><input type="radio" name="price" checked value="none" /> Todos</label>
        <br />
        <label><input type="radio" name="price" value="80" /> Até R$80</label>
        <br />
        <label><input type="radio" name="price" value="150" /> R$80 a R$150</label>
        <br />
        <label><input type="radio" name="price" value="150+" /> Mais de
          R$150</label>
      </ul>
    </section>

    <section class="produtos">
      <h2 id="texto-produtos">Produtos encontrados</h2>
      <?php $serverRendered = !empty($products); ?>
      <div id="cards-inside" <?php if ($serverRendered)
        echo 'data-server-rendered="1" style="visibility: visible;"'; ?>>

        <!-- CARD TEMPLATE -->
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $p): ?>
            <?php
            $name = htmlspecialchars($p['name']);
            $rawImage = isset($p['image']) ? $p['image'] : '';
            // normaliza o caminho da imagem: se já contém 'uploads/' usamos ../ + campo; senão assumimos uploads/products/
            if (!empty($rawImage) && strpos($rawImage, 'uploads/') === 0) {
              $imagePath = '../' . $rawImage;
            } elseif (!empty($rawImage)) {
              $imagePath = '../uploads/products/' . htmlspecialchars($rawImage);
            } else {
              $imagePath = '../images/icones/placeholder.png';
            }
            $price = number_format((float) $p['price'], 2, ',', '.');

            $catId = isset($p['id_category_fk']) ? (int) $p['id_category_fk'] : 0;
            $categoryName = isset($categoryMap[$catId]) ? htmlspecialchars($categoryMap[$catId]) : 'Sem categoria';
            ?>
            <div class="fundo" data-category-id="<?= $catId ?>" data-price="<?= htmlspecialchars((float) $p['price']) ?>">
              <div class="card" style="
                background-color: #4b3a35;
                width: 15rem;
                margin: 0;
                border-radius: 1.5rem;
                border: #3c2924 solid;
              ">
                <picture>
                  <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= $name ?>"
                    onerror="this.onerror=null; this.src='../images/icones/placeholder.png';" />
                </picture>
                <div class="card-body" style="padding: 0.1rem">
                  <h5 class="card-title"><?= $name ?></h5>
                  <p class="categoria"><?= $categoryName ?></p>
                  <!-- <h5 class="avaliacoes">
                    4.6
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    (81)
                  </h5> -->
                  <div class="precos">
                    <p class="sub-card-text">R$ <?= $price ?></p>
                  </div>
                  <button onclick="window.location.href='product.php?id=<?= (int) $p['id_product'] ?>'">Ver mais</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Nenhum produto encontrado.</p>
        <?php endif; ?>
        <!-- CARD TEMPLATE -->

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
    new window.VLibras.Widget("https://vlibras.gov.br/app");
  </script>

  <script type="module" src="../js/search.js"></script>
  <script type="module" src="../js/search/search-in-page.js"></script>
  <script src="../js/search/filters.js"></script>
  <script src="../js/mobile-pop-up.js"></script>
  <script src="../js/logged-in.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>