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

const preload = (url) => (new Image()).src = url;

document
  .querySelectorAll(".thesis--sidebar > div")
  .forEach((item) => item.classList.add("hidden"));
document
  .querySelectorAll(".thesis--fragments > div")
  .forEach((item) => item.classList.add("hidden"));
document
  .querySelector(".thesis--fragments > div")
  .classList.remove("hidden")

config.forEach((item) => {
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
    };
  }
});

let images = {
  fronte: "/wp-content/uploads/2024/03/mockup-fronte.png",
  fronteRetro: "/wp-content/uploads/2024/03/mockup-fronte-retro.png"
}

for (image in images) {
  let preloaded = new Image();
  preloaded.src = preload(images[image])
  preloaded.className = "w-full h-2/3 drop-shadow-md"
  images[image] = preloaded
}

const fronte = document.querySelector("#fronte")
const fronteRetro = document.querySelector("#fronte-retro")

fronte.onmouseenter = () => {
  document.querySelector(".tipologia > img").remove()
  document.querySelector(".tipologia").append(images.fronte)
}
fronteRetro.onmouseenter = () => {
  document.querySelector(".tipologia > img").remove()
  document.querySelector(".tipologia").append(images.fronteRetro)
}

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
