console.log("inputSpanShow.js loaded");

const cadastroBtn = document.querySelector(".buttons");
const inputs = document.querySelectorAll("input");
const form = document.querySelector(".form-container form");

inputs.forEach((input) => {
  input.addEventListener("focus", function () {
    let errorMsg = document.querySelector("span");
    errorMsg.style.display = "none";
  });
});

cadastroBtn.addEventListener("click", function (e) {
  // console.log("hi");
  e.preventDefault();
  let userName = form.querySelector("#userName").value.trim();
  let userEmail = form.querySelector("#userEmail").value.trim();
  let userPass = form.querySelector("#userPass").value.trim();
  let userPassConfirm = form.querySelector("#userPassConfirm").value.trim();
  if (
    userName === "" ||
    userEmail === "" ||
    userPass === "" ||
    userPassConfirm === ""
  ) {
    // console.log("habla");
    let errorMsg = document.querySelector("span");
    errorMsg.style.display = "block";
    return;
  }
  // alert('Cadastro realizado com sucesso!')
  // form.reset();
});