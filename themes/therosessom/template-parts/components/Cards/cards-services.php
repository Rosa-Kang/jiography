<?php
/**
 * Template part for displaying cards-services.
 *
 * @package by Therosessom
 */

if (have_rows('service_cards_list')) :
?>

<section class="cards-service-section bg-white py-16 sm:py-24">
    <div class="container mx-auto max-w-7xl px-6 lg:px-8">
        <div class="space-y-16 sm:space-y-24">
            <?php 
            while (have_rows('service_cards_list')) : the_row();
                $image = get_sub_field('card_image');
                $subheading = get_sub_field('card_subheading');
                $title = get_sub_field('card_title');
                $button = get_sub_field('card_button');
            ?>

            <div class="service-card-item flex flex-col lg:flex-row items-center gap-12 lg:gap-16 even:lg:flex-row-reverse">

                <div class="w-full lg:w-1/2">
                    <?php if ($image) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full h-auto object-cover">
                    <?php endif; ?>
                </div>

                <div class="w-full lg:w-1/2">
                    <?php if ($subheading) : ?>
                        <p class="text-sm tracking-[0.2em] text-gray-500 uppercase"><?php echo esc_html($subheading); ?></p>
                    <?php endif; ?>

                    <?php if ($title) : ?>
                        <h2 class="font-primary text-4xl md:text-5xl mt-2 leading-tight"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>

                    <?php
                    if (have_rows('service_details_list')) :
                    ?>
                        <ul class="mt-10 lg:mt-12 space-y-6">
                            <?php
                            while (have_rows('service_details_list')) : the_row();
                                $number = get_sub_field('service_number');
                                $name = get_sub_field('service_name');
                                $price = get_sub_field('service_price');
                                $price_detail = get_sub_field('service_price_detail');
                            ?>
                                <li class="border-b border-gray-200 pb-4">
                                    <div class="flex justify-between items-start gap-4">
                                        <h3 class="font-primary text-2xl">
                                            <?php if ($number) : ?>
                                                <span class="text-gray-400"><?php echo esc_html($number); ?></span>
                                            <?php endif; ?>
                                            <?php echo esc_html($name); ?>
                                        </h3>
                                        <div class="text-right flex-shrink-0">
                                            <?php if ($price) : ?>
                                                <p class="text-base font-semibold"><?php echo esc_html($price); ?></p>
                                            <?php endif; ?>
                                            <?php if ($price_detail) : ?>
                                                <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($price_detail); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($button && $button['url'] && $button['title']) : ?>
                        <a href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target'] ? $button['target'] : '_self'); ?>"
                           class="inline-block mt-10 lg:mt-12 border border-black px-10 py-3 text-sm tracking-widest hover:bg-black hover:text-white transition-colors duration-300">
                            <?php echo esc_html($button['title']); ?>
                        </a>
                    <?php endif; ?>

                </div> </div> <?php endwhile; ?>
        </div> </div> </section> <?php
endif;
?>