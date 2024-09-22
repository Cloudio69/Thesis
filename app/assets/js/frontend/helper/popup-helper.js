(async () => {
  const waitForElementorProFrontend = () => {
    return new Promise((resolve, reject) => {
      let attempts = 0;
      const maxAttempts = 10;

      const checkElementorProFrontend = () => {
        if (typeof elementorProFrontend !== "undefined") {
          resolve();
        } else if (attempts < maxAttempts) {
          attempts++;
          setTimeout(checkElementorProFrontend, 100);
        } else {
          reject(new Error("Elementor Pro not found after 10 attempts"));
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
  }
})();


window.onbeforeunload = () => {
  return "";
};
