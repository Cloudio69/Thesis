const fronte = document.querySelector("#fronte");
const fronteRetro = document.querySelector("#fronte-retro");

fronte.onmouseenter = () => {
  document.querySelector(".tipologia > img").remove();
  document.querySelector(".tipologia").append(images.fronte);
};
fronteRetro.onmouseenter = () => {
  document.querySelector(".tipologia > img").remove();
  document.querySelector(".tipologia").append(images.fronteRetro);
};

fronte.addEventListener('click', () => {
  cart.tipologia = "Fronte";
  updateCart();
  showToast(`Tipologia selezionata: ${cart.tipologia}`, "success", 'check');
})
fronteRetro.addEventListener('click', () => {
  cart.tipologia = "Fronte e retro";
  updateCart();
  showToast(`Tipologia selezionata: ${cart.tipologia}`, "success", 'check');
})