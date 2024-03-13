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
    case "thesis-prodotti":
      viewingPage.innerHTML = "Prodotti";
      break;
    case "thesis-copertine":
      viewingPage.innerHTML = "Copertine";
      break;
    case "thesis-impostazioni":
      viewingPage.innerHTML = "Impostazioni";
      break;
  }
};
