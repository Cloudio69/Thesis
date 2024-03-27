const listAngoli = document.querySelector("#list--angoli");
const aggiungiAngolo = document.querySelector("#aggiungi--angoli");
const modalAngolo = document.querySelector("#modal--angoli");

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
  }
};

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
};
