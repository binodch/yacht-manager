document.addEventListener('DOMContentLoaded', function () {
    // Prevent form submission
    let bannerForm = document.querySelector('.ytm-select-filter-form');
    if (bannerForm) {
        bannerForm.addEventListener('submit', function (event) {
            event.preventDefault();
        });
    }

    /* Destination Dropdown */
    document.querySelectorAll('.form-element-destination .dropdown-item').forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default anchor behavior

            let destination = this.textContent.trim();
            let destinationDropdown = document.getElementById('destinationDropdown');
            let destinationDropdownMobile = document.getElementById('destinationDropdownMobile');
            let destinationInput = document.getElementById('banner-destination');

            if (destinationDropdown) destinationDropdown.textContent = destination;
            if (destinationDropdownMobile) destinationDropdown.textContent = destination;
            if (destinationInput) destinationInput.value = destination;

            // Remove 'active' class from all dropdown items
            document.querySelectorAll('.form-element-destination .dropdown-item').forEach(el => el.classList.remove('active'));

            // Add 'active' class to the clicked item
            this.classList.add('active');
        });
    });

    /* Yacht Selection Dropdown */
    document.querySelectorAll('.form-element-yacht .yacht-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            let selectedYachts = [];
            let selectedYAttr = [];

            document.querySelectorAll('.form-element-yacht .yacht-checkbox:checked').forEach(function (checkedBox) {
                selectedYachts.push(checkedBox.value);
                selectedYAttr.push(checkedBox.getAttribute("data-ytype"));
            });

            let yachtDropdown = document.getElementById('yachtDropdown');
            let yachtInput = document.getElementById('ytm-yacht-type');

            if (yachtDropdown) yachtDropdown.textContent = selectedYachts.join(', ') || "Choose a yacht";
            if (yachtInput) yachtInput.value = selectedYAttr.join(',');
        });
    });

    // Function to update the total guest count and button text
    function updateTotalGuests() {
        let adultCount = parseInt(document.getElementById('adultCount')?.textContent || 0);
        let childCount = parseInt(document.getElementById('childCount')?.textContent || 0);
        let infantCount = parseInt(document.getElementById('infantCount')?.textContent || 0);
        let customerCount = document.getElementById('customerCount');
        let totalGuestsInput = document.getElementById('totalGuestsInput');

        let totalGuests = adultCount + childCount;
        let totalGuestsText = totalGuests === 0 && infantCount === 0 ? 'Add guest' :
            `${totalGuests} Guest${totalGuests !== 1 ? 's' : ''}${infantCount > 0 ? `, ${infantCount} Infant${infantCount !== 1 ? 's' : ''}` : ''}`;

        if (customerCount) customerCount.textContent = totalGuestsText;
        if (totalGuestsInput) totalGuestsInput.value = totalGuests;
    }

    function setupGuestButton(increaseId, decreaseId, countId, minCount = 0) {
        let increaseBtn = document.getElementById(increaseId);
        let decreaseBtn = document.getElementById(decreaseId);
        let countEl = document.getElementById(countId);

        if (increaseBtn && countEl) {
            increaseBtn.addEventListener('click', function () {
                countEl.textContent = parseInt(countEl.textContent) + 1;
                updateTotalGuests();
            });
        }

        if (decreaseBtn && countEl) {
            decreaseBtn.addEventListener('click', function () {
                let count = parseInt(countEl.textContent);
                if (count > minCount) {
                    countEl.textContent = count - 1;
                    updateTotalGuests();
                }
            });
        }
    }

    setupGuestButton('increaseAdultBtn', 'decreaseAdultBtn', 'adultCount');
    setupGuestButton('increaseChildBtn', 'decreaseChildBtn', 'childCount');
    setupGuestButton('increaseInfantBtn', 'decreaseInfantBtn', 'infantCount');

    // Prevent dropdown from closing when buttons are clicked
    document.querySelectorAll('#decreaseAdultBtn, #increaseAdultBtn, #decreaseChildBtn, #increaseChildBtn, #decreaseInfantBtn, #increaseInfantBtn')
        .forEach(button => {
            if (button) {
                button.addEventListener('click', function (event) {
                    event.stopPropagation();
                    event.preventDefault();
                });
            }
        });

    // Initialize the total on page load
    updateTotalGuests();

    function syncDropdownWithHiddenInput(selectId, hiddenInputId) {
        let selectElement = document.getElementById(selectId);
        let hiddenInput = document.getElementById(hiddenInputId);

        if (selectElement && hiddenInput) {
            selectElement.addEventListener("change", function () {
                hiddenInput.value = this.value;
            });
            hiddenInput.value = selectElement.value;
        }
    }

    syncDropdownWithHiddenInput("yacht-manufacture-from", "ytm-manufacture-from");
    syncDropdownWithHiddenInput("yacht-manufacture-to", "ytm-manufacture-to");

    
    const dropdownItems = document.querySelectorAll(".filter-section-mobile .dropdown-item");
    const hiddenInput = document.getElementById("mobile-destination");
    const mobileForm = document.getElementById("ytm-banner-mobile-form");
    const dropdownButton = document.getElementById("destinationDropdownMobile");

    dropdownItems.forEach(item => {
        item.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior

            const selectedText = this.textContent.trim();
            
            // Update button text
            dropdownButton.textContent = selectedText;
            
            // Update hidden input value
            hiddenInput.value = selectedText;

            // Submit the form
            mobileForm.submit();
        });
    });
    

});