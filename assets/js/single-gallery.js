document.addEventListener("DOMContentLoaded", function () {
    var yachtSwiperContainer = document.querySelector(".yacht-swiper-container");

    if (yachtSwiperContainer) { // Ensure the element exists
        var swiper = new Swiper(".yacht-swiper-container", {
            slidesPerView: 2,
            spaceBetween: 30,
            centeredSlides: false, // Ensures items align correctly
            loop: false, // Prevents empty space
            navigation: {
                nextEl: ".yacht-swiper-container .swiper-button-next",
                prevEl: ".yacht-swiper-container .swiper-button-prev",
            },
        });
    }
});