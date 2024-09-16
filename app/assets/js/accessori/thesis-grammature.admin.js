const listGrammature = document.querySelector("#list--grammature");
const aggiungiGrammatura = document.querySelector("#aggiungi--grammature");
const dialogGrammatura = document.querySelector("#dialog--grammature");

jQuery.ajax({
  dataType: "json",
  method: "GET",
  url: "admin-ajax.php",
  data: {
    action: "get_grammature",
  },
  success: (response) => {
    res = JSON.parse(response.data);
    results = JSON.parse(res.results);
    getGrammature(results);
  },
});

const getGrammature = (results) => {
  if (results.length === 0) {
    listGrammature.removeAttribute("class");
    listGrammature.innerHTML = "Non ci sono grammature.";
  } else {
    listGrammature.removeAttribute("class");
    listGrammature.classList.add("grid", "gap-4", "grid-cols-3");

    results.forEach((grammatura) => {
      let grammaturaCard = document.createElement("div");
      grammaturaCard.classList.add(
        "bg-white",
        "shadow-md",
        "rounded-lg",
        "p-4",
        "flex",
        "items-center",
        "justify-between"
      );

      let grammaturaNome = document.createElement("h2");
      grammaturaNome.textContent = grammatura.nome_grammatura;
      grammaturaNome.classList.add("text-sm", "font-bold");

      let grammaturaButton = document.createElement("button");
      grammaturaButton.innerHTML = "<span class='material-symbols-outlined'>delete</span>";
      grammaturaButton.classList.add(
        "text-amber-300",
        "text-sm",
        "flex",
        "items-center",
        "font-bold",
        "rounded-lg",
        "p-2",
        "hover:bg-red-600"
      );


      grammaturaCard.appendChild(grammaturaNome);
      grammaturaCard.appendChild(grammaturaButton);

      listGrammature.appendChild(grammaturaCard);
    });
  }
};

aggiungiGrammatura.onclick = () => {  
  dialogGrammatura.showModal();
};


