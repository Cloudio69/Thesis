const listSegnalibri = document.querySelector("#list--segnalibri");
const aggiungiSegnalibro = document.querySelector("#aggiungi--segnalibri");
const dialogSegnalibro = document.querySelector("#dialog--segnalibri");
const formSegnalibro = document.querySelector("#form--segnalibro");

jQuery.ajax({
  dataType: "json",
  method: "GET",
  url: "admin-ajax.php",
  data: {
    action: "get_segnalibri",
  },
  success: (response) => {
    res = JSON.parse(response.data);
    results = JSON.parse(res.results);
    getSegnalibri(results);
  },
});

const getSegnalibri = (results) => {
  if (results.length === 0) {
    listSegnalibri.removeAttribute("class");
    listSegnalibri.innerHTML = "Non ci sono segnalibri.";
  } else {
    listSegnalibri.removeAttribute("class");
    listSegnalibri.classList.add("grid", "gap-4", "lg:grid-cols-5", "md:grid-cols-2");

    results.forEach((segnalibro) => {
      let segnalibroCard = document.createElement("div");
      segnalibroCard.classList.add(
        "bg-white",
        "shadow-md",
        "rounded-lg",
        "p-4",
        "flex",
        "flex-col",
        "justify-between"
      );

      let segnalibroNome = document.createElement("h2");
      segnalibroNome.textContent = segnalibro.nome_colore;
      segnalibroNome.classList.add("text-xl", "font-bold", "mt-2");

      let segnalibroButton = document.createElement("button");
      segnalibroButton.textContent = "Modifica";
      segnalibroButton.classList.add(
        "bg-blue-500",
        "text-white",
        "font-bold",
        "rounded-lg",
        "p-2",
        "mt-2",
        "hover:bg-blue-700"
      );

      segnalibroCard.appendChild(segnalibroNome);
      segnalibroCard.appendChild(segnalibroButton);

      listSegnalibri.appendChild(segnalibroCard);
    });
  }
};


aggiungiSegnalibro.onclick = () => {
  dialogSegnalibro.showModal();
};





