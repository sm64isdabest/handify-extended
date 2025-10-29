<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Pagamento via Boleto | Handify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/payment-bank-slip-and-pix.css" />
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
                <li><a href="../index.php">Produtos</a></li>
            </ul>
        </div>
    </header>

    <main>
        <div class="container-pagamento">
            <a href="payment-methods.php" class="botao-voltar">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="titulo-pagamento">Pagamento via Boleto</h2>
            <div class="boleto-content">
                <div class="boleto-logo">
                    <img src="../images/icones/Logo-BOLETO.png" alt="Boleto Logo" />
                </div>
                <div class="boleto-code-section">
                    <label for="boletoCode" class="boleto-label">Código do boleto:</label>
                    <div class="boleto-code-wrapper">
                        <input type="text" id="boletoCode" readonly
                            value="23790.00009 12345.678901 23456.789012 3 12345678901234" />
                        <button class="copy-button" onclick="copyBoletoCode()" title="Copiar código do boleto">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
                <div class="boleto-instructions">
                    <p>Para realizar o pagamento via boleto, utilize o código acima no seu banco ou aplicativo.</p>
                    <p>Data de vencimento: 30/06/2025</p>
                    <p>Após o pagamento, aguarde a confirmação.</p>
                </div>
            </div>
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
    <script src="../js/payment-bank-slip/copy-bank-slip.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>

    <script type="module" src="../js/logged-in.js"></script>
</body>

</html>