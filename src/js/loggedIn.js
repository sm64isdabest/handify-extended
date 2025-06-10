function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

document.addEventListener("DOMContentLoaded", function () {
  const userName = getCookie("userName");
  const entrarLi = document.querySelector("li .entrar")?.parentElement;
  const userLoggedLi = document.querySelector("li.user-logged");

  if (!userName) {
    entrarLi.style.display = "block";
    userLoggedLi.style.display = "none";
    return;
  }

  if (userName && entrarLi && userLoggedLi) {
    entrarLi.style.display = "none";
    userLoggedLi.style.display = "block";
    userLoggedLi.style.display = "list-item";
    userLoggedLi.innerHTML = `<i class="bi bi-person"></i> ${decodeURIComponent(userName)}`;
  }
});