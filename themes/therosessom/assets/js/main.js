/**
 * Lightweight Main JavaScript for therosessom Theme
 * Optimized for performance and minimal functionality
 */

// Import essential libraries
import AOS from 'aos';
import 'aos/dist/aos.css';

// Import core CSS
import '../css/style.scss';

// Import custom modules
import { NavigationMenu } from './navigation.js';

/**
 * Lightweight Theme Class
 */
class TheRosessomTheme {
  constructor() {
    this.init();
  }

  /**
   * Initialize theme functionality
   */
  init() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => {
        this.initializeComponents();
      });
    } else {
      this.initializeComponents();
    }
  }

  /**
   * Initialize essential components only
   */
  initializeComponents() {
    this.initNavigation();
    this.initAOS();
    this.initLazyLoading();
    this.initSwipers(); // Only if needed
    this.initSmoothScroll();
    
    // Dispatch initialization complete event
    document.dispatchEvent(new CustomEvent('therosessom:initialized'));
  }

  /**
   * Initialize navigation
   */
  initNavigation() {
    this.navigation = new NavigationMenu();
  }

  /**
   * Initialize AOS (Animate On Scroll)
   */
  initAOS() {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 100,
      delay: 0,
      anchorPlacement: 'top-bottom'
    });
  }

  /**
   * Simple lazy loading without external library
   */
  initLazyLoading() {
    // Native lazy loading support check
    if ('loading' in HTMLImageElement.prototype) {
      const images = document.querySelectorAll('img[data-src]');
      images.forEach(img => {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      });
    } else {
      // Fallback for older browsers
      const images = document.querySelectorAll('img[data-src]');
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
            img.classList.add('loaded');
            observer.unobserve(img);
          }
        });
      });

      images.forEach(img => imageObserver.observe(img));
    }
  }

  /**
   * Initialize Swiper only when needed with dynamic import
   */
  async initSwipers() {
    const heroSlider = document.querySelector('.hero-swiper');
    
    // Exit early if no sliders exist
    if (!heroSlider) {
      return;
    }

    try {
      // Dynamic import only when needed
      const [{ default: Swiper }] = await Promise.all([
        import('swiper/bundle'),
        import('swiper/css/bundle')
      ]);

      // Hero slider - minimal configuration
      if (heroSlider) {
        const slideCount = heroSlider.querySelectorAll('.swiper-slide').length;
        
        if (slideCount > 1) {
          new Swiper(heroSlider, {
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
            // Accessibility
            a11y: {
              enabled: true,
              prevSlideMessage: 'Previous slide',
              nextSlideMessage: 'Next slide',
            }
          });
        }
      }

    } catch (error) {
      console.error('Failed to load Swiper:', error);
    }
  }

  /**
   * Simple smooth scroll
   */
  initSmoothScroll() {
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    
    smoothScrollLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  }

  /**
   * Get navigation instance
   */
  getNavigation() {
    return this.navigation;
  }

  /**
   * Reinitialize if needed
   */
  reinitialize() {
    this.initializeComponents();
  }
}

// Initialize theme
const theme = new TheRosessomTheme();

// Make theme available globally
window.TheRosessomTheme = theme;

// Theme initialization complete
document.addEventListener('therosessom:initialized', () => {
  console.log('🎉 TheRosessom Theme initialized');
});