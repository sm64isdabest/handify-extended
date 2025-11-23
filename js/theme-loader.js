function applyTheme() {
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.documentElement.classList.add('dark-mode');
    } else {
        document.documentElement.classList.remove('dark-mode');
    }
}

applyTheme();

window.addEventListener('load', applyTheme);
document.addEventListener('DOMContentLoaded', applyTheme);
window.addEventListener('pageshow', applyTheme);
const themeToggle = document.getElementById('theme-toggle-btn');
if (themeToggle) {
    themeToggle.addEventListener('click', function() {
        const isDark = document.documentElement.classList.toggle('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });
}