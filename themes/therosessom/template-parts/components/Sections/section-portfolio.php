<?php

/**
 * Template part for displaying Portfolio Section.
 *
 * @package by Therosessom
 */
?>

<section class="section-portfolio bg-primary-light py-[92px] max-w-screen-xl mx-auto px-4">

    <?php
    get_template_part('template-parts/components/Filter/portfolio-filter');
    ?>

    <div id="portfolio-grid" class="portfolio-grid grid gap-8 mt-8">
        <?php
        $args = [
            'post_type'      => 'portfolio',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                get_template_part('template-parts/components/Sections/portfolio-item');
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p class="text-center text-gray-500">No portfolios found.</p>';
        endif;
        ?>
    </div>

    <div class="text-center mt-10">
        <button id="portfolio-loadmore"
                data-page="1"
                data-category="all"
                class="bg-black text-white px-6 py-3 hover:bg-gray-800 transition">
            View More
        </button>
    </div>

</section>
