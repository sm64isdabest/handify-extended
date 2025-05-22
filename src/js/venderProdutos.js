document.addEventListener('DOMContentLoaded', () => {
    // 1. Funcionalidade para o botão "Voltar"
    const btnBack = document.querySelector('.btn-back');
    if (btnBack) {
        btnBack.addEventListener('click', () => {
            // Volta para a página anterior no histórico do navegador
            // Você pode mudar isso para uma URL específica se preferir, ex: window.location.href = 'pagina-anterior.html';
            window.history.back();
            console.log('Botão "Voltar" clicado. Voltando para a página anterior.');
        });
    }

    // 2. Funcionalidade para o botão "Adicionar Imagem"
    const imagemProdutoDiv = document.querySelector('.imagem-produto');
    const btnAddImage = imagemProdutoDiv ? imagemProdutoDiv.querySelector('.btn-add') : null;

    if (btnAddImage) {
        btnAddImage.addEventListener('click', () => {
            // Cria um input de arquivo dinamicamente
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*'; // Aceita apenas arquivos de imagem

            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        // Remove o botão de adicionar imagem existente se houver um
                        if (btnAddImage) {
                            btnAddImage.remove(); // Remove o botão de +
                        }

                        // Cria um elemento img para a imagem
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.alt = 'Imagem do Produto';
                        imgElement.style.maxWidth = '100%';
                        imgElement.style.maxHeight = '100%';
                        imgElement.style.objectFit = 'contain'; // Garante que a imagem se ajuste sem cortar

                        // Limpa o conteúdo atual da div imagem-produto e adiciona a imagem
                        imagemProdutoDiv.innerHTML = ''; // Limpa qualquer conteúdo anterior (como o botão inicial)
                        imagemProdutoDiv.appendChild(imgElement);
                        console.log('Imagem adicionada com sucesso!');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Simula um clique no input de arquivo para abrir a janela de seleção
            fileInput.click();
        });
    }

    // 3. Funcionalidade para os botões de destaque (exemplo: adicionar um item de destaque)
    const botoesDestaque = document.querySelectorAll('.botoes-destaque button');
    botoesDestaque.forEach(button => {
        button.addEventListener('click', () => {
            // Exemplo simples: você pode querer adicionar um novo campo de input
            // ou abrir um modal para mais detalhes
            alert('Botão de destaque clicado! (Funcionalidade a ser implementada)');
            console.log('Botão de destaque clicado.');
        });
    });

    // 4. Funcionalidade para os botões "Comprar Agora" e "Adicionar ao Carrinho"
    const comprarAgoraBtn = document.querySelector('.comprar-agora');
    const adicionarCarrinhoBtn = document.querySelector('.adicionar-carrinho');

    // Função de validação dos inputs
    const validateInputs = () => {
        const inputs = document.querySelectorAll('.info-produto input, .quantidade-produto input, .quadro-descricao input');
        let allInputsFilled = true;
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                input.style.border = '2px solid red'; // Destaca inputs vazios
                allInputsFilled = false;
            } else {
                input.style.border = ''; // Remove o destaque se preenchido
            }
        });
        return allInputsFilled;
    };

    if (comprarAgoraBtn) {
        comprarAgoraBtn.addEventListener('click', () => {
            if (validateInputs()) {
                alert('Produto comprado com sucesso! (Funcionalidade de checkout a ser implementada)');
                console.log('Produto comprado.');
            } else {
                alert('Por favor, preencha todos os campos do produto antes de comprar.');
                console.log('Tentativa de compra com campos vazios.');
            }
        });
    }

    if (adicionarCarrinhoBtn) {
        adicionarCarrinhoBtn.addEventListener('click', () => {
            if (validateInputs()) {
                alert('Produto adicionado ao carrinho! (Funcionalidade de carrinho a ser implementada)');
                console.log('Produto adicionado ao carrinho.');
            } else {
                alert('Por favor, preencha todos os campos do produto antes de adicionar ao carrinho.');
                console.log('Tentativa de adicionar ao carrinho com campos vazios.');
            }
        });
    }

    // Opcional: Adicionar funcionalidade para o link de "Entrar" no header
    const entrarLink = document.querySelector('header nav ul li a.entrar');
    if (entrarLink) {
        entrarLink.addEventListener('click', (e) => {
            e.preventDefault(); // Impede o comportamento padrão do link
            alert('Você clicou em Entrar! (Redirecionar para página de login/cadastro)');
            // window.location.href = 'pagina-de-login.html'; // Exemplo de redirecionamento
            console.log('Link "Entrar" clicado.');
        });
    }

    // Opcional: Adicionar funcionalidade para o link de "Contato" no header
    const contatoLink = document.querySelector('header nav ul li a[href="#"]'); // Seleciona o primeiro link com href="#"
    if (contatoLink && contatoLink.textContent.includes('Contato')) {
        contatoLink.addEventListener('click', (e) => {
            e.preventDefault(); // Impede o comportamento padrão do link
            alert('Você clicou em Contato! (Redirecionar para página de contato)');
            // window.location.href = 'pagina-de-contato.html'; // Exemplo de redirecionamento
            console.log('Link "Contato" clicado.');
        });
    }
});