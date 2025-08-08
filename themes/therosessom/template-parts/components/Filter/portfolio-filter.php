<?php

/**
 * Template part for displaying portfolio filter.
 *
 * @package by Therosessom
 */

$terms = get_terms([
    'taxonomy'   => 'portfolio_category',
    'hide_empty' => true,
]);
?>

<div class="portfolio-filter flex gap-6 justify-center border-b border-gray-200 pb-4">
    <button class="filter-btn active font-medium text-black" data-category="all">ALL</button>
    <?php foreach ($terms as $term) : ?>
        <button class="filter-btn text-gray-500 hover:text-black transition" data-category="<?php echo esc_attr($term->slug); ?>">
            <?php echo esc_html($term->name); ?>
        </button>
    <?php endforeach; ?>
</div>