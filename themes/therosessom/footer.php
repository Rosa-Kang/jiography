<?php

/**
 * The template for displaying the footer.
 *
 * @package by Therosessom
 */
    $footer_copyright = get_field('footer_copyright', 'option');
	$footer_script = get_field('footer_script', 'option');
?>

		<footer id="colophon" role="contentinfo" class="relative z-20">
			<div class="py-12">
				<?php if ( is_front_page() ) : ?>
					<div class="container lg:max-w-[1400px] mx-auto">
						<hr class="horizontal-line">
					</div>
				<?php endif; ?>
			</div>

			<div class="ig-feed">
				<?php get_template_part('template-parts/components/IG/ig-feed') ;?>
			</div>

			<div class="container lg:max-w-[1024px] mx-auto px-4 py-6">
				<div class="w-full flex justify-center items-center py-6 sm:px-6 lg:px-8">
					<div id="footer-menu-container" class="space-y-2">
						<?php wp_nav_menu(['menu' => 'Footer Menu', 'menu_id' => 'footer-menu']); ?>
					</div>
				</div>
				<?php if( $footer_copyright ): ?>
					<div class="pb-6">
						<div class="footer-bar text-neutral-500">
							<?php { echo $footer_copyright; } ?>
						</div>
					</div>
				<?php endif;?>

			</div>
		</footer>
	</div><!-- #content -->
</div> <!-- #page -->

<?php wp_footer(); ?>
<?php if( $footer_script ){ echo $footer_script; } ?>
</body>

</html>