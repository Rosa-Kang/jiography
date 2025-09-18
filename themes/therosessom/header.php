<?php
/**
 * The header for our theme
 *
 * Enhanced with separated mobile and desktop navigation
 * No JavaScript modifications required
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Therosessom
 */

$site_favicon = get_field('site_favicon', 'option');
$header_classes = 'site-header w-full';
if (is_front_page()) {
    $header_classes .= ' is-transparent';
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
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
	
	<!-- Enhanced header with separated mobile/desktop navigation -->
	<header id="masthead" class="<?php echo esc_attr($header_classes); ?>" 
	        data-sticky="true" 
	        data-hide-on-scroll="true"
	        data-scroll-threshold="100">
		<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-14">
				
				<!-- Site Logo - Always visible -->
				<div class="site-branding">
					<?php get_template_part('template-parts/components/Branding/site-logo'); ?>
				</div>

				<!-- Desktop Navigation - Hidden on mobile -->
				<nav class="desktop-navigation hidden md:block" role="navigation" aria-label="<?php esc_attr_e( 'Desktop Primary Menu', 'therosessom' ); ?>">
					<?php
					wp_nav_menu(array(
						'theme_location'  => 'primary-menu',
						'menu_id'         => 'desktop-primary-menu',
						'menu_class'       => 'desktop-menu-list',
						'container'       => false,
						'depth'           => 3,
						'fallback_cb'     => false,
						'link_before'     => '<span class="menu-text text-sm">',
						'link_after'      => '</span>',
					));
					?>
				</nav>

				<!-- Mobile Navigation Container - Hidden on desktop -->
				<nav id="site-navigation" class="main-navigation md:hidden" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Primary Menu', 'therosessom' ); ?>">
					<!-- Hamburger button for mobile -->
					<button id="menu-toggle" 
					        class="hamburger-button"
					        aria-controls="primary-menu"
					        aria-expanded="false"
					        aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'therosessom' ); ?>">
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'therosessom' ); ?></span>
						<span class="line" aria-hidden="true"></span>
						<span class="line" aria-hidden="true"></span>
						<span class="line" aria-hidden="true"></span>
					</button>

					<!-- Mobile menu panel -->
					<?php
					// Get social icons HTML for mobile menu
					ob_start();
					get_template_part('template-parts/components/Icons/social-icons');
					$social_icons_html = ob_get_clean();

					// Mobile navigation menu with social icons
					wp_nav_menu(array(
						'theme_location'  => 'primary-menu',
						'menu_id'         => 'primary-menu', // Keep same ID for JS compatibility
						'menu_class'      => 'mobile-menu-list',
						'container'       => false,
						'depth'           => 3,
						'fallback_cb'     => false,
						'link_before'     => '<span class="menu-text text-2xl">',
						'link_after'      => '</span>',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item mobile-social-icons">' . $social_icons_html . '</li></ul>',
					));
					?>
				</nav>

			</div>
		</div>
	</header>

	<!-- Main content area with proper spacing for fixed header -->
	<main id="content" class="site-content bg-primary-light">
		<!-- Content will be inserted here by WordPress -->