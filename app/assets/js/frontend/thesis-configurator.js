const cart = {
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
  let grammatura = document.querySelector("[name='grammatura']");
  let formato = document.querySelector("[name='formato']");
  let angoli = document.querySelector("[name='angoli']");
  let qty = document.querySelector("[name='quantita']");

  cart.rilegature.push({
    id_rilegatura: rilegatura.value,
    id_variante: variante.value,
    id_colore: colore.value,
    nome_rilegatura: rilegatura.dataset.nome,
    prezzo_rilegatura: rilegatura.dataset.prezzo,
    id_grammatura: grammatura.value,
    id_formato: formato.value,
    id_angolo: angoli.value,
    qty: qty.value,
  });

  e.currentTarget.reset();

  document.querySelector(".thesis--rilegature").replaceChildren();
  document.querySelector(".thesis--rilegature").innerHTML = `<div class='flex flex-col items-center justify-center'><span class='material-symbols-outlined text-7xl'>check</span><p class='text-lg text-center'><b>Aggiunto al carrello!</b><br>Puoi continuare ad aggiungere altre rilegature!</p>`;

  document.querySelector(".varianti div").replaceChildren()
  document.querySelector(".colori_carattere div").replaceChildren()

  document.querySelector(".varianti div").innerHTML = `<p class="opacity-50 col-span-5 place-self-start">Scegli prima una rilegatura.</p>`
  document.querySelector(".colori_carattere div").innerHTML = `<p class="opacity-50 col-span-5 place-self-start">Scegli prima una rilegatura.</p>`

};


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