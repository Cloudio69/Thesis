const idListaColori = document.querySelector("#lista--colori");
const dialogColore = document.querySelector("#crea--colore")
const buttonCreaColore = document.querySelector("#aggiungi--colore")
const formCreaColore = document.querySelector("#form--crea-colore")
const coloreScelto = document.querySelector("#colore--scelto")

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
    idListaColori.removeAttribute("class")
    idListaColori.innerHTML = "Non ci sono varianti";
  } else {
    idListaColori.removeAttribute("class")
    idListaColori.classList.add("grid", "grid-cols-3", "gap-4")
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
      nomeColore.classList.add("p-4", "text-center")
      nomeColore.innerHTML = `${colore.nome_colore}<br><span class='font-bold'>${colore.hex_colore}</span>`
      wrapperColore.appendChild(nomeColore)

      let hexColore = document.createElement("span");
      hexColore.style.background = colore.hex_colore;
      hexColore.classList.add("shadow-md", "w-full", "h-1")

      wrapperColore.appendChild(hexColore)

      let deleteColore = document.createElement("span")
      deleteColore.classList.add("material-symbols-outlined", "absolute", "top-0", "right-0", "text-sm", "px-0.5", "cursor-pointer");
      deleteColore.textContent = "close"
      deleteColore.dataset.id = colore.id_colore_carattere

      deleteColore.onclick = (e) => cancellaColore(e)

      wrapperColore.appendChild(deleteColore)

    });
  }
};

const cancellaColore = async (e) => {
    let id = e.currentTarget.dataset.id;
    const options = {
      action: "delete_char_colors",
      data: {
        id_colore_carattere: id
      }
    };
  
    let colori = await jQuery.ajax({
      dataType: "json",
      method: "POST",
      url: "admin-ajax.php",
      data: options,
      success: (response) => {
        getColori();
        showToast(response)
      },
    });
}

formCreaColore.hex_colore.onchange = (e) => {
  coloreScelto.textContent = e.currentTarget.value
}
formCreaColore.hex_colore.oninput = (e) => {
  coloreScelto.textContent = e.currentTarget.value
}

formCreaColore.onsubmit = async (e) => {
  e.preventDefault();

  const options = {
    action: "post_char_colors",
    data: {
      nome_colore: e.currentTarget.nome_colore.value,
      hex_colore: e.currentTarget.hex_colore.value
    }
  }

  let colori = await jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      getColori();
      showToast(response)
    },
  });

}

buttonCreaColore.onclick = () => {
  dialogColore.showModal();
}


getColori();
