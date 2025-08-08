<?php

/**
 * Template part for displaying Portfolio Item.
 *
 * @package by Therosessom
 */
?>

<article class="portfolio-item">
    <?php if (has_post_thumbnail()) : ?>
        <div class="portfolio-thumb">
            <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
        </div>
    <?php endif; ?>

    <div class="portfolio-content mt-4 prose max-w-none line-clamp-2">
        <?php the_content(); ?>
    </div>
</article>