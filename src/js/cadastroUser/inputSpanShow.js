console.log("inputSpanShow.js loaded");

const usuarioBtn = document.querySelector(".active");
const storeBtn = document.querySelector(".active1");
const inputs = document.querySelectorAll("input");
const form = document.querySelector(".form-container form");

inputs.forEach((input) => {
  input.addEventListener("focus", function () {
    let errorMsg = document.querySelector("span");
    errorMsg.style.display = "none";
  });
});

function inputSpanShow() {
  let userNameInput = form.querySelector("#userName") || form.querySelector("#userCNPJ");
  let userName = userNameInput.value.trim();
  let userEmail = form.querySelector("#userEmail").value.trim();
  let userPass = form.querySelector("#userPass").value.trim();
  let userPassConfirm = form.querySelector("#userPassConfirm").value.trim();
  if (
    userName === "" ||
    userEmail === "" ||
    userPass === "" ||
    userPassConfirm === ""
  ) {
    let errorMsg = document.querySelector("span");
    errorMsg.style.display = "block";
    return true;
  };
  return false;
};

usuarioBtn.addEventListener("click", function () {
  inputSpanShow();
  if (!inputSpanShow()) {
    let userNameInput = form.querySelector("#userName") || form.querySelector("#userPassConfirm");
    let userName = userNameInput.value.trim();
    document.cookie = "userName=" + encodeURIComponent(userName) + "; path=/";
    window.location.href = "cadastroUser.html";
  };
});

// para ler o cookie em outra página:
//
// function getCookie(name) {
//   const value = "; " + document.cookie;
//   const parts = value.split("; " + name + "=");
//   if (parts.length === 2) return parts.pop().split(";").shift();
// }
// const userName = getCookie("userName");
// console.log(userName);

storeBtn.addEventListener("click", function () {
  inputSpanShow();
  if (!inputSpanShow()) {
    form.reset();
    updateFormText();
  };
});
