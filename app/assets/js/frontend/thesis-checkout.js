const checkoutForm = document.querySelector("#checkout_form")
const submitCheckout = document.querySelector("#submit_checkout")
const shippingSelect = document.querySelector("#spedizione")

let fieldChecker = {}

const fieldLookup = () => {
    for (const [key, value] of Object.entries(fieldChecker)) {
        let inputField = document.querySelector(`#${key}`)
        let labelField = document.querySelector(`label[for=${key}]`)
        let errorField = document.querySelector(`#${key}_error`)

        inputField.onchange = () => {
            inputField.classList.remove("ring-2", "ring-red-500", "focus:ring-2", "focus:ring-red-500")
            labelField.classList.remove("text-red-500", "flex", "items-center", "justify-between")
            errorField.classList.add("hidden")
        }

        if (value) {
            inputField.classList.add("ring-2", "ring-red-500", "focus:ring-2", "focus:ring-red-500")
            labelField.classList.add("text-red-500", "flex", "items-center", "justify-between")
            errorField.innerHTML = value
            errorField.classList.remove("hidden")
        } else {
            inputField.classList.remove("ring-2", "ring-red-500", "focus:ring-2", "focus:ring-red-500")
            errorField.classList.add("hidden")
        }
    }
}

checkoutForm.addEventListener("submit", (e) => {
    e.preventDefault()

    submitCheckout.classList.add("animate-pulse", "pointer-events-none", "cursor-not-allowed");
    submitCheckout.innerHTML = "Attendere..."
    submitCheckout.disabled = true;

    let cartObject = Object.fromEntries(
        Object.entries(cart).filter(([key, value]) => value && Object.keys(value).length > 0)
    )

    window.onbeforeunload = null;

    let formData = new FormData()
    formData.append("nome", checkoutForm.nome.value)
    formData.append("cognome", checkoutForm.cognome.value)
    formData.append("email", checkoutForm.email.value)
    formData.append("telefono", checkoutForm.telefono.value)
    formData.append("provincia", checkoutForm.provincia.value)
    formData.append("indirizzo", checkoutForm.indirizzo.value)
    formData.append("citta", checkoutForm.citta.value)
    formData.append("codice_postale", checkoutForm.codice_postale.value)
    formData.append("spedizione", shippingSelect.value);
    formData.append('cart', JSON.stringify(cartObject))
    
    formData.append("action", "validate_user_info")
    formData.append("nonce", nonce)


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
            errorData = JSON.parse(error.responseText)

            fieldChecker = { ...errorData.data }

            fieldLookup();
        }
    })

})


shippingSelect.addEventListener("change", (e) => {
    updateCart()
})