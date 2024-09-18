const rilegatureForm = document.querySelector("#rilegature_form");
const pagineForm = document.querySelector("#form_pagine");
const cdForm = document.querySelector("#form_cd");

const cartWrapper = document.querySelector(".thesis--cart-items");

let forms = [rilegatureForm, pagineForm, cdForm];

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    if(document.querySelector('.placeholder-cart')) document.querySelector('.placeholder-cart').classList.add('hidden');

    updateCart();
  });
});

const createCartItem = (item) => {
  const cartItem = document.createElement("div");
  const removeButton = document.createElement("button");

  removeButton.classList.add(
    "cart--remove",
    "flex",
    "items-center",
    "justify-center"
  );
  removeButton.setAttribute("data-id", item.position);
  removeButton.onclick = (e) => {
    cart.rilegature.splice(e.target.dataset.id, 1);
    removeButton.parentElement.remove();
  };
  removeButton.innerHTML =
    "<span class='material-symbols-outlined !text-white !bg-red-600'>close</span>";
  cartItem.classList.add(
    "cart--item",
    "flex",
    "justify-between",
    "items-center",
    "p-4",
    "bg-white",
    "rounded-lg",
    "border"
  );
  cartItem.innerHTML = `<span class='font-bold text-xl'>${item.nome_rilegatura}</span><span class='flex justify-center'>${item.qty} x ${item.prezzo_rilegatura}€</span>`;

  cartItem.appendChild(removeButton);

  return cartItem;
};

const updateCart = () => {
  Object.keys(cart).forEach((key) => {
    if (key.match(/rilegature/)) {
      // rilegature is an array of objects
      cart[key].forEach((item) => {
        cartWrapper.appendChild(
          createCartItem({ ...item, position: cart[key].indexOf(item) })
        );
      });
    }
  });
};
