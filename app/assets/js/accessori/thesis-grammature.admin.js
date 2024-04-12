const listGrammature = document.querySelector("#list--grammature");

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
    listGrammature.classList.add("grid", "gap-4", "lg:grid-cols-5", "md:grid-cols-2");

    results.forEach((grammatura) => {
      let grammaturaCard = document.createElement("div");
      grammaturaCard.classList.add(
        "bg-white",
        "shadow-md",
        "rounded-lg",
        "p-4",
        "flex",
        "flex-col",
        "justify-between"
      );

      let grammaturaNome = document.createElement("h2");
      grammaturaNome.textContent = grammatura.nome_grammatura;
      grammaturaNome.classList.add("text-xl", "font-bold", "mt-2");

      let grammaturaButton = document.createElement("button");
      grammaturaButton.textContent = "Modifica";
      grammaturaButton.classList.add(
        "bg-blue-500",
        "text-white",
        "font-bold",
        "rounded-lg",
        "p-2",
        "mt-2",
        "hover:bg-blue-700"
      );

      grammaturaCard.appendChild(grammaturaNome);
      grammaturaCard.appendChild(grammaturaButton);

      listGrammature.appendChild(grammaturaCard);
    });
  }
};


