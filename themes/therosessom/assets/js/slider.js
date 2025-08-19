/**
 * Lightweight Slider Manager for therosessom Theme
 * Simple Swiper initialization with dynamic loading
 */

// Import Swiper and all necessary modules and styles up front for clarity and correctness
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/autoplay';
import 'swiper/css/effect-fade';
import 'swiper/css/thumbs';

// Add the modules to Swiper's use configuration
Swiper.use([Navigation, Pagination, Autoplay, EffectFade, Thumbs]);

export class SliderManager {
    constructor() {
        // No need for this.swiperLoaded; the dynamic import handles this.
    }

    /**
     * Initialize all sliders
     */
    async init() {
        const hero = document.querySelector('.hero-swiper');
        if (hero) this.initHero(hero);

        const callout = document.querySelector('.callout-swiper');
        if (callout) this.initCallout(callout);

        const testimonials = document.querySelector('.testimonials-swiper');
        if (testimonials) this.initTestimonials(testimonials);

        const testimonialsAbout = document.querySelector('.testimonials-about-swiper');
        if (testimonialsAbout) this.initTestimonialsAbout(testimonialsAbout);

        const mainPortfolio = document.querySelector('.main-portfolio-swiper');
        const portfolioGallery = document.querySelector('.portfolio-gallery-swiper');
        if (mainPortfolio && portfolioGallery) {
            this.initPortfolioSlider(mainPortfolio, portfolioGallery);
        }
    }

    /**
     * Initialize hero slider
     */
    initHero(element) {
        if (!element || element.querySelectorAll('.swiper-slide').length <= 1) return;

        new Swiper(element, {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 2000,
            touchRatio: 0.2,
            simulateTouch: true,
            allowTouchMove: true,
            preloadImages: false,
            lazy: {
                loadPrevNext: true,
                loadOnTransitionStart: true,
            },
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide',
            }
        });
    }

    /**
     * Initialize callout slider
     */
    initCallout(element) {
        if (!element || element.querySelectorAll('.swiper-slide').length <= 1) return;

        const currentSlideSpan = document.querySelector('.callout-counter .current-slide');

        const updateImageBlur = (swiperInstance) => {
            const slides = swiperInstance.slides;
            slides.forEach((slide, idx) => {
                const img = slide.querySelector('img');
                if (img) {
                    if (idx === swiperInstance.activeIndex) {
                        img.style.filter = 'none';
                    } else {
                        img.style.filter = 'blur(4px)';
                    }
                }
            });
        };

        new Swiper(element, {
            direction: 'vertical',
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 500,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination-vertical-bullets',
                clickable: true,
            },
            on: {
                init: function () {
                    if (currentSlideSpan) {
                        currentSlideSpan.textContent = this.realIndex + 1;
                    }
                    updateImageBlur(this);
                },
                slideChangeTransitionEnd: function () {
                    if (currentSlideSpan) {
                        currentSlideSpan.textContent = this.realIndex + 1;
                    }
                    updateImageBlur(this);
                },
            },
        });
    }


    /**
     * Initialize testimonials slider
     */
    initTestimonials(element) {
        if (!element) return;
        
        const slideCount = element.querySelectorAll('.swiper-slide').length;
        if (slideCount <= 1) return;

        const swiper = new Swiper(element, {
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '">' + String(index + 1).padStart(2, '0') + '</span>';
                },
            },
            a11y: { enabled: true }
        });

        document.querySelectorAll('.testimonial-number').forEach(number => {
            number.addEventListener('click', () => {
                const slideIndex = parseInt(number.getAttribute('data-slide'));
                if (!isNaN(slideIndex)) swiper.slideTo(slideIndex);
            });
        });
    }

    /**
     * Initialize testimonials slider for the About page
     */
    initTestimonialsAbout(element) {
        if (!element || element.querySelectorAll('.swiper-slide').length <= 1) return;

        new Swiper(element, {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination-fraction',
                type: 'fraction',
                renderFraction: function (currentClass, totalClass) {
                    return '(<span class="' + currentClass + '"></span>' +
                        '/' +
                        '<span class="' + totalClass + '"></span>)';
                }
            },
            navigation: {
                nextEl: '#next-btn',
                prevEl: '#prev-btn',
            },
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous testimonial',
                nextSlideMessage: 'Next testimonial',
            }
        });
    }

    // /**
    //  * Initialize portfolio main and thumbnail gallery sliders
    //  */
    initPortfolioSlider(mainElement, thumbnailElement) {
        if (!mainElement || !thumbnailElement || mainElement.querySelectorAll('.swiper-slide').length <= 1) {
            if (thumbnailElement) thumbnailElement.classList.add('hidden');
            return;
        }

        // 1. Initialize thumbnail slider first
        const gallerySwiper = new Swiper(thumbnailElement, {
            loop: false,
            spaceBetween: 10,
            slidesPerView: 'auto',
            freeMode: true,
            grabCursor: true,
            watchSlidesProgress: true,
            centeredSlides: false,
            breakpoints: {
                320: { slidesPerView: 3, spaceBetween: 8 },
                480: { slidesPerView: 4, spaceBetween: 10 },
                768: { slidesPerView: 5, spaceBetween: 12 },
                1024: { slidesPerView: 6, spaceBetween: 15 }
            },
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous thumbnail',
                nextSlideMessage: 'Next thumbnail',
            },
        });

        const updateThumbnailHighlight = (swiperInstance) => {
            const thumbnails = thumbnailElement.querySelectorAll('.swiper-slide');
            thumbnails.forEach(thumb => thumb.classList.remove('portfolio-thumb-active'));
            const activeIndex = swiperInstance.loop ? swiperInstance.realIndex : swiperInstance.activeIndex;
            if (thumbnails[activeIndex]) {
                thumbnails[activeIndex].classList.add('portfolio-thumb-active');
            }
        };

        // 2. Initialize main slider, linking it to the thumbnail slider
        const mainSwiper = new Swiper(mainElement, {
            loop: true,
            spaceBetween: 0,
            speed: 600,
            effect: 'slide',
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: gallerySwiper,
            },
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous image',
                nextSlideMessage: 'Next image',
            },
            on: {
                init: function () {
                    updateThumbnailHighlight(this);
                },
                slideChange: function () {
                    updateThumbnailHighlight(this);
                },
            }
        });

        this.setupPortfolioSliderEnhancements(mainSwiper, gallerySwiper, thumbnailElement);
    }

    /**
     * Setup additional enhancements for portfolio slider.
     */
    setupPortfolioSliderEnhancements(mainSwiper, gallerySwiper, thumbnailElement) {
        if (thumbnailElement) {
            thumbnailElement.addEventListener('mouseenter', () => {
                if (mainSwiper.autoplay) mainSwiper.autoplay.stop();
            });
            thumbnailElement.addEventListener('mouseleave', () => {
                if (mainSwiper.autoplay) mainSwiper.autoplay.start();
            });
        }

        document.addEventListener('keydown', (e) => {
            const mainElement = document.querySelector('.main-portfolio-swiper');
            if (!mainElement || !this.isElementInViewport(mainElement)) return;

            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    mainSwiper.slidePrev();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    mainSwiper.slideNext();
                    break;
                case ' ':
                    e.preventDefault();
                    if (mainSwiper.autoplay.running) mainSwiper.autoplay.stop();
                    else mainSwiper.autoplay.start();
                    break;
            }
        });
    }

    /**
     * Helper method to check if element is in viewport.
     */
    isElementInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
}