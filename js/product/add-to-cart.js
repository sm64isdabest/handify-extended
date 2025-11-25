const cartPopup = document.getElementById('cart-popup');
const cartCloseBtn = document.querySelector('.cart-close');
const cartItemsContainer = document.querySelector('.cart-items');
const cartTotalEl = document.querySelector('.cart-total');
const addToCartButtons = document.querySelectorAll('.add-to-cart');

let cart = [];

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function loadCart() {
    const storedCart = localStorage.getItem('cart');
    cart = storedCart ? JSON.parse(storedCart) : [];
}

function updateCart() {
    cartItemsContainer.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        const priceNum = parseFloat(item.price);
        total += priceNum * item.quantity;

        const itemEl = document.createElement('div');
        itemEl.classList.add('cart-item');
        itemEl.innerHTML = `
            <span>${item.name}</span>
            <div class="quantity-controls">
                <button class="decrease">-</button>
                <span class="quantity">${item.quantity}</span>
                <button class="increase">+</button>
            </div>
            <span>R$ ${(priceNum * item.quantity).toFixed(2)}</span>
        `;

        const decreaseBtn = itemEl.querySelector('.decrease');
        const increaseBtn = itemEl.querySelector('.increase');
        const quantityEl = itemEl.querySelector('.quantity');

        decreaseBtn.addEventListener('click', () => {
            if (item.quantity > 1) {
                item.quantity -= 1;
                quantityEl.textContent = item.quantity;
                saveCart();
                updateCart();
            } else {
                cart = cart.filter(i => i.id !== item.id);
                saveCart();
                updateCart();
            }
        });

        increaseBtn.addEventListener('click', () => {
            item.quantity += 1;
            quantityEl.textContent = item.quantity;
            saveCart();
            updateCart();
        });

        cartItemsContainer.appendChild(itemEl);
    });

    cartTotalEl.textContent = `R$ ${total.toFixed(2)}`;
}

function addItemToCart(product) {
    const priceNum = parseFloat(product.price);
    const existing = cart.find(i => i.id === product.id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: isNaN(priceNum) ? 0 : priceNum,
            image: product.image || '',
            quantity: 1
        });
    }
    saveCart();
    updateCart();
    cartPopup.style.display = 'block';
}

addToCartButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const productData = JSON.parse(btn.getAttribute('data-product'));
        addItemToCart(productData);
    });
});

cartCloseBtn.addEventListener('click', () => {
    cartPopup.style.display = 'none';
});

loadCart();
updateCart();
