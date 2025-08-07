<?php

/**
 * Template part for displaying hero - services.
 *
 * @package by Therosessom
 */

$hero_services_image = get_field('hero_services_image');
$hero_services_text = get_field('hero_services_text');

$bg_style = $hero_services_image ? 
    'style="background-image: url(' . esc_url($hero_services_image['url']) . '); 
           background-position: center; 
           background-size: cover; 
           background-repeat: no-repeat; 
           background-attachment: fixed;"' : '';
?>

<section class="hero-services py-[92px] relative" <?php echo $bg_style; ?>>
    <div class="hero-content min-h-[418px] flex justify-center items-center">
        <?php if ($hero_services_text) : ?>
           <div class="sticky-content">
               <h1
               data-aos="fade-in"
               data-aos-duration="1000"
               class="hero-services-title font-primary max-w-[725px] text-white text-3xl text-center pt-[9rem]">
                   <?php echo $hero_services_text; ?>
               </h1>
           </div>
        <?php endif; ?>
    </div>
</section>