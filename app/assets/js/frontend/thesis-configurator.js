function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

const order = {
  rilegature: [],
  pagine: {
    bn: [],
    colorate: [],
  },
  cd: {},
};

const formOrder = document.querySelector("#rilegature_form");

let currentStep = 0;

const config = [
  {
    step: "frontespizio",
    nav: document.querySelector("#frontespizio"),
    sidebar: document.querySelector("#frontespizio_step"),
    content: document.querySelector(".thesis--frontespizio"),
    isCompleted: true,
  },
  {
    step: "tipologia",
    nav: document.querySelector("#tipologia"),
    sidebar: document.querySelector("#tipologia_step"),
    content: document.querySelector(".thesis--tipologia"),
    isCompleted: true,
  },
  {
    step: "rilegatura",
    nav: document.querySelector("#rilegature"),
    sidebar: document.querySelector("#rilegature_step"),
    content: document.querySelector(".thesis--rilegature"),
    isCompleted: true,
  },
  {
    step: "pagine",
    nav: document.querySelector("#pagine"),
    sidebar: document.querySelector("#pagine_step"),
    content: document.querySelector(".thesis--pagine"),
    isCompleted: true,
  },
  {
    step: "cd",
    nav: document.querySelector("#cd"),
    sidebar: document.querySelector("#cd_step"),
    content: document.querySelector(".thesis--cd"),
    isCompleted: true,
  },
];

let numPages = 0,
  generated = false;

const preload = (url) => (new Image().src = url);

document
  .querySelectorAll(".thesis--sidebar > div")
  .forEach((item) => item.classList.add("hidden"));
document
  .querySelectorAll(".thesis--fragments > div")
  .forEach((item) => item.classList.add("hidden"));
document.querySelector(".thesis--fragments > div").classList.remove("hidden");

config.forEach((item, index) => {
  if (item.sidebar.id === "frontespizio_step")
    item.sidebar.classList.remove("hidden");

  if (!item.isCompleted) {
    item.nav.disabled = "true";
    item.nav.classList.add("opacity-50");
  } else {
    item.nav.onclick = (e) => {
      if (item.step === "pagine" && generated === false) generaPagine();

      document
        .querySelectorAll(".route")
        .forEach((item) => item.classList.remove("active"));
      document
        .querySelectorAll(".thesis--fragments > div")
        .forEach((item) => item.classList.add("hidden"));

      e.currentTarget.classList.add("active");

      item.content.classList.remove("hidden");

      document
        .querySelectorAll(".thesis--sidebar > div")
        .forEach((item) => item.classList.add("hidden"));

      item.sidebar.classList.remove("hidden");

      currentStep = index;
    };

    item.sidebar.querySelectorAll(".next-step").forEach((button) => {
      button.onclick = (e) => {
        if (e.currentTarget.nextElementSibling) {
          e.currentTarget.nextElementSibling.classList.remove("selected");
        } else if (e.currentTarget.previousElementSibling) {
          e.currentTarget.previousElementSibling.classList.remove("selected");
        }

        e.currentTarget.classList.add("selected");
        document
          .querySelectorAll(".route")
          .forEach((item) => item.classList.remove("active"));
        document
          .querySelector(".thesis--navigation")
          .children[currentStep + 1].classList.add("active");
        document
          .querySelector(".thesis--sidebar")
          .children[currentStep].classList.add("hidden");
        document
          .querySelector(".thesis--sidebar")
          .children[currentStep + 1].classList.remove("hidden");
        document
          .querySelector(".thesis--fragments")
          .children[currentStep].classList.add("hidden");
        document
          .querySelector(".thesis--fragments")
          .children[currentStep + 1].classList.remove("hidden");

        currentStep++;
      };
    });
  }
});

let images = {
  fronte: "/wp-content/plugins/thesis/app/assets/img/mockup-fronte.png",
  fronteRetro:
    "/wp-content/plugins/thesis/app/assets/img/mockup-fronte-retro.png",
};

for (let image in images) {
  let preloaded = new Image();
  preloaded.src = preload(images[image]);
  preloaded.className = "w-full h-2/3 drop-shadow-md object-contain p-4";
  images[image] = preloaded;
}

const fronte = document.querySelector("#fronte");
const fronteRetro = document.querySelector("#fronte-retro");

fronte.onmouseenter = () => {
  document.querySelector(".tipologia > img").remove();
  document.querySelector(".tipologia").append(images.fronte);
};
fronteRetro.onmouseenter = () => {
  document.querySelector(".tipologia > img").remove();
  document.querySelector(".tipologia").append(images.fronteRetro);
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

const generaFrontespizio = () => {
  jQuery.ajax({
    dataType: "json",
    method: "POST",
    url: ajaxurl,
    data: {
      action: "genera_frontespizio",
      data: {
        uuid: getCookie("thesis_session"),
        rgb: [192, 192, 192],
      },
    },
    success: (response) => {
      return response;
    },
  });
};

const getColori = async (id) => {
  const listaColori = document.querySelector(".colori_carattere > div");
  listaColori.replaceChildren();
  listaColori.classList.add(
    "animate-pulse",
    "min-h-[2rem]",
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

formOrder.onsubmit = (e) => {
  e.preventDefault();

  if (!checkFields()) return;

  let rilegatura = document.querySelector("[name='rilegatura']:checked");
  let variante = document.querySelector("[name='variante']:checked");
  let colore = document.querySelector("[name='colori_carattere']:checked");
  let qty = document.querySelector("[name='quantita']");

  order.rilegature.push({
    id_rilegatura: rilegatura.value,
    id_variante: variante.value,
    id_colore: colore.value,
    qty: qty.value,
  });

  e.currentTarget.reset();

  console.log(order);
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

const generaPagine = async () => {
  let getNumPages = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: ajaxurl,
    data: {
      action: "get_num_pagine",
      uuid: getCookie("thesis_session"),
    },
    success: (response) => {
      return JSON.parse(response.data);
    },
  });

  numPages = JSON.parse(getNumPages.data).results;

  // Contatore persistente
  let counter = 0;
  const progresso = document.querySelector("#progresso--pagine");

  if (!generated) {
    await Promise.all(
      Array.from({ length: numPages }, async (_, i) => {
        await jQuery.ajax({
          dataType: "json",
          method: "POST",
          url: ajaxurl,
          data: {
            action: "genera_pagine",
            data: {
              uuid: getCookie("thesis_session"),
              num_pagina: i,
            },
          },
          success: () => {
            // Evita di far rimbalzare il progresso
            if (i > counter) counter = i;
            progresso.textContent = `Pagina ${counter + 1} di ${numPages}`;
          },
        });
      })
    ).then(() => {
      creaPagine()
      generated = true; // Evita di rigenerare le pagine
    });
  }
};

const creaPagine = () => {
  const pagineWrapper = document.querySelector(".thesis--pagine");

  pagineWrapper.replaceChildren();

  let pagineContainer = document.createElement("div");

  pagineContainer.classList.add(
    "grid",
    "grid-cols-3",
    "gap-4",
    "overflow-auto"
  );

  for (let i = 0; i < numPages; i++) {
    let pagina = new Image();
    pagina.src =
      "/wp-content/plugins/thesis/app/files/" +
      getCookie("thesis_session") +
      "/pagine/pagina-" +
      i +
      ".jpg";

    pagina.classList.add("p-4");

    let zoomIn = document.createElement("a");
    zoomIn.href = pagina.src;

    zoomIn.dataset.fancybox = "gallery";

    zoomIn.appendChild(pagina);

    pagineContainer.appendChild(zoomIn);
  }

  Fancybox.bind("[data-fancybox='gallery']");

  pagineWrapper.classList.replace("items-center", "self-start");

  pagineWrapper.appendChild(pagineContainer);
};

generaFrontespizio();
getOpzioni();


/* Preloader */

window.onload = () => {
  let preloader = gsap.fromTo(
    "#preloader",
    { opacity: 1 },
    {
      opacity: 0,
      onComplete: () => {
        document.querySelector("#preloader").classList.add("hidden");
      },
    }
  );

  // preloader.pause();
};

// Lightbox

Fancybox.bind("[data-fancybox]");
