/**
 * REVISED: A more robust version to correctly handle state, filtering,
 * and the browser's back-forward cache (bfcache).
 */
import AOS from 'aos';
import 'aos/dist/aos.css';
import '../css/style.scss';

import { NavigationMenu } from './navigation.js';
import { SliderManager } from './slider.js';
import { PortfolioAjax } from './portfolio-ajax.js';

class TheRosessomTheme {
  constructor() {
    this.init();
  }

  init() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
    } else {
      this.initializeComponents();
    }
  }

  initializeComponents() {
    this.initNavigation();
    this.initLazyLoading();
    this.initSmoothScroll();
    this.initAOS();
    this.initSwipers();
    this.initTransparentHeader();

    // Portfolio-specific functionality
    if (document.getElementById('portfolio-grid')) {
      this.initPortfolioAjax();
    }

    this.initPortfolioFilterToggle();

    // Add a load event listener to refresh AOS after everything has loaded
    window.addEventListener('load', () => {
      AOS.refresh();
      setTimeout(() => {
        AOS.refresh();
      }, 500);
    });

    document.dispatchEvent(new CustomEvent('therosessom:initialized'));
  }

  initPortfolioFilterToggle() {
    const filterToggleButton = document.getElementById('filter-toggle-btn');
    const filterList = document.getElementById('portfolio-filter-list');

    if (filterToggleButton && filterList) {
      filterToggleButton.addEventListener('click', () => {
        filterList.classList.toggle('open');
        filterToggleButton.classList.toggle('open');
      });

      const filterButtons = filterList.querySelectorAll('.filter-btn');
      const toggleButtonText = filterToggleButton.querySelector('.filter-toggle-text');

      filterButtons.forEach(button => {
        button.addEventListener('click', () => {
          if (window.innerWidth < 1024) {
            toggleButtonText.textContent = button.textContent;
            filterList.classList.remove('open');
            filterToggleButton.classList.remove('open');
          }
        });
      });
    }
  }

  initNavigation() {
    this.navigation = new NavigationMenu();
  }

  initPortfolioAjax() {
    this.portfolioAjax = new PortfolioAjax();
  }

  async initSwipers() {
    this.sliderManager = new SliderManager();
    await this.sliderManager.init();
    AOS.refresh();
  }

  initAOS() {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 100
    });
  }

  initLazyLoading() {
    if ('loading' in HTMLImageElement.prototype) {
      document.querySelectorAll('img[data-src]').forEach(img => {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      });
    } else {
      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
            obs.unobserve(img);
          }
        });
      });
      document.querySelectorAll('img[data-src]').forEach(img => observer.observe(img));
    }
  }

  initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const targetId = link.getAttribute('href').substring(1);
        const target = document.getElementById(targetId);
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  initTransparentHeader() {
    const header = document.getElementById('masthead');
    if (!header || !header.classList.contains('is-transparent')) {
      return;
    }

    const scrollThreshold = 100;

    const onScroll = () => {
      if (window.scrollY > scrollThreshold) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
  }
}

window.TheRosessomTheme = new TheRosessomTheme();