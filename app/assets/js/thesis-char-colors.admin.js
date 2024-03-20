const wrapperColori = document.querySelector("#list--colors");

const creaColoriHTML = (oggettiRaggruppati) => {

  for (id in oggettiRaggruppati) {
    let gruppoCounter = 0;
    const gruppo = oggettiRaggruppati[id]

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
    titolo.innerHTML = `<span class="opacity-50 font-semibold text-[12px]">Copertina </span> ${gruppo[gruppoCounter].nome_copertina}`;
    titolo.classList.add("font-bold", "text-xl", "flex", "px-2", "flex-col");
    divGruppo.appendChild(titolo);

    const divList = document.createElement("div");
    divGruppo.appendChild(divList);
    divList.classList.add("w-full", "grid", "grid-cols-4", "gap-2");

    gruppo.forEach((oggetto) => {
      const card = document.createElement("div");
      card.classList.add(
        "rounded-md",
        "flex",
        "justify-between",
        "w-full",
        "p-4",
        "border",
        "shadow-md"
      );

      const nomeCopertina = document.createElement("p");
      nomeCopertina.innerHTML = `<div class='flex flex-col'><span class="opacity-50">NOME VARIANTE</span><span class="font-bold">${oggetto.nome_variazione}</span></div>`;
      nomeCopertina.classList.add("flex-1");
      card.appendChild(nomeCopertina);

      const idVariazione = document.createElement("p");
      idVariazione.innerHTML = `<div class='flex flex-col'><span class="opacity-50">COD. COLORE</span><span class="font-bold">${oggetto.codice_colore}</span></div>`;
      idVariazione.classList.add("flex-1");
      card.appendChild(idVariazione);

      divList.appendChild(card);

      gruppoCounter++;
    });

    wrapperColori.classList.add(
      "flex",
      "flex-col",
      "gap-4",
      "max-h-[60vh]",
      "overflow-auto"
    );

    wrapperColori.appendChild(divGruppo);
  }
};

const getGlobalVarianti = async () => {
  let options = {
    action: "get_char_colors",
  };

  let varianti = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      wrapperColori.removeAttribute("class");
      return results;
    },
  });

  let response = JSON.parse(varianti.data);
  let results = JSON.parse(response.results);

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
  // if (!oggettiRaggruppati) console.log(true);
  creaColoriHTML(oggettiRaggruppati);
};

getGlobalVarianti();
