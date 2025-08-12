<?php
/**
 * Template part for displaying testimonial - about.
 *
 * @package by Therosessom
 */
$testimonials = get_field('testimonials');
?>

<section class="testimonials-about bg-primary-light py-16 lg:py-[92px]">
    <div class="max-w-[85%] lg:container-md mx-auto relative"
         data-aos="fade-in"
         data-aos-duration="1200"
         data-aos-delay="200"
         data-aos-easing="ease-in-out">
        <?php if ($testimonials) : ?>
            <div class="swiper testimonials-about-swiper overflow-visible">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($testimonials as $testimonial_row) :
                        $post_object = $testimonial_row['testimonial'];
                        if (!$post_object) continue;
                        setup_postdata($post_object);
                    ?>
                        <div class="swiper-slide">
                            <div class="slide-content relative w-full h-[470px] md:w-[647px] md:h-[647px] mx-auto text-overlay">
                                <?php if (has_post_thumbnail($post_object->ID)) : ?>
                                    <div class="testimonial-image-container w-full h-[470px] md:w-[647px] md:h-[647px] mx-auto">
                                        <?php echo get_the_post_thumbnail($post_object->ID, 'large', ['class' => 'testimonial-image grayscale h-full md:aspect-square w-full md:h-inherit object-cover']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="absolute top-0 left-0 right-0 flex justify-between p-8 lg:p-12 z-10 text-black">
                                    <div class="text-sm font-secondary font-bold tracking-wider uppercase">Favourite</div>
                                    <div class="text-sm font-secondary font-bold tracking-wider uppercase">Testimonial</div>
                                </div>
                                
                                <div class="absolute inset-0 flex items-center justify-center p-8 md:p-16 z-20 pointer-events-none">
                                    <div class="max-w-2xl">
                                        <div class="font-secondary text-justify text-lg lg:text-xl leading-relaxed line-clamp-5 lg:line-clamp-12 mb-6 text-secondary">
                                            <?php echo wp_kses_post(get_the_content(null, false, $post_object->ID)); ?>
                                        </div>
                                        <div class="font-secondary text-sm font-bold uppercase flex justify-end text-secondary">
                                            <?php echo esc_html(get_the_title($post_object->ID)); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="absolute bottom-0 left-0 right-0 flex justify-between items-end p-8 lg:p-12 z-10 text-black">
                                    <span class="text-sm font-secondary font-bold tracking-wider uppercase"><?php echo get_the_date('M', $post_object->ID); ?></span>
                                    <span class="text-sm font-secondary font-bold tracking-wider uppercase"><?php echo get_the_date('Y', $post_object->ID); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            
            <div id="prev-btn" class="swiper-button-prev">
                <img width="11px" height="11px" src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg" alt="Toronto Photographer Previous Slide">
            </div>
            <div id="next-btn" class="swiper-button-next">
                <img width="11px" height="11px" src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right.svg" alt="Toronto Photographer Next Slide">
            </div>
            
            <div class="swiper-pagination-fraction flex justify-center items-center pt-6"></div>

        <?php endif; ?>
    </div>
</section>