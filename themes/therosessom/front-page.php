<?php

/**
 * The main template file.
 *
 * @package by Therosessom
 */

// Debug comment (can be removed later)
echo "<!-- front-page.php is loading -->";
get_header();

get_template_part('template-parts/components/Hero/hero-slider');
get_template_part('template-parts/components/Intro/intro');
get_template_part('template-parts/components/Callout/callout-slider');
get_template_part('template-parts/components/Testimonial/testimonials');

get_footer();