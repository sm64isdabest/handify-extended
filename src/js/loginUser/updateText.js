console.log("updateText.js loaded");

function updateText() {
  const textToChange = document.getElementById('responsive-text');
// para debug vv
//   if (!textToChange) {
//     console.error("Element with ID 'responsive-text' not found.");
//     return;
//   }
  if (window.matchMedia("(max-width: 768px)").matches) {
    textToChange.textContent = "Consumidores";
    return;
  }

  textToChange.textContent = "Para Consumidores";
}

window.addEventListener("resize", updateText);
window.addEventListener("DOMContentLoaded", updateText);