/**
 * Lightweight Slider Manager for therosessom Theme
 * Simple Swiper initialization with dynamic loading
 */

export class SliderManager {
    constructor() {
        this.swiperLoaded = false;
    }

/**
 * Initialize all sliders
 */
    async init() {
        const sliders = {
            hero: document.querySelector('.hero-swiper'),
            callout: document.querySelector('.callout-swiper'), 
            testimonials: document.querySelector('.testimonials-swiper')
        };

        // Exit early if no sliders exist
        if (!Object.values(sliders).some(slider => slider)) {
            return;
        }

        try {
            // Load Swiper only when needed
            const { default: Swiper } = await import('swiper/bundle');
            await import('swiper/css/bundle');
            
            this.swiperLoaded = true;

            // Initialize each slider if it exists and has multiple slides
            this.initHero(sliders.hero, Swiper);
            this.initCallout(sliders.callout, Swiper);
            this.initTestimonials(sliders.testimonials, Swiper);

        } catch (error) {
            console.error('Failed to load Swiper:', error);
        }
    }


/**
 * Initialize hero slider
 */
    initHero(element, Swiper) {
        if (!element) return;
        
        const slideCount = element.querySelectorAll('.swiper-slide').length;
        if (slideCount <= 1) return;

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
    initCallout(element, Swiper) {
        if (!element) return;

        const slideCount = element.querySelectorAll('.swiper-slide').length;
        if (slideCount <= 1) return;

        const currentSlideSpan = document.querySelector('.callout-counter .current-slide');

            new Swiper(element, {
            direction: 'vertical',
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 500,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination-vertical-bullets',
                clickable: true,
            },
            on: {
                init: function () {
                    const slides = this.slides;
                    slides.forEach((slide, idx) => {
                        const img = slide.querySelector('img');
                        if (img) {
                            if (idx === this.activeIndex) {
                                img.style.filter = 'none';
                            } else {
                                img.style.filter = 'blur(4px)';
                            }
                        }
                    });
                    
                    if (currentSlideSpan) {
                        currentSlideSpan.textContent = this.realIndex + 1; 
                    }
                },
                slideChangeTransitionEnd: function () {
                    const slides = this.slides;
                    slides.forEach((slide, idx) => {
                        const img = slide.querySelector('img');
                        if (img) {
                            if (idx === this.activeIndex) {
                                img.style.filter = 'none';
                            } else {
                                img.style.filter = 'blur(4px)';
                            }
                        }
                    });

                    if (currentSlideSpan) {
                        currentSlideSpan.textContent = this.realIndex + 1; 
                    }
                },
            },
        });
    }

    /**
     * Initialize testimonials slider
     */
    initTestimonials(element, Swiper) {
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
}