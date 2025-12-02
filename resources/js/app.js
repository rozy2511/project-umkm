import './bootstrap';
// resources/js/app.js
import Swiper from 'swiper';
import { Navigation, Pagination, Thumbs } from 'swiper/modules';

// Register Swiper modules
Swiper.use([Navigation, Pagination, Thumbs]);

// Export Swiper untuk digunakan di file lain
window.Swiper = Swiper;

// NAVBAR SCROLL EFFECT
window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");
    
    if (window.scrollY > 30) {
        navbar.classList.add("scrolled");
        navbar.classList.remove("transparent");
    } else {
        navbar.classList.add("transparent");
        navbar.classList.remove("scrolled");
    }
});

// ===============================
// SWIPER INITIALIZATION (TAMBAHAN)
// ===============================
document.addEventListener("DOMContentLoaded", () => {

    // Cek apakah elemen swiper ada (biar tidak error di halaman lain)
    const thumbsEl = document.querySelector('.product-gallery-thumbs');
    const mainEl = document.querySelector('.product-gallery-main');

    if (thumbsEl && mainEl) {

        const thumbs = new Swiper('.product-gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const main = new Swiper('.product-gallery-main', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            thumbs: {
                swiper: thumbs,
            },
        });

    }

});
