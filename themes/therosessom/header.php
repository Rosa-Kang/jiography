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
$site_logo = get_field('site_logo', 'option');
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
				<!-- Site Branding -->
				<div class="site-branding flex-shrink-0">
					<?php if ( $site_logo ) : ?>
						<div class="logo-wrapper">
							<?php echo $site_logo; ?>
						</div>
					<?php else : ?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title">
								<a class="lowercase font-primary text-2xl text-gray-800 hover:opacity-80 transition-opacity" 
								   href="<?php echo esc_url( home_url( '/' ) ); ?>" 
								   rel="home">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
						<?php else : ?>
							<p class="site-title">
								<a class="lowercase font-primary text-2xl text-gray-800 hover:opacity-80 transition-opacity" 
								   href="<?php echo esc_url( home_url( '/' ) ); ?>" 
								   rel="home">
									<?php bloginfo( 'name' ); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endif; ?>
				</div>

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
					// WordPress navigation menu with enhanced parameters
					wp_nav_menu(
						array(
							'theme_location'  => 'primary-menu',
							'menu_id'         => 'primary-menu',
							'menu_class'      => 'primary-menu-list',
							'container'       => false,
							'depth'           => 3,
							'fallback_cb'     => false,
							'link_before'     => '<span class="menu-text">',
							'link_after'      => '</span>',
						)
					);
					?>
				</nav>
			</div>
		</div>
	</header>

	<!-- Main content area with proper spacing for fixed header -->
	<div id="content" class="site-content">
		<!-- Content will be inserted here by WordPress -->