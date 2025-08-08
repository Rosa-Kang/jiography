import AOS from 'aos';
import 'aos/dist/aos.css';
import '../css/style.scss';

import { NavigationMenu } from './navigation.js';
import { SliderManager } from './slider.js';
import { PortfolioAjax } from './portfolio-ajax.js';

class TheRosessomTheme {
  constructor() {
    this.isPortfolioPage = document.body.classList.contains('page-portfolio') || 
                            document.body.classList.contains('single-portfolio') ||
                            document.body.classList.contains('post-type-archive-portfolio');
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
    this.initAOS();
    this.initLazyLoading();
    this.initSmoothScroll();
    this.initSwipers();

    // Portfolio 페이지 전용 기능
    if (this.isPortfolioPage) {
      this.initPortfolioAjax();
    }

    document.dispatchEvent(new CustomEvent('therosessom:initialized'));
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
}

window.TheRosessomTheme = new TheRosessomTheme();
