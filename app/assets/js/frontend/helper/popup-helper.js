(async () => {
  const waitForElementorProFrontend = () => {
    return new Promise((resolve) => {
      const checkElementorProFrontend = () => {
        if (typeof elementorProFrontend !== "undefined") {
          resolve();
        } else {
          setTimeout(checkElementorProFrontend, 100);
        }
      };
      checkElementorProFrontend();
    });
  };

  await waitForElementorProFrontend();

  if (typeof elementorFrontend === "undefined") {
    console.error("Elementor Pro not found - Thesis Popup will not work");
  } else {
    document.addEventListener("mouseleave", (e) => {
      if (
        e.clientY <= 0 ||
        e.clientX <= 0 ||
        e.clientX >= window.innerWidth ||
        e.clientY >= window.innerHeight
      ) {
        !elementorProFrontend.modules.popup.popupPopped && elementorProFrontend.modules.popup.showPopup( { id: popupId } );
      }
    });

    window.onbeforeunload = () => {
      return "";
    };
  }
})();
