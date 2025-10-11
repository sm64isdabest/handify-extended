console.log("input-span-show.js loaded");

const cadastroBtn = document.querySelector(".buttons");
const usuarioBtn = document.querySelector(".active");
const inputs = document.querySelectorAll("input");
const form = document.querySelector(".form-container form");

inputs.forEach((input) => {
  input.addEventListener("focus", function () {
    let errorMsg = document.querySelector("span");
    errorMsg.style.display = "none";
  });
});

function inputSpanShow() {
  let userName = form.querySelector("#userName").value.trim();
  let userPass = form.querySelector("#userPass").value.trim();
  if (
    userName === "" ||
    userPass === ""
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
    let userName = form.querySelector("#userName").value.trim();
    document.cookie = "userName=" + encodeURIComponent(userName) + "; path=/";
    window.location.href = "../../index.php";
  };
}); 