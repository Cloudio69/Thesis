const rilegatureForm = document.getElementById("#rilegature_form");
const pagineForm = document.getElementById("#form_pagine");
const cdForm = document.getElementById("#form_cd");

let forms = [rilegatureForm, pagineForm, cdForm];

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    updateCart();
  });
});

const updateCart = () => {
}
