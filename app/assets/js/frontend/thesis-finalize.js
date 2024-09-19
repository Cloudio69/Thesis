const rilegatureForm = document.querySelector("#rilegature_form");
const pagineForm = document.querySelector("#form_pagine");
const cdForm = document.querySelector("#form_cd");

const cartWrapper = document.querySelector(".thesis--cart-items");

let forms = [rilegatureForm, pagineForm, cdForm];

forms.forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    if (document.querySelector(".placeholder-cart"))
      document.querySelector(".placeholder-cart").classList.add("hidden");

    updateCart(e);
  });
});

const updateCart = async (e) => {
  cartWrapper.innerHTML = "";

  const cdDiv = document.createElement("div");
  const pagineDiv = document.createElement("div");
  const rilegatureDiv = document.createElement("div");
  const totaleDiv = document.createElement("div");

  let totale = 0;

  rilegatureDiv.classList.add("flex", "flex-col", "gap-4");
  pagineDiv.classList.add("flex", "flex-col", "gap-4");
  cdDiv.classList.add("flex", "flex-col", "gap-4");

  cdDiv.innerHTML = "<h3 class='font-bold'>CD</h3>";
  pagineDiv.innerHTML = "<h3 class='font-bold'>Pagine</h3>";
  rilegatureDiv.innerHTML = "<h3 class='font-bold'>Rilegature</h3>";

  if (cart.rilegature && cart.rilegature.length > 0) {
    cart.rilegature.forEach((rilegatura, index) => {
      let rilegatureItem = document.createElement("div");
      rilegatureItem.classList.add(
        "flex",
        "flex-col",
        "gap-2",
        "p-4",
        "bg-white",
        "border",
        "rounded-md",
        "shadow-md"
      );

      rilegatureItem.innerHTML = `
        <div class="flex justify-between items-start">
          <div class='flex flex-col'>
            <h4 class="font-bold text-xl">${rilegatura.nome_rilegatura}</h4>
            <span class='text-sm mt-2'>Colore: ${rilegatura.nome_colore}</span>
            <span class='text-sm'>Variante: ${rilegatura.nome_variante}</span>
            <span class='text-sm'>Segnalibro: ${
              rilegatura.nome_segnalibro
            } (+${parseFloat(rilegatura.prezzo_segnalibro).toFixed(2)})</span>
            <span class='text-sm mb-2'>Angoli: ${
              rilegatura.nome_angolo
            } (+${parseFloat(rilegatura.prezzo_angolo).toFixed(2)})</span>
          </div>
          <span class="text-xl font-bold">${(
            parseFloat(rilegatura.prezzo_rilegatura) +
            parseFloat(rilegatura.prezzo_segnalibro) +
            parseFloat(rilegatura.prezzo_angolo)
          ).toFixed(2)}€</span>
        </div>
      `;

      totale +=
        parseFloat(rilegatura.prezzo_rilegatura) +
        parseFloat(rilegatura.prezzo_segnalibro) +
        parseFloat(rilegatura.prezzo_angolo);

      let eliminaBtn = document.createElement("button");
      eliminaBtn.innerText = "Elimina";
      eliminaBtn.addEventListener("click", () => {
        removeRilegatura(index);
      });

      rilegatureItem.appendChild(eliminaBtn);
      rilegatureDiv.appendChild(rilegatureItem);
    });
  } else {
    let rilegatureItem = document.createElement("div");
    rilegatureItem.innerText = "Nessun dato";
    rilegatureDiv.appendChild(rilegatureItem);
  }
  // claudejs
  if (cart.pagine.bn.length > 0 && cart.pagine.colorate.length > 0) {
    let pagineItem = document.createElement("div");

    pagineItem.classList.add(
      "flex",
      "flex-col",
      "gap-2",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );

    pagineItem.innerHTML = `
    <h4 class="font-bold text-xl">Listino pagine</h4>
      <div class="flex justify-between items-start">
        <div class='flex flex-col w-full'>
        <span class='flex items-center justify-between my-2'><b class='text-xl'>B/N: ${
          cart.pagine.bn.length
        }</b> <b class='text-xl'>Colorate: ${
      cart.pagine.colorate.length
    }</b></span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo B/N</b><span>  ${
          (cart.pagine.prezzo_bn * cart.pagine.bn.length).toFixed(2)
        }€</span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo Colorate</b><span>  ${
          (cart.pagine.prezzo_colorate * cart.pagine.colorate.length).toFixed(2)
        }€</span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo Formato</b><span>  ${
          cart.pagine.prezzo_formato
        }€</span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo Grammatura</b><span> ${
          cart.pagine.prezzo_grammatura
        }€</span></span>
        </div>
      </div>
    `;

    let numPagine = cart.pagine.bn.length + cart.pagine.colorate.length;
    let costoPagine =
      cart.pagine.prezzo_bn * cart.pagine.bn.length +
      cart.pagine.prezzo_colorate * cart.pagine.colorate.length;
    costoPagine +=
      cart.pagine.prezzo_formato * numPagine +
      cart.pagine.prezzo_grammatura * numPagine;

    totale += costoPagine;

    pagineDiv.appendChild(pagineItem);
  } else {
    let pagineItem = document.createElement("div");
    pagineItem.innerText = "Nessun dato";
    pagineDiv.appendChild(pagineItem);
  }

  if (cart.cd.contenuto) {
    let cdItem = document.createElement("div");
    cdItem.classList.add(
      "flex",
      "flex-col",
      "gap-2",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );
    cdItem.innerHTML = `
      <div class="flex justify-between items-start">
        <div class='flex flex-col w-full'>
        <span class="text-sm flex items-center justify-between"><b>CD Serigrafato x ${cart.cd.qty}</b> <span>${cart.cd.prezzo}€</span></span>
        </div>
      </div>
    `;
    cdDiv.appendChild(cdItem);

    let removeCd = document.createElement("button");
    removeCd.innerText = "Elimina";
    removeCd.addEventListener("click", () => {
      cart.cd = {};
      updateCart();
    });

    cdItem.appendChild(removeCd);

    totale += cart.cd.prezzo * cart.cd.qty;
  } else {
    let cdItem = document.createElement("div");
    cdItem.innerText = "Nessun dato";
    cdDiv.appendChild(cdItem);
  }

  totaleDiv.innerHTML = `<h3 class='text-2xl mt-4 font-bold flex items-center justify-between w-full'><span>Totale: </span><span>${totale.toFixed(
    2
  )}€</span></h3>`;

  
  cartWrapper.appendChild(rilegatureDiv);
  cartWrapper.appendChild(pagineDiv);
  cartWrapper.appendChild(cdDiv);
  cartWrapper.appendChild(totaleDiv);

  updateFinalize(totale);
};

const updateFinalize = (totale) => {
  const rilegatureWrapper = document.querySelector( ".riepilogo-rilegature section");
  const pagineWrapper = document.querySelector(".riepilogo-pagine section");
  const cdWrapper = document.querySelector(".riepilogo-cd section");
  const totaleWrapper = document.querySelector("#totale");

  rilegatureWrapper.innerHTML = "";
  pagineWrapper.innerHTML = "";
  cdWrapper.innerHTML = "";
  totaleWrapper.innerHTML = "";

  const cdDiv = document.createElement("div");
  const pagineDiv = document.createElement("div");
  const rilegatureDiv = document.createElement("div");

  rilegatureDiv.classList.add("flex", "flex-col", "gap-4");
  pagineDiv.classList.add("flex", "flex-col", "gap-4");
  cdDiv.classList.add("flex", "flex-col", "gap-4");

  cdDiv.innerHTML = "<h3 class='font-bold'>CD</h3>";
  pagineDiv.innerHTML = "<h3 class='font-bold'>Pagine</h3>";
  rilegatureDiv.innerHTML = "<h3 class='font-bold'>Rilegature</h3>";

  if (cart.rilegature && cart.rilegature.length > 0) {
    cart.rilegature.forEach((rilegatura, index) => {
      let rilegatureItem = document.createElement("div");
      rilegatureItem.classList.add(
        "flex",
        "flex-col",
        "gap-2",
        "p-4",
        "bg-white",
        "border",
        "rounded-md",
        "shadow-md"
      );

      rilegatureItem.innerHTML = `
        <div class="flex justify-between items-start">
          <div class='flex flex-col'>
            <h4 class="font-bold text-xl">${rilegatura.nome_rilegatura}</h4>
            <span class='text-sm mt-2'>Colore: ${rilegatura.nome_colore}</span>
            <span class='text-sm'>Variante: ${rilegatura.nome_variante}</span>
            <span class='text-sm'>Segnalibro: ${
              rilegatura.nome_segnalibro
            } (+${parseFloat(rilegatura.prezzo_segnalibro).toFixed(2)})</span>
            <span class='text-sm mb-2'>Angoli: ${
              rilegatura.nome_angolo
            } (+${parseFloat(rilegatura.prezzo_angolo).toFixed(2)})</span>
          </div>
          <span class="text-xl font-bold">${(
            parseFloat(rilegatura.prezzo_rilegatura) +
            parseFloat(rilegatura.prezzo_segnalibro) +
            parseFloat(rilegatura.prezzo_angolo)
          ).toFixed(2)}€</span>
        </div>
      `;

      totale +=
        parseFloat(rilegatura.prezzo_rilegatura) +
        parseFloat(rilegatura.prezzo_segnalibro) +
        parseFloat(rilegatura.prezzo_angolo);

      let eliminaBtn = document.createElement("button");
      eliminaBtn.innerText = "Elimina";
      eliminaBtn.addEventListener("click", () => {
        removeRilegatura(index);
      });

      rilegatureItem.appendChild(eliminaBtn);
      rilegatureDiv.appendChild(rilegatureItem);
    });
  } else {
    let rilegatureItem = document.createElement("div");
    rilegatureItem.innerText = "Nessun dato";
    rilegatureDiv.appendChild(rilegatureItem);
  }

  if (cart.pagine.bn.length > 0 && cart.pagine.colorate.length > 0) {
    let pagineItem = document.createElement("div");

    pagineItem.classList.add(
      "flex",
      "flex-col",
      "gap-2",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );

    pagineItem.innerHTML = `
    <h4 class="font-bold text-xl">Listino pagine</h4>
      <div class="flex justify-between items-start">
        <div class='flex flex-col w-full'>
        <span class='flex items-center justify-between my-2'><b class='text-xl'>B/N: ${
          cart.pagine.bn.length
        }</b> <b class='text-xl'>Colorate: ${
      cart.pagine.colorate.length
    }</b></span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo B/N</b><span>  ${
          cart.pagine.prezzo_bn * cart.pagine.bn.length
        }€</span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo Colorate</b><span>  ${
          cart.pagine.prezzo_colorate * cart.pagine.colorate.length
        }€</span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo Formato</b><span>  ${
          cart.pagine.prezzo_formato
        }€</span></span>
        <span class="text-sm flex items-center justify-between"><b>Costo Grammatura</b><span> ${
          cart.pagine.prezzo_grammatura
        }€</span></span>
        </div>
      </div>
    `;
    pagineDiv.appendChild(pagineItem);
  } else {
    let pagineItem = document.createElement("div");
    pagineItem.innerText = "Nessun dato";
    pagineDiv.appendChild(pagineItem);
  }

  if (cart.cd.contenuto) {
    let cdItem = document.createElement("div");
    cdItem.classList.add(
      "flex",
      "flex-col",
      "gap-2",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );
    cdItem.innerHTML = `
      <div class="flex justify-between items-start">
        <div class='flex flex-col w-full'>
        <span class="text-sm flex items-center justify-between"><b>CD Serigrafato x ${cart.cd.qty}</b> <span>${cart.cd.prezzo}€</span></span>
        </div>
      </div>
    `;
    cdDiv.appendChild(cdItem);

    let removeCd = document.createElement("button");
    removeCd.innerText = "Elimina";
    removeCd.addEventListener("click", () => {
      cart.cd = {};
      updateCart();
    });

    cdItem.appendChild(removeCd);
  } else {
    let cdItem = document.createElement("div");
    cdItem.innerText = "Nessun dato";
    cdDiv.appendChild(cdItem);
  }

  rilegatureWrapper.appendChild(rilegatureDiv);
  pagineWrapper.appendChild(pagineDiv);
  cdWrapper.appendChild(cdDiv);

  totaleWrapper.textContent = parseFloat(totale).toFixed(2);
};

function removeRilegatura(index) {
  cart.rilegature.splice(index, 1);

  updateCart();
}
