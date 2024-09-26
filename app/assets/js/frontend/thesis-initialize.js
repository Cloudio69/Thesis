if (typeof init != "undefined" && init) {
  init.forEach((element) => {
    let preloader = document.createElement("div");

    preloader.classList.add(
      "h-full",
      "w-full",
      "z-[999]",
      "flex",
      "justify-center",
      "items-center",
      "flex-col",
      "fixed",
      "bg-white",
      "top-0",
      "gap-2"
    );
    preloader.innerHTML =
      "<img class='animate-spin w-10 h-10' src='/wp-content/plugins/thesis/app/assets/img/svg/loading.svg' /><p id='status'>Caricamento...</p>";

    let fileUpload = document.createElement("input");
    fileUpload.type = "file";
    fileUpload.accept = ".pdf";

    fileUpload.classList.add("hidden");

    element.appendChild(fileUpload);

    element.onclick = () => {
      fileUpload.click();

      fileUpload.onchange = (e) => {
        if (
          !e.currentTarget.files[0] ||
          e.currentTarget.files[0].type !== "application/pdf"
        ) {
          console.error("Errore nel caricamento file.");
          return;
        }

        document.body.appendChild(preloader);

        let data = new FormData();
        data.append("action", "upload_file");
        data.append("nonce", nonce);
        data.append("file", e.currentTarget.files[0]);

        jQuery.ajax({
          processData: false,
          contentType: false,
          type: "POST",
          cache: false,
          url: ajaxurl,
          data: data,
          xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener(
              "progress",
              function (evt) {
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  jQuery("#status").html(
                    "<p class='text-xl'>" +
                      Math.round(percentComplete * 100) +
                      "% </p>"
                  );
                }
              },
              false
            );
            return xhr;
          },
          success: (response) => {
            init.forEach((item) => item.removeAttribute("disabled"));
            let res = JSON.parse(response);
            setCookie("thesis_session", res.thesis_session, 1);
            if(getCookie('thesis_page_generation')) setCookie('thesis_page_generation', '', 0);
            window.location.href = configuratore;
          },
          error: (error) => {
            console.error(
              "Si è verificato un errore durante il caricamento del file:",
              error
            );
          },
        });
      };
    };
  });
}
