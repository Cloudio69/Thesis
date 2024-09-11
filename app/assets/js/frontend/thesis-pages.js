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

          statusCode: {
            404: function () {
              console.error("Pagina non trovata");
            },
            502: function () {
              let container = document.querySelector(".thesis--pagine");
              container.replaceChildren();
              container.innerHTML =
                "<span class='material-symbols-outlined text-8xl'>error</span><p class='text-center'>Si è verificato un errore durante la generazione delle pagine<br> Ricarica la pagina per proseguire</p>";
            },
          },
        });
      })
    ).then(() => {
      creaPagine();
      generated = true; // Evita di rigenerare le pagine
    });
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
    "overflow-auto"
  );

  for (let i = 0; i < numPages; i++) {
    let paginaWrapper = document.createElement("div");
    let colorSwitch = document.createElement("button");

    colorSwitch.dataset.pagina = i;

    colorSwitch.addEventListener("click", (e) => {
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
      getCookie("thesis_session") +
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
          .classList.add("grayscale", "Transition-all");
      } else {
        pagineTipologia.colorate.push({ ...rgb, pagina: i });
        document.querySelectorAll(".color-switch")[i].querySelector("img").src =
          assets.rgb;
      }

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

    counterBn.classList.remove("animate-pulse");
    counterColorate.classList.remove("animate-pulse");

    order.pagine.bn = pagineBn;
    order.pagine.colorate = pagineColorate;
  }
};

let pageFilter = [
  document.querySelector("#bianco--nero"),
  document.querySelector("#colore"),
];
let filtered = false;

pageFilter.forEach((item) => {

  item.onclick = (e) => {

    if(!generated) return;

    pageFilter.forEach((item) => { item.classList.contains('active') && item.classList.remove('active')})

    // if is already filtered remove the filter
    if (filtered) {
      document.querySelectorAll(".pagina--wrapper").forEach((item) => {
        item.classList.remove("hidden");
      });

      filtered = false;
    }

    if (e.currentTarget.id === "bianco--nero") {
      document.querySelectorAll(".pagina--wrapper").forEach((item) => {
        if (pagineTipologia.bn.find((pagina) => pagina.pagina === parseInt(item.querySelector("button").dataset.pagina)) === undefined) {
          item.classList.add("hidden");
        }
      });

    } else {
      document.querySelectorAll(".pagina--wrapper").forEach((item) => {
        if (pagineTipologia.colorate.find((pagina) => pagina.pagina === parseInt(item.querySelector("button").dataset.pagina)) === undefined) {
          item.classList.add("hidden");
        }
      });
    }

    filtered = true;
  };
});

document.querySelector("#pagine").addEventListener("click", () => {
  generaPagine();
}) 
