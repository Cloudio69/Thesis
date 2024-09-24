const cart = {
  rilegature: [],
  pagine: {
    bn: [],
    colorate: [],
  },
  cd: {},
  tipologia: ""
};

let objRilegatura = {
  prezzo_rilegatura: 0,
  prezzo_grammatura: 0,
  prezzo_formato: 0,
  prezzo_angoli: 0,
  prezzo_segnalibri: 0,
  qty: 0,
};

error = false;

const showToast = async (message, status, icon) => {
  if (document.querySelector(".toast"))
    document.querySelector(".toast").remove();

  let mapStatus = {
    error: "bg-red-500",
    success: "bg-green-500",
    warning: "bg-yellow-500",
  };

  let bgStatus = mapStatus[status];

  let toast = document.createElement("div");
  toast.className = `toast toast-${status} fixed top-1/2 left-1/2 m-4 p-6 ${bgStatus} text-white rounded-lg shadow-lg flex items-center gap-4 z-50 fade-in `;
  toast.innerHTML = `<span class="material-symbols-outlined flex items-center !text-white text-2xl">${icon}</span><p class="flex font-bold text-2xl">${message}</p>`;
  document.body.appendChild(toast);

  await new Promise((resolve) => {
    setTimeout(() => {
      toast.classList.remove("fade-in");
      toast.classList.add("fade-out");
      resolve();
    }, 3000);
  });
};

let totale = 0;

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
    isCompleted: false,
  },
  {
    step: "rilegatura",
    nav: document.querySelector("#rilegature"),
    sidebar: document.querySelector("#rilegature_step"),
    content: document.querySelector(".thesis--rilegature"),
    isCompleted: false,
  },
  {
    step: "pagine",
    nav: document.querySelector("#pagine"),
    sidebar: document.querySelector("#pagine_step"),
    content: document.querySelector(".thesis--pagine"),
    isCompleted: false,
  },
  {
    step: "cd",
    nav: document.querySelector("#cd"),
    sidebar: document.querySelector("#cd_step"),
    content: document.querySelector(".thesis--cd"),
    isCompleted: false,
  },
  {
    step: "finalizza",
    nav: document.querySelector("#finalizza"),
    sidebar: document.querySelector("#finalizza_step"),
    content: document.querySelector(".thesis--finalizza"),
    isCompleted: false,
  },
  {
    step: "checkout",
    nav: document.querySelector("#checkout"),
    sidebar: document.querySelector("#checkout_step"),
    content: document.querySelector(".thesis--checkout"),
    isCompleted: false,
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
  }

  item.nav.onclick = (e) => {
    if (item.isCompleted === false) return;
    document
      .querySelectorAll(".route")
      .forEach((item) => item.classList.remove("active"));
    document
      .querySelectorAll(".thesis--fragments > div")
      .forEach((item) => item.classList.add("hidden"));

    e.currentTarget.classList.add("active");

    if (
      e.currentTarget.id === "finalizza" ||
      e.currentTarget.id === "checkout"
    ) {
      document.querySelector(".open-cart-dialog").classList.add("hidden");
    } else {
      if (
        document.querySelector(".open-cart-dialog").classList.contains("hidden")
      ) {
        document.querySelector(".open-cart-dialog").classList.remove("hidden");
      }
    }

    item.content.classList.remove("hidden");

    document
      .querySelectorAll(".thesis--sidebar > div")
      .forEach((item) => item.classList.add("hidden"));

    item.sidebar.classList.remove("hidden");

    currentStep = index;
  };
});


const nextStep = () => {
  document.querySelectorAll(".next-step").forEach((button) => {
    button.onclick = (e) => {
      if (e.currentTarget.disabled) return;

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

      document
        .querySelectorAll(".route")
      [currentStep].classList.remove("opacity-50");
      config[currentStep].isCompleted = true;

      document.querySelector('.thesis--sidebar').scrollTo(0, 0);

      if (currentStep === 5 || currentStep === 6) {
        document.querySelector(".open-cart-dialog").classList.add("hidden");
      } else {
        if (
          document.querySelector(".open-cart-dialog").classList.contains("hidden")
        ) {
          document.querySelector(".open-cart-dialog").classList.remove("hidden");
        }
      }
    };
  });
}

nextStep();

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

formOrder.onsubmit = (e) => {
  e.preventDefault();

  if (!checkFields()) return;

  let rilegatura = document.querySelector("[name='rilegatura']:checked");
  let variante = document.querySelector("[name='variante']:checked");
  let colore = document.querySelector("[name='colori_carattere']:checked");
  let angoli = document.querySelector("[name='angoli']");
  let segnalibri = document.querySelector("[name='segnalibri']");
  let qty = document.querySelector("[name='quantita']");

  cart.rilegature.push({
    id_rilegatura: rilegatura.value,
    nome_rilegatura: rilegatura.dataset.nome,
    prezzo_rilegatura: rilegatura.dataset.prezzo,
    id_variante: variante.value,
    nome_variante: variante.parentElement.querySelector("h3").textContent,
    id_colore: colore.value,
    nome_colore: colore.parentElement.querySelector("span").textContent,
    id_segnalibro: segnalibri.value ? segnalibri.value : null,
    nome_segnalibro:
      segnalibri.selectedIndex !== 0
        ? segnalibri.selectedOptions[0].textContent
        : "Nessun segnalibro",
    prezzo_segnalibro:
      segnalibri.selectedIndex !== 0
        ? segnalibri.selectedOptions[0].dataset.prezzo
        : 0,
    id_angolo: angoli.value ? angoli.value : null,
    nome_angolo:
      angoli.selectedIndex !== 0
        ? angoli.selectedOptions[0].textContent
        : "Nessun angolo",
    prezzo_angolo:
      angoli.selectedIndex !== 0 ? angoli.selectedOptions[0].dataset.prezzo : 0,
    rilegatura_thumbnail: document.querySelector('.thesis--rilegature canvas').toDataURL("image/jpeg", 0.4), // TODO: Comprire il canvas con l'immagine della rilegatura
    qty: qty.value,
  });

  e.currentTarget.reset();

  document.querySelector("#subtotale_rilegature").textContent = "0.00€";

  document.querySelector(".thesis--rilegature").replaceChildren();
  document.querySelector(".thesis--rilegature").innerHTML = `
    <div class='flex flex-col items-center justify-center'>
      <span class='material-symbols-outlined text-7xl'>check</span>
      <p class='text-lg text-center'>
        <b>Aggiunto al carrello!</b><br>
        Puoi continuare ad aggiungere altre rilegature! <br><br>
        <b>Oppure clicca su "PROSEGUI"</b>
      </p>
    </div>
  `;

  document.querySelector(".varianti div").replaceChildren();
  document.querySelector(".colori_carattere div").replaceChildren();

  document.querySelector(".varianti div").innerHTML = `
    <p class="opacity-50 col-span-5 place-self-start">Scegli prima una rilegatura.</p>
  `;
  document.querySelector(".colori_carattere div").innerHTML = `
    <p class="opacity-50 col-span-5 place-self-start">Scegli prima una rilegatura.</p>
  `;

  document.querySelector("#prosegui_rilegature").classList.remove("hidden");
  document.querySelector("#prosegui_rilegature").scrollIntoView({ behavior: "smooth" });
};

let names = [
  "rilegatura",
  "grammatura",
  "formato",
  "angoli",
  "segnalibri",
  "quantita",
];

const calcoloRilegatura = () => {
  let subtotal = 0;

  names.forEach((name) => {
    let selected = document.querySelector(`[name='${name}']`);

    if (document.querySelector(`[name='${name}']:checked`)) {
      selected = document.querySelector(`[name='${name}']:checked`);
      objRilegatura[`prezzo_${name}`] = parseFloat(selected.dataset.prezzo);
    }

    if (selected.tagName === "SELECT") {
      selected = selected.selectedOptions[0];
      selected.dataset.prezzo
        ? (objRilegatura[`prezzo_${name}`] = parseFloat(
          selected.dataset.prezzo
        ))
        : (objRilegatura[`prezzo_${name}`] = 0);
    }

    if (selected.type === "number")
      objRilegatura[`qty`] = parseInt(selected.value);
  });

  Object.entries(objRilegatura).forEach(([key, value]) => {
    if (
      key.includes("prezzo") &&
      !key.includes("grammatura") &&
      !key.includes("formato")
    ) {
      subtotal += value;
    }
    if (key === "qty") subtotal *= value;
  });

  totale = subtotal.toFixed(2);
  document.querySelector("#subtotale_rilegature").textContent = totale + "€";
};

names.forEach((name) => {
  if (document.querySelector(`[name='${name}']`).type !== "radio")
    document
      .querySelector(`[name='${name}']`)
      .addEventListener("change", calcoloRilegatura);
  else
    document
      .querySelectorAll(`[name='${name}']`)
      .forEach((radio) => radio.addEventListener("change", calcoloRilegatura));
});

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
