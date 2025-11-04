console.log("logged-in.js loaded");

function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

function deleteCookie(name) {
  document.cookie = name + "=; expires=Thu, 23 Set 2025 00:00:00 UTC; path=/;";
}

document.addEventListener("DOMContentLoaded", function () {
  const userName = getCookie("userName");
  const entrarLi = document.querySelector("li .entrar")?.parentElement;
  const entrarLiMobile = document.querySelector("li .entrar-mobile")?.parentElement;
  const userLoggedLi = document.querySelector("li.user-logged");

  if (!userName) {
    entrarLi && (entrarLi.style.display = "block");
    entrarLiMobile && (entrarLiMobile.style.display = "block");
    userLoggedLi && (userLoggedLi.style.display = "none");
    return;
  }

  const formattedName = decodeURIComponent(userName);
  entrarLi && (entrarLi.style.display = "none");
  entrarLiMobile && (entrarLiMobile.style.display = "none");
  userLoggedLi && (userLoggedLi.style.display = "list-item");

  const userNameSpan = userLoggedLi.querySelector(".user-name");
  userNameSpan.textContent = formattedName;

  const profileBtn = userLoggedLi.querySelector(".profile-btn");
  const menuPopup = userLoggedLi.querySelector(".menu-popup");
  const logoutBtn = userLoggedLi.querySelector(".logout-btn");

  profileBtn.addEventListener("click", () => {
    menuPopup.classList.toggle("show");
  });

  document.addEventListener("click", (e) => {
    if (!menuPopup.contains(e.target) && !profileBtn.contains(e.target)) {
      menuPopup.classList.remove("show");
    }
  });

  logoutBtn.addEventListener("click", () => {
    deleteCookie("userName");
    location.href = "View/login.php";
  });

  const rastrearBtn = document.getElementById('rastrear-btn');
  const rastrearPopup = document.getElementById('rastrear-popup');
  const closeRastrear = document.getElementById('close-rastrear');

  rastrearBtn && rastrearBtn.addEventListener('click', () => {
    rastrearPopup.style.display = 'flex';
  });

  closeRastrear && closeRastrear.addEventListener('click', () => {
    rastrearPopup.style.display = 'none';
  });
});
