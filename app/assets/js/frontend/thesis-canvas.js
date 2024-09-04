/* Canvas */
const canvas = new fabric.Canvas("cd-canvas", { selection: true, hoverCursor: "default" });
canvas.setDimensions({ width: 600, height: 600 });

canvas.backgroundColor = "#ffffff";

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
    fontFamily: "arial",
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
  fontFamily: "arial",
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
  fontFamily: "arial",
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
  width: 250,
  height: 100,
  hoverCursor: "pointer",
});


canvas.add(titoloTesi);

const annoAccademico = new fabric.Textbox("Anno Accademico 20XX/20XX", {
  fontFamily: "arial",
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
    fontFamily: "arial",
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
    fontFamily: "arial",
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
