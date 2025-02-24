document.addEventListener('DOMContentLoaded', function() {
    // Prevent form submission
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
    });

    // Destination Dropdown
    document.querySelectorAll('.form-element-destination .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default anchor behavior
            
            var destination = item.textContent.trim();

            // Update the destination dropdown button text
            document.getElementById('destinationDropdown').textContent = destination;

            // Update the hidden input value
            document.getElementById('destination').value = destination;
        });
    });

    // Yacht Selection Dropdown
    document.querySelectorAll('.form-element-yacht .yacht-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var selectedYachts = [];
            var selectedYAttr = [];

            // Collect selected yachts
            document.querySelectorAll('.form-element-yacht .yacht-checkbox:checked').forEach(function(checkedBox) {
                selectedYachts.push(checkedBox.value);
                selectedYAttr.push(checkedBox.getAttribute("data-ytype"));

            });

            // Update the yacht dropdown button text
            document.getElementById('yachtDropdown').textContent = selectedYachts.join(',') || "Choose a yacht";

            // Update the hidden input value with selected yachts
            document.getElementById('ytm-yacht-type').value = selectedYAttr.join(',');
        });
    });

    // Function to update the total guest count and button text
    function updateTotalGuests() {
        var adultCount = parseInt(document.getElementById('adultCount').textContent);
        var childCount = parseInt(document.getElementById('childCount').textContent);
        var infantCount = parseInt(document.getElementById('infantCount').textContent);

        var totalGuests = adultCount + childCount;

        if (totalGuests === 0 && infantCount === 0) {
            document.getElementById('customerCount').textContent = 'Add guest';
        } else {
            var totalGuestsText = totalGuests + " Guest" + (totalGuests !== 1 ? "s" : "");
            if (infantCount > 0) {
                totalGuestsText += ", " + infantCount + " Infant" + (infantCount !== 1 ? "s" : "");
            }
            document.getElementById('customerCount').textContent = totalGuestsText;
        }

        document.getElementById('totalGuestsInput').value = totalGuests;
    }

    // Increase/Decrease Adult Count
    if( document.getElementById('increaseAdultBtn') ) {
        document.getElementById('increaseAdultBtn').addEventListener('click', function() {
            var adultCount = parseInt(document.getElementById('adultCount').textContent);
            document.getElementById('adultCount').textContent = adultCount + 1;
            updateTotalGuests();
        });
    }
    if (document.getElementById('decreaseAdultBtn') ) {
        document.getElementById('decreaseAdultBtn').addEventListener('click', function() {
            var adultCount = parseInt(document.getElementById('adultCount').textContent);
            var childCount = parseInt(document.getElementById('childCount').textContent);
            var infantCount = parseInt(document.getElementById('infantCount').textContent);

            if (childCount > 0 || infantCount > 0) return;

            if (adultCount > 0) {
                document.getElementById('adultCount').textContent = adultCount - 1;
                updateTotalGuests();
            }
        });
    }

    // Increase/Decrease Child Count
    if (document.getElementById('increaseChildBtn') ) {
        document.getElementById('increaseChildBtn').addEventListener('click', function() {
            var childCount = parseInt(document.getElementById('childCount').textContent);
            var adultCount = parseInt(document.getElementById('adultCount').textContent);

            if (adultCount < 1) {
                document.getElementById('adultCount').textContent = 1;
            }

            document.getElementById('childCount').textContent = childCount + 1;
            updateTotalGuests();
        });
    }

    if (document.getElementById('decreaseChildBtn') ) {
        document.getElementById('decreaseChildBtn').addEventListener('click', function() {
            var childCount = parseInt(document.getElementById('childCount').textContent);
            if (childCount > 0) {
                document.getElementById('childCount').textContent = childCount - 1;
                updateTotalGuests();
            }
        });
    }

    // Increase/Decrease Infant Count
    if (document.getElementById('increaseInfantBtn') ) {
        document.getElementById('increaseInfantBtn').addEventListener('click', function() {
            var infantCount = parseInt(document.getElementById('infantCount').textContent);
            var adultCount = parseInt(document.getElementById('adultCount').textContent);

            if (adultCount < 1) {
                document.getElementById('adultCount').textContent = 1;
            }

            document.getElementById('infantCount').textContent = infantCount + 1;
            updateTotalGuests();
        });
    }

    if (document.getElementById('decreaseInfantBtn') ) {
        document.getElementById('decreaseInfantBtn').addEventListener('click', function() {
            var infantCount = parseInt(document.getElementById('infantCount').textContent);
            if (infantCount > 0) {
                document.getElementById('infantCount').textContent = infantCount - 1;
                updateTotalGuests();
            }
        });
    }

    // Prevent the dropdown from closing when the plus or minus buttons are clicked
    document.querySelectorAll('#decreaseAdultBtn, #increaseAdultBtn, #decreaseChildBtn, #increaseChildBtn, #decreaseInfantBtn, #increaseInfantBtn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            event.preventDefault();
        });
    });

    // Initialize the total on page load
    updateTotalGuests();

    // manufacture year from
    let selectElementFrom = document.getElementById("yacht-manufacture-from");
    let hiddenInputFrom = document.getElementById("ytm-manufacture-from");
    // Update hidden input when select changes
    selectElementFrom.addEventListener("change", function () {
        hiddenInputFrom.value = this.value;
    });
    hiddenInputFrom.value = selectElementFrom.value;

    // manufacture year to
    let selectElementTo = document.getElementById("yacht-manufacture-to");
    let hiddenInputTo = document.getElementById("ytm-manufacture-to");
    // Update hidden input when select changes
    selectElementTo.addEventListener("change", function () {
        hiddenInputTo.value = this.value;
    });
    hiddenInputTo.value = selectElementTo.value;
});
