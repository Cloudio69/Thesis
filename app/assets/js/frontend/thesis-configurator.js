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
];

document
  .querySelectorAll(".thesis--sidebar > div")
  .forEach((item) => item.classList.add("hidden"));
document
  .querySelectorAll(".thesis--fragments > div")
  .forEach((item) => item.classList.add("hidden"));

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
};
