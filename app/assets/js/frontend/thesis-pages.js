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
      creaPagine();
      generated = true; // Evita di rigenerare le pagine
    });
  }
};

let pagineTipologia = {
  bn: [],
  colorate: [],
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
      } else {
        pagineTipologia.colorate.push({ ...rgb, pagina: i });
      }

      if (
        pagineTipologia.bn.length + pagineTipologia.colorate.length ===
        numPages
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


// Se ci troviamo nello step Pagine, generiamo le pagine
// Check se fai click su un pulsante con classe .next-step oppuer se clicchi sulla navbar per andare allo step Pagine
// Check se è già stato generato il contenuto

window.onclick = (e) => {
  currentStep === 3 && generaPagine();
}