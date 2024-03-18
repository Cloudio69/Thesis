const form = document.querySelector("#form--copertine");
const submit = document.querySelector("#submit--copertine");

const dialog = document.querySelector("#modal--thesis");
const showButton = document.querySelector("#aggiungi--copertina");
let img = document.querySelector("#selected--image");

showButton.addEventListener("click", () => {
  dialog.showModal();
});

let mediaCopertina = document.querySelector(".select--copertina");

mediaCopertina.onclick = (e) => {
  e.preventDefault();
  mediaCopertina.querySelector("span").classList.add("hidden");
  dialog.close();
  let options = {
    title: "Seleziona un file multimediale",
    multiple: false,
    library: {
      type: "image",
    },
  };

  // Apri la finestra di media
  let mediaFrame = wp.media(options);
  mediaFrame.open();

  mediaFrame.on("select", () => {
    let attachment = mediaFrame.state().get("selection").first().toJSON();
    img.src = attachment.url;
    img.classList.remove("hidden");
    dialog.showModal();
  });

  mediaFrame.on("close", () => {
    dialog.showModal();
  });
};

let resetForm = document.querySelector("#reset--copertine");

resetForm.onclick = () => {
  img.removeAttribute("src");
  img.classList.add("hidden");
  mediaCopertina.querySelector("span").classList.remove("hidden");
};

form.onsubmit = (e) => {
  e.preventDefault();
  submit.disabled = "true";

  let options = {
    action: "post_copertine",
    data: {
      nome_copertina: e.currentTarget.nome_copertina.value,
      desc_copertina: e.currentTarget.descrizione_copertina.value,
      url_copertina: img.src,
    },
  };

  jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (msg) => {
      submit.removeAttribute("disabled");
      dialog.close();
      showToast(msg);
    },
  });
};


const showToast = (msg) => {
  let messageJson = JSON.parse(msg.data)
  console.log(messageJson)
}