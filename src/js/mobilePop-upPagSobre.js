console.log("mobilePop-upPagSobre.js loaded");

const menuIcon = document.getElementById("list");
const popupMenu = document.getElementById("popup-menu");

menuIcon.addEventListener("click", function (e) {
  e.stopPropagation();
  if (popupMenu.style.display === "block") {
    menuIcon.style.backgroundColor = "white";
    menuIcon.style.color = "black"
    popupMenu.style.display = "none";
    return;
  }
  menuIcon.style.backgroundColor = "#593d36";
  menuIcon.style.color = "white"
  popupMenu.style.display = "block";
});

document.addEventListener("click", function (e) {
  if (
    popupMenu.style.display === "block" &&
    !popupMenu.contains(e.target) &&
    e.target !== menuIcon
  ) {
    popupMenu.style.display = "none";
  }
});