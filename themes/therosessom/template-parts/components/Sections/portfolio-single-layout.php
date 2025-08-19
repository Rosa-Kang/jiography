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

    <div class="max-w-[90%] lg:container-lg mx-auto px-4 flex flex-col py-16">

        <div class="flex flex-col md:flex-row md:gap-x-12 lg:gap-x-20 items-start pb-16">
            
            <div class="w-full mb-8 md:mb-0">
                <?php if ( $two_images ) : ?>
                    <div class="flex gap-4 mb-6 items-stretch">
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
                                <div class="w-1/2 h-full" data-aos="fade-in" data-aos-duration="600" data-aos-delay="350">
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
                
                <header>
                    <?php the_title( '<h1 class="text-4xl font-semibold font-secondary text-gray-800 mb-4">', '</h1>' ); ?>
                </header>
                
                <div class="entry-content font-secondary font-light lg:mt-36" data-aos="fade-in" data-aos-duration="600" data-aos-delay="450">
                    <?php the_content(); ?>
                </div>
            </div>

            <div class="h-full">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="aspect-[2/3]" data-aos="fade-in" data-aos-duration="600">
                        <?php the_post_thumbnail( 'large', ['class' => 'w-full h-full object-cover'] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="py-16 mx-auto" data-aos="fade-in" data-aos-duration="600">
            <?php if ( $subheading ) : ?>
                <p class="mt-16 text-6xl italic font-primary lowercase leading-none" data-aos="fade-in" data-aos-duration="650">
                    <?php echo esc_html($subheading); ?>
                </p>
            <?php endif; ?>
            
            <?php if ( $heading ) : ?>
                <h2 class="mb-16 text-6xl font-primary uppercase leading-none" data-aos="fade-in" data-aos-duration="800" data-aos-delay="350">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>
        </div>
        
        <?php if ( $slider_images ) : ?>
            <div class="max-w-[90%] lg:container-md mx-auto">
                <div class="main-portfolio-swiper swiper aspect-[1/1.23] max-h-[670px] mb-8 relative">
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
                            <div class="swiper-slide cursor-pointer">
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

    <?php endwhile; ?>
</main>