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
