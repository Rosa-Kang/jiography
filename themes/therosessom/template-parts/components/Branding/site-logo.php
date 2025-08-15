<?
/**
 * Template for displaying Site Logo
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Therosessom
 */
$site_logo = get_field('site_logo', 'option');
?>

<!-- Site Branding -->
<div class="site-branding flex-shrink-0">
    <?php if ( $site_logo ) : ?>
        <div class="logo-wrapper">
            <?php echo $site_logo; ?>
        </div>
    <?php else : ?>
        <?php if ( is_front_page() && is_home() ) : ?>
            <h1 class="site-title">
                <a class="lowercase font-primary text-4xl lg:text-2xl text-gray-800 hover:opacity-80 transition-opacity" 
                    href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                    rel="home">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </h1>
        <?php else : ?>
            <p class="site-title">
                <a class="lowercase font-primary text-4xl lg:text-2xl text-gray-800 hover:opacity-80 transition-opacity" 
                    href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                    rel="home">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div>
