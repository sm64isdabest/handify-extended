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

setupImageUpload('.imagem-produto', '.btn-add');
setupImageUpload('.imagem-produto', '.mobile.btn-add');