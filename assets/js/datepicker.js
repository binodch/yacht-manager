document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.querySelector('.ytm-filter-wrap');
    if (filterForm) {
        let selectedStartDate = null;
        let selectedEndDate = null;

        const startDatePicker = flatpickr("#startDate", {
            mode: "multiple", // Show two months but allow only one selection
            dateFormat: "d M",
            showMonths: 2,
            minDate: "today",
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length > 1) {
                    instance.clear(); // Clear previous selection
                    instance.setDate(selectedDates.slice(-1)); // Keep only the last selected date
                }

                selectedStartDate = selectedDates[0] || null;

                if (selectedStartDate) {
                    // Disable dates before the selected start date in the end date picker
                    endDatePicker.set('minDate', selectedStartDate);
                }

                // Prevent selecting earlier dates in the start date picker after choosing a date
                startDatePicker.set('disable', [(date) => date < selectedStartDate]);
            }
        });

        const endDatePicker = flatpickr("#endDate", {
            mode: "multiple", // Show two months but allow only one selection
            dateFormat: "d M",
            showMonths: 2,
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length > 1) {
                    instance.clear(); // Clear previous selection
                    instance.setDate(selectedDates.slice(-1)); // Keep only the last selected date
                }

                selectedEndDate = selectedDates[0] || null;
            }
        });
    }
});
