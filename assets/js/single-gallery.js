document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".yacht-swiper-container", {
        slidesPerView: 2,
        spaceBetween: 30,
        centeredSlides: false, /* Ensures items align correctly */
        loop: false, /* Prevents empty space */
        navigation: {
            nextEl: ".yacht-swiper-container .swiper-button-next",
            prevEl: ".yacht-swiper-container .swiper-button-prev",
        },
    });
});
