document.addEventListener("DOMContentLoaded", function () {
    let aboutBtn = document.getElementById("about-see-more");
    if (aboutBtn) {
        aboutBtn.addEventListener("click", function () {
            let aboutText = document.getElementById("yacht-about");
            aboutText.classList.toggle("show-more");
            aboutBtn.classList.toggle("show-more");

            this.textContent = aboutText.classList.contains("show-more") ? "Show Less" : "Read More";
        });
    }

    let amenitiesBtn = document.getElementById("amenities-see-more");
    if (amenitiesBtn) {
        amenitiesBtn.addEventListener("click", function () {
            let amenitiesText = document.getElementById("yacht-amenities");
            amenitiesText.classList.toggle("show-more");
            amenitiesBtn.classList.toggle("show-more");

            this.textContent = amenitiesText.classList.contains("show-more") ? "Show Less" : "View More";
        });
    }
});