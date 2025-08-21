<?php
/**
 * Template part for displaying Portfolio Section.
 * UPDATED: The complex layout logic is now handled by a separate template part.
 *
 * @package by Therosessom
 */
?>

<section class="section-portfolio bg-primary-light py-[92px] max-w-screen-xl mx-auto px-4">
    <div class="max-w-[90%] lg:container-lg mx-auto px-4">
        <?php
        get_template_part('template-parts/components/Filter/portfolio-filter');
        ?>
    
        <div id="portfolio-grid" class="portfolio-grid flex flex-col lg:gap-8 lg:mt-4">
            <?php
            $args = [
                'post_type'      => 'portfolio',
                'posts_per_page' => 4,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];
    
            $query = new WP_Query($args);
    
            if ($query->have_posts()) :
                $post_counter = 0;
                $is_row_open = false;
    
                while ($query->have_posts()) : $query->the_post();
                    
                    get_template_part('template-parts/components/Sections/portfolio-layout-item', null, [
                        'post_counter' => $post_counter,
                        'is_row_open'  => &$is_row_open,
                    ]);
                    $post_counter++;
                endwhile;
    
                if ($is_row_open) { echo '</div>'; }
                
                $initial_post_count = $query->post_count;
                wp_reset_postdata();
    
            else :
                $initial_post_count = 0;
                echo '<p class="text-center text-gray-500">No portfolios found.</p>';
            endif;
            ?>
        </div>
    
        <?php if ($query->max_num_pages > 1) : ?>
            <div class="flex justify-center mt-10">
                    <button
                    data-aos="fade-up"
                    id="portfolio-loadmore"
                    data-page="1"
                    data-category="all"
                    data-max-pages="<?php echo $query->max_num_pages; ?>"
                    data-post-count="<?php echo $initial_post_count; ?>"
                    class="flex text-xs uppercase tracking-widest font-medium">
                        View More
                    </button>
            </div>
        <?php endif; ?>
    </div>
</section>