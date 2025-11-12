console.log("input-span-show.js loaded");

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
  if (userName === "" || userPass === "") {
    let errorMsg = document.querySelector("span");
    errorMsg.style.display = "block";
    return true;
  }
  return false;
}

form.addEventListener("submit", function (e) {
  if (inputSpanShow()) {
    e.preventDefault();
  }
});
