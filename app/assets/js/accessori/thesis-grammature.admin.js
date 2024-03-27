const listGrammature = document.querySelector("#list--grammature");

jQuery.ajax({
  dataType: "json",
  method: "GET",
  url: "admin-ajax.php",
  data: {
    action: "get_grammature",
  },
  success: (response) => {
    res = JSON.parse(response.data);
    results = JSON.parse(res.results);
    getGrammature(results);
  },
});

const getGrammature = (results) => {
  if (results.length === 0) {
    listGrammature.removeAttribute("class");
    listGrammature.innerHTML = "Non ci sono grammature.";
  }
};
