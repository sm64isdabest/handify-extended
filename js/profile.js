console.log("profile.js loaded");

document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.profile-nav-item[href^="#"]:not(.logout-btn)');
    const sections = document.querySelectorAll('.profile-section');

    function activateTab(targetId) {
        console.log('Ativando tab:', targetId);
        navLinks.forEach(nav => nav.classList.remove('active'));
        sections.forEach(sec => {
            sec.classList.remove('active');
        });

        const link = Array.from(navLinks).find(l => l.getAttribute('href') === targetId);
        const section = document.querySelector(targetId);

        if (link) {
            link.classList.add('active');
        }
        if (section) {
            section.classList.add('active');
        }

        console.log('Link ativo:', link);
        console.log('Seção ativa:', section);
    }

    navLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            console.log('Clicou no link:', targetId);
            history.pushState(null, '', targetId);
            activateTab(targetId);
        });
    });

    const initialHash = window.location.hash || '#info';
    console.log('Hash inicial:', initialHash);
    activateTab(initialHash);

    window.addEventListener('hashchange', () => {
        console.log('Hash changed:', window.location.hash);
        activateTab(window.location.hash);
    });

    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const editButton = document.getElementById('edit-info-btn');
    const cancelButton = document.getElementById('cancel-edit-btn');

    if (editButton && cancelButton && viewMode && editMode) {
        editButton.addEventListener('click', () => {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
        });
        cancelButton.addEventListener('click', () => {
            editMode.style.display = 'none';
            viewMode.style.display = 'block';
        });
    }

    const themeBtn = document.getElementById('theme-toggle-btn');
    if (themeBtn) {
        const icon = themeBtn.querySelector('i');
        const updateIcon = theme => {
            if (theme === 'dark') {
                icon.classList.remove('bi-moon-stars-fill');
                icon.classList.add('bi-sun-fill');
            } else {
                icon.classList.remove('bi-sun-fill');
                icon.classList.add('bi-moon-stars-fill');
            }
        };
        const theme = localStorage.getItem('theme') || 'light';
        updateIcon(theme);
        themeBtn.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark-mode');
            const newTheme = isDark ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });
    }

    const detailsModal = document.getElementById("detailsModal");
    const closeDetails = document.getElementById("closeDetails");
    const orderItems = document.getElementById("order-items");
    const orderTotal = document.getElementById("order-total");

    document.querySelectorAll(".details-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.order;
            orderItems.innerHTML = "";
            orderTotal.innerText = "";
            try {
                const res = await fetch(`order-details.php?purchaseId=${id}`);
                const data = await res.json();
                if (!data.items || data.items.length === 0) orderItems.innerHTML = "<p>Pedido vazio</p>";
                else {
                    data.items.forEach(item => {
                        const div = document.createElement("div");
                        div.classList.add("order-detail-item");
                        div.innerHTML = `${item.name} - ${item.quantity}x R$ ${parseFloat(item.price_at_time_of_purchase).toFixed(2)}`;
                        orderItems.appendChild(div);
                    });
                    orderTotal.innerText = parseFloat(data.total).toFixed(2);
                }
                detailsModal.style.display = "flex";
            } catch {
                orderItems.innerHTML = "<p>Erro ao carregar detalhes</p>";
                detailsModal.style.display = "flex";
            }
        });
    });

    if (closeDetails) closeDetails.addEventListener("click", () => detailsModal.style.display = "none");
});