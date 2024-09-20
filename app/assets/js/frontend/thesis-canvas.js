/* Canvas */
const canvas = new fabric.Canvas("cd-canvas", {
  selection: false,
  hoverCursor: "default",
});
// Set background color TRANSPARENT
canvas.setDimensions({ width: 600, height: 600 });

canvas.backgroundColor = "transparent";

const img = new fabric.Image.fromURL(
  "/wp-content/plugins/thesis/app/assets/img/cd-mask.png",
  function (img) {
    img.set({
      scaleX: canvas.width / img.width,
      scaleY: canvas.height / img.height,
      selectable: false,
    });
    canvas.add(img);
    canvas.sendToBack(img);
  }
);

const titoloUni = new fabric.Textbox(
  "Università degli Studi di Bari\nFacoltà di Lorem Ipsum",
  {
    fontFamily: "Inter",
    fontWeight: "bold",
    fontSize: 20,
    originX: "center",
    originY: "top",
    left: canvas.width / 2,
    top: canvas.height * 0.15,
    selectable: true,
    hasControls: false,
    hasBorders: false,
    lockMovementX: true,
    lockMovementY: true,
    textAlign: "center",
    width: 350,
    height: 50,
    hoverCursor: "pointer",
  }
);

canvas.add(titoloUni);

const corsoDiLaurea = new fabric.Textbox("Corso di Laurea in Lorem Ipsum", {
  fontFamily: "Inter",
  fontSize: 18,
  originX: "center",
  originY: "top",
  left: canvas.width / 2,
  top: canvas.height * 0.25,
  selectable: true,
  hasControls: false,
  hasBorders: false,
  lockMovementX: true,
  lockMovementY: true,
  textAlign: "center",
  width: 350,
  hoverCursor: "pointer",
});

canvas.add(corsoDiLaurea);

// titoloTesi

const titoloTesi = new fabric.Textbox("TITOLO TESI DI LAUREA", {
  fontFamily: "Inter",
  fontSize: 20,
  fontWeight: "bold",
  originX: "center",
  originY: "center",
  left: canvas.width / 2,
  top: canvas.height * 0.7, // Adjusted top position
  selectable: true,
  hasControls: false,
  hasBorders: false,
  lockMovementX: true,
  lockMovementY: true,
  textAlign: "center",
  width: 350,
  height: 100,
  hoverCursor: "pointer",
});

canvas.add(titoloTesi);

const annoAccademico = new fabric.Textbox("Anno Accademico 20XX/20XX", {
  fontFamily: "Inter",
  fontSize: 18,
  originX: "center",
  originY: "bottom",
  left: canvas.width / 2,
  top: canvas.height * 0.95,
  selectable: true,
  hasControls: false,
  hasBorders: false,
  lockMovementX: true,
  lockMovementY: true,
  textAlign: "center",
  width: 200,
  hoverCursor: "pointer",
});

canvas.add(annoAccademico);

// testoStudente

const testoStudente = new fabric.Textbox(
  "Studente:\nCarlo Bianchi\nMatricola:\nXXXXXX",
  {
    fontFamily: "Inter",
    fontSize: 16,
    originX: "left",
    originY: "center",
    left: canvas.width * 0.05, // Adjusted left position
    top: canvas.height / 2,
    selectable: true,
    hasControls: false,
    hasBorders: false,
    lockMovementX: true,
    lockMovementY: true,
    textAlign: "left",
    width: 150,
    hoverCursor: "pointer",
  }
);

canvas.add(testoStudente);

// testoRelatore

const testoRelatore = new fabric.Textbox(
  "Relatore:\nMario Rossi\nContro relatore:\nJohn Doe",
  {
    fontFamily: "Inter",
    fontSize: 16,
    originX: "right",
    originY: "center",
    left: canvas.width * 0.95, // Adjusted left position
    top: canvas.height / 2,
    selectable: true,
    hasControls: false,
    hasBorders: false,
    lockMovementX: true,
    lockMovementY: true,
    textAlign: "right",
    width: 150,
    hoverCursor: "pointer",
  }
);

canvas.add(testoRelatore);

titoloUni.on("editing:exited", function (e) {
  if (titoloUni.text === "") {
    titoloUni.fontSize = 20;
    titoloUni.text = "Università degli Studi di Bari\nFacoltà di Lorem Ipsum";
    canvas.renderAll();
  }
});

corsoDiLaurea.on("editing:exited", function (e) {
  if (corsoDiLaurea.text === "") {
    corsoDiLaurea.fontSize = 18;
    corsoDiLaurea.text = "Corso di Laurea in Lorem Ipsum";
    canvas.renderAll();
  }
});

titoloTesi.on("editing:exited", function (e) {
  if (titoloTesi.text === "") {
    titoloTesi.fontSize = 20;
    titoloTesi.text = "TITOLO TESI DI LAUREA";
    canvas.renderAll();
  }
});

annoAccademico.on("editing:exited", function (e) {
  if (annoAccademico.text === "") {
    annoAccademico.fontSize = 18;
    annoAccademico.text = "Anno Accademico 20XX/20XX";
    canvas.renderAll();
  }
});

testoStudente.on("editing:exited", function (e) {
  if (testoStudente.text === "") {
    testoStudente.fontSize = 16;
    testoStudente.text = "Studente:\nCarlo Bianchi\nMatricola:\nXXXXXX";
    canvas.renderAll();
  }
});

testoRelatore.on("editing:exited", function (e) {
  if (testoRelatore.text === "") {
    testoRelatore.fontSize = 16;
    testoRelatore.text = "Relatore:\nMario Rossi\nContro relatore:\nJohn Doe";
    canvas.renderAll();
  }
});

titoloTesi.on("changed", function (e) {
  const obj = titoloTesi;
  const text = obj.text;

  if (text.length > 20) {
    obj.fontSize = 16;
  } else {
    obj.fontSize = 20;
  }
  canvas.renderAll();
});

canvas.on("object:moving", function (e) {
  const obj = e.target;

  // Check boundaries and adjust object position
  if (obj.left < 0) {
    obj.left = 0;
  }
  if (obj.top < 0) {
    obj.top = 0;
  }
  if (obj.left + obj.width * obj.scaleX > canvas.width) {
    obj.left = canvas.width - obj.width * obj.scaleX;
  }
  if (obj.top + obj.height * obj.scaleY > canvas.height) {
    obj.top = canvas.height - obj.height * obj.scaleY;
  }
});

canvas.renderAll();

const editCd = document.querySelector("#edit-cd");
const selectCD = document.querySelector("#contenuto");
const fileListCD = document.querySelector("#file_cd");
const fileListWrapper = document.querySelector("#file_list_cd");
const formCD = document.querySelector("#form_cd");

editCd.addEventListener("click", () => {
  document.querySelector("#form_cd").classList.remove("hidden");
  document.querySelector("#form_cd").classList.add("flex");
  document.querySelector(".tipo--stampa-cd").classList.add("hidden");
});

formCD.onsubmit = (e) => {
  e.preventDefault();
  
  cart.cd = {
    contenuto: selectCD.value,
    prezzo: 10,
    qty: formCD.querySelector("[name='quantita_cd']").value,
    filenames: document.querySelectorAll('[data-filename]') ? Array.from(document.querySelectorAll('[data-filename]')).map(item => item.getAttribute('data-filename')) : [],
  };

  const data = new FormData();
  data.append("action", "upload_cd_cover");
  data.append("nonce", nonce);
  data.append("thesis_session", getCookie("thesis_session"));
  data.append("canvas", canvas.toDataURL());

  jQuery.ajax({
    url: ajaxurl,
    type: "POST",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (response) {
      cart.cd = { ...cart.cd, url: JSON.parse(response).url}
    },
    error: function (error) {
      console.error(error);
    },
  });
};

selectCD.onchange = (e) => {
  const listWrapper = document.querySelector("#file_list_wrapper");
  const selected = e.currentTarget.value;
  if (selected !== "file") {
    if (!listWrapper.classList.contains("opacity-50"))
      listWrapper.classList.add("opacity-50");
    listWrapper.querySelector("input[type='file']").disabled = true;
  } else {
    listWrapper.classList.remove("opacity-50");
    listWrapper.querySelector("input[type='file']").disabled = false;
  }
};

fileListCD.onchange = (e) => {
  const files = e.currentTarget.files;
  const list = fileListWrapper;
  let isAlreadyUploaded = false;

  if (list.querySelector("[data-filename]")) {
    list.querySelectorAll("[data-filename]").forEach((item) => {
      if (item.getAttribute("data-filename") === files[0].name) {
        alert("Il file è già stato caricato");
        isAlreadyUploaded = true;
      }
    });
  }

  if (isAlreadyUploaded) return;

  const data = new FormData();
  data.append("action", "upload_cd_file");
  data.append("nonce", nonce);
  data.append("thesis_session", getCookie("thesis_session"));
  data.append("file", files[0]);

  // Upload file with ajax where action is upload_cd_file

  jQuery.ajax({
    url: ajaxurl,
    type: "POST",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    xhr: function () {
      const xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener(
        "progress",
        function (evt) {
          if (evt.lengthComputable) {
            const percentComplete = evt.loaded / evt.total;
          }
        },
        false
      );
      return xhr;
    },
    success: function (response) {
      if (list.querySelector("p")) list.querySelector("p").remove();

      const listItem = document.createElement("div");
      listItem.classList.add(
        "flex",
        "items-center",
        "justify-between",
        "p-2",
        "border",
        "border-gray-200"
      );
      listItem.innerHTML = `<span class="text-sm">${files[0].name}</span><button class="text-sm text-white bg-red-600 p-2" id="remove_file_cd" data-filename='${files[0].name}'>Rimuovi</button>`;

      const removeButton = listItem.querySelector("#remove_file_cd");
      removeButton.onclick = (e) => {
        e.preventDefault();

        let filename = removeButton.getAttribute("data-filename");
        const data = new FormData();

        if(cart.cd.filenames.includes(filename)) {
          cart.cd.filenames = cart.cd.filenames.filter(item => item !== filename);
        }

        data.append("action", "remove_cd_file");
        data.append("nonce", nonce);
        data.append("thesis_session", getCookie("thesis_session"));
        data.append("filename", filename);

        jQuery.ajax({
          url: ajaxurl,
          type: "POST",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          success: function (response) {
            removeButton.parentElement.remove();
            

            if (!list.firstElementChild) {
              const p = document.createElement("p");
              p.classList.add("text-sm", "opacity-50");
              p.textContent = "Nessun file selezionato";
              list.appendChild(p);
            }
          },
          error: function (error) {
            console.error(error);
          },
        });
      };

      list.appendChild(listItem);
      fileListCD.value = "";
    },
    error: function (error) {
      console.error(error);
    },
  });
};
