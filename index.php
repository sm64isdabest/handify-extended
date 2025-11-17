<?php
session_start();
$userName = isset($_COOKIE['userName']) ? urldecode($_COOKIE['userName']) : '';
$userType = isset($_COOKIE['userType']) ? $_COOKIE['userType'] : '';

require_once __DIR__ . '/Model/Product.php';
require_once __DIR__ . '/Model/Connection.php';
use Model\Product;
use Model\Connection;

$products = [];
$dbError = null;

try {
    $db = Connection::getInstance();
    $stmt = $db->prepare("
        SELECT id_product AS id, name, image AS img, price, category
        FROM product
        ORDER BY category, id_product DESC
        LIMIT 20
    ");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $products = [];
    $dbError = $e->getMessage();
}

// Endpoint JSON para frontend
if (isset($_GET['action']) && $_GET['action'] === 'get-products') {
    header('Content-Type: application/json; charset=UTF-8');
    if ($dbError) {
        http_response_code(500);
        echo json_encode(['error' => 'DB_ERROR', 'message' => $dbError]);
    } else {
        echo json_encode(['products' => $products]);
    }
    exit;
}

function normalize_img_path($src) {
    if (empty($src)) return '';
    $src = trim($src);
    // converte barras invertidas em normais (Windows para URL)
    $src = str_replace('\\', '/', $src);
    // remove ../ ou ./
    $src = preg_replace('#^(\.\./)+#', '', $src);
    $src = preg_replace('#^(\./)+#', '', $src);
    // se for URL absoluta, retorna
    if (preg_match('#^https?://#i', $src)) return $src;
    // se começar com '/', usa como caminho absoluto
    if (strpos($src, '/') === 0) return $src;
    // base da aplicação (ex: /handify-extended)
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    if ($base === '' || $base === '/') $base = '';
    return $base . '/' . ltrim($src, '/');
}

function normalize_category_key($cat) {
    if (empty($cat)) return '';
    $cat = trim((string)$cat);
    // remove acentos
    $cat = iconv('UTF-8', 'ASCII//TRANSLIT', $cat);
    $cat = strtolower($cat);
    // keep only letters (remove espaços e sinais)
    $cat = preg_replace('/[^a-z0-9]/', '', $cat);
    return $cat;
}

function getProductsForCategory(array $products, string $categoryName, int $limit = 5): array {
    $key = normalize_category_key($categoryName);
    $matched = array_filter($products, function($p) use ($key) {
        return normalize_category_key($p['category'] ?? '') === $key;
    });

    $matched = array_values($matched); // reindex
    if (count($matched) >= $limit) {
        return array_slice($matched, 0, $limit);
    }

    // completar com outros produtos que não estão em $matched (sem duplicar)
    $result = $matched;
    $idsTaken = array_column($result, 'id');
    foreach ($products as $p) {
        if (count($result) >= $limit) break;
        if (in_array($p['id'], $idsTaken, true)) continue;
        $result[] = $p;
        $idsTaken[] = $p['id'];
    }
    return $result;
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
  <link rel="stylesheet" href="css/track-pop-up.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body style="background-color: #FAECCE;">
  <header>
    <nav>
      <img src="images/logo-handify.png" alt="Handify Logo" class="logo" />
      <div class="search-bar">
        <input type="text" id="searchInput" autocomplete="off" placeholder="Buscar produtos..." />
        <i id="searchButton" class="bi bi-search"></i>
        <ul id="autocomplete-list" class="autocomplete-items"></ul>
      </div>
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
            <button class="menu-item logout-btn">Sair</button>
          </div>
        </li>
      </ul>
      
      <button id="cart"><i class="bi bi-cart"></i></button>
      <button id="list"><i class="bi bi-list"></i></button>
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
        <button id="rastrear-btn">Rastrear</button>
      </div>
      <button class="cart"><i class="bi bi-cart"></i></button>
    </div>
  </header>

  <!-- Pop-up Rastrear -->
  <div id="rastrear-popup" style="display: none;">
    <div class="container-principal">
      <header class="cabecalho">
        <img src="images/logo-handify.png" alt="Logo Handify" class="logo" />
        <div class="linha-vertical"></div>
        <h2>Rastrear</h2>
        <button class="retorn" id="close-rastrear"><i class="bi bi-x"></i></button>
      </header>
      <main>
        <section class="info-produto">
          <button id="prev-product" class="nav-arrow"><i class="bi bi-arrow-left-circle"></i></button>
          <img id="imagem-produto" class="imagem-produto" src="" alt="Imagem do produto" />
          <button id="next-product" class="nav-arrow"><i class="bi bi-arrow-right-circle"></i></button>
          <div class="detalhes-produto">
            <h3 id="nome-produto">Nome do Produto</h3>
            <p id="descricao-produto" class="descricao"></p>
          </div>
        </section>
      </main>
      <div class="cabecalho-rastreio">
        <span class="rotulo-numero-pedido">Código de rastreio:</span>
        <span id="numeroPedido" class="numeroPedido"></span>
        <button class="botao-copiar" onclick="copyOrderNumber()">Copiar</button>
      </div>
    </div>
  </div>

  <script>
    // Evento para abrir o pop-up rastrear
    document.getElementById('rastrear-btn').addEventListener('click', function () {
      document.getElementById('rastrear-popup').style.display = 'flex';
    });

    // Evento para fechar o pop-up rastrear
    document.getElementById('close-rastrear').addEventListener('click', function () {
      document.getElementById('rastrear-popup').style.display = 'none';
    });
  </script>

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
    <section class="ofertas">
      <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="rounded-4 55 oferta-dia card">
          <div class="oferta-header">
            <span class="oferta-titulo">Oferta do dia</span>
          </div>
          <span class="oferta-descricao"></span>
          <div class="oferta-conteudo">
            <div class="oferta-info">
              <span class="oferta-desconto"></span>
              <span class="oferta-preco-antigo"></span>
              <span class="oferta-preco-novo"></span>
              <button class="oferta-btn">Comprar</button>
            </div>
          </div>
        </div>
        <div class="rounded-4 oferta-semanal card">
          <div class="oferta-header">
            <span class="oferta-titulo">Oferta Semanal</span>
          </div>
          <span class="oferta-descricao"></span>
          <div class="oferta-conteudo">
            <div class="oferta-info">
              <span class="oferta-desconto"></span>
              <span class="oferta-preco-antigo"></span>
              <span class="oferta-preco-novo"></span>
              <button class="oferta-btn">Comprar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="rounded-4 outras-ofertas card">
        <div class="outras-ofertas-header">
          <span class="outras-ofertas-titulo">Explore Mais</span>
        </div>
        <div class="outras-ofertas-lista">
          <div class="outras-produto-vaso">
            <span class="spantext"></span>
          </div>
          <div class="outras-produto-retrato">
            <span class="spantext"></span>
          </div>
          <div class="outras-produto-panela">
            <span class="spantext"></span>
          </div>
          <div class="outras-produto-colher">
            <span class="spantext"></span>
          </div>
        </div>
        <button class="oferta-btn"><a href="View/search.php">Veja mais</a></button>
      </div>
    </section>


    <section id="produto" class="rounded-4 card produtos Cozinha">
      <h3 class="produtos-paraC">Produtos para cozinha</h3>
      <div class="produtos-lista">
        <?php
        // usa a função que preenche até 5 itens por categoria (completa com outros sem duplicar)
        $cozinhaProducts = getProductsForCategory($products, 'Cozinha', 5);
        if (empty($cozinhaProducts)) {
            echo '<p style="color: #666; padding: 20px;">Nenhum produto disponível no momento.</p>';
        } else {
            foreach ($cozinhaProducts as $p):
                $img = normalize_img_path($p['img'] ?? '');
        ?>
          <div class="produto" data-slug="<?= htmlspecialchars($p['slug'] ?? '') ?>">
            <?php if (!empty($img)): ?>
              <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['name'] ?? '') ?>" style="height:110px;width:auto;object-fit:contain;margin:0 auto 6px;display:block;">
            <?php endif; ?>
            <span class="produto-nome"><?= htmlspecialchars($p['name'] ?? '') ?></span>
            <div class="produto-preco-bloco">
              <div class="produto-preco-desconto-container">
                <?php if (!empty($p['originalPrice'])): ?>
                  <span class="produto-preco-antigo">R$ <?= number_format((float)str_replace(['R$', '.',' '], ['', '.',''], $p['originalPrice']), 2, ',', '.') ?></span>
                <?php endif; ?>
                <?php if (!empty($p['discount'])): ?>
                  <span class="produto-desconto"><?= htmlspecialchars($p['discount']) ?>%</span>
                <?php endif; ?>
              </div>
              <span class="produto-preco">R$ <?= number_format((float)str_replace(['R$', '.',' '], ['', '.',''], $p['price']), 2, ',', '.') ?></span>
            </div>
          </div>
        <?php
            endforeach;
        }
        ?>
      </div>
    </section>


<section class="rounded-4 produtos card Decorativos">
  <h3 class="produtos-decorativos">Produtos decorativos</h3>
  <div class="produtos-lista">
    <?php
    $decorativosProducts = getProductsForCategory($products, 'Decorativos', 5);
    if (empty($decorativosProducts)) {
        echo '<p style="color: #666; padding: 20px;">Nenhum produto disponível no momento.</p>';
    } else {
        foreach ($decorativosProducts as $p):
            $img = normalize_img_path($p['img'] ?? '');
    ?>
      <div class="produto" data-slug="<?= htmlspecialchars($p['slug'] ?? '') ?>">
        <?php if (!empty($img)): ?>
          <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['name'] ?? '') ?>" style="height:110px;width:auto;object-fit:contain;margin:0 auto 6px;display:block;">
        <?php endif; ?>
        <span class="produto-nome"><?= htmlspecialchars($p['name'] ?? '') ?></span>
        <div class="produto-preco-bloco">
          <div class="produto-preco-desconto-container">
            <?php if (!empty($p['originalPrice'])): ?>
              <span class="produto-preco-antigo">R$ <?= number_format((float)str_replace(['R$', '.',' '], ['', '.',''], $p['originalPrice']), 2, ',', '.') ?></span>
            <?php endif; ?>
            <?php if (!empty($p['discount'])): ?>
              <span class="produto-desconto"><?= htmlspecialchars($p['discount']) ?>%</span>
            <?php endif; ?>
          </div>
          <span class="produto-preco">R$ <?= number_format((float)str_replace(['R$', '.',' '], ['', '.',''], $p['price']), 2, ',', '.') ?></span>
        </div>
      </div>
    <?php
        endforeach;
    }
    ?>
  </div>
</section>


<section class="rounded-4 card produtos Moveis">
  <h3 class="moveis">Móveis</h3>
  <div class="produtos-lista">
    <?php
    $moveisProducts = getProductsForCategory($products, 'Móveis', 4);
    if (empty($moveisProducts)) {
        echo '<p style="color: #666; padding: 20px;">Nenhum produto disponível no momento.</p>';
    } else {
        foreach ($moveisProducts as $p):
            // normaliza e resolve caminho web/local
            $imgPath = normalize_img_path($p['img'] ?? '');
            $webImg = $imgPath ?: 'images/placeholder-no-image.png';
            // tenta transformar em caminho físico para ver se o arquivo existe
            $localCandidate = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imgPath, '/');
            if (!empty($imgPath) && file_exists($localCandidate)) {
                $webImg = $imgPath;
            } else {
                $webImg = 'images/placeholder-no-image.png';
            }
    ?>
      <div class="produto" data-slug="<?= htmlspecialchars($p['slug'] ?? '') ?>">
        <?php if (!empty($webImg)): ?>
          <img src="<?= htmlspecialchars($webImg) ?>" alt="<?= htmlspecialchars($p['name'] ?? 'Produto') ?>" style="height:110px;width:auto;object-fit:contain;margin:0 auto 6px;display:block;" loading="lazy">
        <?php endif; ?>
        <span class="produto-nome"><?= htmlspecialchars($p['name'] ?? '') ?></span>
        <div class="produto-preco-bloco">
          <div class="produto-preco-desconto-container">
            <?php if (!empty($p['originalPrice'])): ?>
              <span class="produto-preco-antigo">R$ <?= number_format((float)str_replace(['R$', '.',' '], ['', '.',''], $p['originalPrice']), 2, ',', '.') ?></span>
            <?php endif; ?>
            <?php if (!empty($p['discount'])): ?>
              <span class="produto-desconto"><?= htmlspecialchars($p['discount']) ?>%</span>
            <?php endif; ?>
          </div>
          <span class="produto-preco">R$ <?= number_format((float)str_replace(['R$', '.',' '], ['', '.',''], $p['price']), 2, ',', '.') ?></span>
        </div>
      </div>
    <?php
        endforeach;
    }
    ?>
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
      <img src="images/icones/Logo-BOLETO.png" alt="Boleto" />
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
  <script type="module" src="js/database.js"></script>
  <script type="module" src="js/logged-in.js"></script>
  <script type="module" src="js/index/track-pop-up.js"></script>
  <script type="module" src="js/index/go-to-product.js"></script>
</body>

</html>