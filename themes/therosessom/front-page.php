<?php

/**
 * The main template file.
 *
 * @package by Therosessom
 */

// Debug comment (can be removed later)
echo "<!-- front-page.php is loading -->";
get_header();

get_template_part('template-parts/components/hero/hero-slider');
// get_template_part('template-parts/section/intro');
// get_template_part('template-parts/card/cards-quad');
// get_template_part('template-parts/callout/callout-right');
// get_template_part('template-parts/slider/slider-testimonials');
// get_template_part('template-parts/section/signup-banner');

get_footer();