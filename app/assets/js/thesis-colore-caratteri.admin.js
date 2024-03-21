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

const cancellaColore = (e) => {
    console.log(e.currentTarget.dataset.id)
}

formCreaColore.hex_colore.onchange = (e) => {
  coloreScelto.textContent = e.currentTarget.value
}


buttonCreaColore.onclick = () => {
  dialogColore.showModal();
}


getColori();
