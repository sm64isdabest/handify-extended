<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - Handify</title>
    <link rel="stylesheet" href="../css/about.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
</head>

<body>
    <header>
        <img src="../images/logo-handify.png" alt="Handify Logo" class="logo" />
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
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
                <li><a href="../index.php">Home</a></li>
            </ul>
        </div>
    </header>

    <main class="sobre-main">
        <section class="sobre-hero">
            <div class="sobre-hero-content">
                <h1>Handify – onde o feito à mão ganha espaço e valor</h1>
                <p>Conectamos artesãos apaixonados a quem valoriza o singular, o criativo e o autêntico.</p>
                <a href="sign-up.php" class="sobre-btn"><i class="bi bi-rocket-takeoff"></i>Começar</a>
            </div>
            </div>
        </section>
        <section class="sobre-info">
            <div class="sobre-info-top">
                <div class="sobre-info-text-box"
                    style="background-color: #faecce; padding: 1rem; border-radius: 8px; border-radius: 2rem;">
                    <h2 class="sobre-info-title">Artesanato</h2>
                    <p class="sobre-info-desc">
                        O artesanato é uma forma de criar com as próprias mãos, usando matérias-primas naturais
                        para dar vida a objetos únicos. Muitas vezes, esse trabalho é feito por famílias em casa
                        ou em pequenas oficinas, com muito cuidado e tradição. Essa prática é antiga vem lá do
                        período Neolítico quando nossos ancestrais já poliam pedras para fazer armas, criavam
                        cerâmicas
                        para guardar alimentos e usavam a tecelagem para produzir redes, roupas e colchas.
                    </p>
                </div>
            </div>
        </section>
        <section class="sobre-info">
            <div class="sobre-info-top">
                <div class="sobre-info-text-box" style="background-color: #faecce; padding: 1rem; border-radius: 8px; border-radius: 2rem;ggggggg
                ">
                    <h2 class="sobre-info-title">Sobre o Handify</h2>
                    <p class="sobre-info-desc">
                        A Handify é um marketplace que valoriza o trabalho artesanal, conectando criadores
                        independentes
                        com pessoas que buscam produtos únicos e feitos com cuidado. Além de vender, a plataforma
                        promove a sustentabilidade, a originalidade e a história por trás de cada peça, criando uma
                        comunidade em torno do feito à mão.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <div class="contatos">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Compre pelo telefone</h5>
                <p class="card-text">
                    Atendimento das 8h às 19h de segunda a sexta. 8h às 14h aos sábados.
                </p>
            </div>
            <button>(71) 00000-0000</button>
            <button>0000-000-0000</button>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Atendimento ao cliente</h5>
                <p class="card-text">
                    Das 08h às 19h de<br />segunda a sábado, exceto feriados.
                </p>
            </div>
            <button>handifycontato@gmail.com</button>
            <button>0000-000-0000</button>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Compre pelo Whatsapp</h5>
                <p class="card-text">
                    Para todo o território nacional. Horário de atendimento sujeito à
                    região.
                </p>
            </div>
            <button><i class="bi bi-whatsapp"></i> (71) 0000-0000</button>
            <button><i class="bi bi-whatsapp"></i> (71) 0000-0000</button>
        </div>
    </div>

    <footer id="footer">
        <p>© 2025 HANDIFY. Todos os direitos reservados.</p>
        <div class="social-icons">
            <a href="https://web.whatsapp.com/" target="_blank"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.youtube.com/" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="https://x.com/" target="_blank"><i class="bi bi-twitter-x"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
    </footer>
</body>

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

<script src="../js/mobile-pop-up.js"></script>
<script src="../js/logged-in.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>

</html>