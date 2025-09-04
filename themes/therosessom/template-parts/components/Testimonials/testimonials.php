<?php
/**
 * Template part for displaying testimonials section.
 *
 * @package by Therosessom
 */

$testimonials_title = get_field('testimonials_title');
$testimonials_subtitle = get_field('testimonials_subtitle'); 
$testimonials = get_field('testimonials');
?>

<section class="testimonials bg-texture-neutral py-16 lg:py-[92px] relative">
    <div class="container-xl m-auto px-8 relative z-10">
        
        <!-- Section Title -->
        <div class="text-center mb-8 lg:mb-16" data-aos="fade-in" data-aos-delay="100">
            <?php if ($testimonials_title || $testimonials_subtitle): ?>
                <h2 class="flex flex-wrap justify-center text-3xl lg:text-4xl text-gray-900 font-primary leading-tight">
                    <?php if ($testimonials_title): ?>
                        <span class="font-normal tracking-wider uppercase mr-2">
                            <?php echo esc_html($testimonials_title); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($testimonials_subtitle): ?>
                        <span class="block font-light italic">
                            <?php echo esc_html($testimonials_subtitle); ?>
                        </span>
                    <?php endif; ?>
                </h2>
            <?php endif; ?>
        </div>

        <!-- Testimonials Swiper Container -->
        <div class="testimonials-swiper swiper relative max-w-[479px] lg:max-w-none flex flex-col-reverse lg:flex-row-reverse" data-aos="fade-in" data-aos-delay="100">
            <div class="swiper-wrapper"> 
                <?php
                    foreach ($testimonials as $index => $testimonial_row) :
                        $post_object = $testimonial_row['testimonial'];
                        if (!$post_object) continue;
                        setup_postdata($post_object);
                        $button_link = get_field('testimonials_link', $post_object->ID);
                    ?>
                <div class="swiper-slide lg:pl-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 items-center justify-center">
                        
                        <!-- Left Column - Polaroid Image -->
                        <div class="order-1 m-auto flex flex-col items-center justify-center w-full max-w-[390px] relative testimonial-image-container">
                            <div class="polaroid-frame">
                                <?php if (has_post_thumbnail($post_object->ID)) :
                                ?>
                                <?php echo get_the_post_thumbnail($post_object->ID, 'large', ['class' => 'w-full aspect-[3/3.5] object-cover']); ?>
                                <?php endif; ?>
                            </div>
                            <!-- Polaroid Caption -->
                            <div class="flex w-full items-center justify-between text-center pt-4 max-w-[390px]">
                                    <p class="font-primary text-sm text-gray-800 italic">
                                       <?php echo esc_html(get_the_title($post_object->ID)); ?>
                                    </p>

                                    <p class="text-xs text-gray-600 font-secondary">
                                        <span><?php echo get_the_date('M d, Y', $post_object->ID); ?></span>
                                    </p> 
                            </div>
                        </div>

                        <!-- Right Column - Testimonials -->
                        <div class="order-2 space-y-8 m-auto">
                            
                            <!-- Current Testimonial -->
                            <div class="testimonial-content">
                                
                                <!-- Testimonial Text -->
                                <div class="font-secondary max-w-[390px] md:max-unset">
                                    <?php echo wp_kses_post(get_the_content(null, false, $post_object->ID)); ?>
                                </div>
                                
                                <!-- See Moments Button -->
                                <?php if ($button_link):?>
                                <div class="flex justify-end mt-4">
                                    <a href="<?php echo esc_url($button_link['url']); ?>" 
                                    target="<?php echo esc_attr($button_link['target'] ?: '_self'); ?>"
                                    class="btn-primary up flex text-xs uppercase tracking-widest font-medium">
                                    <span class="uppercase">see moments</span> 
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
                
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination testimonial-pagination"></div>
        </div>
    </div>
</section>