function textVisibility() {
  let x = document.getElementById("password-input");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  let y = document.getElementById("swap");
  if (y.innerHTML === "Show") {
    y.innerHTML = "Hide";
  } else {
    y.innerHTML = "Show";
  }
}