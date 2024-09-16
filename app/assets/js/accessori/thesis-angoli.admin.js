const listAngoli = document.querySelector("#list--angoli");
const aggiungiAngolo = document.querySelector("#aggiungi--angoli");
const modalAngolo = document.querySelector("#modal--angoli");
const formAngolo = document.querySelector("#form--angolo");


const getAngoli = async () => {

  let results = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: { action: "get_angoli" },
    success: (response) => {
      res = JSON.parse(response.data);
      inObj = JSON.parse(res.results);
     
      return inObj;
    },
  });

  // Che cazzo di casino che merda di codice

  results = JSON.parse(await results.data)
  results = JSON.parse(await results.results);

  if (results.length === 0) {
    listAngoli.removeAttribute("class");
    listAngoli.innerHTML = "Non ci sono angoli.";
  } else {
    listAngoli.removeAttribute("class");
    listAngoli.classList.add("grid", "gap-4", "grid-cols-3");

    results.forEach((angolo) => {
      let angoloCard = document.createElement("div");
      angoloCard.classList.add(
        "bg-white",
        "shadow-md",
        "rounded-lg",
        "p-4",
        "flex",
        "items-center",
        "justify-between"
      );

      let angoloNome = document.createElement("h2");
      angoloNome.textContent = angolo.nome_angolo;
      angoloNome.classList.add("text-sm", "font-bold");

      /* 
      let angoloPrezzo = document.createElement("span");
      angoloPrezzo.textContent = angolo.prezzo + "€";
      angoloPrezzo.classList.add("text-lg", "font-bold", "mt-2");
      */

      let actionWrapper = document.createElement("div");
      actionWrapper.classList.add("flex", "items-center", "justify-center");

      let angoloButtonDelete = document.createElement("button");
      angoloButtonDelete.dataset.id = angolo.id_angolo;
      angoloButtonDelete.innerHTML = "<span class=\"material-symbols-outlined\"> delete </span>";
      angoloButtonDelete.classList.add(
        "text-amber-300",
        "text-sm",
        "flex",
        "items-center",
        "font-bold",
        "rounded-lg",
        "p-2",
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
            getAngoli();
          },
        });
      };
      

      actionWrapper.appendChild(angoloButtonDelete);

      angoloCard.appendChild(angoloNome);
      angoloCard.appendChild(actionWrapper);

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


getAngoli();