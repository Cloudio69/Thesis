const listSegnalibri = document.querySelector("#list--segnalibri");

jQuery.ajax({
  dataType: "json",
  method: "GET",
  url: "admin-ajax.php",
  data: {
    action: "get_segnalibri",
  },
  success: (response) => {
    res = JSON.parse(response.data);
    results = JSON.parse(res.results);
    getSegnalibri(results);
  },
});

const getSegnalibri = (results) => {
  if (results.length === 0) {
    listSegnalibri.removeAttribute("class");
    listSegnalibri.innerHTML = "Non ci sono segnalibri.";
  }
};
