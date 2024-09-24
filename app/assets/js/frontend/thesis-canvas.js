/* Canvas */
const canvas = new fabric.Canvas("cd-canvas", {
  selection: false,
  hoverCursor: "default",
});

let placeholders = {
  Relatori: "[Relatori]",
  Controrelatori: "[Controrelatori]",
  Studente: "[Studente]",
  Matricola: "[Matricola]",
};

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

const titoloUni = new fabric.Textbox("[Nome Università]", {
  fontFamily: "Inter",
  fontWeight: "bold",
  fontSize: 20,
  originX: "center",
  originY: "top",
  left: canvas.width / 2,
  top: canvas.height * 0.10,
  selectable: false,
  hasControls: false,
  hasBorders: false,
  lockMovementX: true,
  lockMovementY: true,
  textAlign: "center",
  width: 320,
  height: 50,
  hoverCursor: "pointer",
});

canvas.add(titoloUni);

const nomeFacolta = new fabric.Textbox("[Facoltà]", {
  fontFamily: "Inter",
  fontSize: 20,
  originX: "center",
  originY: "top",
  left: canvas.width / 2,
  top: canvas.height * 0.2,
  selectable: false,
  hasControls: false,
  hasBorders: false,
  lockMovementX: true,
  lockMovementY: true,
  textAlign: "center",
  width: 350,
  height: 50,
  hoverCursor: "pointer",
});

canvas.add(nomeFacolta);

const corsoDiLaurea = new fabric.Textbox("[Corso di Laurea]", {
  fontFamily: "Inter",
  fontSize: 18,
  originX: "center",
  originY: "top",
  left: canvas.width / 2,
  top: canvas.height * 0.25,
  selectable: false,
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

const titoloTesi = new fabric.Textbox("[TITOLO TESI DI LAUREA]", {
  fontFamily: "Inter",
  fontSize: 20,
  fontWeight: "bold",
  originX: "center",
  originY: "center",
  left: canvas.width / 2,
  top: canvas.height * 0.7, // Adjusted top position
  selectable: false,
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
  selectable: false,
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
  "Studente:\n[Nome Cognome]\nMatricola:\n[Matricola]",
  {
    fontFamily: "Inter",
    fontSize: 16,
    originX: "left",
    originY: "center",
    left: canvas.width * 0.05, // Adjusted left position
    top: canvas.height / 2,
    selectable: false,
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
  "Relatore:\n[Relatore]\nContro relatore:\n[Contro relatore]",
  {
    fontFamily: "Inter",
    fontSize: 16,
    originX: "right",
    originY: "center",
    left: canvas.width * 0.95, // Adjusted left position
    top: canvas.height / 2,
    selectable: false,
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
    titoloUni.text = "[Nome Università]\n[Facoltà]";
    canvas.renderAll();
  }
});

nomeFacolta.on("editing:exited", function (e) {
  if (nomeFacolta.text === "") {
    nomeFacolta.fontSize = 20;
    nomeFacolta.text = "[Facoltà]";
    canvas.renderAll();
  }
});

corsoDiLaurea.on("editing:exited", function (e) {
  if (corsoDiLaurea.text === "") {
    corsoDiLaurea.fontSize = 18;
    corsoDiLaurea.text = "[Corso di Laurea]";
    canvas.renderAll();
  }
});

titoloTesi.on("editing:exited", function (e) {
  if (titoloTesi.text === "") {
    titoloTesi.fontSize = 20;
    titoloTesi.text = "[TITOLO TESI DI LAUREA]";
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
    testoStudente.text = "Studente:\n[Nome Cognome]\nMatricola:\n[Matricola]";
    canvas.renderAll();
  }
});

testoRelatore.on("editing:exited", function (e) {
  if (testoRelatore.text === "") {
    testoRelatore.fontSize = 16;
    testoRelatore.text =
      "Relatore:\n[Nome Cognome]\nContro relatore:\n[Nome Cognome]";
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

  const submitButton = formCD.querySelector("button[type='submit']");

  const requiredFields = [
    "nome_universita",
    "nome_facolta",
    "corso_laurea",
    "titolo_tesi",
    "anno_accademico",
    "nome_studente",
    "numero_matricola",
    "nome_relatori",
    "nome_controrelatori",
  ];

  let allFieldsPopulated = requiredFields.every((field) => {
    const element = formCD.querySelector(`[name='${field}']`);
    return element && element.value.trim() !== "";
  });

  if (!allFieldsPopulated) {
    alert("Compila tutti i campi obbligatori");
    return;
  } else {
    document.querySelector("#no_cd").click();
  }

  cart.cd = {
    contenuto: selectCD.value,
    prezzo: 10,
    qty: formCD.querySelector("[name='quantita_cd']").value,
    filenames: document.querySelectorAll("[data-filename]")
      ? Array.from(document.querySelectorAll("[data-filename]")).map((item) =>
          item.getAttribute("data-filename")
        )
      : [],
    inputs: placeholders ? { ...placeholders } : {},
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
      cart.cd = { ...cart.cd, url: JSON.parse(response).url };
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

    },
    error: function (error) {
      console.error(error);
    },
  });

  formCD.reset();

  titoloUni.text = "[Nome Università]";
  nomeFacolta.text = "[Facoltà]";
  corsoDiLaurea.text = "[Corso di Laurea]";
  titoloTesi.text = "[TITOLO TESI DI LAUREA]";
  annoAccademico.text = "Anno Accademico\n20XX/20XX";
  testoStudente.text = "Studente:\n[Nome Cognome]\nMatricola:\n[Matricola]";
  testoRelatore.text =
    "Relatore:\n[Nome Cognome]\nContro relatore:\n[Nome Cognome]";

  placeholders = {
    Relatori: "[Relatori]",
    Controrelatori: "[Controrelatori]",
    Studente: "[Studente]",
    Matricola: "[Matricola]",
  };

  canvas.renderAll();
};

selectCD.onchange = (e) => {
  const listWrapper = document.querySelector("#file_list_wrapper");
  const selected = e.currentTarget.value;
  const submitButton = document.querySelector("#form_cd button[type='submit']");
  submitButton.disabled = false;

  if (selected !== "file") {
    if (!listWrapper.classList.contains("hidden"))
      listWrapper.classList.add("hidden");
    document.querySelector(".formati-accettati").classList.add("hidden");

    listWrapper.querySelector("input[type='file']").disabled = true;
  } else {
    listWrapper.classList.remove("hidden");
    listWrapper.classList.add("flex");
    document.querySelector(".formati-accettati").classList.remove("hidden");
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

        if (cart.cd.filenames.includes(filename)) {
          cart.cd.filenames = cart.cd.filenames.filter(
            (item) => item !== filename
          );
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

const editorCd = document.querySelector("form_cd");

const textElements = Array.from(
  document.querySelector("#form_cd").elements
).filter(
  (element) => element.type === "text" || element.tagName === "TEXTAREA"
);
const canvasElements = [
  titoloUni,
  nomeFacolta,
  corsoDiLaurea,
  titoloTesi,
  annoAccademico,
  testoStudente,
  testoRelatore,
];

let textMapping = {
  nome_universita: titoloUni,
  nome_facolta: nomeFacolta,
  corso_laurea: corsoDiLaurea,
  titolo_tesi: titoloTesi,
  anno_accademico: annoAccademico,
  nome_studente: testoStudente,
  numero_matricola: testoStudente,
  nome_relatori: testoRelatore,
  nome_controrelatori: testoRelatore,
};

textElements.forEach((element) => {
  element.addEventListener("keyup", function () {
    if (
      textMapping[element.name] &&
      element.name !== "nome_relatore" &&
      element.name !== "nome_studente"
    ) {
      textMapping[element.name].text = element.value;
      canvas.renderAll();

      if (element.name === "anno_accademico") {
        textMapping[element.name].text = `Anno Accademico\n ${element.value}`;
        canvas.renderAll();
      }
    }

    if (
      element.name === "nome_studente" ||
      element.name === "numero_matricola"
    ) {
      if (element.name === "nome_studente") {
        placeholders["Studente"] = element.value;
      }

      if (element.name === "numero_matricola") {
        placeholders["Matricola"] = element.value;
      }

      textMapping[
        element.name
      ].text = `Studente: \n${placeholders["Studente"]}\nMatricola: \n${placeholders["Matricola"]}`;
      canvas.renderAll();
    }

    if (
      element.name === "nome_relatori" ||
      element.name === "nome_controrelatori"
    ) {
      if (element.name === "nome_relatori") {
        placeholders["Relatori"] = element.value;
        if (element.value.split(",").length > 1)
          placeholders["Relatori"] = element.value.split(",").join("\n");
      }

      if (element.name === "nome_controrelatori") {
        placeholders["Controrelatori"] = element.value;
        if (element.value.split(",").length > 1)
          placeholders["Controrelatori"] = element.value.split(",").join("\n");
      }

      textMapping[
        element.name
      ].text = `Relatore:\n${placeholders["Relatori"]}\nControrelatore:\n${placeholders["Controrelatori"]}`;

      canvas.renderAll();
    }
  });
});
