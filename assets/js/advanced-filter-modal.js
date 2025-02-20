document.addEventListener("DOMContentLoaded", function () {
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