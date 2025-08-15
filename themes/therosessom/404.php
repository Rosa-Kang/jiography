<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Therosessom
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'therosessom' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content py-16">
				
				<div class="flex flex-col items-center width-full pt-16">
						<p><?php esc_html_e( 'OOps! it looks like nothing was found at this location.', 'therosessom' ); ?></p>

						<div class="pt-16">
							<h1 class="site-title">
									   <a class="lowercase font-primary text-2xl text-gray-800 hover:opacity-80 transition-opacity" 
										  href="<?php echo esc_url( home_url( '/' ) ); ?>" 
										  rel="home">
										   <?php bloginfo( 'name' ); ?>
									   </a>
							</h1>
		
						   <div class="pt-8 flex justify-center" data-aos="fade-up" data-aos-duration="800">
							   <a href="<?php echo esc_url(home_url()); ?>"
								  class="btn-primary up flex text-xs uppercase tracking-widest font-medium">
								  <span>go to home</span>
							   </a>
						   </div>
						</div>
					</div>


			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
