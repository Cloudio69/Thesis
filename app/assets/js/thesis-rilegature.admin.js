const form = document.querySelector("#form--rilegature");
const formUpdate = document.querySelector("#form--update-rilegatura");
const submit = document.querySelector("#submit--rilegature");
const listRilegature = document.querySelector("#list--rilegature");

const dialog = document.querySelector("#modal--thesis");
const dialogUpdate = document.querySelector("#update--thesis");
const showButton = document.querySelector("#aggiungi--rilegatura");
let img = document.querySelector("#selected--image");

const createElementRilegatura = (rilegatura) => {
  listRilegature.classList.add("grid", "grid-cols-5", "gap-4");

  let wrapper = document.createElement("div");

  let detailsRilegatura = document.createElement("div");

  let nomeRilegatura = document.createElement("h1");
  let descrizioneRilegatura = document.createElement("p");
  let prezzoRilegatura = document.createElement("b");

  let anteprimaRilegatura = document.createElement("img");

  let optionsRilegatura = document.createElement("button");
  let optionsButton = document.createElement("span");
  optionsButton.classList.add(
    "material-symbols-outlined",
    "rounded-md",
    "bg-white",
    "text-black",
    "text-md",
    "p-1",
    "border",
    "shadow-md"
  );

  optionsButton.innerHTML = "more_vert";

  optionsRilegatura.appendChild(optionsButton);

  optionsRilegatura.classList.add(
    "absolute",
    "top-0",
    "right-0",
    "p-4",
    "option--list"
  );

  nomeRilegatura.classList.add(
    "text-xl",
    "font-bold",
    "overflow-anywhere",
    "text-center"
  );

  nomeRilegatura.innerHTML = rilegatura.nome_rilegatura;
  descrizioneRilegatura.innerHTML = rilegatura.descrizione_rilegatura;
  prezzoRilegatura.innerHTML = "€ " + rilegatura.prezzo_rilegatura;
  anteprimaRilegatura.src = rilegatura.anteprima_rilegatura;
  optionsButton.dataset.id = rilegatura.id_rilegatura;

  optionsButton.onclick = (e) => showOptions(e);

  anteprimaRilegatura.classList.add("w-[300px]", "h-[300px]", "object-contain");

  detailsRilegatura.append(nomeRilegatura, descrizioneRilegatura);

  detailsRilegatura.classList.add(
    "flex",
    "flex-col",
    "items-center",
    "w-full",
    "gap-2"
  );

  prezzoRilegatura.classList.add(
    "absolute",
    "top-0",
    "left-0",
    "m-4",
    "p-2",
    "bg-white",
    "border",
    "shadow-md",
    "text-black",
    "rounded-md"
  );

  wrapper.append(
    anteprimaRilegatura,
    detailsRilegatura,
    prezzoRilegatura,
    optionsRilegatura
  );

  wrapper.classList.add(
    "rounded-md",
    "flex",
    "flex-col",
    "p-4",
    "border",
    "justify-center",
    "shadow-sm",
    "items-center",
    "relative",
    "gap-2",
  );

  listRilegature.appendChild(wrapper);
};

const showRilegature = (results) => {
  const listRilegature = document.querySelector("#list--rilegature");

  if (results.length === 0) {
    listRilegature.removeAttribute("class");
    listRilegature.innerHTML = "Non ci sono rilegature.";
  } else {
    listRilegature.innerHTML = "";
    listRilegature.removeAttribute("class");
    results.forEach((rilegatura) => {
      createElementRilegatura(rilegatura);
    });
  }
};

const getRilegature = () => {
  let options = {
    action: "get_rilegature",
  };

  jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      showRilegature(results);
    },
  });
};

const showOptions = (e) => {
  if (e.currentTarget.parentElement.querySelector("ul")) {
    e.currentTarget.parentElement.querySelector("ul").remove();
    return;
  }
  const id = e.currentTarget.dataset.id;

  let options = {
    action: "delete_rilegatura",
    data: { id_rilegatura: id },
  };

  let optionList = document.createElement("ul");
  optionList.classList.add(
    "bg-white",
    "rounded-md",
    "divide-y",
    "absolute",
    "z-50",
    "shadow-md",
    "flex",
    "flex-col",
    "justify-center",
    "overflow-hidden"
  );

  let deleteButton = document.createElement("li");
  deleteButton.innerHTML = "Elimina";
  let updateButton = document.createElement("li");
  updateButton.innerHTML = "Modifica";

  deleteButton.classList.add("m-0", "cursor-pointer", "p-2");
  updateButton.classList.add("m-0", "cursor-pointer", "p-2");

  deleteButton.onclick = (e) => {
    e.currentTarget.classList.add("bg-red-700", "text-white");
    jQuery.ajax({
      dataType: "json",
      method: "POST",
      url: "admin-ajax.php",
      data: options,
      success: () => {
        getRilegature();
        getVarianti();
      },
    });
  };

  updateButton.onclick = (e) => {
    e.currentTarget.classList.add("bg-cyan-700", "text-white");

    dialogUpdate.showModal();

    formUpdate.onsubmit = (e) => {
      e.preventDefault();

      const img = document.querySelector("#updated--image");

      let options = {
        action: "update_rilegatura",
        data: {
          id_rilegatura: id,
          nome_rilegatura: e.currentTarget.nome_rilegatura.value,
          desc_rilegatura: e.currentTarget.descrizione_rilegatura.value,
          prezzo_rilegatura: e.currentTarget.prezzo_rilegatura.value,
          angoli: +e.currentTarget.angoli.value,
          url_rilegatura: img.src,
        },
      };

      jQuery.ajax({
        dataType: "json",
        method: "POST",
        url: "admin-ajax.php",
        data: options,
        success: (response) => {
          getRilegature();
          getVarianti();
          showToast(response);
        },
      });
    };
  };

  optionList.append(updateButton, deleteButton);

  e.currentTarget.parentElement.appendChild(optionList);
};

showButton.addEventListener("click", () => {
  dialog.showModal();
});

let mediaUpdate = document.querySelector(".update--rilegatura");

mediaUpdate.onclick = (e) => {
  e.preventDefault();

  let img = document.querySelector("#updated--image");

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

let mediaRilegatura = document.querySelector(".select--rilegatura");

mediaRilegatura.onclick = (e) => {
  e.preventDefault();

  mediaRilegatura.querySelector("span").classList.add("hidden");
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

let resetForm = document.querySelector("#reset--rilegature");

resetForm.onclick = () => {
  img.removeAttribute("src");
  img.classList.add("hidden");
  mediaRilegatura.querySelector("span").classList.remove("hidden");
};

let resetUpdate = document.querySelector("#reset--rilegature");

resetUpdate.onclick = () => {
  img.removeAttribute("src");
  img.classList.add("hidden");
  mediaUpdate.querySelector("span").classList.remove("hidden");
};

form.onsubmit = (e) => {
  e.preventDefault();
  submit.disabled = "true";

  let options = {
    action: "post_rilegature",
    data: {
      nome_rilegatura: e.currentTarget.nome_rilegatura.value,
      desc_rilegatura: e.currentTarget.descrizione_rilegatura.value,
      prezzo_rilegatura: parseFloat(e.currentTarget.prezzo_rilegatura.value),
      angoli: +e.currentTarget.angoli.value,
      url_rilegatura: img.src,
    },
  };

  jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      submit.removeAttribute("disabled");
      dialog.close();
      getRilegature();
      showToast(response);
    },
  });
};

const showToast = (response) => {
  const toast = document.querySelector("#toast");
  toast.classList.remove("hidden");
  toast.classList.add("flex");

  let icon = document.createElement("span");
  icon.classList.add("material-symbols-outlined");

  let messageJson = JSON.parse(response.data);

  if (response.success) {
    if (toast.classList.contains("bg-red-700")) {
      toast.classList.remove("bg-red-700");
      toast.classList.add("bg-green-700");
    }

    icon.innerHTML = "check";
    toast.querySelector(".icon").appendChild(icon);
    toast.querySelector(".body").innerHTML = messageJson.message;
  } else {
    icon.innerHTML = "warning";
    toast.classList.remove("bg-green-700");
    toast.classList.add("bg-red-700");
    toast.querySelector(".icon").appendChild(icon);
    toast.querySelector(".body").innerHTML = messageJson.message;
  }

  setTimeout(() => {
    toast.classList.add("hidden");
    toast.querySelector(".icon").innerHTML = "";
    toast.querySelector(".body").innerHTML = "";
  }, 5000);
};

getRilegature();
