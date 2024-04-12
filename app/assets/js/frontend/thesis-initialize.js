function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

if (typeof init != "undefined" && init) {
  init.forEach((element) => {
    let preloader = document.createElement("div");

    preloader.classList.add(
      "h-full",
      "w-full",
      "z-[99]",
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
      "<img class='animate-spin w-10 h-10' src='/wp-content/plugins/thesis/app/assets/img/svg/loading.svg' />";

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
          url: ajaxurl,
          data: data,
          success: (response) => {
            init.forEach((item) => item.removeAttribute("disabled"))
            let res = JSON.parse(response);
            setCookie("thesis_session", res.thesis_session, 1);
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
