<?php
/**
 * Lightweight Therosessom functions and definitions
 * Optimized for performance and minimal functionality
 *
 * @package therosessom
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme version
define('THEROSESSOM_VERSION', '1.0.0');

/**
 * Theme setup function
 */
function therosessom_setup() {
    // Make theme available for translation
    load_theme_textdomain('therosessom', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Add theme support for HTML5 markup
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);

    // Register navigation menus
    register_nav_menus([
        'primary-menu' => esc_html__('Primary Menu', 'therosessom'),
        'footer-menu'  => esc_html__('Footer Menu', 'therosessom'),
    ]);

    // Add essential image sizes only
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('portfolio-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'therosessom_setup');

/**
 * Enqueue scripts and styles - Further simplified
 */
function therosessom_scripts() {
    // Check if in development mode
    $is_development = (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development');
    
    if ($is_development && therosessom_is_vite_running()) {
        // Development mode
        wp_enqueue_script('vite-client', 'http://localhost:10024/@vite/client', [], null, false);
        wp_script_add_data('vite-client', 'type', 'module');

        wp_enqueue_script('therosessom-main', 'http://localhost:10024/assets/js/main.js', [], null, true);
        wp_script_add_data('therosessom-main', 'type', 'module');
    } else {
        // Production mode
        therosessom_enqueue_production_assets();
    }

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script with data for JS
    wp_localize_script('therosessom-main', 'therosessomData', [
        'themeUrl' => get_template_directory_uri(),
        'ajax_url' => admin_url('admin-ajax.php'), // AJAX URL 추가
        'nonce'    => wp_create_nonce('therosessom_portfolio_nonce') // 보안 Nonce 추가
    ]);
}
add_action('wp_enqueue_scripts', 'therosessom_scripts');

/**
 * Simple check if Vite development server is running
 */
function therosessom_is_vite_running() {
    $context = stream_context_create([
        'http' => [
            'timeout' => 1,
            'ignore_errors' => true
        ]
    ]);
    
    return @file_get_contents('http://localhost:10024', false, $context) !== false;
}

/**
 * Simplified production asset loading
 */
function therosessom_enqueue_production_assets() {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        wp_enqueue_style('therosessom-style', get_stylesheet_uri(), [], THEROSESSOM_VERSION);
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);
    if (!$manifest || !isset($manifest['assets/js/main.js'])) {
        wp_enqueue_style('therosessom-style', get_stylesheet_uri(), [], THEROSESSOM_VERSION);
        return;
    }

    $main_js_entry = $manifest['assets/js/main.js'];

    // 1. Enqueue CSS files from the manifest directly in the <head>.
    // This is the key to fixing the Flash of Unstyled Content (FOUC).
    if (!empty($main_js_entry['css'])) {
        foreach ($main_js_entry['css'] as $index => $css_file) {
            wp_enqueue_style(
                'therosessom-style-' . $index,
                get_template_directory_uri() . '/dist/' . $css_file,
                [],
                THEROSESSOM_VERSION
            );
        }
    }

    // 2. Enqueue the main JS file in the footer.
    wp_enqueue_script(
        'therosessom-main',
        get_template_directory_uri() . '/dist/' . $main_js_entry['file'],
        [], // No dependencies needed here
        THEROSESSOM_VERSION,
        true // Load in footer
    );
    
    // Ensure the script is loaded as a module.
    wp_script_add_data('therosessom-main', 'type', 'module');
}

/**
 * Essential WordPress cleanup only
 */
function therosessom_cleanup() {
    // Remove emoji scripts for performance
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove WordPress version for security
    remove_action('wp_head', 'wp_generator');
    
    // Remove only clearly unnecessary links
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    
    // Keep REST API and oEmbed for Contact Form plugins compatibility
}
add_action('init', 'therosessom_cleanup');

/**
 * Basic query optimization
 */
function therosessom_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Limit search to posts and pages only
        if ($query->is_search()) {
            $query->set('post_type', ['post', 'page']);
        }
    }
}
add_action('pre_get_posts', 'therosessom_optimize_queries');

/**
 * Add defer attribute to main script for performance
 */
function therosessom_defer_scripts($tag, $handle) {
    if ($handle === 'therosessom-main') {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'therosessom_defer_scripts', 10, 2);

/**
 * Content width for better responsive images
 */
if (!isset($content_width)) {
    $content_width = 1200;
}

/**
 * ACF Pro Integration - Theme Options pages
 */
add_action('init', function() {
    if (function_exists('acf_add_options_page')) {
        // Main Theme Options page
        acf_add_options_page([
            'page_title'  => __('Theme Options', 'therosessom'),
            'menu_title'  => __('Theme Options', 'therosessom'),
            'menu_slug'   => 'theme-options',
            'capability'  => 'edit_posts',
            'icon_url'    => 'dashicons-admin-generic',
            'redirect'    => true, 
        ]);

        // Site Settings sub-page
        acf_add_options_sub_page([
            'page_title'  => __('Site Settings', 'therosessom'),
            'menu_title'  => __('Site Settings', 'therosessom'),
            'parent_slug' => 'theme-options',
        ]);

        // Business Settings sub-page
        acf_add_options_sub_page([
            'page_title'  => __('Business Settings', 'therosessom'),
            'menu_title'  => __('Business Settings', 'therosessom'),
            'parent_slug' => 'theme-options',
        ]);
    }
});

/**
 * Optional: Hide unnecessary admin menu items
 * Comment out if you need access to these features
 */
add_action('admin_menu', function() {
    remove_submenu_page('themes.php', 'customize.php');   
    remove_submenu_page('themes.php', 'customize.php?return=' . urlencode($_SERVER['REQUEST_URI']));    
    remove_submenu_page('themes.php', 'patterns.php');       
    remove_submenu_page('themes.php', 'site-editor.php?path=%2Fpatterns');
    remove_submenu_page('themes.php', 'edit.php?post_type=wp_template_part');
    remove_submenu_page('themes.php', 'themes.php?page=gutenberg-edit-site&path=%2Fpatterns');
    remove_submenu_page('themes.php', 'theme-editor.php');
}, 999);


/**
 * AJAX handler for loading portfolio posts.
 *
 * This function now includes a check for post count and returns a more
 * robust JSON object for frontend handling.
 */
function therosessom_load_portfolio_posts() {
    // Check for a valid AJAX nonce and exit if it's not present or invalid.
    check_ajax_referer('therosessom_portfolio_nonce', 'nonce');

    // Sanitize and validate input parameters.
    $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $posts_per_page = 6;

    // Define the WP_Query arguments.
    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
        'no_found_rows'  => true, // Improves performance for pagination that doesn't need to count all posts
    ];

    if ($category !== 'all') {
        $args['tax_query'] = [
            [
                'taxonomy' => 'portfolio_category',
                'field'    => 'slug',
                'terms'    => $category,
            ],
        ];
    }
    
    $query = new WP_Query($args);

    // Prepare the response data.
    $response = [
        'html'       => '',
        'has_more'   => false, // New flag to easily check if there are more posts
        'post_count' => 0,
    ];

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/components/Sections/portfolio-layout-item');
        endwhile;
        $response['html'] = ob_get_clean();

        // Check if there are more posts to load.
        $response['has_more'] = ($query->max_num_pages > $page);
        $response['post_count'] = $query->post_count;
    }
    
    wp_reset_postdata();

    // Send the JSON response.
    wp_send_json_success($response);
}

// Add the action hooks to register the AJAX handler.
add_action('wp_ajax_therosessom_load_portfolio_posts', 'therosessom_load_portfolio_posts');
add_action('wp_ajax_nopriv_therosessom_load_portfolio_posts', 'therosessom_load_portfolio_posts');