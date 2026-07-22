import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Swiper = Swiper;
window.SwiperModules = {
    Navigation,
    Pagination,
    Autoplay,
};

document.addEventListener('DOMContentLoaded', () => {

    const companiesSlider = document.querySelector('.companies-swiper');

    if (!companiesSlider) return;

    new Swiper(companiesSlider, {

        modules: [
            SwiperModules.Navigation,
            SwiperModules.Pagination,
            SwiperModules.Autoplay,
        ],

        slidesPerView: 1,
        spaceBetween: 24,
        speed: 700,
        loop: true,
        grabCursor: true,
        watchOverflow: true,
        centeredSlides: false,

        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },

        pagination: {
            el: '.companies-swiper .swiper-pagination',
            clickable: true,
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
                spaceBetween: 16,
            },

            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },

            1024: {
                slidesPerView: 3,
                spaceBetween: 24,
            },

            1400: {
                slidesPerView: 4,
                spaceBetween: 28,
            },

        },

    });

});

import './components/entity-slider';