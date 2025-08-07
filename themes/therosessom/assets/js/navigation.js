/**
 * Navigation Module for therosessom Theme
 * Special Auto-Reveal Sticky Header Effect
 */

export class NavigationMenu {
    constructor() {
        this.config = {
            DESKTOP_BREAKPOINT: 768,
            DEBOUNCE_DELAY: 250,
            selectors: {
                header: '#masthead',
                navigation: '#site-navigation',
                menuToggle: '#menu-toggle', 
                menu: '#primary-menu',
                menuLinks: '#primary-menu a'
            },
            classes: {
                toggled: 'toggled',
                menuOpen: 'menu-open',
                menuCurrent: 'menu-current',
                headerHidden: 'header-hidden',
                headerSticky: 'header-sticky',
                headerScrolled: 'header-scrolled'
            },
            scroll: {
                hideStart: 7,
                hideEnd: 210,  
                stickyThreshold: 50, 
                scrollDelta: 5   
            }
        };

        this.elements = {};
        this.state = {
            isOpen: false,
            isAnimating: false,
            isDesktop: window.innerWidth >= this.config.DESKTOP_BREAKPOINT,
            prefersReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
            lastScrollY: 0,
            currentScrollY: 0,
            isTicking: false,
            isScrollingDown: false,
            headerHeight: 0,
            didScroll: false,
            hasHiddenOnce: false     // Track if header was hidden at least once
        };

        this.init();
    }

    /**
     * Initialize the menu
     */
    init() {
        this.getElements();
        if (this.validateElements()) {
            this.setupInitialState();
            this.bindEvents();
            this.initScrollBehavior();
        }
    }

    /**
     * Get DOM elements
     */
    getElements() {
        const { selectors } = this.config;
        
        this.elements = {
            header: document.querySelector(selectors.header),
            navigation: document.querySelector(selectors.navigation),
            menuToggle: document.querySelector(selectors.menuToggle),
            menu: document.querySelector(selectors.menu),
            menuLinks: document.querySelectorAll(selectors.menuLinks),
            body: document.body
        };
    }

    /**
     * Validate required elements exist
     */
    validateElements() {
        const { header, navigation, menuToggle, body } = this.elements;
        return header && navigation && menuToggle && body;
    }

    /**
     * Setup initial states
     */
    setupInitialState() {
        this.elements.menuToggle.setAttribute('aria-expanded', 'false');
        
        // Cache header height for performance
        if (this.elements.header) {
            this.state.headerHeight = this.elements.header.offsetHeight;
        }
    }

    /**
     * Initialize scroll behavior
     */
    initScrollBehavior() {
        // Set initial scroll position
        this.state.lastScrollY = window.scrollY;
        this.state.currentScrollY = window.scrollY;
        
        // Apply initial state if already scrolled
        if (window.scrollY > 0) {
            this.handleScroll();
        }
    }

    /**
     * Bind all event listeners
     */
    bindEvents() {
        const { menuToggle } = this.elements;

        // Mobile menu toggle
        menuToggle.addEventListener('click', this.handleToggleClick.bind(this));
        
        // Close menu on outside click
        document.addEventListener('click', this.handleDocumentClick.bind(this));
        
        // Keyboard navigation
        document.addEventListener('keydown', this.handleKeydown.bind(this));

        // Optimized resize handler
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, this.config.DEBOUNCE_DELAY);
        });
        
        // Optimized scroll handler with RAF
        window.addEventListener('scroll', () => {
            this.state.currentScrollY = window.scrollY;
            
            if (!this.state.isTicking) {
                window.requestAnimationFrame(() => {
                    this.handleScroll();
                    this.state.isTicking = false;
                });
                this.state.isTicking = true;
            }
        }, { passive: true });

        // Listen for reduced motion preference changes
        const motionMediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        motionMediaQuery.addEventListener('change', (e) => {
            this.state.prefersReducedMotion = e.matches;
        });
    }

    /**
     * Special Auto-Reveal Scroll Handler
     * Header disappears initially, then reappears as sticky
     */
    handleScroll() {
        const { header } = this.elements;
        if (!header) return;

        const { classes, scroll } = this.config;
        const currentScrollY = this.state.currentScrollY;
        const scrollDelta = Math.abs(currentScrollY - this.state.lastScrollY);
        
        // Don't react to tiny scroll movements
        if (scrollDelta < scroll.scrollDelta && currentScrollY > 0) {
            return;
        }

        // Determine scroll direction
        this.state.isScrollingDown = currentScrollY > this.state.lastScrollY;
        
        // Reset when scrolled to top
        if (currentScrollY === 0) {
            header.classList.remove(classes.headerHidden, classes.headerSticky, classes.headerScrolled);
            this.state.hasHiddenOnce = false;
            this.state.lastScrollY = currentScrollY;
            return;
        }

        // Apply sticky background styles when scrolled
        if (currentScrollY > scroll.stickyThreshold) {
            header.classList.add(classes.headerSticky);
        } else {
            header.classList.remove(classes.headerSticky);
        }

        // Special auto-reveal logic
        if (this.state.isScrollingDown) {
            // Phase 1: Hide header between hideStart and hideEnd
            if (currentScrollY > scroll.hideStart && currentScrollY < scroll.hideEnd) {
                header.classList.add(classes.headerHidden);
                this.state.hasHiddenOnce = true;
            }
            // Phase 2: Auto-reveal as sticky after hideEnd
            else if (currentScrollY >= scroll.hideEnd && this.state.hasHiddenOnce) {
                header.classList.remove(classes.headerHidden);
            }
        } else {
            // Always show when scrolling up
            header.classList.remove(classes.headerHidden);
        }

        // Update last scroll position
        this.state.lastScrollY = currentScrollY;
    }

    /**
     * Alternative Scroll Handler - Traditional Hide/Show on Scroll Direction
     * Uncomment this and comment out the above handleScroll if you prefer traditional behavior
     */
    handleScrollTraditional() {
        const { header } = this.elements;
        if (!header) return;

        const { classes, scroll } = this.config;
        const currentScrollY = this.state.currentScrollY;
        const scrollDelta = Math.abs(currentScrollY - this.state.lastScrollY);
        
        // Don't react to tiny scroll movements
        if (scrollDelta < scroll.scrollDelta && currentScrollY > 0) {
            return;
        }

        // Determine scroll direction
        this.state.isScrollingDown = currentScrollY > this.state.lastScrollY;
        
        // Apply sticky styles when scrolled
        if (currentScrollY > scroll.stickyThreshold) {
            header.classList.add(classes.headerSticky);
        } else {
            header.classList.remove(classes.headerSticky);
        }

        // Traditional hide/show based on scroll direction
        if (this.state.isScrollingDown && currentScrollY > scroll.hideStart) {
            // Hide when scrolling down
            header.classList.add(classes.headerHidden);
        } else if (!this.state.isScrollingDown) {
            // Show when scrolling up
            header.classList.remove(classes.headerHidden);
        }

        // Reset at top
        if (currentScrollY === 0) {
            header.classList.remove(classes.headerHidden, classes.headerSticky);
        }

        // Update last scroll position
        this.state.lastScrollY = currentScrollY;
    }

    /**
     * Handle window resize
     */
    handleResize() {
        const wasDesktop = this.state.isDesktop;
        this.state.isDesktop = window.innerWidth >= this.config.DESKTOP_BREAKPOINT;
        
        // Update cached header height
        if (this.elements.header) {
            this.state.headerHeight = this.elements.header.offsetHeight;
        }

        // Close mobile menu when switching to desktop
        if (this.state.isDesktop && this.state.isOpen) {
            this.closeMenu();
        }
    }

    /**
     * Handle mobile menu toggle click
     */
    handleToggleClick(event) {
        event.preventDefault();
        event.stopPropagation();
        
        if (!this.state.isAnimating) {
            this.toggleMenu();
        }
    }

    /**
     * Handle clicks outside menu to close it
     */
    handleDocumentClick(event) {
        if (!this.state.isOpen) return;

        const { navigation } = this.elements;
        
        if (navigation.contains(event.target)) return;

        this.closeMenu();
    }

    /**
     * Handle keyboard navigation
     */
    handleKeydown(event) {
        if (event.key === 'Escape' && this.state.isOpen) {
            event.preventDefault();
            this.closeMenu();
        }
    }

    /**
     * Toggle mobile menu
     */
    async toggleMenu() {
        this.state.isAnimating = true;
        this.state.isOpen = !this.state.isOpen;

        try {
            await this.updateVisuals();
            this.manageFocus();
        } finally {
            setTimeout(() => {
                this.state.isAnimating = false;
            }, 300);
        }
    }

    /**
     * Update visual states
     */
    async updateVisuals() {
        const { navigation, menuToggle, body } = this.elements;
        const { classes } = this.config;
        const { isOpen } = this.state;

        navigation.classList.toggle(classes.toggled, isOpen);
        menuToggle.classList.toggle(classes.toggled, isOpen);  
        body.classList.toggle(classes.menuOpen, isOpen);

        menuToggle.setAttribute('aria-expanded', isOpen.toString());

        return new Promise(resolve => setTimeout(resolve, 50));
    }

    /**
     * Manage focus for accessibility
     */
    manageFocus() {
        const { isOpen } = this.state;
        
        if (isOpen) {
            this.updateMenuLinks();
            const firstLink = this.elements.menuLinks[0];
            if (firstLink) {
                setTimeout(() => firstLink.focus(), 100);
            }
        } else {
            this.elements.menuToggle.focus();
        }
    }

    /**
     * Close mobile menu
     */
    closeMenu() {
        if (this.state.isOpen && !this.state.isAnimating) {
            this.toggleMenu();
        }
    }

    /**
     * Update menu links collection
     */
    updateMenuLinks() {
        this.elements.menuLinks = document.querySelectorAll(this.config.selectors.menuLinks);
    }
    
    /**
     * Highlight current page menu item
     */
    highlightCurrentPage() {
        const currentItems = document.querySelectorAll(`
            .current-menu-item > a,
            .current-page-ancestor > a,
            .current-menu-ancestor > a,
            .current-menu-parent > a
        `);

        currentItems.forEach(link => {
            link.classList.add(this.config.classes.menuCurrent);
        });
    }

    /**
     * Destroy the navigation instance
     */
    destroy() {
        // Remove all event listeners and clean up
        this.elements.menuToggle?.removeEventListener('click', this.handleToggleClick);
        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeydown);
        
        // Reset states
        this.elements.body?.classList.remove(this.config.classes.menuOpen);
        this.elements.navigation?.classList.remove(this.config.classes.toggled);
        this.elements.header?.classList.remove(
            this.config.classes.headerHidden,
            this.config.classes.headerSticky,
            this.config.classes.headerScrolled
        );
    }
}

// Auto-initialize if not using module system
if (typeof window !== 'undefined' && !window.TheRosessomTheme) {
    document.addEventListener('DOMContentLoaded', () => {
        window.navigationMenu = new NavigationMenu();
    });
}