const nuovaVariante = document.querySelector("#aggiungi--variante");
const dialogVariante = document.querySelector("#modal--variants");
const selectCopertine = document.querySelector("#lista_copertine");
const wrapperVarianti = document.querySelector("#list--varianti");
const formVariante = document.querySelector("#form--variante");

const getVarianti = async () => {
  let options = {
    action: "get_varianti",
  };

  let varianti = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(varianti.data);
  let results = JSON.parse(response.results);

  if (results.length === 0) {
    wrapperVarianti.innerHTML = "Non ci sono varianti";
    wrapperVarianti.removeAttribute("class");
  }
};

let mediaVariante = document.querySelector(".select--variante");

mediaVariante.onclick = (e) => {
  e.preventDefault();

  let img = document.querySelector("#selected--image-variante");

  mediaVariante.querySelector("span").classList.add("hidden");
  dialogVariante.close();
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
    dialogVariante.showModal();
  });

  mediaFrame.on("close", () => {
    dialogVariante.showModal();
  });
};

const showGlobalToast = (response) => {
  const toast = document.querySelector("#toast");
  toast.classList.remove("hidden");
  toast.classList.add("flex");

  let icon = document.createElement("span");
  icon.classList.add("material-symbols-outlined");

  if (response.success) {
    if (toast.classList.contains("bg-red-700")) {
      toast.classList.remove("bg-red-700");
      toast.classList.add("bg-green-700");
    }

    icon.innerHTML = "check";
    toast.querySelector(".icon").appendChild(icon);
    toast.querySelector(".body").innerHTML = response.message;
  } else {
    icon.innerHTML = "warning";
    toast.classList.remove("bg-green-700");
    toast.classList.add("bg-red-700");
    toast.querySelector(".icon").appendChild(icon);
    toast.querySelector(".body").innerHTML = response.message;
  }

  setTimeout(() => {
    toast.querySelector(".icon").innerHTML = "";
    toast.querySelector(".body").innerHTML = "";
    toast.classList.add("hidden");
  }, 5000);
};

nuovaVariante.onclick = async () => {
  selectCopertine.innerHTML = ""
  let options = {
    action: "get_copertine",
  };

  let copertine = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(copertine.data);
  let results = JSON.parse(response.results);

  results.forEach((copertina) => {
    let option = document.createElement("option");
    option.value = copertina.id_copertina;
    option.innerHTML =
      copertina.id_copertina + " | " + copertina.nome_copertina;

    selectCopertine.append(option);
  });

  if (results.length === 0) {
    showGlobalToast({ message: "Crea prima una copertina!", success: false });
    return;
  }
  dialogVariante.showModal();
};

formVariante.onsubmit = (e) => {
  e.preventDefault();
  
  let img = document.querySelector("#selected--image-variante");
  
  const submit = document.querySelector("#submit--variante")
  submit.disabled = true

  let options = {
    action: "post_variante",
    data: {
      id_copertina: e.currentTarget.lista_copertine.value,
      nome_variante: e.currentTarget.nome_variante.value,
      codice_colore: e.currentTarget.codice_colore.value,
      url_variante: img.src,
    },
  };

  jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      submit.removeAttribute("disabled");
      dialogVariante.close();
      showToast(response);
    },
  });
};

getVarianti();
