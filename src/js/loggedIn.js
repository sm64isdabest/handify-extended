console.log("loggedIn.js loaded");

function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

document.addEventListener("DOMContentLoaded", function () {
  const userName = getCookie("userName");
  const entrarLi = document.querySelector("li .entrar")?.parentElement;
  const entrarLiMobile = document.querySelector("li .entrar-mobile")?.parentElement;
  const userLoggedLi = document.querySelector("li.user-logged");
  const userLoggedLiMobile = document.querySelector("li.user-logged-mobile");

  function formatUserName(name) {
    if (!name) return "";
    return name.length > 12 ? name.slice(0, 12) + "..." : name;
  }

  if (!userName) {
    entrarLi.style.display = "block";
    entrarLiMobile.style.display = "block";
    userLoggedLi.style.display = "none";
    userLoggedLiMobile.style.display = "none";
    return;
  }

  if (userName) {
    const formattedName = formatUserName(decodeURIComponent(userName));
    entrarLi.style.display = "none";
    entrarLiMobile.style.display = "none";
    userLoggedLi.style.display = "block";
    userLoggedLi.style.display = "list-item";
    userLoggedLiMobile.style.display = "block";
    userLoggedLiMobile.style.display = "list-item";
    userLoggedLi.innerHTML = `<i class="bi bi-person"></i> ${formattedName}`;
    userLoggedLiMobile.innerHTML = `<i class="bi bi-person"></i> ${formattedName}`;
  }
});