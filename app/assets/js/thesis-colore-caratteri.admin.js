const idListaColori = document.querySelector("#lista--colori");

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
        "overflow-hidden"
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
    });
  }
};

getColori();
