/**
 * Portfolio Ajax Loader and Filter for therosessom Theme
 *
 * REVISED: A more robust version to correctly handle state, filtering,
 * and the browser's back-forward cache (bfcache).
 */
export class PortfolioAjax {
  constructor() {
    this.grid = document.getElementById('portfolio-grid');
    this.loadMoreBtn = document.getElementById('portfolio-loadmore');
    this.filterContainer = document.querySelector('.portfolio-filter');

    if (!this.grid) return; // If the grid doesn't exist, do nothing.

    this.config = {
      classes: {
        loading: 'is-loading',
        hidden: 'is-hidden',
        active: 'active'
      },
      ajax: {
        url: window.therosessomData.ajax_url,
        action: 'load_portfolio',
        nonce: window.therosessomData.nonce
      }
    };

    this.state = {
      currentPage: 1,
      currentCategory: 'all',
      maxPages: 1,
      postCount: 0,
      isLoading: false
    };

    this.init();
  }

  init() {
    // Set initial state from the "View More" button's data attributes
    if (this.loadMoreBtn) {
      this.state.currentPage = parseInt(this.loadMoreBtn.dataset.page, 10) || 1;
      this.state.currentCategory = this.loadMoreBtn.dataset.category || 'all';
      this.state.postCount = parseInt(this.loadMoreBtn.dataset.postCount, 10) || 0;
      this.state.maxPages = parseInt(this.loadMoreBtn.dataset.maxPages, 10) || 1;
    }

    this.bindEvents();
  }

  bindEvents() {
    if (this.loadMoreBtn) {
      this.loadMoreBtn.addEventListener('click', () => this.loadMore());
    }

    if (this.filterContainer) {
      this.filterContainer.addEventListener('click', (e) => {
        if (e.target.matches('.filter-btn')) {
          e.preventDefault();
          this.handleFilter(e.target);
        }
      });
    }

    // This is the fix for the "back button" issue.
    window.addEventListener('pageshow', (event) => {
      // event.persisted is true if the page was restored from bfcache.
      if (event.persisted) {
        this.setLoading(false); // Ensure loading state is off.
        // Force a full reset to the initial view.
        this.resetAndFetch('all');
      }
    });
  }

  // A new helper function to reset the state and fetch new content.
  resetAndFetch(category) {
    if (this.state.isLoading) return;

    this.state.currentCategory = category;
    this.state.currentPage = 1;
    this.state.postCount = 0;

    this.updateFilterUI(category);
    this.fetchPosts(false); // `false` means replace the grid content.
  }

  handleFilter(btn) {
    const category = btn.dataset.category;
    if (this.state.isLoading || this.state.currentCategory === category) {
      return;
    }
    this.resetAndFetch(category);
  }

  // A new helper function to keep the filter buttons' appearance in sync.
  updateFilterUI(activeCategory) {
    this.filterContainer.querySelectorAll('.filter-btn').forEach(b => {
      b.classList.remove(this.config.classes.active, 'font-medium', 'text-black');
      b.classList.add('text-gray-500');
      if (b.dataset.category === activeCategory) {
        b.classList.add(this.config.classes.active, 'font-medium', 'text-black');
        b.classList.remove('text-gray-500');
      }
    });
  }

  loadMore() {
    if (this.state.isLoading) return;
    this.state.currentPage++;
    this.fetchPosts(true); // `true` means append to the grid.
  }

  async fetchPosts(isAppending = false) {
    this.setLoading(true);

    const formData = new FormData();
    formData.append('action', this.config.ajax.action);
    formData.append('nonce', this.config.ajax.nonce);
    formData.append('page', this.state.currentPage);
    formData.append('category', this.state.currentCategory);
    formData.append('offset', this.state.postCount);

    try {
      const response = await fetch(this.config.ajax.url, { method: 'POST', body: formData });
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      const result = await response.json();

      if (result.success) {
        const { html, max_pages, post_count: newItemsCount } = result.data;

        if (isAppending) {
          this.grid.insertAdjacentHTML('beforeend', html);
        } else {
          this.grid.innerHTML = html || `<p class="text-center text-gray-500">No portfolios found in this category.</p>`;
        }
        
        this.state.postCount += newItemsCount;
        this.state.maxPages = max_pages;

        if (this.loadMoreBtn) {
          if (this.state.currentPage >= this.state.maxPages) {
            this.loadMoreBtn.classList.add(this.config.classes.hidden);
          } else {
            this.loadMoreBtn.classList.remove(this.config.classes.hidden);
          }
        }
      } else {
        throw new Error(result.data.message || 'AJAX request failed.');
      }
    } catch (error) {
      console.error('Portfolio Fetch Error:', error);
      this.grid.innerHTML = `<p class="text-center text-red-500">Something went wrong. Please try again.</p>`;
    } finally {
      this.setLoading(false);
    }
  }

  setLoading(isLoading) {
    this.state.isLoading = isLoading;
    if (this.loadMoreBtn) {
      this.loadMoreBtn.disabled = isLoading;
      this.loadMoreBtn.textContent = isLoading ? 'Loading...' : 'View More';
    }
  }
}