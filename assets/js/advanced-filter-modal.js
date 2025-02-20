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