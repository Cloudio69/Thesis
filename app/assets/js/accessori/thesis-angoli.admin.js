const listAngoli = document.querySelector("#list--angoli");
const aggiungiAngolo = document.querySelector("#aggiungi--angoli");
const modalAngolo = document.querySelector("#modal--angoli");
const formAngolo = document.querySelector("#form--angolo");

jQuery.ajax({
  dataType: "json",
  method: "GET",
  url: "admin-ajax.php",
  data: { action: "get_angoli" },
  success: (response) => {
    res = JSON.parse(response.data);
    results = JSON.parse(res.results);
    getAngoli(results);
  },
});

const getAngoli = (results) => {
  if (results.length === 0) {
    listAngoli.removeAttribute("class");
    listAngoli.innerHTML = "Non ci sono angoli.";
  } else {
    listAngoli.removeAttribute("class");
    listAngoli.classList.add("grid", "gap-4", "lg:grid-cols-5", "md:grid-cols-2");

    results.forEach((angolo) => {
      let angoloCard = document.createElement("div");
      angoloCard.classList.add(
        "bg-white",
        "shadow-md",
        "rounded-lg",
        "p-4",
        "flex",
        "flex-col",
        "justify-between"
      );

      let angoloImg = document.createElement("img");
      angoloImg.src = angolo.anteprima_angolo;
      angoloImg.classList.add("w-full", "h-48", "object-cover", "rounded-lg");

      let angoloNome = document.createElement("h2");
      angoloNome.textContent = angolo.nome_angolo;
      angoloNome.classList.add("text-xl", "font-bold", "mt-2");

      /* 
      let angoloPrezzo = document.createElement("span");
      angoloPrezzo.textContent = angolo.prezzo + "€";
      angoloPrezzo.classList.add("text-lg", "font-bold", "mt-2");
      */

      let angoloButton = document.createElement("button");
      angoloButton.textContent = "Modifica";
      angoloButton.classList.add(
        "bg-blue-500",
        "text-white",
        "font-bold",
        "rounded-lg",
        "p-2",
        "mt-2",
        "hover:bg-blue-600"
      );

      angoloButton.onclick = () => {
        let img = document.querySelector("#selected--image-angolo");
        let nome = formAngolo.nome_angolo.value;
        let immagine = img.src;

        jQuery.ajax({
          dataType: "json",
          method: "POST",
          url: "admin-ajax.php",
          data: {
            action: "update_angoli",
            data: {
              id: angolo.id,
              nome: nome,
              immagine: immagine,
            },
          },
          success: (response) => {
            listAngoli.replaceChildren();
            res = JSON.parse(response.data);
            results = JSON.parse(res.results);
            getAngoli(results);
          },
        });
      };

      let angoloButtonDelete = document.createElement("button");
      angoloButtonDelete.dataset.id = angolo.id_angolo;
      angoloButtonDelete.textContent = "Elimina";
      angoloButtonDelete.classList.add(
        "bg-red-500",
        "text-white",
        "font-bold",
        "rounded-lg",
        "p-2",
        "mt-2",
        "hover:bg-red-600"
      );

      angoloButtonDelete.onclick = (e) => {
        jQuery.ajax({
          dataType: "json",
          method: "POST",
          url: "admin-ajax.php",
          data: {
            action: "delete_angolo",
            data: { id: e.currentTarget.dataset.id },
          },
          success: (response) => {
            listAngoli.replaceChildren();
            res = JSON.parse(response.data);
            results = JSON.parse(res.results);
            getAngoli(results);
          },
        });
      };

      angoloCard.appendChild(angoloImg);
      angoloCard.appendChild(angoloNome);
      // angoloCard.appendChild(angoloPrezzo);
      angoloCard.appendChild(angoloButton);
      angoloCard.appendChild(angoloButtonDelete);

      listAngoli.appendChild(angoloCard);
    });
  }

  aggiungiAngolo.onclick = () => {
    modalAngolo.showModal();

    let mediaAngolo = document.querySelector(".select--angolo");

    mediaAngolo.onclick = (e) => {
      e.preventDefault();

      let img = document.querySelector("#selected--image-angolo");

      mediaAngolo.querySelector("span").classList.add("hidden");
      modalAngolo.close();
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
        modalAngolo.showModal();
      });

      mediaFrame.on("close", () => {
        modalAngolo.showModal();
      });
    };

    formAngolo.onsubmit = (e) => {
      e.preventDefault();

      listAngoli.removeAttribute("class");
      listAngoli.classList.add("animate-pulse");

      let img = document.querySelector("#selected--image-angolo");
      let nome = formAngolo.nome_angolo.value;
      let immagine = img.src;

      jQuery.ajax({
        dataType: "json",
        method: "POST",
        url: "admin-ajax.php",
        data: {
          action: "post_angoli",
          data: {
            nome: nome,
            prezzo: 0,
            immagine: immagine,
          },
        },
        success: (response) => {
          listAngoli.replaceChildren();
          res = JSON.parse(response.data);
          results = JSON.parse(res.results);
          getAngoli(results);
        },
      });
    };
  };
};
