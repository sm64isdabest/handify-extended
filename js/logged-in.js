console.log("logged-in.js loaded");

function getCookie(name) {
  const value = "; " + document.cookie;
  const parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

function performLogout() {
  window.location.href = "logout.php"; 
}

document.addEventListener("DOMContentLoaded", function () {
  const userName = getCookie("userName");
  const entrarLi = document.querySelector("li .entrar")?.parentElement;
  const entrarLiMobile = document.querySelector("li .entrar-mobile")?.parentElement;
  const userLoggedLi = document.querySelector("li.user-logged");

  if (userName) {
    const formattedName = decodeURIComponent(userName);
    entrarLi && (entrarLi.style.display = "none");
    entrarLiMobile && (entrarLiMobile.style.display = "none");
    
    if (userLoggedLi) {
        userLoggedLi.style.display = "list-item";
        const userNameSpan = userLoggedLi.querySelector(".user-name");
        
        if (userNameSpan) {
            userNameSpan.textContent = formattedName;
        }
    }

  } else {
    entrarLi && (entrarLi.style.display = "block");
    entrarLiMobile && (entrarLiMobile.style.display = "block");
    if (userLoggedLi) {
        userLoggedLi.style.display = "none";
    }
  }

  const logoutButtons = document.querySelectorAll(".logout-btn");

  logoutButtons.forEach(button => {
    button.addEventListener("click", (event) => {
      event.preventDefault(); 
      performLogout();
    });
  });

  const profileBtn = document.querySelector(".profile-btn");
  const menuPopup = document.querySelector(".menu-popup");

  if (profileBtn && menuPopup) {
    profileBtn.addEventListener("click", () => {
      menuPopup.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
      if (!menuPopup.contains(e.target) && !profileBtn.contains(e.target)) {
        menuPopup.classList.remove("show");
      }
    });
  }
  
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
