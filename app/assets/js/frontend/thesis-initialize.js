if (typeof init != "undefined" && init) {

  let fileUpload = document.createElement("input");
  fileUpload.type = "file"
  fileUpload.accept = ".pdf";
  
  fileUpload.classList.add("hidden");

  init.appendChild(fileUpload)

  init.onclick = () => {
    fileUpload.click();

    fileUpload.onchange = () => {
        console.log("changed");
    }
  }
}
