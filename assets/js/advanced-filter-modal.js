document.addEventListener("DOMContentLoaded", function () {
  if(document.getElementById('ytm-advanced-filter-modal')) {

    var myModal = new bootstrap.Modal(document.getElementById('ytm-advanced-filter-modal'));
    
    // Open modal on button click
    document.querySelector(".ytm-modal-popup").addEventListener("click", function () {
      myModal.show();
    });
    
    // Close modal on close button or "Close" button click
    document.querySelectorAll(".close, .ytm-modal-close").forEach(function (element) {
      element.addEventListener("click", function () {
        myModal.hide();
      });
    });
  }
});

/* range slider */
  function ytmUpdateRangeValue(value) {
    document.getElementById("rangeValue").textContent = value;
    document.getElementById("ytm-cabin").value = value;
}

/* yacht type checkboxes */
document.addEventListener("DOMContentLoaded", function () {
  const checkboxes = document.querySelectorAll(".yacht-checkbox-ct");
  const hiddenInput = document.getElementById("ytm-charter-type");

  checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", function () {
          let selectedValues = Array.from(checkboxes)
              .filter((cb) => cb.checked)
              .map((cb) => cb.value)
              .join(","); // Join selected values as a comma-separated string
          
          hiddenInput.value = selectedValues;
      });
  });
});

// const data = {
//   "lastModified": 1739955033,
//   "uri": "c::15913269941::vessel::21af4b7e-6727-11ee-ba46-d3cdf96e9da3",
//   "hero": "/media/media::image::a::vessel::21af4b7e-6727-11ee-ba46-d3cdf96e9da3::assets::0f503770-734f-11ee-99a3-ab5213f0e455.jpeg/{imageVariant}",
//   "name": "CARINTHIA VII",
//   "length": "97.2",
//   "cabins": "8",
//   "sleeps": "12",
//   "builtYear": "2002",
//   "make": "Lurssen"
// };

// const imageVariant = "original"; // Change this if needed
// const imageUrl = data.hero.replace("{imageVariant}", imageVariant);

// document.getElementById("yachtImage").src = imageUrl;
// document.getElementById("yachtImage").alt = data.name;
