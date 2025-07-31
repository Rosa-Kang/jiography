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

    // Minimal localization - no form handling needed
    wp_localize_script('therosessom-main', 'therosessomData', [
        'themeUrl' => get_template_directory_uri(),
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

    // Simple fallback if no build exists
    if (!file_exists($manifest_path)) {
        wp_enqueue_style('therosessom-style', get_stylesheet_uri(), [], THEROSESSOM_VERSION);
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);
    if (!$manifest || !isset($manifest['assets/js/main.js'])) {
        wp_enqueue_style('therosessom-style', get_stylesheet_uri(), [], THEROSESSOM_VERSION);
        return;
    }

    $js_file = $manifest['assets/js/main.js'];

    // Enqueue main JS
    wp_enqueue_script(
        'therosessom-main',
        get_template_directory_uri() . '/dist/' . $js_file['file'],
        [],
        THEROSESSOM_VERSION,
        true
    );
    wp_script_add_data('therosessom-main', 'type', 'module');

    // Enqueue CSS files
    if (!empty($js_file['css'])) {
        foreach ($js_file['css'] as $index => $css_file) {
            wp_enqueue_style(
                'therosessom-style-' . $index,
                get_template_directory_uri() . '/dist/' . $css_file,
                [],
                THEROSESSOM_VERSION
            );
        }
    }
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