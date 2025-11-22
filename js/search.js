console.log("search.js loaded");



const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');

let autocompleteList = document.getElementById('autocomplete-list');
if (!autocompleteList) {
    autocompleteList = document.createElement('ul');
    autocompleteList.id = 'autocomplete-list';
    autocompleteList.className = 'autocomplete-items';
    searchInput.parentNode.appendChild(autocompleteList);
}

function goToSearchPage(query) {
    if (query) {
        window.location.href = `/View/search.php?q=${encodeURIComponent(query)}`;
    }
}

searchInput.addEventListener('input', async function () {
    const value = this.value.trim();
    autocompleteList.innerHTML = '';
    if (!value) {
        autocompleteList.style.visibility = 'hidden';
        return;
    }

    try {
        const response = await fetch(`/View/search-suggestions.php?q=${encodeURIComponent(value)}`);
        if (!response.ok) throw new Error("Erro na requisição");
        const suggestions = await response.json();

        if (suggestions.length === 0) {
            autocompleteList.style.visibility = 'hidden';
            return;
        }

        autocompleteList.style.visibility = 'visible';

        suggestions.slice(0, 4).forEach(product => {
            const li = document.createElement('li');
            li.textContent = product.name;
            li.addEventListener('click', () => {
                searchInput.value = product.name;
                autocompleteList.innerHTML = '';
                autocompleteList.style.visibility = 'hidden';
                goToSearchPage(product.name);
            });
            autocompleteList.appendChild(li);
        });

    } catch {
        autocompleteList.style.visibility = 'hidden';
    }
});


document.addEventListener('click', function (e) {
    if (e.target !== searchInput) {
        autocompleteList.innerHTML = '';
        autocompleteList.style.visibility = 'hidden';
    }
});

searchInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        goToSearchPage(searchInput.value.trim());
        autocompleteList.innerHTML = '';
    }
});

if (searchButton) {
    searchButton.addEventListener('click', () => goToSearchPage(searchInput.value.trim()));
}