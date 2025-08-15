<?php
/**
 * The header for our theme
 *
 * Enhanced with sticky header support for mobile and desktop
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Therosessom
 */

$site_favicon = get_field('site_favicon', 'option');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="#ffffff">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php 
		if ($site_favicon) {
			echo '<link rel="icon" href="' . esc_url($site_favicon['url']) . '">';
		} else {
			echo '<link rel="icon" href="data:,">';
		} 
	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'therosessom' ); ?></a>
	
	<!-- Enhanced header with data attributes for JS initialization -->
	<header id="masthead" class="site-header w-full" 
	        data-sticky="true" 
	        data-hide-on-scroll="true"
	        data-scroll-threshold="100">
		<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-16">
				<!-- Site Logo -->
				<?php get_template_part('template-parts/components/Branding/site-logo')?>
				<!-- Navigation -->
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'therosessom' ); ?>">
					<!-- Enhanced hamburger button with proper ARIA labels -->
					<button id="menu-toggle" 
					        class="hamburger-button md:hidden" 
					        aria-controls="primary-menu" 
					        aria-expanded="false"
					        aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'therosessom' ); ?>">
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'therosessom' ); ?></span>
						<span class="line" aria-hidden="true"></span>
						<span class="line" aria-hidden="true"></span>
						<span class="line" aria-hidden="true"></span>
					</button>

					<?php
					// Base arguments for the navigation menu
					$nav_menu_args = array(
						'theme_location'  => 'primary-menu',
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'primary-menu-list',
						'container'       => false,
						'depth'           => 3,
						'fallback_cb'     => false,
						'link_before'     => '<span class="menu-text text-2xl md:text-sm">',
						'link_after'      => '</span>',
					);

					// Check if it's a mobile device to add social icons
					if (function_exists('wp_is_mobile') && wp_is_mobile()) {
						ob_start();
						get_template_part('template-parts/components/Icons/social-icons');
						$social_icons_html = ob_get_clean();

						// Add the custom 'items_wrap' to the arguments array for mobile
						$nav_menu_args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item mobile-social-icons h-full flex">' . $social_icons_html . '</li></ul>';
					}

					// Call the navigation menu function with the prepared arguments
					wp_nav_menu($nav_menu_args);
					?>
				</nav>
			</div>
		</div>
	</header>

	<!-- Main content area with proper spacing for fixed header -->
	<div id="content" class="site-content">
		<!-- Content will be inserted here by WordPress -->