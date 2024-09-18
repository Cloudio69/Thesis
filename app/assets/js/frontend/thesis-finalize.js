const rilegatureForm = document.querySelector("#rilegature_form");
const pagineForm = document.querySelector("#form_pagine");
const cdForm = document.querySelector("#form_cd");

const cartWrapper = document.querySelector(".thesis--cart-items")

let forms = [rilegatureForm, pagineForm, cdForm];

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    updateCart();
  });
});

const createCartItem = (item) => {
  const cartItem = document.createElement("div");
  const removeButton = document.createElement("button");

  removeButton.classList.add("cart--remove", "flex", "items-center", "justify-center");
  removeButton.setAttribute('id', item.id)
  removeButton.innerHTML = "<span class='material-symbols-outlined'>close</span>";
  cartItem.classList.add("cart--item", "flex", "justify-between", "items-center", "p-4", "bg-white", "rounded-lg", "shadow-sm", "mb-4");
  cartItem.innerHTML = `${item.innerHTML}`;

  return cartItem;
}

const updateCart = () => {
}
