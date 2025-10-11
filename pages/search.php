<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesquisa - Handify</title>
  <link rel="stylesheet" href="../css/search.css" />
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
</head>

<body style="background-color: #faecce">
  <header>
    <nav>
      <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
      <div class="search-bar">
        <input type="text" id="searchInput" autocomplete="off" placeholder="Buscar produtos..." />
        <i id="searchButton" class="bi bi-search"></i>
        <ul id="autocomplete-list" class="autocomplete-items"></ul>
      </div>
      <ul>
        <li><a href="../../index.html">Home</a></li>
        <li><a href="#footer">Contato</a></li>
        <li><a href="about.html">Sobre</a></li>
        <li style="display: none;">
          <a href="sign-up.html" class="entrar"><i class="bi bi-person"></i>Entrar</a>
        </li>
        <li class="user-logged" style="display: none;">
            <i class="bi bi-person"></i> placeholder
          </li>
      </ul>
      <!-- PARA DISPOSITIVOS MÓVEIS -->
      <button id="cart"><i class="bi bi-cart"></i></button>
      <button id="list"><i class="bi bi-list"></i></button>
      <div id="popup-menu">
        <ul class="popup-list">
          <li style="display: none;">
            <a href="sign-up.html" class="entrar-mobile"><i class="bi bi-person"></i>Entrar</a>
          </li>
          <li class="user-logged-mobile" style="display: none;">
            <i class="bi bi-person"></i> placeholder
          </li>
          <li><a href="about.html">Sobre</a></li>
          <li><a href="#footer">Contato</a></li>
          <li><a href="../../index.html">Home</a></li>
        </ul>
      </div>
    </nav>

    <div class="menu-bar">
      <div>
        <button>Categorias</button>
        <button>Ofertas</button>
        <button id="vender-btn" onclick="window.location.href = './sell.html'">Vender</button>
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
        <li><button class="categoria-btn categoria-todas" data-category="">Todas</button></li>
        <li><button class="categoria-btn" data-category="Bolsa">Bolsas</button></li>
        <li><button class="categoria-btn" data-category="Decoracao">Decorações</button></li>
        <li><button class="categoria-btn" data-category="Utensilios">Utensílios Domésticos</button></li>
        <li><button class="categoria-btn" data-category="Moveis">Móveis</button></li>

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
      <div id="cards-inside">
        <!-- CARD TEMPLATE -->
        <div id="cardTemplate" class="fundo">
          <div class="card" style="
                background-color: #4b3a35;
                width: 15rem;
                border-radius: 1.5rem;
                border: #3c2924 solid;
              ">
            <picture>
              <img src="" class="card-img-top" alt="..." />
            </picture>
            <div class="card-body" style="padding: 0.1rem">
              <h5 class="card-title">Placeholder</h5>
              <h5 class="avaliacoes">
                4.6
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
                (81)
              </h5>
              <p class="card-text preco-original">R$ Placeholder</p>
              <div class="precos">
                <p class="sub-card-text">R$ Placeholder</p>
                <p id="oferta">Placeholder% OFF</p>
              </div>
              <button>Ver mais</button>
            </div>
          </div>
        </div>
        <!-- CARD TEMPLATE -->

        <!-- Estrutura se repete aqui -->
      </div>
    </section>
  </main>

  <div class="caracteristicas">
    <div class="card">
      <i class="bi bi-shield-check"></i>
      <div class="card-body">
        <h5 class="card-title">Segurança</h5>
        <p class="card-text">
          Este site utiliza protocolos de segurança avançados para garantir a
          proteção de seus dados durante a navegação.
        </p>
      </div>
    </div>
    <div class="card">
      <i class="bi bi-patch-check"></i>
      <div class="card-body">
        <h5 class="card-title">Confiável</h5>
        <p class="card-text">
          Pode confiar: aqui tudo é feito com cuidado, segurança e respeito
          por você.
        </p>
      </div>
    </div>
    <div class="card">
      <i class="bi bi-truck"></i>
      <div class="card-body">
        <h5 class="card-title">Frete grátis</h5>
        <p class="card-text">
          Do carrinho até a sua casa, com segurança, carinho e frete grátis.
        </p>
      </div>
    </div>
  </div>

  <div class="contatos">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Compre pelo telefone</h5>
        <p class="card-text">
          Atendimento das 8h às 19h de segunda a sexta. 8h às 14h aos sábados.
        </p>
      </div>
      <button>(71) 97534-4397</button>
      <button>0800-020-5243</button>
    </div>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Atendimento ao cliente</h5>
        <p class="card-text">
          Das 08h às 19h de<br />segunda a sábado, exceto feriados.
        </p>
      </div>
      <button>handifycontato@gmail.com</button>
      <button>0800-020-6639</button>
    </div>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Compre pelo Whatsapp</h5>
        <p class="card-text">
          Para todo o território nacional. Horário de atendimento sujeito à
          região.
        </p>
      </div>
      <button><i class="bi bi-whatsapp"></i> (71) 9985-7897</button>
      <button>(71) 9535-6332</button>
    </div>
  </div>

  <section class="pagamento card">
    <h4>Formas de pagamento</h4>
    <div class="pagamento-icones">
      <img src="../images/icones/visa-logo.png" alt="Visa" />
      <img src="../images/icones/Mastercard.png" alt="Mastercard" />
      <img src="../images/icones/Logo-ELO.png" alt="Elo" />
      <img src="../images/icones/Logo-BOLETO.png" alt="Boleto" />
      <img src="../images/icones/Logo-PIX.png" alt="Pix" />
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

  <script type="module" src="../js/database.js"></script>
  <script type="module" src="../js/search.js"></script>
  <script type="module" src="../js/search/search-in-page.js"></script>
  <script src="../js/mobile-pop-up.js"></script>
  <script src="../js/logged-in.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>