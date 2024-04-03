function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

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
];

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
  fronte: "/wp-content/uploads/2024/03/mockup-fronte.png",
  fronteRetro: "/wp-content/uploads/2024/03/mockup-fronte-retro.png",
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
          frontespizioGen.src =
            "/wp-content/plugins/thesis/app/files/" +
            getCookie("thesis_session") +
            "/frontespizio_generato.png";

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
  jQuery
    .get(
      "/wp-content/plugins/thesis/app/files/" +
        getCookie("thesis_session") +
        "/frontespizio_generato.png"
    )
    .fail(async () => {
      await jQuery.ajax({
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
