const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');

let autocompleteList = document.getElementById('autocomplete-list');
if (!autocompleteList) {
    autocompleteList = document.createElement('ul');
    autocompleteList.id = 'autocomplete-list';
    autocompleteList.className = 'autocomplete-items';
    searchInput.parentNode.appendChild(autocompleteList);
}

function goToSearchPage() {
    const query = encodeURIComponent(searchInput.value.trim());
    if (query) {
        window.location.href = `/View/search.php?q=${query}`;
    }
}

searchInput.addEventListener('input', function () {
    const value = this.value.trim().toLowerCase();
    autocompleteList.innerHTML = '';
    if (!value) {
        autocompleteList.style.visibility = 'hidden'; // Esconde se não houver valor
        return;
    }

    // Filtra produtos pelo nome
    const suggestions = products
        .filter(p => p.name.toLowerCase().includes(value))
        .slice(0, 4); // Limite de sugestões

    if (suggestions.length === 0) {
        autocompleteList.style.visibility = 'hidden'; // Esconde se não houver sugestões
        return;
    }

    autocompleteList.style.visibility = 'visible';

    suggestions.forEach(product => {
        const li = document.createElement('li');
        li.textContent = product.name;
        li.addEventListener('click', function () {
            searchInput.value = product.name;
            autocompleteList.innerHTML = '';
            autocompleteList.style.visibility = 'hidden'; // Esconde ao selecionar
            goToSearchPage();
        });
        autocompleteList.appendChild(li);
    });
});

// Fecha sugestões ao clicar fora
document.addEventListener('click', function (e) {
    if (e.target !== searchInput) {
        autocompleteList.innerHTML = '';
        autocompleteList.style.visibility = 'hidden';
    }
});

searchInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        goToSearchPage();
        autocompleteList.innerHTML = '';
    }
});

if (searchButton) {
    searchButton.addEventListener('click', goToSearchPage);
}