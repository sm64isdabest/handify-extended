console.log("profile.js loaded");
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.profile-nav-item:not(.logout-btn)');
    const contentSections = document.querySelectorAll('.profile-section');

    navLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            navLinks.forEach(nav => nav.classList.remove('active'));
            contentSections.forEach(sec => sec.classList.remove('active'));

            this.classList.add('active');

            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
            }
        });
    });

    const infoLink = document.querySelector('.profile-nav-item[href="#info"]');
    if (infoLink) {
        infoLink.click();
    }

    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const editButton = document.getElementById('edit-info-btn');
    const cancelButton = document.getElementById('cancel-edit-btn');

    if (editButton && cancelButton && viewMode && editMode) {
        editButton.addEventListener('click', function () {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
        });

        cancelButton.addEventListener('click', function () {
            editMode.style.display = 'none';
            viewMode.style.display = 'block';
        });
    }

    const passwordViewMode = document.getElementById('password-view-mode');
    const passwordEditMode = document.getElementById('password-edit-mode');
    const changePasswordButton = document.getElementById('change-password-btn');
    const cancelPasswordButton = document.getElementById('cancel-password-btn');

    if (changePasswordButton && cancelPasswordButton && passwordViewMode && passwordEditMode) {
        changePasswordButton.addEventListener('click', function () {
            passwordViewMode.style.display = 'none';
            passwordEditMode.style.display = 'block';
        });

        cancelPasswordButton.addEventListener('click', function () {
            passwordEditMode.style.display = 'none';
            passwordViewMode.style.display = 'block';
        });
    }
    const themeToggleButton = document.getElementById('theme-toggle-btn');

    if (themeToggleButton) {
        const themeIcon = themeToggleButton.querySelector('i');

        function updateIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-stars-fill');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-stars-fill');
            }
        }

        const initialTheme = localStorage.getItem('theme') || 'light';
        updateIcon(initialTheme);

        themeToggleButton.addEventListener('click', function () {
            const isDarkMode = document.documentElement.classList.contains('dark-mode');
            const newTheme = isDarkMode ? 'light' : 'dark';

            localStorage.setItem('theme', newTheme);
            document.documentElement.classList.toggle('dark-mode');
            updateIcon(newTheme);
        });
    }
});
