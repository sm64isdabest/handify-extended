console.log("theme-loader.js loaded");
(function() {
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.documentElement.classList.add('dark-mode');
    }
})();
