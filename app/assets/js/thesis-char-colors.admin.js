const creaColoriHTML = (oggettiRaggruppati) => {
    for (const id in oggettiRaggruppati) {
      let gruppoCounter = 0;
      const gruppo = oggettiRaggruppati[id];
      console.log(gruppo)
    }
}

const getGlobalVarianti = async () => {
  let options = {
    action: "get_varianti",
  };

  let varianti = await jQuery.ajax({
    dataType: "json",
    method: "GET",
    url: "admin-ajax.php",
    data: options,
    success: (response) => {
      let parseData = JSON.parse(response.data);
      let results = JSON.parse(parseData.results);
      return results;
    },
  });

  let response = JSON.parse(varianti.data);
  let results = JSON.parse(response.results);

  const raggruppaPerId = (array) => {
    const raggruppato = {};

    array.forEach((oggetto) => {
      const { id_copertina } = oggetto;

      if (!raggruppato[id_copertina]) {
        raggruppato[id_copertina] = [];
      }

      raggruppato[id_copertina].push(oggetto);
    });

    return raggruppato;
  };

  // Utilizza la funzione per raggruppare gli oggetti
  const oggettiRaggruppati = raggruppaPerId(results);
  creaColoriHTML(oggettiRaggruppati)
};

getGlobalVarianti()