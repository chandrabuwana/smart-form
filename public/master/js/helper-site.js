function fetchSite(cb=function(site) {}) {
  axios.post("/bss-form/catering/helper-site", {
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })
  .then(function(data) {
      var opstionSite = []
      // opstionSite.push(new Option("--- Cari Site ---", "", true, true))
      opstionSite.push({
          id: "",
          text: "--- Cari Site ---"
      })

      data.data.data.forEach(element => {
          opstionSite.push({
              id: element.id,
              text: element.text
          })

          // opstionSite.push(new Option(element.text, element.id))
      });
      
      cb(opstionSite)
  })
  .catch(function(err) {
      console.log(err)
  })
  .finally( function(){

  });
}