const nuovaVariante = document.querySelector("#aggiungi--variante");
const dialogVariante = document.querySelector("#modal--variants");
const selectCopertine = document.querySelector("#lista_copertine");
const wrapperVarianti = document.querySelector("#list--varianti");
const formVariante = document.querySelector("#form--variante");

function creaElementiHTML(oggettiRaggruppati) {
  for (const id in oggettiRaggruppati) {
    let gruppoCounter = 0;
    const gruppo = oggettiRaggruppati[id];

    const divGruppo = document.createElement("div");
    divGruppo.classList.add(
      "gruppo",
      "flex",
      "flex-1",
      "gap-4",
      "items-center",
      "w-full",
      "p-4",
      "border",
      "rounded-md"
    );

    const titolo = document.createElement("h2");
    titolo.textContent = `${gruppo[gruppoCounter].nome_copertina}`;
    titolo.classList.add("font-bold", "text-xl", "p-4", "flex-1");
    divGruppo.appendChild(titolo);

    const divList = document.createElement("div");
    divGruppo.appendChild(divList);
    divList.classList.add("w-full", "flex", "flex-col", "gap-2", "flex-1");

    gruppo.forEach((oggetto) => {
      const card = document.createElement("div");
      card.classList.add(
        "rounded-md",
        "flex",
        "items-center",
        "justify-between",
        "w-full",
        "p-4",
        "border"
      );

      const nomeCopertina = document.createElement("p");
      nomeCopertina.textContent = `${oggetto.nome_variazione}`;
      nomeCopertina.classList.add("flex-1");
      card.appendChild(nomeCopertina);

      const idVariazione = document.createElement("p");
      idVariazione.textContent = `${oggetto.codice_colore}`;
      idVariazione.classList.add("flex-1", "text-end");
      card.appendChild(idVariazione);

      const anteprima = document.createElement("a");
      anteprima.classList.add(
        "underline",
        "text-cyan-800",
        "text-end",
        "flex-1",
        "active:outline-none"
      );
      anteprima.textContent = "Vedi anteprima";
      anteprima.href = oggetto.anteprima_variazione;
      anteprima.target = "_blank";

      card.appendChild(anteprima);

      const actions = document.createElement("div");
      actions.classList.add(
        "flex",
        "gap-4",
        "items-center",
        "flex-1",
        "justify-end"
      );

      card.appendChild(actions);

      const modifica = document.createElement("button");
      modifica.textContent = "edit";
      modifica.dataset.id = oggetto.id_variazione;
      modifica.classList.add(
        "material-symbols-outlined",
        "text-sky-900",
        "drop-shadow-sm"
      );
      modifica.onclick = (e) => modificaVariante(e);

      const cancella = document.createElement("button");
      cancella.dataset.id = oggetto.id_variazione;
      cancella.textContent = "delete";
      cancella.classList.add(
        "material-symbols-outlined",
        "text-sky-900",
        "drop-shadow-sm"
      );
      cancella.onclick = (e) => cancellaVariante(e);

      actions.append(modifica, cancella);

      divList.appendChild(card);

      gruppoCounter++;
    });

    wrapperVarianti.classList.add("flex", "flex-col", "gap-4");

    wrapperVarianti.appendChild(divGruppo);
  }
}

const getVarianti = async () => {
  wrapperVarianti.innerHTML = "";
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
  } else {
    wrapperVarianti.removeAttribute("class");

    const raggruppaPerId = (array) => {
      const raggruppato = {};

      array.forEach((oggetto) => {
        const { id_copertina } = oggetto;

        if (!raggruppato[id_copertina]) {
          raggruppato[id_copertina] = [];
        }

        raggruppato[id_copertina].push(oggetto);
      });

      return raggruppato;
    };

    // Utilizza la funzione per raggruppare gli oggetti
    const oggettiRaggruppati = raggruppaPerId(results);

    creaElementiHTML(oggettiRaggruppati);
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
  selectCopertine.innerHTML = "";
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

  const submit = document.querySelector("#submit--variante");
  submit.disabled = true;

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
      getVarianti();
      showToast(response);
    },
  });
};

const modificaVariante = (e) => {
  let idVariante = e.currentTarget.dataset.id;

  const dialogUpdate = document.querySelector("#modal--variants-update");
  dialogUpdate.showModal();

  const mediaUpdate = document.querySelector(".select--variante-update");
  mediaUpdate.onclick = (e) => {
    e.preventDefault();

    let img = document.querySelector("#selected--image-variante-update");

    mediaUpdate.querySelector("span").classList.add("hidden");
    dialogUpdate.close();

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
      dialogUpdate.showModal();
    });

    mediaFrame.on("close", () => {
      dialogUpdate.showModal();
    });
  };

  const formUpdate = document.querySelector("#form--variante-update");
  formUpdate.onsubmit = (e) => {
    e.preventDefault();

    let img = document.querySelector("#selected--image-variante-update");
    let submit = document.querySelector("#submit--variante_update")

    submit.disabled = "true"

    let options = {
      action: "update_variante",
      data: {
        id_variante: idVariante,
        nome_variante: e.currentTarget.nome_variante_update.value,
        codice_colore: e.currentTarget.codice_colore_update.value,
        url_variante: img.src,
      },
    };

    console.log(options)

    jQuery.ajax({
      dataType: "json",
      method: "POST",
      url: "admin-ajax.php",
      data: options,
      success: (response) => {
        submit.removeAttribute("disabled")
        dialogUpdate.close();
        getVarianti();
        showToast(response);
      },
    });
  };
};

const cancellaVariante = (e) => {
  let idVariante = e.currentTarget.dataset.id;

  let options = {
    action: "delete_variante",
    data: { id_variazione: idVariante },
  };

  jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      getVarianti();
      showToast(response);
    },
  });
};

getVarianti();
