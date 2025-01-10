const checkoutForm = document.querySelector("#checkout_form");
const submitCheckout = document.querySelector("#submit_checkout");
const shippingSelect = document.querySelector("#spedizione");
const shippingMethod = document.querySelector("#metodo_spedizione");

let fieldChecker = {};

const fieldLookup = () => {
  for (const [key, value] of Object.entries(fieldChecker)) {
    let inputField = document.querySelector(`#${key}`);
    let labelField = document.querySelector(`label[for=${key}]`);
    let errorField = document.querySelector(`#${key}_error`);

    inputField.onchange = () => {
      inputField.classList.remove(
        "ring-2",
        "ring-red-500",
        "focus:ring-2",
        "focus:ring-red-500"
      );
      labelField.classList.remove(
        "text-red-500",
        "flex",
        "items-center",
        "justify-between"
      );
      errorField.classList.add("hidden");
    };

    if (value) {
      inputField.classList.add(
        "ring-2",
        "ring-red-500",
        "focus:ring-2",
        "focus:ring-red-500"
      );
      labelField.classList.add(
        "text-red-500",
        "flex",
        "items-center",
        "justify-between"
      );
      errorField.innerHTML = value;
      errorField.classList.remove("hidden");
    } else {
      inputField.classList.remove(
        "ring-2",
        "ring-red-500",
        "focus:ring-2",
        "focus:ring-red-500"
      );
      errorField.classList.add("hidden");
    }
  }
};

checkoutForm.addEventListener("submit", (e) => {
  e.preventDefault();

  submitCheckout.classList.add(
    "animate-pulse",
    "pointer-events-none",
    "cursor-not-allowed"
  );
  submitCheckout.innerHTML = "Attendere...";
  submitCheckout.disabled = true;

  let cartObject = Object.fromEntries(
    Object.entries(cart).filter(
      ([key, value]) => value && Object.keys(value).length > 0
    )
  );

  window.onbeforeunload = null;

  let formData = new FormData();
  formData.append("nome", checkoutForm.nome.value);
  formData.append("cognome", checkoutForm.cognome.value);
  formData.append("email", checkoutForm.email.value);
  formData.append("telefono", checkoutForm.telefono.value);
  formData.append("provincia", checkoutForm.provincia.value);
  formData.append("indirizzo", checkoutForm.indirizzo.value);
  formData.append("citta", checkoutForm.citta.value);
  formData.append("codice_postale", checkoutForm.codice_postale.value);

  if (document.querySelector(".spedizione").textContent < 75) {
    if (
      shippingSelect.value == "" ||
      shippingMethod.dataset.instance == "" ||
      (shippingMethod.dataset.zone == "" &&
        document.querySelector(".subtotale").textContent < 75)
    ) {
      alert("Calcola il costo della spedizione prima di procedere");
      submitCheckout.classList.remove(
        "animate-pulse",
        "pointer-events-none",
        "cursor-not-allowed"
      );
      submitCheckout.innerHTML = "CONTINUA AL PAGAMENTO";
      submitCheckout.disabled = false;
      return;
    }
  }

  formData.append(
    "spedizione",
    JSON.stringify({
      title: shippingSelect.value,
      instance: shippingMethod.dataset.instance,
      zone: shippingMethod.dataset.zone,
    })
  );
  formData.append("cart", JSON.stringify(cartObject));

  formData.append("action", "validate_user_info");
  formData.append("nonce", nonce);

  jQuery.ajax({
    type: "POST",
    url: ajaxurl,
    data: formData,
    cache: false,
    processData: false, // Impedisce a jQuery di trasformare i dati in una stringa di query
    contentType: false, // Impedisce a jQuery di impostare automaticamente il tipo di contenuto
    success: (response) => {
      let responseData = response.data.payment_url;

      window.location.href = responseData;
    },
    error: (error) => {
      // parse data
      let errorData;
      errorData = JSON.parse(error.responseText);

      fieldChecker = { ...errorData.data };

      fieldLookup();
    },
  });
});

document
  .querySelector(".calcola--spedizione")
  .addEventListener("click", (e) => {
    e.preventDefault();

    e.currentTarget.disabled = true;

    let formData = new FormData();
    formData.append("action", "thesis_get_shipping_cost");
    formData.append("nonce", nonce);
    formData.append("codice_postale", checkoutForm.codice_postale.value);
    formData.append("provincia", checkoutForm.provincia.value);
    formData.append("citta", checkoutForm.citta.value);

    jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      data: formData,
      cache: false,
      processData: false,
      contentType: false,
      success: (response) => {
        let responseData = response.data.shipping_cost;
        let responseMethod = response.data.shipping_method;
        let shippingCost = document.querySelector("#spedizione");
        let shippingMethod = document.querySelector("#metodo_spedizione");

        shippingCost.value = responseData;

        if (responseMethod) {
          shippingMethod.value = responseMethod.method_title
            ? responseMethod.method_title
            : "";
          shippingMethod.dataset.instance = responseMethod.instance_id
            ? responseMethod.instance_id
            : "";
        }

        shippingMethod.dataset.zone = response.data.zone_id;

        document.querySelector(".calcola--spedizione").disabled = false;

        updateCart();
      },
      error: (error) => {
        console.log(error);
      },
    });
  });

const objectRitiro = {
  provincia: "BA",
  indirizzo: "Via Re David, 180",
  citta: "Bari",
  codice_postale: "70125",
};

document.querySelector(".ritiro--sede").addEventListener("click", (e) => {
  e.preventDefault();

  checkoutForm.provincia.value = objectRitiro.provincia;
  checkoutForm.indirizzo.value = objectRitiro.indirizzo;
  checkoutForm.citta.value = objectRitiro.citta;
  checkoutForm.codice_postale.value = objectRitiro.codice_postale;

  document.querySelector("#spedizione").value = 0;
  document.querySelector("#metodo_spedizione").value = "Ritiro in sede";
  document.querySelector("#metodo_spedizione").dataset.instance = 3;
  document.querySelector("#metodo_spedizione").dataset.zone = 1;

  updateCart();
});

const resetShippingFields = () => {
  document.querySelector("#spedizione").value = "";
  document.querySelector("#metodo_spedizione").value = "";
  document.querySelector("#metodo_spedizione").dataset.instance = "";
  document.querySelector("#metodo_spedizione").dataset.zone = "";
};

["provincia", "indirizzo", "citta", "codice_postale"].forEach((field) => {
  document
    .querySelector(`#${field}`)
    .addEventListener("change", resetShippingFields);
});
