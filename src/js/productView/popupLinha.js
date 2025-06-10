document.getElementById("listToggle").addEventListener("click", function() {
  const list = document.getElementById("popup-menu-list");
  if (list.style.display === 'none') {
    list.style.display = 'block';
  } else {
    list.style.display = 'none';
  }
});