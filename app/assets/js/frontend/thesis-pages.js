let prezzoPagine = {
  prezzo_bn: parseFloat(document.querySelector("#prezzo_bn b").textContent),
  prezzo_colorate: parseFloat(
    document.querySelector("#prezzo_colori b").textContent
  ),
  prezzo_grammatura: 0,
  prezzo_formato: 0,
  id_grammatura: null,
  id_formato: null,
};

let pagine = {
  bn: [],
  colorate: [],
}

function getAverageRGB(imgEl) {
  var blockSize = 5, // only visit every 5 pixels
    defaultRGB = { r: 0, g: 0, b: 0 }, // for non-supporting envs
    canvas = document.createElement("canvas"),
    context = canvas.getContext && canvas.getContext("2d"),
    data,
    width,
    height,
    i = -4,
    length,
    rgb = { r: 0, g: 0, b: 0 },
    count = 0;

  if (!context) {
    return defaultRGB;
  }

  height = canvas.height =
    imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
  width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

  context.drawImage(imgEl, 0, 0);

  try {
    data = context.getImageData(0, 0, width, height);
  } catch (e) {
    console.error(e);
    return defaultRGB;
  }

  length = data.data.length;

  while ((i += blockSize * 4) < length) {
    ++count;
    rgb.r += data.data[i];
    rgb.g += data.data[i + 1];
    rgb.b += data.data[i + 2];
  }

  // ~~ used to floor values
  rgb.r = ~~(rgb.r / count);
  rgb.g = ~~(rgb.g / count);
  rgb.b = ~~(rgb.b / count);
  return rgb;
}

let numPages = 0,
  generated = false;

const generaPagine = async () => {
  if (!generated) {
    let getNumPages = await jQuery.ajax({
      dataType: "json",
      method: "GET",
      url: ajaxurl,
      data: {
        action: "get_num_pagine",
        uuid: TGetCookie("thesis_session"),
      },
      success: (response) => {
        return JSON.parse(response.data);
      },
    });

    numPages = JSON.parse(getNumPages.data).results;

    if (numPages === 0) {
      let container = document.querySelector(".thesis--pagine");
      container.replaceChildren();
      container.innerHTML = `<span class='material-symbols-outlined text-8xl !text-red-500'>error</span><p class='text-center'>Impossibile generare pagine, riprova con un altro file altrimenti contatta l'assistenza</p>`;
      let retry = document.createElement("button");
      retry.textContent = "TORNA ALLA HOME";
      retry.classList.add(
        "rounded-md",
        "bg-red-500",
        "hover:bg-slate-400",
        "text-white",
        "border-none",
        "focus:bg-yellow-400",
        "disabled:animate-pulse",
        "px-4",
        "py-2",
        "mt-4"
      );
      retry.onclick = () => {
        window.location.href = "/";
      };

      container.appendChild(retry);
      throw new Error("No pages returned from the server.");
    }

    if (TGetCookie("thesis_page_generation") === "true") {
      creaPagine();
      updateColorCounter();
      generated = true;
      return;
    }

    // Contatore persistente
    let counter = 0;
    const progresso = document.querySelector("#progresso--pagine");

    const generatePagesBatch = async (start, end) => {
      await Promise.all(
        Array.from({ length: end - start }, async (_, i) => {
          let pageIndex = start + i;
          await jQuery.ajax({
            dataType: "json",
            method: "POST",
            url: ajaxurl,
            data: {
              action: "genera_pagine",
              data: {
                uuid: TGetCookie("thesis_session"),
                num_pagina: pageIndex,
              },
            },
            success: () => {
              if (progresso) {
                progresso.replaceChildren();

                if (pageIndex > counter) counter = pageIndex;
                progresso.textContent = `Pagina ${counter + 1} di ${numPages}`;
              } else {
                let container = document.querySelector(".thesis--pagine");
                container.replaceChildren();

                let progresso = document.createElement("p");
                let loadingSvg = document.createElement("img");
                loadingSvg.src =
                  "/wp-content/plugins/thesis/app/assets/img/svg/loading.svg";
                loadingSvg.classList.add("loading-svg");
                progresso.appendChild(loadingSvg);
                progresso.classList.add("text-center", "text-xl", "mb-4");
                progresso.textContent = `Pagina ${counter + 1} di ${numPages}`;
                container.appendChild(progresso);
              }
            },
            statusCode: {
              404: function () {
                console.error("Pagina non trovata");
              },
              502: function () {
                let container = document.querySelector(".thesis--pagine");
                container.replaceChildren();
                container.innerHTML =
                  "<span class='material-symbols-outlined text-8xl'>error</span><p class='text-center'>Si è verificato un errore durante la generazione delle pagine</p>";
                let retry = document.createElement("button");
                retry.textContent = "RIPROVA";
                retry.classList.add(
                  "rounded-md",
                  "bg-[#f4b424]",
                  "hover:bg-slate-400",
                  "text-white",
                  "border-none",
                  "focus:bg-yellow-400",
                  "disabled:animate-pulse",
                  "px-4",
                  "py-2",
                  "mt-4"
                );
                retry.onclick = () => {
                  window.location.reload();
                };

                container.appendChild(retry);
              },
              503: function () {
                let container = document.querySelector(".thesis--pagine");
                container.replaceChildren();
                container.innerHTML =
                  "<span class='material-symbols-outlined text-8xl'>error</span><p class='text-center'>Si è verificato un errore durante la generazione delle pagine</p>";
                let retry = document.createElement("button");
                retry.textContent = "RIPROVA";
                retry.classList.add(
                  "rounded-md",
                  "bg-[#f4b424]",
                  "hover:bg-slate-400",
                  "text-white",
                  "border-none",
                  "focus:bg-yellow-400",
                  "disabled:animate-pulse",
                  "px-4",
                  "py-2",
                  "mt-4"
                );
                retry.onclick = () => {
                  window.location.reload();
                };

                container.appendChild(retry);
              },
            },
          });
        })
      );
    };

    await generatePagesBatch(0, numPages);

    creaPagine();
    generated = true; // Evita di rigenerare le pagine
    TSetCookie("thesis_page_generation", "true", 1 / 720);
  }
};

let pagineTipologia = {
  bn: [],
  colorate: [],
};

let assets = {
  rgb: "/wp-content/plugins/thesis/app/assets/img/svg/rgb.svg",
  bn: "/wp-content/plugins/thesis/app/assets/img/svg/black-and-white.svg",
};

const creaPagine = async () => {
  const pagineWrapper = document.querySelector(".thesis--pagine");

  pagineWrapper.replaceChildren();

  let pagineContainer = document.createElement("div");

  pagineContainer.classList.add(
    "grid",
    "grid-cols-3",
    "gap-4",
    "overflow-auto",
    "mb-16"
  );

  for (let i = 0; i < numPages; i++) {
    let paginaWrapper = document.createElement("div");
    let colorSwitch = document.createElement("button");

    colorSwitch.dataset.pagina = i;

    colorSwitch.addEventListener("click", (e) => {

      if(!generated) return;

      // document.querySelector("#annulla_azioni").removeAttribute("disabled");
      let numPagina = e.currentTarget.dataset.pagina;
      let colorSrc = new URL(e.currentTarget.querySelector("img").src);

      if (colorSrc.pathname === assets.bn) {
        e.currentTarget.querySelector("img").src = assets.rgb;
        if (
          e.currentTarget.parentElement
            .querySelector("img")
            .classList.contains("grayscale")
        )
          e.currentTarget.parentElement
            .querySelector("img")
            .classList.remove("grayscale");
        pagineTipologia.colorate.push(
          pagineTipologia.bn.splice(
            pagineTipologia.bn.findIndex(
              (pagina) => pagina.pagina === parseInt(numPagina)
            ),
            1
          )[0]
        );


      } else {
        e.currentTarget.querySelector("img").src = assets.bn;
        pagineTipologia.bn.push(
          pagineTipologia.colorate.splice(
            pagineTipologia.colorate.findIndex(
              (pagina) => pagina.pagina === parseInt(numPagina)
            ),
            1
          )[0]
        );


        if (
          !e.currentTarget.parentElement
            .querySelector("img")
            .classList.contains("grayscale")
        )
          e.currentTarget.parentElement
            .querySelector("img")
            .classList.add("grayscale", "transition-all");
      }

      updateColorCounter();
    });

    paginaWrapper.classList.add("pagina--wrapper", "relative");

    colorSwitch.classList.add(
      "absolute",
      "bottom-6",
      "right-6",
      "rounded-full",
      "color-switch",
      "border-none",
      "hover:bg-transparent",
      "focus:outline-none",
      "focus:bg-transparent"
    );
    colorSwitch.innerHTML =
      "<img src='" +
      assets.bn +
      "' class='w-8 h-8 drop-shadow-md' data-pagina=" +
      i +
      "/>";

    let pagina = new Image();
    pagina.src =
      "/wp-content/plugins/thesis/app/files/" +
      TGetCookie("thesis_session") +
      "/pagine/pagina-" +
      i +
      ".jpg";

    pagina.onload = (e) => {
      let rgb = getAverageRGB(e.currentTarget);

      if (rgb.r === rgb.g && rgb.g === rgb.b) {
        pagineTipologia.bn.push({ ...rgb, pagina: i });
        document.querySelectorAll(".color-switch")[i].querySelector("img").src =
          assets.bn;
        document
          .querySelectorAll(".color-switch")
          [i].parentElement.querySelector("img")
          .classList.add("grayscale", "transition-all");
      } else {
        pagineTipologia.colorate.push({ ...rgb, pagina: i });
        document.querySelectorAll(".color-switch")[i].querySelector("img").src =
          assets.rgb;
      }

      /* TODO */ 

      /* if (pagine.bn.length === 0 && pagine.colorate.length === 0) {
        pagine = structuredClone(pagineTipologia);
      } */

      updateColorCounter();
    };

    pagina.classList.add("p-4");

    let zoomIn = document.createElement("a");
    zoomIn.href = pagina.src;

    zoomIn.dataset.fancybox = "gallery";

    zoomIn.appendChild(pagina);

    paginaWrapper.appendChild(zoomIn);
    paginaWrapper.appendChild(colorSwitch);

    pagineContainer.appendChild(paginaWrapper);
  }

  Fancybox.bind("[data-fancybox='gallery']");

  pagineWrapper.classList.replace("items-center", "self-start");

  pagineWrapper.appendChild(pagineContainer);
};

const updateColorCounter = () => {
  if (
    pagineTipologia.bn.length + pagineTipologia.colorate.length === numPages &&
    generated
  ) {
    let counterBn = document.querySelector("#bianco--nero span");
    let counterColorate = document.querySelector("#colore span");
    let pagineBn = pagineTipologia.bn.map((pagina) => pagina.pagina);
    let pagineColorate = pagineTipologia.colorate.map(
      (pagina) => pagina.pagina
    );

    counterBn.textContent = pagineTipologia.bn.length;
    counterColorate.textContent = pagineTipologia.colorate.length;
    document.querySelector("#subtotale_bn b").textContent =
      pagineTipologia.bn.length;
    document.querySelector("#subtotale_colori b").textContent =
      pagineTipologia.colorate.length;

    counterBn.classList.remove("animate-pulse");
    counterColorate.classList.remove("animate-pulse");
    document
      .querySelector(".subtotale_pagine")
      .classList.remove("animate-pulse");

    calcoloPagine();

    cart.pagine.bn = pagineBn;
    cart.pagine.colorate = pagineColorate;
  }
};

let pageFilter = [
  document.querySelector("#bianco--nero"),
  document.querySelector("#colore"),
];

let filtered = false;

pageFilter.forEach((item) => {
  item.onclick = (e) => {
    if (!generated) return;

    pageFilter.forEach((item) => {
      item.querySelector("span").classList.contains("active") &&
        item.querySelector("span").classList.remove("active");
    });

    e.currentTarget.querySelector("span").classList.add("active");

    if (!filtered) {
      filtered = true;

      if (e.currentTarget.id === "bianco--nero") {
        document.querySelectorAll(".pagina--wrapper").forEach((item) => {
          if (
            pagineTipologia.bn.find(
              (pagina) =>
                pagina.pagina ===
                parseInt(item.querySelector("button").dataset.pagina)
            ) === undefined
          ) {
            item.classList.add("hidden");
          }
        });
      } else {
        document.querySelectorAll(".pagina--wrapper").forEach((item) => {
          if (
            pagineTipologia.colorate.find(
              (pagina) =>
                pagina.pagina ===
                parseInt(item.querySelector("button").dataset.pagina)
            ) === undefined
          ) {
            item.classList.add("hidden");
          }
        });
      }
    } else {
      document.querySelectorAll(".pagina--wrapper").forEach((item) => {
        item.classList.remove("hidden");
      });

      pageFilter.forEach((item) => {
        item.querySelector("span").classList.contains("active") &&
          item.querySelector("span").classList.remove("active");
      });

      filtered = false;
    }
  };
});

let massiveActions = [
  document.querySelector("#stampa_colori"),
  document.querySelector("#stampa_bn"),
];


/* TODO */

/* document.querySelector("#annulla_azioni").onclick = (e) => {
  e.preventDefault();

  if (!generated) return;

  document.querySelector("#annulla_azioni").setAttribute("disabled", "true");

  document.querySelectorAll(".color-switch").forEach((item) => {
    item.querySelector("img").src = assets.rgb;
    item.parentElement.querySelector("img").classList.remove("grayscale");
  });

  pagineTipologia.colorate = pagine.colorate;
  pagineTipologia.bn = pagine.bn;

  updateColorCounter();
}; */

massiveActions.forEach((item) => {
  item.onclick = (e) => {
    e.preventDefault();

    if (!generated) return;

    // document.querySelector("#annulla_azioni").removeAttribute("disabled");

    let color = e.currentTarget.id === "stampa_colori" ? "colorate" : "bn";

    if (color === "colorate") {
      document.querySelectorAll(".color-switch").forEach((item) => {
        item.querySelector("img").src = assets.rgb;
        item.parentElement.querySelector("img").classList.remove("grayscale");
      });

      pagineTipologia.colorate = pagineTipologia.colorate.concat(
        pagineTipologia.bn
      );
      pagineTipologia.bn = [];
    } else {
      document.querySelectorAll(".color-switch").forEach((item) => {
        item.querySelector("img").src = assets.bn;
        item.parentElement.querySelector("img").classList.add("grayscale");
      });

      pagineTipologia.bn = pagineTipologia.bn.concat(pagineTipologia.colorate);
      pagineTipologia.colorate = [];
    }

    updateColorCounter();
  };
});

const listinoPagine = document.querySelector(".listino_pagine");
const totalePagine = document.querySelector(".totale_pagine");

document
  .querySelector("[name='grammatura']")
  .addEventListener("change", (e) => {
    if (document.querySelector("#prezzo_grammatura"))
      document.querySelector("#prezzo_grammatura").parentElement.remove();
    prezzoPagine.prezzo_grammatura = objRilegatura.prezzo_grammatura;
    prezzoPagine.id_grammatura = e.currentTarget.value;
    cart.pagine = { ...cart.pagine, ...prezzoPagine };

    let grammatura = listinoPagine.firstElementChild.cloneNode(true);
    grammatura.firstElementChild.textContent =
      "Grammatura: " + e.currentTarget.selectedOptions[0].textContent;
    grammatura.childNodes.forEach((item) => {
      if (item.id) item.removeAttribute("id");
      item.id = "prezzo_grammatura";
    });
    listinoPagine.insertBefore(grammatura, totalePagine);

    document.querySelector("#prezzo_grammatura b").textContent =
      prezzoPagine.prezzo_grammatura !== 0
        ? prezzoPagine.prezzo_grammatura
        : "Nessun sovrapprezzo";

    calcoloPagine();
  });

document.querySelector("[name='formato']").addEventListener("change", (e) => {
  if (document.querySelector("#prezzo_formato"))
    document.querySelector("#prezzo_formato").parentElement.remove();
  prezzoPagine.prezzo_formato = objRilegatura.prezzo_formato;
  prezzoPagine.id_formato = e.currentTarget.value;
  cart.pagine = { ...cart.pagine, ...prezzoPagine };

  let formato = listinoPagine.firstElementChild.cloneNode(true);
  formato.firstElementChild.textContent =
    "Formato: " + e.currentTarget.selectedOptions[0].textContent;
  formato.childNodes.forEach((item) => {
    if (item.id) item.removeAttribute("id");
    item.id = "prezzo_formato";
  });
  listinoPagine.insertBefore(formato, totalePagine);

  document.querySelector("#prezzo_formato b").textContent =
    prezzoPagine.prezzo_formato !== 0
      ? prezzoPagine.prezzo_formato
      : "Nessun sovrapprezzo";

  calcoloPagine();
});

const calcoloPagine = () => {
  totaleRilegature = 0;
  totaleRilegature = cart.rilegature.reduce(
    (acc, rilegatura) => parseInt(acc + parseInt(rilegatura.qty)),
    0
  );
  let pagineBn = pagineTipologia.bn.length;
  let pagineColorate = pagineTipologia.colorate.length;
  let numPagine = pagineBn + pagineColorate;

  let totaleFormato = 0;
  let totaleGrammatura = 0;

  let totale = 0;

  let prezzoBn = pagineBn * prezzoPagine.prezzo_bn;
  let prezzoColorate = pagineColorate * prezzoPagine.prezzo_colorate;

  prezzoPagine.prezzo_formato !== 0 &&
    (totaleFormato = numPagine * prezzoPagine.prezzo_formato);
  prezzoPagine.prezzo_grammatura !== 0 &&
    (totaleGrammatura = numPagine * prezzoPagine.prezzo_grammatura);

  totale = prezzoBn + prezzoColorate + totaleFormato + totaleGrammatura;
  document.querySelectorAll(".totale_pagine b").forEach((element) => {
    element.textContent = totale.toFixed(2) + "€ x " + totaleRilegature;
  });

  if (totale > 0)
    document.querySelector(
      '#pagine_step button[type="submit"]'
    ).disabled = false;
};

const formPagine = document.querySelector("#form_pagine");

formPagine.onsubmit = (e) => {
  e.preventDefault();

  const submitButton = formPagine.querySelector("[type='submit']");
  submitButton.innerText = "AGGIORNA IL CARRELLO";

  let goNext = document.querySelector("#prosegui_pagine");
  if (goNext.classList.contains("hidden")) {
    goNext.classList.remove("hidden");
    goNext.scrollIntoView({ behavior: "smooth" });
  }
};

const nextStepPagine = document.querySelector("#prosegui_rilegature");

nextStepPagine.addEventListener("click", () => {
  generaPagine();
  nextStepPagine.classList.add("hidden");
});
