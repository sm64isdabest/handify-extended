<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adicionar Cartão - Handify</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/payment-card.css" />
    <link rel="shortcut icon" href="../images/favicon.ico" />
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
                <li><a href="../../index.php">Produtos</a></li>
            </ul>
        </div>
    </header>

    <main>
        <div class="container-pagamento">
            <button class="botao-voltar" aria-label="Voltar">
                <i class="bi bi-arrow-left"></i>
            </button>
            <h2 class="titulo-pagamento">Adicionar Cartão</h2>
            <div class="formulario-e-preview">
                <form class="formulario-cartao" autocomplete="off" novalidate>
                    <label for="numeroCartao" class="rotulo">Número do Cartão</label>
                    <input type="text" id="numeroCartao" name="numeroCartao" maxlength="19"
                        placeholder="____-____-__-__" required />

                    <label for="nomeCartao" class="rotulo">Nome do titular</label>
                    <input type="text" id="nomeCartao" name="nomeCartao" maxlength="30" placeholder="Seu nome aqui"
                        required />

                    <div class="linha-formulario">
                        <div class="grupo-formulario pequeno">
                            <label for="validade" class="rotulo">Validade</label>
                            <input type="text" id="validade" name="validade" maxlength="5" placeholder="MM/AA"
                                required />
                        </div>
                        <div class="grupo-formulario pequeno">
                            <label for="cvv" class="rotulo">CVV</label>
                            <input type="password" id="cvv" name="cvv" maxlength="4" placeholder="•••"
                                pattern="[0-9]{3,4}" required />
                        </div>
                    </div>
                </form>

                <div class="container-preview-cartao">
                    <div class="preview-cartao">
                        <div class="logos-cartao">
                            <img id="iconeInputCartao" src="../images/icones/Mastercard.png" alt="Ícone do Cartão"
                                class="logo-mastercard" />
                        </div>
                        <div class="numero-cartao-display" id="numeroCartaoDisplay">1234-5678-90-••</div>
                        <div class="nome-cartao-display" id="nomeCartaoDisplay">Seu nome aqui</div>
                        <div class="validade-cartao-display" id="validadeCartaoDisplay">•• / ••</div>
                        <div class="icone-contactless-cartao"><i class="bi bi-rss"></i></div>
                    </div>
                    <div class="dados-seguros">
                        <i class="bi bi-shield-fill-check"></i>
                        <span>Seus dados estão seguros</span>
                    </div>
                </div>
            </div>
            <a href="payment-confirmed1.php" class="botao-adicionar">Adicionar</a>
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

    <script src="../js/payment-card/add-card.js"></script>
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

    <script type="module" src="../js/logged-in.js"></script>
</body>

</html>