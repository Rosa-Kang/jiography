<?php
/**
 * Template part for displaying a single portfolio item with layout logic.
 * This is the new "central control tower" for portfolio layout.
 *
 * It uses variables passed via get_template_part's $args.
 *
 * @package by Therosessom
 *
 * @var array $args {
 * @type int  $post_counter The current post counter from the loop.
 * @type bool $is_row_open  A reference to track if a row div is open.
 * }
 */

$post_counter = $args['post_counter'];
$is_row_open  = &$args['is_row_open'];

$layout_index = $post_counter % 4;

if ($layout_index == 0) {
    if ($is_row_open) { echo '</div>'; $is_row_open = false; }
    echo '<div class="portfolio-item-full pt-16 lg:mx-10" data-aos="fade-in" data-aos-delay="200" data-aos-duration="700">';
    get_template_part('template-parts/components/Sections/portfolio-item');
    echo '</div>';

} elseif ($layout_index == 1) {
    if ($is_row_open) { echo '</div>'; } 
    echo '<div class="portfolio-row grid grid-cols-1 md:grid-cols-2 gap-16 items-start py-16" data-aos="fade-in" data-aos-delay="200" data-aos-duration="700">';
    $is_row_open = true; 
    echo '<div class="portfolio-item-half square">';
    get_template_part('template-parts/components/Sections/portfolio-item');
    echo '</div>';

} elseif ($layout_index == 2) {
    if (!$is_row_open) { 
        echo '<div class="portfolio-row grid grid-cols-1 md:grid-cols-2 gap-8 items-start" data-aos="fade-in" data-aos-delay="300" data-aos-duration="700">';
        $is_row_open = true;
        echo '<div></div>'; 
    }
    echo '<div class="portfolio-item-half rectangular lg:pt-[20rem]" data-aos="fade-in" data-aos-delay="400" data-aos-duration="900">';
    get_template_part('template-parts/components/Sections/portfolio-item');
    echo '</div></div>'; 
    $is_row_open = false; 

} elseif ($layout_index == 3) {
    if ($is_row_open) { echo '</div>'; $is_row_open = false; }
    echo '<div class="portfolio-item-full rectangular portfolio-item-alt pb-16" data-aos="fade-in" data-aos-delay="300" data-aos-duration="700">';
    get_template_part('template-parts/components/Sections/portfolio-item');
    echo '</div>';
}