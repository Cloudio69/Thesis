/**
 * Questo file è lo script per l'admin page
 *
 * @author Claudio Caso
 *
 */

// Current page

const windowURL = window.location;
const viewingPage = document.querySelector("#current--page");
const page = new URLSearchParams(window.location.search).get("page");

window.onload = () => {
  switch (page) {
    case "thesis":
      viewingPage.innerHTML = "Dashboard";
      break;
    case "thesis-ordini":
      viewingPage.innerHTML = "Ordini";
      break;
    case "thesis-accessori":
      viewingPage.innerHTML = "Accessori";
      break;
    case "thesis-rilegature":
      viewingPage.innerHTML = "Rilegature";
      break;
    case "thesis-impostazioni":
      viewingPage.innerHTML = "Impostazioni";
      break;
  }
};


const success = document.querySelectorAll(".success")

success.forEach((item) => {
  item.querySelector("button").onclick = (e) => e.currentTarget.parentElement.remove()
})
