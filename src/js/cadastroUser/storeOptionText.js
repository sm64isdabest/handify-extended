console.log("storeOptionText.js loaded");

const storeButton = document.getElementsByClassName('active1');

function updateFormText() {
    // pega os títulos
    const formh1 = document.querySelector('.form-container h1');
    const formh3 = document.querySelector('.form-container h3');

    // pega tudo que inclui userName
    const formUserName = document.querySelector('#labelUserName');
    const userNameIcon = formUserName.querySelector('i');
    const userNameInput = formUserName.querySelector('input');

    // pega tudo que inclui userEmail
    const formUserEmail = document.querySelector('#labelUserEmail');
    const userEmailIcon = formUserEmail.querySelector('i');
    const userEmailInput = formUserEmail.querySelector('input');

    // pega tudo que inclui userPass
    const formUserPass = document.querySelector('#labelUserPass');
    const userPassIcon = formUserPass.querySelector('i');
    const userPassInput = formUserPass.querySelector('input');

    // pega tudo que inclui userPassConfirm
    const formUserPassConfirm = document.querySelector('#labelUserPassConfirm')
    const userPassConfirmIcon = formUserPassConfirm.querySelector('i');
    const userPassConfirmInput = formUserPassConfirm.querySelector('input');

    // pega o botão de confirmação do cadastro
    const formConfirmButton = document.querySelector('.form-container .active');

    // atualiza os títulos
    formh1.textContent = "Cadastro de Loja";
    formh3.textContent = "🎉 Quase lá! Agora, vamos finalizar o cadastro da sua loja. Insira as informações essenciais para começar a vender. 🚀";

    // atualiza a class e placeholder do userName
    userNameIcon.classList.remove('bi-person');
    userNameIcon.classList.add('bi-building');
    userNameInput.id = "userCNPJ"
    userNameInput.type = "number";
    userNameInput.placeholder = "CNPJ";

    // atualiza a class e placeholder do userEmail
    userEmailIcon.classList.remove('bi-envelope');
    userEmailIcon.classList.add('bi-geo-alt');
    userEmailInput.type = "text";
    userEmailInput.placeholder = "Endereço";

    // atualiza a class e placeholder do userPass
    userPassIcon.classList.remove('bi-key');
    userPassIcon.classList.add('bi-telephone');
    userPassInput.type = "number";
    userPassInput.placeholder = "Telefone";

    // atualiza a class e placeholder do userPassConfirm
    userPassConfirmIcon.classList.remove('bi-lock');
    userPassConfirmIcon.classList.add('bi-shop');
    userPassConfirmInput.type = "text";
    userPassConfirmInput.placeholder = "Nome da Marca";

    // remove o id "responsive-text" e o botão da loja, e altera o texto do botão de confirmação
    formConfirmButton.removeAttribute('id');
    formConfirmButton.textContent = "Cadastrar Loja";
    storeButton[0].remove();
};

