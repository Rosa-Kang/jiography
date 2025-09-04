<main id="primary" class="site-main single-portfolio">
    <?php
    while ( have_posts() ) :
        the_post();

        $two_images   = get_field('image_on_top');
        $subheading = get_field('subheading');
        $heading  = get_field('heading');
        $slider_bottom_blurb = get_field('slider_bottom_blurb');
        $slider_images  = get_field('slider_images');
        $button = get_field('slider_button');
    ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16'); ?>>

    <div class="max-w-[100%] lg:max-w-[80%] lg:container-lg mx-auto px-4 flex flex-col py-16">

        <div class="flex flex-col md:flex-row md:gap-x-12 lg:gap-x-20 items-stretch">
            
            <div class="w-full mb-8 md:mb-0 md:basis-[57%]">
                <?php if ( $two_images ) : ?>
                    <div class="flex gap-4 mb-6">
                        <?php foreach( $two_images as $item ) : 
                            $image = isset($item['image']) ? $item['image'] : null;
                            $image_link_raw = isset($item['image_link']) ? $item['image_link'] : '';
                            
                            // Handle both string URLs and ACF Link field arrays
                            $image_link = '';
                            if (is_array($image_link_raw)) {
                                // ACF Link field returns array with 'url', 'title', 'target'
                                $image_link = isset($image_link_raw['url']) ? $image_link_raw['url'] : '';
                            } elseif (is_string($image_link_raw)) {
                                // Simple URL field
                                $image_link = $image_link_raw;
                            }
                            
                            $image_alt = (is_array($image) && isset($image['alt']) && !empty($image['alt'])) ? $image['alt'] : 'Toronto Photographer Portfolio Image';
                            if( $image ): ?>
                                <div class="w-1/2 h-full items-stretch" data-aos="fade-in" data-aos-duration="600" data-aos-delay="350">
                                    <?php if( !empty($image_link) ): ?>
                                        <a href="<?php echo esc_url($image_link); ?>" target="_blank" rel="noopener noreferrer" class="block w-full h-full">
                                            <img src="<?php echo esc_url($image['sizes']['medium']); ?>" 
                                                 alt="<?php echo esc_attr($image_alt); ?>" 
                                                 class="w-full aspect-square object-cover hover:opacity-90 transition-opacity duration-300">
                                        </a>
                                    <?php else: ?>
                                        <img src="<?php echo esc_url($image['sizes']['medium']); ?>" 
                                             alt="<?php echo esc_attr($image_alt); ?>" 
                                             class="w-full aspect-square object-cover">
                                    <?php endif; ?>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div>
                    <div data-aos="fade-in" data-aos-duration="600" data-aos-delay="450">
                        <?php the_title( '<h1 class="text-4xl font-semibold font-secondary text-gray-800 mb-4">', '</h1>' ); ?>
                    </div>
                    
                    <div class="entry-content font-secondary font-light lg:mt-32" data-aos="fade-in" data-aos-duration="600" data-aos-delay="650">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

            <div class="h-full md:basis-[43%]" data-aos="fade-in" data-aos-duration="600">
                <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'large', ['class' => 'h-full min-h-[520px] object-cover'] ); ?>
                <?php endif; ?>
            </div>
        </div>
    
    <?php if( $subheading || $heading ):?>
        <div class="pb-8 lg:py-16 mx-auto" data-aos="fade-in" data-aos-duration="600">
            <?php if ( $subheading ) : ?>
                <p class="mt-16 text-6xl italic font-primary lowercase leading-none" data-aos="fade-in" data-aos-duration="650">
                    <?php echo esc_html($subheading); ?>
                </p>
            <?php endif; ?>
            
            <?php if ( $heading ) : ?>
                <h2 class="lg:mb-16 text-6xl font-primary uppercase leading-none" data-aos="fade-in" data-aos-duration="800" data-aos-delay="350">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>
        </div>
    <?php endif;?> 
    
        <?php if ( $slider_images ) : ?>
            <div class="max-w-[100%] lg:max-w-[90%] lg:container-md mx-auto">
                <div class="main-portfolio-swiper swiper aspect-[1/1.23] lg:max-h-[670px] mb-8 relative">
                    <div class="swiper-wrapper">
                        <?php foreach ( $slider_images as $slide ) : 
                            $image = isset($slide['image']) ? $slide['image'] : null;
                            $slider_link_raw = isset($slide['image_link']) ? $slide['image_link'] : '';
                            
                            // Handle both string URLs and ACF Link field arrays for slider
                            $slider_large_image_link = '';
                            if (is_array($slider_link_raw)) {
                                $slider_large_image_link = isset($slider_link_raw['url']) ? $slider_link_raw['url'] : '';
                            } elseif (is_string($slider_link_raw)) {
                                $slider_large_image_link = $slider_link_raw;
                            }
                            
                            if ( $image ) : ?>
                            <div class="swiper-slide h-full">
                                <?php if( !empty($slider_large_image_link) ): ?>
                                    <a href="<?php echo esc_url($slider_large_image_link); ?>" target="_blank" rel="noopener noreferrer" class="block w-full h-full">
                                        <img src="<?php echo esc_url($image['sizes']['large']); ?>" 
                                             alt="<?php echo esc_attr(isset($image['alt']) ? $image['alt'] : ''); ?>" 
                                             class="aspect-[1/1.23] object-cover hover:opacity-90 transition-opacity duration-300">
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo esc_url($image['sizes']['large']); ?>" 
                                         alt="<?php echo esc_attr(isset($image['alt']) ? $image['alt'] : ''); ?>" 
                                         class="aspect-[1/1.23] object-cover">
                                <?php endif; ?>
                            </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

                <!-- Thumbnail gallery - NO LINKS as requested -->
                <div class="portfolio-gallery-swiper swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ( $slider_images as $slide ) : 
                            $image = isset($slide['image']) ? $slide['image'] : null;
                            if ( $image ) : ?>
                            <div class="swiper-slide cursor-pointer aspect-square">
                                <img src="<?php echo esc_url($image['sizes']['medium']); ?>" 
                                    alt="<?php echo esc_attr(isset($image['alt']) ? $image['alt'] : ''); ?>" 
                                    class="aspect-square object-cover">
                            </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>

                <?php if ($slider_bottom_blurb) : ?>
                    <div class="text-left text-xs text-gray-800 my-4 mx-auto max-w-md">
                        <?php echo wp_kses_post($slider_bottom_blurb); ?>
                    </div>
                <?php endif; ?>

                <?php if($button) : 
                    $button_url = '';
                    $button_text = '';
                    $button_target = '_self';
                    
                    // Handle ACF Link field array format
                    if (is_array($button)) {
                        $button_url = isset($button['url']) ? esc_url($button['url']) : '';
                        $button_text = isset($button['title']) ? esc_html($button['title']) : '';
                        $button_target = isset($button['target']) ? esc_attr($button['target']) : '_blank';
                    }
                    
                    if (!empty($button_url) && !empty($button_text)) :
                ?>
                    <div class="pt-4 flex justify-end mt-16" data-aos="fade-up">
                        <a href="<?php echo $button_url; ?>"
                           target="<?php echo $button_target; ?>"
                           rel="noopener noreferrer"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>
    </article>

    <nav class="portfolio-navigation flex justify-between max-w-6xl mx-auto lg:max-w-[80%] px-4 sm:px-6 lg:px-16 pb-8">
        <div data-aos="fade-up">
            <?php
            $next_post = get_next_post();
            if (!empty($next_post)) : ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="flex items-center space-x-4">
                    <div id="prev-btn">
                        <img width="11px" height="11px" src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg" alt="Previous Portfolio">
                    </div>
                    <span class="text-xs uppercase tracking-widest font-medium !ml-[10px]">Previous</span>
                </a>
            <?php endif; ?>
        </div>
        <div data-aos="fade-up">
             <?php
            $prev_post = get_previous_post();
            if (!empty($prev_post)) : ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="flex items-center space-x-4">
                    <span class="text-xs uppercase tracking-widest font-medium">Next</span>
                    <div id="next-btn" class="!ml-[10px]">
                        <img width="11px" height="11px" src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right.svg" alt="Next Portfolio">
                    </div>
                </a>
            <?php endif; ?>
           
        </div>
    </nav>

    <?php endwhile; ?>
</main>