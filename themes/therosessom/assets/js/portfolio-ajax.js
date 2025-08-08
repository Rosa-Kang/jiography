/**
 * Portfolio Ajax Loader for therosessom Theme
 * Matches existing JS module pattern & minimal footprint
 */

import '../css/_portfolio.scss';

export class PortfolioAjax {
  constructor() {
    this.config = {
      selectors: {
        container: '#portfolio-container',
        loadMoreBtn: '#portfolio-load-more',
        item: '.portfolio-item'
      },
      classes: {
        loading: 'is-loading',
        hidden: 'is-hidden'
      },
      endpoints: {
        load: '/wp-admin/admin-ajax.php'
      }
    };

    this.state = {
      currentPage: 1,
      isLoading: false
    };

    this.init();
  }

  init() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.bindEvents());
    } else {
      this.bindEvents();
    }
  }

  bindEvents() {
    const loadMoreBtn = document.querySelector(this.config.selectors.loadMoreBtn);
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.loadMore();
      });
    }
  }

  async loadMore() {
    if (this.state.isLoading) return;

    const container = document.querySelector(this.config.selectors.container);
    const loadMoreBtn = document.querySelector(this.config.selectors.loadMoreBtn);
    if (!container) return;

    this.setLoading(true);

    try {
      const response = await fetch(`${this.config.endpoints.load}?action=load_portfolio&page=${this.state.currentPage + 1}`);
      const data = await response.text();

      if (data.trim()) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = data;

        const newItems = tempDiv.querySelectorAll(this.config.selectors.item);
        newItems.forEach(item => container.appendChild(item));

        this.state.currentPage++;
      } else {
        if (loadMoreBtn) {
          loadMoreBtn.classList.add(this.config.classes.hidden);
        }
      }
    } catch (err) {
      console.error('Portfolio Ajax Error:', err);
    } finally {
      this.setLoading(false);
    }
  }

  setLoading(isLoading) {
    const loadMoreBtn = document.querySelector(this.config.selectors.loadMoreBtn);
    if (!loadMoreBtn) return;

    this.state.isLoading = isLoading;
    loadMoreBtn.classList.toggle(this.config.classes.loading, isLoading);

    if (isLoading) {
      loadMoreBtn.disabled = true;
    } else {
      loadMoreBtn.disabled = false;
    }
  }
}
