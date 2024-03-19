const form = document.querySelector("#form--copertine");
const formUpdate = document.querySelector("#form--update-copertina");
const submit = document.querySelector("#submit--copertine");
const listCopertine = document.querySelector("#list--copertine");

const dialog = document.querySelector("#modal--thesis");
const dialogUpdate = document.querySelector("#update--thesis");
const showButton = document.querySelector("#aggiungi--copertina");
let img = document.querySelector("#selected--image");

const createElementCopertina = (copertina) => {
  listCopertine.classList.add("grid", "grid-cols-5", "gap-4");

  let wrapper = document.createElement("div");

  let nomeCopertina = document.createElement("h1");
  let descrizioneCopertina = document.createElement("p");
  let anteprimaCopertina = document.createElement("img");

  let optionsCopertina = document.createElement("button");
  let optionsButton = document.createElement("span");
  optionsButton.classList.add(
    "material-symbols-outlined",
    "rounded-md",
    "bg-white",
    "text-black",
    "text-md",
    "p-1",
    "shadow-md"
  );

  optionsButton.innerHTML = "more_vert";

  optionsCopertina.appendChild(optionsButton);

  optionsCopertina.classList.add(
    "absolute",
    "top-0",
    "right-0",
    "p-4",
    "option--list"
  );

  nomeCopertina.classList.add("text-xl", "font-bold", "overflow-anywhere", "text-center");

  nomeCopertina.innerHTML = copertina.nome_copertina;
  descrizioneCopertina.innerHTML = copertina.descrizione_copertina;
  anteprimaCopertina.src = copertina.anteprima_copertina;
  optionsButton.dataset.id = copertina.id_copertina;

  optionsButton.onclick = (e) => showOptions(e);

  anteprimaCopertina.classList.add("w-[300px]", "h-[300px]", "object-contain");

  wrapper.append(
    anteprimaCopertina,
    nomeCopertina,
    descrizioneCopertina,
    optionsCopertina
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
    "gap-2"
  );

  listCopertine.appendChild(wrapper);
};

const showCopertine = (results) => {
  const listCopertine = document.querySelector("#list--copertine");

  if (results.length === 0) {
    listCopertine.removeAttribute("class");
    listCopertine.innerHTML = "Non ci sono copertine.";
  } else {
    listCopertine.innerHTML = "";
    listCopertine.removeAttribute("class");
    results.forEach((copertina) => {
      createElementCopertina(copertina);
    });
  }
};

const getCopertine = () => {
  let options = {
    action: "get_copertine",
  };

  jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      showCopertine(results);
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
    action: "delete_copertina",
    data: { id_copertina: id },
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
        getCopertine();
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
        action: "update_copertina",
        data: {
          id_copertina: id,
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
        success: (response) => {
          getCopertine();
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

let mediaUpdate = document.querySelector(".update--copertina");

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

let resetUpdate = document.querySelector("#reset--copertine");

resetUpdate.onclick = () => {
  img.removeAttribute("src");
  img.classList.add("hidden");
  mediaUpdate.querySelector("span").classList.remove("hidden");
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
    success: (response) => {
      submit.removeAttribute("disabled");
      dialog.close();
      getCopertine();
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

getCopertine();
