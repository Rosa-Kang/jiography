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
import { SliderManager } from './slider.js';
import { PortfolioAjax } from './portfolio-ajax.js';

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
    this.initSwipers();
    this.initSmoothScroll();
    this.initPortfolioAjax();
    
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
 * Initialize Portfolio Ajax
 */
initPortfolioAjax() {
  this.portfolioAjax = new PortfolioAjax();
}

/**
 * Initialize Swiper sliders - 기존 메서드 교체
 */
  async initSwipers() {
    this.sliderManager = new SliderManager();
    await this.sliderManager.init();
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