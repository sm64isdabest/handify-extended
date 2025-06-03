// Função genérica para adicionar funcionalidade de upload de imagem
const setupImageUpload = (containerSelector, buttonSelector) => {
    const container = document.querySelector(containerSelector);
    const addButton = container ? container.querySelector(buttonSelector) : null;

    if (addButton) {
        addButton.addEventListener('click', () => {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';

            fileInput.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        // Remove o botão de adicionar imagem existente
                        addButton.remove();

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.alt = 'Imagem do Produto';
                        imgElement.style.maxWidth = '100%';
                        imgElement.style.maxHeight = '100%';
                        imgElement.style.objectFit = 'contain';

                        // Limpa o conteúdo e adiciona a imagem
                        container.innerHTML = '';
                        container.appendChild(imgElement);
                        console.log('Imagem adicionada com sucesso!');
                    };
                    reader.readAsDataURL(file);
                }
            });
            fileInput.click();
        });
    }
};

// 2. Funcionalidade para o botão "Adicionar Imagem" na div .imagem-produto
setupImageUpload('.imagem-produto', '.btn-add');

// 3. Funcionalidade para o botão "Adicionar Imagem" para dispositivos móveis
setupImageUpload('.imagem-produto', '.mobile.btn-add');


// 4. Funcionalidade para os botões de destaque (exemplo: adicionar um item de destaque)
const botoesDestaque = document.querySelectorAll('.botoes-destaque button');
botoesDestaque.forEach(button => {
    button.addEventListener('click', () => {
        alert('Botão de destaque clicado! (Funcionalidade a ser implementada)');
        console.log('Botão de destaque clicado.');
    });
});

// Opcional: Adicionar funcionalidade para o link de "Entrar" no header
const entrarLink = document.querySelector('header nav ul li a.entrar');
if (entrarLink) {
    entrarLink.addEventListener('click', (e) => {
        e.preventDefault();
        alert('Você clicou em Entrar! (Redirecionar para página de login/cadastro)');
        console.log('Link "Entrar" clicado.');
    });
}

// Opcional: Adicionar funcionalidade para o link de "Contato" no header
const contatoLink = document.querySelector('header nav ul li a');
if (contatoLink && contatoLink.textContent.includes('Contato')) {
    contatoLink.addEventListener('click', (e) => {
        e.preventDefault();
        alert('Você clicou em Contato! (Redirecionar para página de contato)');
        console.log('Link "Contato" clicado.');
    });
}