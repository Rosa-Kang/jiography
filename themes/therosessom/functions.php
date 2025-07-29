<?php
/**
 * Therosessom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package therosessom
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme version
define('THEROSESSOM_VERSION', '1.0.0');

// Vite dev server URL.
define('VITE_DEV_SERVER', 'http://localhost:10024');

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

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add theme support for HTML5 markup
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ]);

    // Add theme support for WordPress block styles
    add_theme_support('wp-block-styles');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for wide alignment
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus([
        'primary-menu' => esc_html__('Primary Menu', 'therosessom'),
        'footer-menu'  => esc_html__('Footer Menu', 'therosessom'),
        'mobile-menu'  => esc_html__('Mobile Menu', 'therosessom'),
    ]);

    // Add custom image sizes
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('portfolio-thumb', 400, 300, true);
    add_image_size('portfolio-large', 1200, 900, true);
}
add_action('after_setup_theme', 'therosessom_setup');

/**
 * Check if current page needs Swiper
 */
function therosessom_needs_swiper() {
    // Check if ACF is active
    if (!function_exists('get_field')) {
        return false;
    }
    
    // Check for hero slides
    if (have_rows('hero_slides')) {
        $slide_count = count(get_field('hero_slides'));
        if ($slide_count > 1) {
            return true;
        }
    }
    
    // Check for portfolio sliders (add your conditions)
    if (is_page_template('template-portfolio.php') || is_singular('portfolio')) {
        return true;
    }
    
    // Check for testimonial sliders
    if (is_page_template('template-testimonials.php') || is_front_page()) {
        return true;
    }
    
    return false;
}

/**
 * Enqueue scripts and styles
 */
function therosessom_scripts() {
    // Check if in development mode
    $is_development = (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development');
    
    if ($is_development && is_vite_server_running()) {
        // Development mode - load from Vite dev server
        wp_enqueue_script('vite-client', VITE_DEV_SERVER . '/@vite/client', [], null, false);
        wp_script_add_data('vite-client', 'type', 'module');

        wp_enqueue_script('therosessom-main', VITE_DEV_SERVER . '/assets/js/main.js', [], null, true);
        wp_script_add_data('therosessom-main', 'type', 'module');
    } else {
        // Production mode - load built assets
        therosessom_enqueue_build_assets();
    }

    // Swiper is now loaded via main.js, so we no longer enqueue it here.

    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script with additional data
    wp_localize_script('therosessom-main', 'therosessomData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('therosessom_nonce'),
        'themeUrl' => get_template_directory_uri(),
        'hasSwiper' => therosessom_needs_swiper(),
        'heroSlides' => therosessom_get_hero_slides_data(),
    ]);
}
add_action('wp_enqueue_scripts', 'therosessom_scripts');

/**
 * Get hero slides data for JavaScript
 */
function therosessom_get_hero_slides_data() {
    if (!function_exists('get_field')) {
        return [];
    }
    
    $slides = get_field('hero_slides');
    if (!$slides) {
        return [];
    }
    
    return [
        'count' => count($slides),
        'hasMultiple' => count($slides) > 1,
        'autoplayDelay' => get_field('hero_autoplay_delay') ?: 5000,
        'transitionSpeed' => get_field('hero_transition_speed') ?: 1500,
    ];
}

/**
 * Preload critical fonts for performance optimization
 */
function therosessom_preload_fonts() {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    $original_font_path = 'assets/fonts/perfectly-nineties.woff2';

    if (!isset($manifest[$original_font_path])) {
        return;
    }

    $final_font_path = $manifest[$original_font_path]['file'];

    $font_url = get_template_directory_uri() . '/dist/' . $final_font_path;

    echo '<link rel="preload" href="' . esc_url($font_url) . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
}
add_action('wp_head', 'therosessom_preload_fonts', 1);

/**
 * Preload hero image for better LCP
 */
function therosessom_preload_hero_image() {
    if (!function_exists('get_field')) {
        return;
    }
    
    // Get first hero slide image
    $hero_slides = get_field('hero_slides');
    if ($hero_slides && isset($hero_slides[0]['slide_image'])) {
        $image = $hero_slides[0]['slide_image'];
        $image_url = is_array($image) ? $image['url'] : $image;
        
        if ($image_url) {
            echo '<link rel="preload" as="image" href="' . esc_url($image_url) . '" fetchpriority="high">' . "\n";
        }
    }
}
add_action('wp_head', 'therosessom_preload_hero_image', 2);

/**
 * Check if Vite development server is running
 */
function is_vite_server_running() {
    $context = stream_context_create([
        'http' => [
            'timeout' => 1,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents(VITE_DEV_SERVER, false, $context);
    return $response !== false;
}

/**
 * Enqueue production build assets
 */
function therosessom_enqueue_build_assets() {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        wp_enqueue_style('therosessom-style', get_stylesheet_uri(), [], THEROSESSOM_VERSION);
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    if (!$manifest) {
        wp_enqueue_style('therosessom-style', get_stylesheet_uri(), [], THEROSESSOM_VERSION);
        return;
    }

    // Entry point for main JS
    $js_entry_key = 'assets/js/main.js';

    if (isset($manifest[$js_entry_key])) {
        $js_file_data = $manifest[$js_entry_key];

        // Enqueue the main JS file
        wp_enqueue_script(
            'therosessom-main',
            get_template_directory_uri() . '/dist/' . $js_file_data['file'],
            [],
            THEROSESSOM_VERSION,
            true
        );
        wp_script_add_data('therosessom-main', 'type', 'module');

        // Enqueue all associated CSS files for the main JS entry
        if (isset($js_file_data['css'])) {
            foreach ($js_file_data['css'] as $index => $css_file) {
                wp_enqueue_style(
                    'therosessom-main-style-' . $index,
                    get_template_directory_uri() . '/dist/' . $css_file,
                    [],
                    THEROSESSOM_VERSION
                );
            }
        }
    }

    // Fallback for main style if not included in JS entry
    $css_entry_key = 'assets/css/style.scss';
    if (isset($manifest[$css_entry_key]) && !isset($manifest[$js_entry_key]['css'])) {
         $css_file_data = $manifest[$css_entry_key];
        wp_enqueue_style(
            'therosessom-style',
            get_template_directory_uri() . '/dist/' . $css_file_data['file'],
            [],
            THEROSESSOM_VERSION
        );
    }
}

/**
 * Add resource hints for external resources
 */
function therosessom_resource_hints($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        // Add CDN domains
        $urls[] = 'https://cdn.jsdelivr.net';
    }
    
    if ('preconnect' === $relation_type) {
        // Preconnect to CDN
        $urls[] = array(
            'href' => 'https://cdn.jsdelivr.net',
            'crossorigin' => 'anonymous',
        );
    }
    
    return $urls;
}
add_filter('wp_resource_hints', 'therosessom_resource_hints', 10, 2);

/**
 * ACF Pro Integration - Options pages only
 */
if (function_exists('acf_add_options_page')) {
    // 부모 페이지 등록
    acf_add_options_page([
        'page_title'  => __('Theme Options', 'therosessom'),
        'menu_title'  => __('Theme Options', 'therosessom'),
        'menu_slug'   => 'theme-options',
        'capability'  => 'edit_posts',
        'icon_url'    => 'dashicons-admin-generic',
        'redirect'    => true, 
    ]);

    acf_add_options_sub_page([
        'page_title'  => __('Site Settings', 'therosessom'),
        'menu_title'  => __('Site Settings', 'therosessom'),
        'parent_slug' => 'theme-options',
    ]);

    acf_add_options_sub_page([
        'page_title'  => __('Business Settings', 'therosessom'),
        'menu_title'  => __('Business Settings', 'therosessom'),
        'parent_slug' => 'theme-options',
    ]);
}

/**
 * Clean up WordPress head for better performance
 */
function therosessom_cleanup() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove WordPress version
    remove_action('wp_head', 'wp_generator');
    
    // Remove unnecessary links
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove REST API links
    remove_action('wp_head', 'rest_output_link_wp_head');
}
add_action('init', 'therosessom_cleanup');

/**
 * Optimize WordPress queries
 */
function therosessom_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search()) {
            $query->set('post_type', ['post', 'page']);
        }
        
        // Optimize portfolio queries
        if ($query->is_post_type_archive('portfolio')) {
            $query->set('posts_per_page', 12);
            $query->set('no_found_rows', true);
        }
    }
}
add_action('pre_get_posts', 'therosessom_optimize_queries');

/**
 * Add defer/async attributes to scripts
 */
function therosessom_add_script_attributes($tag, $handle) {
    // Defer non-critical scripts
    $defer_scripts = ['therosessom-main', 'swiper'];
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'therosessom_add_script_attributes', 10, 2);

/**
 * Helper function to check if ACF is active
 */
function therosessom_is_acf_active() {
    return function_exists('get_field');
}

/**
 * Get Vite asset URL helper
 */
function therosessom_asset($path) {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
    
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);
        if (isset($manifest[$path])) {
            return get_template_directory_uri() . '/dist/' . $manifest[$path]['file'];
        }
    }
    
    return get_template_directory_uri() . '/dist/' . $path;
}

/**
 * Hide specific Appearance submenus - Safe version
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