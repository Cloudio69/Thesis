const imageCache = {};

const preloadAssets = () => {
  let assets = [
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/segnalibro-nero.png",
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/segnalibro-rosso.png",
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/segnalibro-verde.png",
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/segnalibro-blu.png",
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/segnalibro-dorato.png",
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/segnalibro-bianco.png",
    "/wp-content/plugins/thesis/app/assets/img/angoli/angoli-dorati.png",
    "/wp-content/plugins/thesis/app/assets/img/angoli/angoli-argentati.png",
  ];

  assets.forEach((asset) => {
    if (!imageCache[asset]) {
      const img = new Image();
      img.src = asset;
      imageCache[asset] = img;
    }
  });
};

preloadAssets();

const rigeneraCanvas = () => {
  let canvas = document.querySelector("canvas");
  let context = canvas.getContext("2d");

  if (!document.querySelector("[name='colori_carattere']:checked")) return;

  let frontespizioGen = new Image();
  frontespizioGen.src =
    "/wp-content/plugins/thesis/app/files/" +
    getCookie("thesis_session") +
    "/frontespizi/frontespizio_generato-" +
    document.querySelector("[name='colori_carattere']:checked").value +
    ".png";
  frontespizioGen.onload = () => {
    context.clearRect(0, 0, canvas.width, canvas.height);

    const varianteScelta = document
      .querySelector("[name='variante']:checked")
      .parentElement.querySelector("img");

    context.drawImage(varianteScelta, 0, 0, canvas.width, canvas.height);
    context.drawImage(frontespizioGen, 0, 0, canvas.width, canvas.height);

    const segnalibriValue = document.querySelector('[name="segnalibri"]').value;
    const angoliValue = document.querySelector('[name="angoli"]').value;

    if (segnalibriValue) {
      const img = imageCache[`/wp-content/plugins/thesis/app/assets/img/segnalibri/${segnalibriValue}.png`];
      if (img.complete) {
        context.drawImage(img, 0, 0, canvas.width, canvas.height);
      } else {
        img.onload = () => {
          context.drawImage(img, 0, 0, canvas.width, canvas.height);
        };
      }
    }

    if (angoliValue) {
      const img = imageCache[`/wp-content/plugins/thesis/app/assets/img/angoli/${angoliValue}.png`];
      if (img.complete) {
        context.drawImage(img, 0, 0, canvas.width, canvas.height);
      } else {
        img.onload = () => {
          context.drawImage(img, 0, 0, canvas.width, canvas.height);
        };
      }
    }
  };
};

const getOpzioni = async () => {
  let opzioni = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: ajaxurl,
    data: {
      action: "get_options",
    },
    success: (response) => {
      return response;
    },
  });

  let data = JSON.parse(opzioni.data);
  let results = JSON.parse(data.results);

  let groupedResults = raggruppaPerId(results);

  // Preload immagini varianti

  for (let property in groupedResults) {
    groupedResults[property].forEach((variante) => {
      let anteprimaVar = new Image();
      anteprimaVar.src = preload(variante.anteprima_variante);
      variante.anteprima_variante = anteprimaVar;
    });
  }

  const radioRilegatura = document.querySelectorAll("[name='rilegatura']");

  radioRilegatura.forEach((radio) => {
    radio.onclick = (e) => {
      let varianti = document.querySelector(".varianti div");
      varianti.className =
        "grid grid-cols-5 gap-4 items-center place-items-center text-center";
      let id = e.currentTarget.value;
      getColori(id);
      varianti.replaceChildren();

      groupedResults[id].forEach((variante) => {
        let varianteWrapper = document.createElement("label");
        let radioVariante = document.createElement("input");
        let titoloVariante = document.createElement("h3");

        titoloVariante.innerHTML = variante.nome_variante;
        titoloVariante.className = "font-bold";

        varianteWrapper.setAttribute("for", `variante-${variante.id_variante}`);

        varianteWrapper.classList.add(
          "w-full",
          "flex",
          "flex-col",
          "items-center",
          "justify-center",
          "gap-2",
          "p-4",
          "rounded-md",
          "bg-slate-50",
          "border"
        );

        radioVariante.type = "radio";
        radioVariante.name = "variante";
        radioVariante.classList.add("hidden");
        radioVariante.id = `variante-${variante.id_variante}`;
        radioVariante.value = variante.id_variante;

        let immagineVariante = variante.anteprima_variante.cloneNode();
        immagineVariante.classList.add(
          "w-full",
          "h-[64px]",
          "rounded-full",
          "object-cover",
          "overflow-hidden",
          "[clip-path:circle()]"
        );

        varianteWrapper.appendChild(immagineVariante);
        varianteWrapper.appendChild(titoloVariante);
        varianteWrapper.appendChild(radioVariante);

        varianti.appendChild(varianteWrapper);

        radioVariante.onclick = () => {
          let canvas = document.createElement("canvas");
          canvas.classList.add(
            "w-[25vw]",
            "h-full",
            "shadow-xl",
            "shadow-[#00000078]",
            "rounded-s"
          );

          let anteprima = document.querySelector(".rilegature");
          anteprima.replaceChildren();

          let zoomIn = document.createElement("a");
          zoomIn.href = "#";

          let anteprimaVariante = variante.anteprima_variante;
          anteprimaVariante.classList.add("shadow-xl");

          let context = canvas.getContext("2d");

          canvas.width = anteprimaVariante.width;
          canvas.height = anteprimaVariante.height;
          context.drawImage(anteprimaVariante, 0, 0);

          let frontespizioGen = new Image();
          if (!document.querySelector("[name='colori_carattere']:checked")) {
            frontespizioGen.src =
              "/wp-content/plugins/thesis/app/files/" +
              getCookie("thesis_session") +
              "/frontespizio_generato.png";
          } else {
            frontespizioGen.src =
              "/wp-content/plugins/thesis/app/files/" +
              getCookie("thesis_session") +
              "/frontespizi/frontespizio_generato-" +
              document.querySelector("[name='colori_carattere']:checked")
                .value +
              ".png";
          }

          frontespizioGen.onload = () =>
            context.drawImage(
              frontespizioGen,
              0,
              0,
              canvas.width,
              canvas.height
            );

          const segnalibriValue = document.querySelector('[name="segnalibri"]').value;
          const angoliValue = document.querySelector('[name="angoli"]').value;

          if (segnalibriValue) {
            const img = imageCache[`/wp-content/plugins/thesis/app/assets/img/segnalibri/${segnalibriValue}.png`];
            if (img.complete) {
              context.drawImage(img, 0, 0, canvas.width, canvas.height);
            } else {
              img.onload = () => {
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
              };
            }
          }

          if (angoliValue) {
            const img = imageCache[`/wp-content/plugins/thesis/app/assets/img/angoli/${angoliValue}.png`];
            if (img.complete) {
              context.drawImage(img, 0, 0, canvas.width, canvas.height);
            } else {
              img.onload = () => {
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
              };
            }
          }

          zoomIn.onclick = () => {
            let imgData = canvas.toDataURL();

            var img = new Image();
            img.src = imgData;

            img.classList.add("w-[25vw]", "h-full");

            new Fancybox([
              {
                src: img.src,
                type: "image",
              },
            ]);
          };

          zoomIn.appendChild(canvas);

          anteprima.appendChild(zoomIn);
        };
      });
    };
  });
};

const getColori = async (id) => {
  const listaColori = document.querySelector(".colori_carattere > div");
  listaColori.replaceChildren();
  listaColori.classList.add(
    "animate-pulse",
    "min-h-[125px]",
    "bg-slate-200",
    "rounded-md"
  );

  await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: ajaxurl,
    data: {
      action: "get_colori_carattere",
      data: {
        id_rilegatura: id,
      },
    },
    success: (response) => {
      listaColori.className = "";
      listaColori.classList.add(
        "grid",
        "grid-cols-5",
        "items-center",
        "justify-center",
        "place-items-center",
        "gap-4",
        "text-center"
      );

      let data = JSON.parse(response.data);
      let results = JSON.parse(data.results);

      results.forEach((colore) => {
        let label = document.createElement("label");
        let radio = document.createElement("input");

        radio.type = "radio";
        radio.value = colore.id_colore_carattere;
        radio.dataset.hex = colore.hex_colore;
        radio.id = `colore-${colore.id_colore_carattere}`;
        radio.name = "colori_carattere";

        radio.className = "hidden";

        label.setAttribute("for", radio.id);

        label.classList.add(
          "w-full",
          "flex",
          "flex-col",
          "items-center",
          "justify-center",
          "gap-2",
          "p-4",
          "rounded-md",
          "bg-slate-50",
          "border"
        );

        label.innerHTML = `<div class='rounded-full h-[64px] w-[64px]' style='background: ${colore.hex_colore}'></div><span>${colore.nome_colore}</span>`;
        label.appendChild(radio);

        listaColori.appendChild(label);

        radio.onclick = async (e) => {
          let body = document.querySelector(".thesis--fragments");
          let preloader = document.createElement("div");

          preloader.classList.add(
            "fixed",
            "flex",
            "w-full",
            "h-full",
            "justify-center",
            "items-center",
            "bg-slate-200",
            "opacity-75"
          );

          preloader.innerHTML =
            "<img src='/wp-content/plugins/thesis/app/assets/img/svg/loading.svg' class='animate-spin w-[48px] h-[48px]'/>";

          body.appendChild(preloader);

          const hexToRgb = (hex) => {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result
              ? [
                parseInt(result[1], 16),
                parseInt(result[2], 16),
                parseInt(result[3], 16),
              ]
              : null;
          };

          let hex = e.currentTarget.dataset.hex;
          await jQuery.ajax({
            dataType: "json",
            method: "POST",
            url: ajaxurl,
            data: {
              action: "genera_frontespizio",
              data: {
                uuid: getCookie("thesis_session"),
                rgb: hexToRgb(hex),
                id: colore.id_colore_carattere,
              },
            },
            success: (response) => {
              preloader.remove();
              let canvas = document.querySelector("canvas");
              let context = canvas.getContext("2d");

              let frontespizioGen = new Image();
              frontespizioGen.src =
                "/wp-content/plugins/thesis/app/files/" +
                getCookie("thesis_session") +
                "/frontespizi/frontespizio_generato-" +
                colore.id_colore_carattere +
                ".png";
              frontespizioGen.onload = () => {
                context.clearRect(0, 0, canvas.width, canvas.height);

                const varianteScelta = document
                  .querySelector("[name='variante']:checked")
                  .parentElement.querySelector("img");

                context.drawImage(
                  varianteScelta,
                  0,
                  0,
                  canvas.width,
                  canvas.height
                );

                context.drawImage(
                  frontespizioGen,
                  0,
                  0,
                  canvas.width,
                  canvas.height
                );

                const segnalibriValue = document.querySelector('[name="segnalibri"]').value;
                const angoliValue = document.querySelector('[name="angoli"]').value;

                if (segnalibriValue) {
                  const img = imageCache[`/wp-content/plugins/thesis/app/assets/img/segnalibri/${segnalibriValue}.png`];
                  if (img.complete) {
                    context.drawImage(img, 0, 0, canvas.width, canvas.height);
                  } else {
                    img.onload = () => {
                      context.drawImage(img, 0, 0, canvas.width, canvas.height);
                    };
                  }
                }

                if (angoliValue) {
                  const img = imageCache[`/wp-content/plugins/thesis/app/assets/img/angoli/${angoliValue}.png`];
                  if (img.complete) {
                    context.drawImage(img, 0, 0, canvas.width, canvas.height);
                  } else {
                    img.onload = () => {
                      context.drawImage(img, 0, 0, canvas.width, canvas.height);
                    };
                  }
                }
              };
            },
          });
        };
      });
    },
  });
};

const raggruppaPerId = (array) => {
  const raggruppato = {};

  array.forEach((oggetto) => {
    const { id_rilegatura } = oggetto;

    if (!raggruppato[id_rilegatura]) {
      raggruppato[id_rilegatura] = [];
    }

    raggruppato[id_rilegatura].push(oggetto);
  });

  return raggruppato;
};

const checkFields = () => {
  let rilegatura = document.querySelector("[name='rilegatura']:checked");
  let variante = document.querySelector("[name='variante']:checked");
  let colore = document.querySelector("[name='colori_carattere']:checked");

  if (!rilegatura || !variante || !colore) {
    alert("Devi selezionare tutte le opzioni per procedere con l'ordine.");
    return false;
  }

  return true;
};

const rilegature = document.querySelectorAll(".rilegatura");
rilegature.forEach((rilegatura) => {
  rilegatura.onclick = () => {
    let nome = rilegatura.querySelector('[type="radio"]').dataset.nome;
    let desc = rilegatura.querySelector('[type="radio"]').dataset.descrizione;
    // Replace backslashes
    desc = desc.replace(/\\/g, "");
    let nomeContainer = document.querySelector(
      ".rilegature_riepilogo"
    ).previousElementSibling;
    let descContainer = document.querySelector(".rilegature_riepilogo p");
    descContainer.textContent = desc;
    nomeContainer.textContent = nome;
  };
});

const fileUpload = document.querySelector("#upload_frontespizio");

fileUpload.onchange = (e) => {
  if (
    !e.currentTarget.files[0] ||
    e.currentTarget.files[0].type !== "application/pdf"
  ) {
    console.error("Errore nel caricamento file.");
    return;
  }

  // Preloader
  let preloader = document.querySelector("#preloader");
  preloader.classList.remove("hidden");
  preloader.style.opacity = 1;

  let progress = document.createElement("progress");
  progress.classList.add(
    "w-full",
    "h-1",
    "bg-slate-200",
    "rounded-md",
    "animate-pulse",
    "fixed",
    "bottom-0"
  );
  preloader.appendChild(progress);

  let data = new FormData();
  data.append("action", "upload_frontespizio");
  data.append("nonce", nonce);
  data.append("file", e.currentTarget.files[0]);

  jQuery.ajax({
    processData: false,
    contentType: false,
    type: "POST",
    url: ajaxurl,
    data: data,
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener(
        "progress",
        function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = Math.round(percentComplete * 100);
            progress.value = percentComplete;
            // console.log(percentComplete);
          }
        },
        false
      );
      return xhr;
    },
    success: (response) => {
      let frontespizio = document.querySelector(".thesis--frontespizio img");
      frontespizio.src =
        "/wp-content/plugins/thesis/app/files/" +
        getCookie("thesis_session") +
        "/frontespizio.jpg?" +
        new Date().getTime();

      jQuery.ajax({
        method: "POST",
        url: ajaxurl,
        data: {
          action: "clear_all_frontespizi",
          data: {
            uuid: getCookie("thesis_session"),
          },
        },
        success: (response) => {
          console.log(response);
        },
        error: (error) => {
          console.error(error);
        },
      });
      window.location.reload();
    },
  });
};

const segnalibroSelect = document.querySelector("[name='segnalibri']");
segnalibroSelect.onchange = (e) => {
  let img = new Image();
  img.src =
    "/wp-content/plugins/thesis/app/assets/img/segnalibri/" +
    e.currentTarget.value +
    ".png";

  img.onload = () => {
    let canvas = document.querySelector("canvas");
    let context = canvas.getContext("2d");

    rigeneraCanvas();
    context.drawImage(img, 0, 0, canvas.width, canvas.height);
  };
};

const angoliSelect = document.querySelector("[name='angoli']");
angoliSelect.onchange = (e) => {
  let img = new Image();
  img.src =
    "/wp-content/plugins/thesis/app/assets/img/angoli/" + e.currentTarget.value + ".png";

  img.onload = () => {
    let canvas = document.querySelector("canvas");
    let context = canvas.getContext("2d");

    rigeneraCanvas();
    context.drawImage(img, 0, 0, canvas.width, canvas.height);
  };
};



getOpzioni();
