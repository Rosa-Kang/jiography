<?php
/**
 * Lightweight Therosessom functions and definitions
 * Optimized for performance and minimal functionality
 *
 * @package therosessom
 */
require_once get_template_directory() . '/inc/template-tags.php';

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
    load_theme_textdomain('therosessom', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);
    register_nav_menus([
        'primary-menu' => esc_html__('Primary Menu', 'therosessom'),
        'footer-menu'  => esc_html__('Footer Menu', 'therosessom'),
    ]);
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('portfolio-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'therosessom_setup');

/**
 * Enqueue scripts and styles - Further simplified
 */
function therosessom_scripts() {
    $is_development = (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'development');
    
    if ($is_development && therosessom_is_vite_running()) {
        wp_enqueue_script('vite-client', 'http://localhost:10024/@vite/client', [], null, false);
        wp_script_add_data('vite-client', 'type', 'module');
        wp_enqueue_script('therosessom-main', 'http://localhost:10024/assets/js/main.js', [], null, true);
        wp_script_add_data('therosessom-main', 'type', 'module');
    } else {
        therosessom_enqueue_production_assets();
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_localize_script('therosessom-main', 'therosessomData', [
        'themeUrl' => get_template_directory_uri(),
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('therosessom_portfolio_nonce')
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

    if (!empty($main_js_entry['css'])) {
        foreach ($main_js_entry['css'] as $index => $css_file) {
            add_action('wp_head', function() use ($css_file) {
                echo '<link rel="preload" href="' . esc_url(get_template_directory_uri() . '/dist/' . $css_file) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
                echo '<noscript><link rel="stylesheet" href="' . esc_url(get_template_directory_uri() . '/dist/' . $css_file) . '"></noscript>' . "\n";
            });
        }
    }

    wp_enqueue_script(
        'therosessom-main',
        get_template_directory_uri() . '/dist/' . $main_js_entry['file'],
        [],
        THEROSESSOM_VERSION,
        true
    );
    
    wp_script_add_data('therosessom-main', 'type', 'module');
}

/**
 * Essential WordPress cleanup only
 */
function therosessom_cleanup() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
}
add_action('init', 'therosessom_cleanup');

/**
 * Basic query optimization
 */
function therosessom_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
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
});

/**
 * Optional: Hide unnecessary admin menu items
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
    check_ajax_referer('therosessom_portfolio_nonce', 'nonce');

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $posts_per_page = 4;
    // Switched from offset to paged for more reliable pagination.
    $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
    
    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page, // Use paged instead of offset
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
        'no_found_rows'  => false,
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

    $response = [
        'html'       => '',
        'max_pages'  => 1,
        'post_count' => 0,
    ];

    if ($query->have_posts()) {
        ob_start();
        // Calculate offset for the counter based on the current page.
        $offset = ($page - 1) * $posts_per_page;
        $post_counter = $offset;
        $is_row_open = false;

        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/components/Sections/portfolio-layout-item', null, [
                'post_counter' => $post_counter,
                'is_row_open'  => &$is_row_open,
            ]);
            $post_counter++;
        endwhile;

        if ($is_row_open) { 
            echo '</div>'; 
        }

        $response['html'] = ob_get_clean();

        // Calculate total pages based on found posts
        $response['max_pages'] = $query->max_num_pages;
        $response['post_count'] = $query->post_count;
    }
    
    wp_reset_postdata();

    wp_send_json_success($response);
}

// Register both logged-in and logged-out AJAX handlers
add_action('wp_ajax_load_portfolio', 'therosessom_load_portfolio_posts');
add_action('wp_ajax_nopriv_load_portfolio', 'therosessom_load_portfolio_posts');



/**
 * Prevent archive from overriding page template with the same slug.
 * This function forces WordPress to load the page template
 * for the 'portfolio' slug instead of the archive template.
 */
function therosessom_custom_portfolio_slug_fix( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive('portfolio') ) {
        
        $page_object = get_page_by_path('portfolio');
        
        if ($page_object) {
            $query->set('page_id', $page_object->ID);
            $query->set('post_type', 'page');
            $query->is_page = true;
            $query->is_archive = false;
            
            $query->query_vars['p'] = $page_object->ID;
            $query->queried_object_id = $page_object->ID;
            $query->queried_object = $page_object;
        }
    }
}
add_action( 'pre_get_posts', 'therosessom_custom_portfolio_slug_fix' );

function therosessom_custom_nav_class($classes, $item, $args) {
    
    $portfolio_page_id = get_page_by_path('portfolio')->ID;
    
    if (is_page($portfolio_page_id) && $item->object_id == $portfolio_page_id) {
        
        $classes = array_filter($classes, function($class) {
            return strpos($class, 'current-') === false;
        });
        $classes[] = 'current-menu-item';
    }

    
    if (is_singular('portfolio')) {
        
        if ($item->object_id == $portfolio_page_id) {
            $classes[] = 'current-menu-item';
        }
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'therosessom_custom_nav_class', 10, 3);

/**
 * Add a Content Security Policy (CSP) to the site.
 * This helps to prevent Cross-Site Scripting (XSS) attacks.
 */
function add_content_security_policy() {
    $policy = "default-src 'self'; ";
    $policy .= "script-src 'self' 'unsafe-inline'; ";
    $policy .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; ";
    $policy .= "img-src 'self' data:; ";
    $policy .= "font-src 'self' data: https://fonts.gstatic.com; ";
    $policy .= "connect-src 'self'; ";
    $policy .= "frame-src 'none';";

    header('Content-Security-Policy: ' . $policy);
}
add_action('send_headers', 'add_content_security_policy');
