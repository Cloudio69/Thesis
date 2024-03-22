const idListaColori = document.querySelector("#lista--colori");
const idAssegnati = document.querySelector("#lista--colori-assegnati");
const associaColore = document.querySelector("#associa--colore");
const dialogColore = document.querySelector("#crea--colore");
const dialogAssoc = document.querySelector("#assoc--colore");
const buttonCreaColore = document.querySelector("#aggiungi--colore");
const formCreaColore = document.querySelector("#form--crea-colore");
const formAssociazioni = document.querySelector("#form--assoc-colore");
const coloreScelto = document.querySelector("#colore--scelto");

const getColori = async () => {
  const options = {
    action: "get_char_colors",
  };

  let colori = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      idListaColori.innerHTML = "";
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(colori.data);
  let results = JSON.parse(response.results);

  if (results.length === 0) {
    idListaColori.removeAttribute("class");
    idListaColori.innerHTML = "Non ci sono varianti";
  } else {
    idListaColori.removeAttribute("class");
    idListaColori.classList.add("grid", "grid-cols-3", "gap-4");
    results.forEach((colore) => {
      let wrapperColore = document.createElement("div");
      wrapperColore.classList.add(
        "border",
        "rounded-md",
        "flex",
        "flex-col",
        "items-center",
        "justify-between",
        "overflow-hidden",
        "relative"
      );
      idListaColori.appendChild(wrapperColore);

      let nomeColore = document.createElement("h3");
      nomeColore.classList.add("p-4", "text-center");
      nomeColore.innerHTML = `${colore.nome_colore}<br><span class='font-bold uppercase'>${colore.hex_colore}</span>`;
      wrapperColore.appendChild(nomeColore);

      let hexColore = document.createElement("span");
      hexColore.style.background = colore.hex_colore;
      hexColore.classList.add("shadow-md", "w-full", "h-1");

      wrapperColore.appendChild(hexColore);

      let deleteColore = document.createElement("span");
      deleteColore.classList.add(
        "material-symbols-outlined",
        "absolute",
        "top-0",
        "right-0",
        "text-sm",
        "px-0.5",
        "cursor-pointer"
      );
      deleteColore.textContent = "close";
      deleteColore.dataset.id = colore.id_colore_carattere;

      deleteColore.onclick = (e) => cancellaColore(e);

      wrapperColore.appendChild(deleteColore);
    });
  }
};

const cancellaColore = async (e) => {
  let id = e.currentTarget.dataset.id;
  const options = {
    action: "delete_char_colors",
    data: {
      id_colore_carattere: id,
    },
  };

  let colori = await jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      getColori();
      showToast(response);
    },
  });
};

formCreaColore.hex_colore.onchange = (e) => {
  coloreScelto.textContent = e.currentTarget.value;
};
formCreaColore.hex_colore.oninput = (e) => {
  coloreScelto.textContent = e.currentTarget.value;
};

formCreaColore.onsubmit = async (e) => {
  e.preventDefault();

  document.querySelector("#submit--colore").disabled = "true";

  const options = {
    action: "post_char_colors",
    data: {
      nome_colore: e.currentTarget.nome_colore.value,
      hex_colore: e.currentTarget.hex_colore.value,
    },
  };

  let colori = await jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      document.querySelector("#submit--colore").removeAttribute("disabled");
      dialogColore.close();
      getColori();
      getColoriAssegnati();
      showToast(response);
    },
  });
};

buttonCreaColore.onclick = () => {
  dialogColore.showModal();
};

const getColoriAssegnati = async () => {
  const options = {
    action: "get_char_assoc",
  };

  let colori = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      idAssegnati.innerHTML = "";
      idAssegnati.removeAttribute("class");
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(colori.data);
  let results = JSON.parse(response.results);

  const raggruppaPerId = (array) => {
    const raggruppato = {};

    array.forEach((oggetto) => {
      const { id_rilegatura } = oggetto;

      if (!raggruppato[id_rilegatura]) {
        raggruppato[id_rilegatura] = [];
      }

      raggruppato[id_rilegatura].push(oggetto);
    });

    return raggruppato;
  };

  if (results.length === 0) {
    idAssegnati.innerHTML = "Nessun colore assegnato.";
  } else {
    const oggettiRaggruppati = raggruppaPerId(results);

    creaAssocHTML(oggettiRaggruppati);

    document.querySelectorAll(".delete-assoc").forEach((item) => {
      item.onclick = async (e) => {
        let id = e.currentTarget.dataset.id;

        const options = {
          action: "delete_char_assoc",
          data: {
            id_associazione: id,
          },
        };

        let colori = await jQuery.ajax({
          dataType: "json",
          method: "POST",
          url: "admin-ajax.php",
          data: options,
          success: (response) => {
            getColoriAssegnati();
            showToast(response);
          },
        });
      };
    });
  }
};

const creaAssocHTML = (oggetti) => {
  idAssegnati.innerHTML = ""
  idAssegnati.classList.add(
    "flex",
    "flex-col",
    "gap-4",
    "overflow-auto",
    "max-h-[30vh]"
  );
  let gruppoCounter = 0;
  for (const id in oggetti) {
    const gruppo = oggetti[id];

    console.log(gruppo);

    const divGruppo = document.createElement("div");
    divGruppo.classList.add(
      "gruppo",
      "flex",
      "flex-col",
      "gap-4",
      "w-full",
      "p-4",
      "border",
      "rounded-md"
    );

    const titolo = document.createElement("h2");
    titolo.innerHTML = `<span class="opacity-50 font-semibold text-[12px]">Rilegatura | ID: <code>${gruppo[gruppoCounter].id_rilegatura}</code></span> ${gruppo[gruppoCounter].nome_rilegatura}`;
    titolo.classList.add("font-bold", "text-xl", "flex", "px-2", "flex-col");
    divGruppo.appendChild(titolo);

    const divList = document.createElement("div");
    divGruppo.appendChild(divList);
    divList.classList.add("w-full", "grid", "grid-cols-4", "gap-2");

    gruppo.forEach((oggetto) => {
      const coloreAssociato = document.createElement("p");
      coloreAssociato.innerHTML = `<div class="border rounded-md flex flex-col items-center justify-between overflow-hidden relative"><h3 class="p-4 text-center">${oggetto.nome_colore}<br><span class="font-bold">${oggetto.hex_colore}</span></h3><span class="shadow-md w-full h-1" style="background-color: ${oggetto.hex_colore};"></span><span class="delete-assoc material-symbols-outlined absolute top-0 right-0 text-sm px-0.5 cursor-pointer" data-id="${oggetto.id_associazione}">close</span></div>`;
      coloreAssociato.classList.add("flex-1");

      divList.appendChild(coloreAssociato);
    });

    idAssegnati.appendChild(divGruppo);
  }
};

associaColore.onclick = async () => {
  const colorList = document.querySelector("#color--list");

  const options = {
    action: "get_char_colors",
  };

  let colori = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      colorList.innerHTML = "";
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(colori.data);
  let results = JSON.parse(response.results);

  dialogAssoc.showModal();

  aggiungiListaRilegature();

  results.forEach((colore) => {
    let wrapperColore = document.createElement("label");
    wrapperColore.setAttribute("for", "colore-" + colore.id_colore_carattere);
    wrapperColore.classList.add(
      "border",
      "rounded-md",
      "flex",
      "flex-col",
      "items-center",
      "justify-between",
      "overflow-hidden",
      "relative"
    );
    colorList.appendChild(wrapperColore);

    let nomeColore = document.createElement("h3");
    nomeColore.classList.add("p-4", "text-center");
    nomeColore.innerHTML = `${colore.nome_colore}<br><span class='font-bold uppercase'>${colore.hex_colore}</span>`;
    wrapperColore.appendChild(nomeColore);

    let hexColore = document.createElement("span");
    hexColore.style.background = colore.hex_colore;
    hexColore.classList.add("shadow-md", "w-full", "h-1");

    wrapperColore.appendChild(hexColore);

    let checkboxColore = document.createElement("input");
    checkboxColore.classList.add(
      "absolute",
      "top-0",
      "right-0",
      "!p-2",
      "!m-1"
    );
    checkboxColore.type = "checkbox";
    checkboxColore.value = colore.id_colore_carattere;
    checkboxColore.name = "colore-" + colore.id_colore_carattere;
    checkboxColore.id = "colore-" + colore.id_colore_carattere;

    wrapperColore.appendChild(checkboxColore);
  });
};

const aggiungiListaRilegature = async () => {
  const selectRilegature = document.querySelector("#select--rilegature-colori");

  let options = {
    action: "get_rilegature",
  };

  let rilegature = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      selectRilegature.innerHTML = "";
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(rilegature.data);
  let results = JSON.parse(response.results);

  results.forEach((rilegatura) => {
    let option = document.createElement("option");
    option.value = rilegatura.id_rilegatura;
    option.innerHTML =
      rilegatura.id_rilegatura + " | " + rilegatura.nome_rilegatura;

    selectRilegature.append(option);
  });
};

formAssociazioni.onsubmit = (e) => {
  e.preventDefault();

  let submit = formAssociazioni.querySelector("#submit--associazione");
  submit.disabled = "true";

  let idRilegatura = e.currentTarget.select_colore.value;

  let arr = [];
  formAssociazioni
    .querySelectorAll("input[type='checkbox']")
    .forEach((checkbox) => {
      arr = [...arr, checkbox.checked ? checkbox.value : ""];
    });

  let idsColori = arr.filter((id) => id !== "");

  idsColori.forEach((id) => {
    const data = { id_rilegatura: idRilegatura, id_colore_carattere: id };

    const options = {
      action: "post_color_assoc",
      data: data,
    };

    jQuery.ajax({
      dataType: "json",
      method: "POST",
      url: "admin-ajax.php",
      data: options,
      success: (response) => {
        submit.removeAttribute("disabled")
        dialogAssoc.close();
        getColoriAssegnati();
        showToast(response)
      },
    });
  });
};

getColori();
getColoriAssegnati();
