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

    if (!error) showToast("Elemento aggiunto al carrello", "success", "check");

    updateCart(e);
  });
});

let iva = 0;

const updateCart = async (e) => {
  cartWrapper.innerHTML = "";

  const cdDiv = document.createElement("div");
  const pagineDiv = document.createElement("div");
  const rilegatureDiv = document.createElement("div");
  const tipologiaDiv = document.createElement("div");
  const totaleDiv = document.createElement("div");

  let totale = 0;

  tipologiaDiv.classList.add("flex", "flex-col", "gap-4");
  rilegatureDiv.classList.add("flex", "flex-col", "gap-4");
  pagineDiv.classList.add("flex", "flex-col", "gap-4");
  cdDiv.classList.add("flex", "flex-col", "gap-4");

  /* cdDiv.innerHTML = "<h3 class='font-bold'>CD</h3>";
  pagineDiv.innerHTML = "<h3 class='font-bold'>Pagine</h3>";
  rilegatureDiv.innerHTML = "<h3 class='font-bold'>Rilegature</h3>"; */

  if (cart.tipologia) {
    let tipologiaItem = document.createElement("div");
    tipologiaItem.classList.add(
      "flex",
      "flex-col",
      "gap-2",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );

    tipologiaItem.innerHTML = `
      <div class="flex justify-between items-start">
        <div class='flex flex-col'>
          <h4 class="font-bold text-xl">Tipologia</h4>
          <span class='text-sm mt-2'>${cart.tipologia}</span>
        </div>
      </div>
    `;

    tipologiaDiv.appendChild(tipologiaItem);
  }

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
        <div class="flex items-start gap-4">
        <div class="flex items-center image">
          <img src="${rilegatura.rilegatura_thumbnail}" data-anteprima-rilegatura alt="${
        rilegatura.nome_rilegatura
      }" class="w-fit h-[120px] object-contain rounded-md cursor-pointer" />
          </div>
          <div class='flex flex-col flex-1 pl-6'>
            <h4 class="font-bold text-xl">${rilegatura.nome_rilegatura}</h4>
            <span class='text-sm mt-2'>Colore: ${rilegatura.nome_colore}</span>
            <span class='text-sm'>Variante: ${rilegatura.nome_variante}</span>
            <span class='text-sm'>Segnalibro: ${
              rilegatura.nome_segnalibro
            } (+${parseFloat(rilegatura.prezzo_segnalibro).toFixed(2)})</span>
            <span class='text-sm'>Angoli: ${
              rilegatura.nome_angolo
            } (+${parseFloat(rilegatura.prezzo_angolo).toFixed(2)})</span>
          </div>
          <div class="flex flex-col text-xl font-bold self-stretch justify-between rilegatura_actions">
          <span>${rilegatura.qty} x ${(
        parseFloat(rilegatura.prezzo_rilegatura) +
        parseFloat(rilegatura.prezzo_segnalibro) +
        parseFloat(rilegatura.prezzo_angolo)
      ).toFixed(2)}€
        </span>
        </div>
        </div>
      `;

      totale += rilegatura.qty
        ? (parseFloat(rilegatura.prezzo_rilegatura) +
            parseFloat(rilegatura.prezzo_segnalibro) +
            parseFloat(rilegatura.prezzo_angolo)) *
          rilegatura.qty
        : parseFloat(rilegatura.prezzo_rilegatura) +
          parseFloat(rilegatura.prezzo_segnalibro) +
          parseFloat(rilegatura.prezzo_angolo);

      let eliminaBtn = document.createElement("button");
      eliminaBtn.innerHTML =
        "<span class='material-symbols-outlined !text-white'>delete</span>";
      eliminaBtn.classList.add(
        "!bg-red-500",
        "text-white",
        "self-end",
        "p-2",
        "rounded-md"
      );
      eliminaBtn.addEventListener("click", () => {
        removeRilegatura(index);
      });

      rilegatureDiv.appendChild(rilegatureItem);
      rilegatureDiv
        .querySelectorAll(".rilegatura_actions")
        .forEach((item) => item.appendChild(eliminaBtn));
    });
    document.querySelector("#finalizza_step button").disabled = false;
    document.querySelector("#finalizza_step .info_finalizzazione").classList.add("hidden")
  } else {
    document.querySelector("#finalizza_step button").disabled = true;
    document.querySelector("#finalizza_step .info_finalizzazione").classList.remove("hidden")

    /* document.querySelector(".thesis--rilegature").innerHTML = `
    <div class='flex flex-col items-center justify-center'>
      <span class='material-symbols-outlined text-7xl'>info</span>
      <p class='text-lg text-center'>
        <b class='info-user'>Rilegatura mancante</b><br>
        <p>Per proseguire con il checkout, devi aggiungere almeno una rilegatura</p> <br><br>
      </p>
    </div>
  `;
    rilegatureForm.reset();
    window.scrollTo({ top: 0, behavior: 'smooth' }); */
    document.querySelector("#prosegui_rilegature").classList.add("hidden")
  }

  if (cart.pagine.prezzo_grammatura >= 0 || cart.pagine.prezzo_formato >= 0) {
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
    <h4 class="font-bold text-xl">Pagine</h4>
      <div class="flex justify-between items-start">
        <div class='flex flex-col w-full gap-2'>
        <span class='flex items-center justify-between my-2'><b class='text-sm rounded-lg bg-neutral-100 px-2 flex items-center gap-2'><img src="/wp-content/plugins/thesis/app/assets/img/svg/black-and-white.svg" class="w-2 h-2">Monocolore: ${
          cart.pagine.bn.length
        }</b> <b class='text-sm rounded-lg bg-neutral-100 px-2 flex items-center gap-2'><img src="/wp-content/plugins/thesis/app/assets/img/svg/rgb.svg" class="w-2 h-2"> Multicolore: ${
      cart.pagine.colorate.length
    }</b></span></span><hr class="mb-2">
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
print
</span> Costo Monocolore</b><span>  ${(
      cart.pagine.prezzo_bn *
      (cart.pagine.bn.length > 0 ? cart.pagine.bn.length : 0)
    ).toFixed(2)}€</span></span>
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"> <span class="material-symbols-outlined">
print
</span> Costo Multicolore</b><span>  ${(
      cart.pagine.prezzo_colorate *
      (cart.pagine.colorate.length > 0 ? cart.pagine.colorate.length : 0)
    ).toFixed(2)}€</span></span>
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
weight
</span> Costo Formato</b><span>  ${
      cart.pagine.prezzo_formato
        ? cart.pagine.prezzo_formato + " €"
        : "Nessun sovraprezzo"
    }</span></span>
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
weight
</span> Costo Grammatura</b><span> ${
      cart.pagine.prezzo_grammatura
        ? cart.pagine.prezzo_grammatura + " €"
        : "Nessun sovraprezzo"
    }</span></span>
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
  }

  if (cart.cd.contenuto) {
    let cdItem = document.createElement("div");

    let removeCd = document.createElement("button");
    removeCd.setAttribute("onclick", "removecd()")
    removeCd.classList.add(
      "!bg-red-500",
      "text-white",
      "self-end",
      "p-2",
      "rounded-md"
    );
    removeCd.innerHTML = "<span class='material-symbols-outlined !text-white'>delete</span>";

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
    <div class="flex justify-between items-start gap-4">
    <div class="flex items-center image">
    <div class="cd-thumbnail animate-pulse bg-gray-200 w-24 h-24 rounded-md p-2"></div>
    </div>
    <div class='flex flex-col w-full'>
    <span class="text-sm flex items-center justify-between"><b>CD Serigrafato x ${
      cart.cd.qty
    }</b></span>
    ${
      Object.values(cart.cd.inputs).some((value) => value !== "")
      ? `<span class="text-xs mt-2 font-bold">Dati inseriti</span>`
      : ""
    }
    ${Object.entries(cart.cd.inputs)
      .filter(([key, value]) => value !== "")
      .map(([key, value]) => `<p class="text-xs mt-2">${key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())}: ${value}</p>`)
      .join("")} 
    </div>
    <div class='flex flex-col w-full self-stretch flex-grow-0'>
    <div class='font-bold cd-actions flex flex-col items-end flex-1 justify-between'><span class="text-sm">${
    cart.cd.qty ? (cart.cd.prezzo * cart.cd.qty).toFixed(2) : cart.cd.prezzo
    }€</span>${removeCd.outerHTML}</div></span>
    </div>
    </div>
    `;
    cdDiv.appendChild(cdItem);

    totale += cart.cd.prezzo * cart.cd.qty;
  }

  iva = totale * 0.22;
  let totaleIva = Math.round((totale + iva) * 100) / 100;

  totaleDiv.innerHTML = `<h3 class='text-2xl mt-4 font-bold flex items-center justify-between w-full'><span>Totale: </span><span>${totaleIva.toFixed(
    2
  )}€</span></h3>`;

  totaleDiv.innerHTML += `<h3 class='text-xs mt-2 opacity-50 font-bold flex items-center justify-between w-full'><span>IVA 22%: </span><span>${iva.toFixed(
    2
  )}€</span></h3>`;

  cartWrapper.appendChild(tipologiaDiv);
  cartWrapper.appendChild(rilegatureDiv);
  cartWrapper.appendChild(pagineDiv);
  cartWrapper.appendChild(cdDiv);
  cartWrapper.appendChild(totaleDiv);

  updateFinalize(totaleIva);
};

const updateFinalize = (totale) => {
  const tipologiaWrapper = document.querySelector(
    ".riepilogo-tipologia section"
  );
  const rilegatureWrapper = document.querySelector(
    ".riepilogo-rilegature section"
  );
  const pagineWrapper = document.querySelector(".riepilogo-pagine section");
  const cdWrapper = document.querySelector(".riepilogo-cd section");
  const totaleWrapper = document.querySelectorAll(".totale");
  const subtotaleWrapper = document.querySelectorAll(".subtotale");
  const spedizioneWrapper = document.querySelectorAll(".spedizione");

  tipologiaWrapper.innerHTML = "";
  rilegatureWrapper.innerHTML = "";
  pagineWrapper.innerHTML = "";
  cdWrapper.innerHTML = "";

  totaleWrapper.forEach((el) => {
    el.innerHTML = "";
  });

  let spedizioneSelect = document.querySelector("#spedizione");

  const cdDiv = document.createElement("div");
  const pagineDiv = document.createElement("div");
  const rilegatureDiv = document.createElement("div");
  const tipologiaDiv = document.createElement("div");

  rilegatureDiv.classList.add("flex", "flex-col", "gap-4");
  pagineDiv.classList.add("flex", "flex-col", "gap-4");
  cdDiv.classList.add("flex", "flex-col", "gap-4");
  tipologiaDiv.classList.add("flex", "flex-col", "gap-4");

  if (cart.tipologia) {
    let tipologiaItem = document.createElement("div");
    tipologiaItem.classList.add(
      "flex",
      "flex-col",
      "gap-2",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );

    tipologiaItem.innerHTML = `
      <div class="flex justify-between items-start">
        <div class='flex flex-col'>
          <h4 class="font-bold text-xl">Tipologia</h4>
          <span class='text-sm mt-2'>${cart.tipologia}</span>
        </div>
      </div>
    `;

    tipologiaDiv.appendChild(tipologiaItem);
  } else {
    let tipologiaItem = document.createElement("div");
    tipologiaItem.classList.add("opacity-50");
    tipologiaItem.innerText = "Nessun elemento";
    tipologiaDiv.appendChild(tipologiaItem);
  }

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
        <div class="flex items-start gap-4">
        <div class="flex items-center image">
          <img src="${rilegatura.rilegatura_thumbnail}" data-anteprima-rilegatura alt="${
        rilegatura.nome_rilegatura
      }" class="w-fit h-[120px] object-contain rounded-md cursor-pointer" />
          </div>
          <div class='flex flex-col flex-1 pl-6 self-center'>
            <h4 class="font-bold text-xl">${rilegatura.nome_rilegatura}</h4>
            <span class='text-sm'>Colore: ${rilegatura.nome_colore}</span>
            <span class='text-sm'>Variante: ${rilegatura.nome_variante}</span>
            <span class='text-sm'>Segnalibro: ${
              rilegatura.nome_segnalibro
            } (+${parseFloat(rilegatura.prezzo_segnalibro).toFixed(2)})</span>
            <span class='text-sm'>Angoli: ${
              rilegatura.nome_angolo
            } (+${parseFloat(rilegatura.prezzo_angolo).toFixed(2)})</span>
          </div>
         <div class="flex flex-col text-xl font-bold self-stretch justify-between rilegatura_actions">
          <span>${rilegatura.qty} x ${(
        parseFloat(rilegatura.prezzo_rilegatura) +
        parseFloat(rilegatura.prezzo_segnalibro) +
        parseFloat(rilegatura.prezzo_angolo)
      ).toFixed(2)}€
        </span>
        </div>
        </div>
      `;

      let eliminaBtn = document.createElement("button");
      eliminaBtn.innerHTML =
        "<span class='material-symbols-outlined !text-white'>delete</span>";
      eliminaBtn.classList.add(
        "!bg-red-500",
        "text-white",
        "self-end",
        "p-2",
        "rounded-md"
      );
      eliminaBtn.addEventListener("click", () => {
        removeRilegatura(index);
      });

      rilegatureDiv.appendChild(rilegatureItem);
      rilegatureDiv
        .querySelectorAll(".rilegatura_actions")
        .forEach((item) => item.appendChild(eliminaBtn));
    });
  } else {
    let rilegatureItem = document.createElement("div");
    rilegatureItem.classList.add("opacity-50");
    rilegatureItem.innerText = "Nessun elemento.";
    rilegatureDiv.appendChild(rilegatureItem);
  }

  if (cart.pagine.prezzo_grammatura >= 0 || cart.pagine.prezzo_formato >= 0) {
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
    <h4 class="font-bold text-xl">Pagine</h4>
      <div class="flex justify-between items-start">
        <div class='flex flex-col w-full gap-2'>
        <span class='flex items-center justify-between my-2'><b class='text-sm rounded-lg bg-neutral-100 px-2 flex items-center gap-2'><img src="/wp-content/plugins/thesis/app/assets/img/svg/black-and-white.svg" class="w-2 h-2"> Monocolore: ${
          cart.pagine.bn.length
        }</b> <b class='text-sm rounded-lg bg-neutral-100 px-2 flex items-center gap-2'><img src="/wp-content/plugins/thesis/app/assets/img/svg/rgb.svg" class="w-2 h-2"> Multicolore: ${
      cart.pagine.colorate.length
    }</b></span></span><hr class="mb-2">
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
        print
        </span> Costo Monocolore</b><span>  ${(
          cart.pagine.prezzo_bn * cart.pagine.bn.length
        ).toFixed(2)} €</span></span>
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
        print
        </span> Costo Multicolore</b><span>  ${(
          cart.pagine.prezzo_colorate * cart.pagine.colorate.length
        ).toFixed(2)} €</span></span>
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
weight
</span> Costo Formato</b><span>  ${
      cart.pagine.prezzo_formato > 0
        ? cart.pagine.prezzo_formato + " €"
        : "Nessun sovraprezzo"
    }</span></span>
        <span class="text-sm flex items-center justify-between"><b class="flex items-center gap-2"><span class="material-symbols-outlined">
weight
</span> Costo Grammatura</b><span> ${
      cart.pagine.prezzo_grammatura > 0
        ? cart.pagine.prezzo_grammatura + " €"
        : "Nessun sovraprezzo"
    }</span></span>
        </div>
      </div>
    `;
    pagineDiv.appendChild(pagineItem);
  } else {
    let pagineItem = document.createElement("div");
    pagineItem.classList.add("opacity-50");
    pagineItem.innerText = "Nessun elemento";
    pagineDiv.appendChild(pagineItem);
  }

  if (cart.cd.contenuto) {
    let cdItem = document.createElement("div");

    let removeCd = document.createElement("button");
    removeCd.innerHTML = "<span class='material-symbols-outlined !text-white'>delete</span>";
    removeCd.classList.add("!bg-red-500", "text-white", "p-2", "rounded-md");
    removeCd.setAttribute("onclick", `removecd()`)

    cdItem.classList.add(
      "flex",
      "flex-col",
      "gap-4",
      "p-4",
      "bg-white",
      "border",
      "rounded-md",
      "shadow-md"
    );

    cdItem.innerHTML = `
    <div class="flex justify-between items-start gap-4">
    <div class="flex items-center image">
    <div class="cd-thumbnail animate-pulse bg-gray-200 w-24 h-24 rounded-md p-2"></div>
    </div>
    <div class='flex flex-col w-full'>
    <span class="text-sm flex items-center justify-between"><b>CD Serigrafato x ${
      cart.cd.qty
    }</b></span>
    ${
      Object.values(cart.cd.inputs).some((value) => value !== "")
        ? `<span class="text-xs mt-2 font-bold">Dati inseriti</span>`
        : ""
    }
    ${Object.entries(cart.cd.inputs)
      .filter(([key, value]) => value !== "")
      .map(([key, value]) => `<p class="text-xs mt-2">${key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())}: ${value}</p>`)
      .join("")} 
    </div>
    <div class='flex flex-col w-full self-stretch flex-grow-0'>
    <div class='font-bold cd-actions flex flex-col items-end flex-1 justify-between'><span class="text-sm">${
    cart.cd.qty ? (cart.cd.prezzo * cart.cd.qty).toFixed(2) : cart.cd.prezzo
  }€</span>${removeCd.outerHTML}</div></span>
    </div>
    </div>
  `;
    cdDiv.appendChild(cdItem);

    if (cart.cd.filenames.length > 0) {
      let fileListDrawer = document.createElement("div");
      fileListDrawer.classList.add(
        "flex",
        "flex-col",
        "gap-2",
        "p-4",
        "bg-white",
        "border",
        "rounded-md",
        "shadow-md",
        "drawer"
      );
      fileListDrawer.innerHTML = `
      <div class="drawer--header flex justify-between items-center">
      <h4 class="font-bold text-xl">File aggiuntivi</h4>
      </div>
      <div class="drawer--content">
      ${cart.cd.filenames
        .map((filename) => `<li class="text-sm mt-2">${filename}</li>`)
        .join("")}
        </div>
    `;
      cdDiv.appendChild(fileListDrawer);
    }
  } else {
    let cdItem = document.createElement("div");
    cdItem.classList.add("opacity-50");
    cdItem.innerText = "Nessun elemento";
    cdDiv.appendChild(cdItem);
  }

  tipologiaWrapper.appendChild(tipologiaDiv);
  rilegatureWrapper.appendChild(rilegatureDiv);
  pagineWrapper.appendChild(pagineDiv);
  cdWrapper.appendChild(cdDiv);

  spedizioneWrapper.forEach((el) => {
    let spedizione = document.querySelector("#spedizione").value;

    if (spedizione === "express") {
      el.textContent = (7.9).toFixed(2);
      totale += 7.9;
    } else el.textContent = (0.0).toFixed(2);
  });

  subtotaleWrapper.forEach((el) => {
    let spedizione = document.querySelector("#spedizione").value;
    let subtotale = (totale - iva).toFixed(2);

    if (spedizione !== "express") {
      el.textContent = subtotale;
    } else {
      el.textContent = subtotale;
      document.querySelector(
        ".subtotale"
      ).textContent = `${subtotale} + Express`;
    }
  });

  totaleWrapper.forEach((el) => {
    el.textContent = parseFloat(totale).toFixed(2);
  });

  if(cart.cd.url) {
    document.querySelectorAll(".cd-thumbnail").forEach((item) => {
      let image = new Image();
      image.src = cart.cd.url;
      image.classList.add("fancybox", "cursor-pointer");
      image.setAttribute("data-cd", "");
      item.appendChild(image);
      item.classList.remove("animate-pulse");

      // Initialize Fancybox
      Fancybox.bind("[data-cd]", {
        Image: {
          zoom: false,
        },
      });
    });
  }

  Fancybox.bind("[data-anteprima-rilegatura]")
};

function removeRilegatura(index) {
  cart.rilegature.splice(index, 1);

  updateCart();

  showToast('Elemento rimosso', 'warning', 'warning')
}

document.addEventListener("click", (e) => {
  const thesisCart = document.querySelector(".thesis--cart-dialog");
  const openCartBtn = document.querySelector(".open-cart-dialog");
  if (e.target.tagName === "BUTTON") {
    return;
  }
  if (!thesisCart.contains(e.target) && !openCartBtn.contains(e.target)) {
    thesisCart.classList.add("hidden");
  }
});

const removecd = () => { cart.cd = {}; updateCart(); showToast('Elemento rimosso', 'warning', 'warning') }