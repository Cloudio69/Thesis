const cartDialog = document.querySelector(".thesis--cart-dialog");
const closeCart = document.querySelector(".close-cart-dialog");
const openCart = document.querySelector(".open-cart-dialog");

closeCart.onclick = () => {
  cartDialog.classList.add("hidden");
};

openCart.onclick = () => {
  cartDialog.classList.remove("hidden");
};
