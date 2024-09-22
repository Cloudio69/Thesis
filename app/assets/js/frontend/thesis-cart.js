const cartDialog = document.querySelector(".thesis--cart-dialog");
const closeCart = document.querySelector(".close-cart-dialog");
const openCart = document.querySelector(".open-cart-dialog");

closeCart.onclick = () => {
  cartDialog.classList.add("hidden");
};

openCart.onclick = () => {
  if (cartDialog.classList.contains("hidden")) {
    cartDialog.classList.remove("hidden");
  } else {
    cartDialog.classList.add("hidden");
  }
};
