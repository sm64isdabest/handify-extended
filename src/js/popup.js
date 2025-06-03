
const addcart = document.getElementsByClassName("add-to-cart");
const popupMenu = document.getElementById("popup-menu");

Array.from(addcart).forEach(btn => {
  btn.addEventListener("click", function (e) {
    e.stopPropagation();
    if (popupMenu.style.display === "block") {
      popupMenu.style.display = "none";
      return;
    }
    popupMenu.style.display = "block";
  });
});

document.addEventListener("click", function (e) {
  if (
    popupMenu.style.display === "block" &&
    !popupMenu.contains(e.target) &&
    !e.target.closest('.add-to-cart')
  ) {
    popupMenu.style.display = "none";
    Array.from(addcart).forEach(btn => {
    });
  }
});