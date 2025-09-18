<?php
/**
 * Template part for displaying portfolio filter.
 *
 * @package by Therosessom
 */

$terms = get_terms([
    'taxonomy'   => 'portfolio_category',
    'hide_empty' => true,
    'orderby'    => 'id',
    'order'      => 'ASC',
]);

$title = get_field('gallery_title');
?>

<div class="flex flex-col">
    <?php if($title):?>
        <div class="section-title">
            <h1 data-aos="fade-in" data-aos-duration="700"  class="uppercase font-primary text-4xl mb-4"><?php echo esc_html($title); ?></h1>
            <hr data-aos="fade-left" data-aos-delay="500" data-aos-duration="1800" class="horizontal-line-gray-400 mb-4">
        </div>
    <?php endif;?>
     <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) && count( $terms ) >= 1 ) : ?>
        <div class="portfolio-filter-container relative">
            <button id="filter-toggle-btn" class="filter-toggle-btn font-primary">
                <span class="filter-toggle-text font-primary">ALL</span>
                <svg class="filter-toggle-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div id="portfolio-filter-list" class="portfolio-filter flex gap-6 justify-center lg:justify-around pb-4 bg-primary-light">
                <button class="filter-btn active font-primary text-black" data-category="all">ALL</button>
                <?php foreach ($terms as $term) : ?>
                    <button class="filter-btn text-gray-500 hover:text-black transition font-primary" data-category="<?php echo esc_attr($term->slug); ?>">
                        <?php echo esc_html($term->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php 
$posts_per_page = 4;
$initial_query = new WP_Query([
    'post_type'      => 'portfolio',
    'posts_per_page' => $posts_per_page,
    'post_status'    => 'publish',
    'no_found_rows'  => false,
]);
$total_posts = $initial_query->found_posts;
$max_pages = ceil($total_posts / $posts_per_page);
$initial_post_count = $initial_query->post_count;
wp_reset_postdata();
?>