console.log("responsiveText.js loaded");

function updateText() {
  const textToChange = document.getElementById('responsive-text');
  if (!textToChange) {
    return
  }
  if (window.matchMedia("(max-width: 768px)").matches) {
    textToChange.textContent = "Consumidores";
    return;
  }

  textToChange.textContent = "Para Consumidores";
}

window.addEventListener("resize", updateText);
window.addEventListener("DOMContentLoaded", updateText);
