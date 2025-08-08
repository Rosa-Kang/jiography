<?php 
/**
 * The Template for displaying a single portfolio post.
 * * @package Therosessom
 */

get_header();

?>

<main id="primary" class="site-main single-portfolio">

  <?php
  // Start the loop.
  while ( have_posts() ) :
    the_post();
  ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      </header><?php therosessom_post_thumbnail(); ?>

      <div class="entry-content">
        <?php
        the_content(
          sprintf(
            wp_kses(
              /* translators: %s: Name of current post. Only visible to screen readers */
              __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'therosessom' ),
              array(
                'span' => array(
                  'class' => array(),
                ),
              )
            ),
            wp_kses_post( get_the_title() )
          )
        );

        wp_link_pages(
          array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'therosessom' ),
            'after'  => '</div>',
          )
        );
        ?>
      </div></article><?php
  endwhile; // End of the loop.
  ?>

</main><?php

get_footer();