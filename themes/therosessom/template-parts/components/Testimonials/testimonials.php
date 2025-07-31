<?php
/**
 * Template part for displaying testimonials section.
 *
 * @package by Therosessom
 */

// Get ACF testimonials data
$testimonials_title = get_field('testimonials_title');
$testimonials_subtitle = get_field('testimonials_subtitle'); 
$testimonials_slides = get_field('testimonials_slides');
$see_moments_button = get_field('see_moments_button');

if (!$see_moments_button) {
    $see_moments_button = [
        'url' => '/gallery',
        'title' => 'SEE THE MOMENTS',
        'target' => '_self'
    ];
}
?>

<section class="testimonials bg-texture-neutral py-16 lg:py-24 relative">
    <div class="container-xl relative z-10">
        
        <!-- Section Title -->
        <div class="text-center mb-16" data-aos="fade-in" data-aos-delay="100">
            <?php if ($testimonials_title || $testimonials_subtitle): ?>
                <h2 class="text-3xl lg:text-4xl text-gray-900 font-primary leading-tight">
                    <?php if ($testimonials_title): ?>
                        <span class="font-normal tracking-wider uppercase">
                            <?php echo esc_html($testimonials_title); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($testimonials_subtitle): ?>
                        <span class="block font-light italic mt-2">
                            <?php echo esc_html($testimonials_subtitle); ?>
                        </span>
                    <?php endif; ?>
                </h2>
            <?php endif; ?>
        </div>

        <!-- Testimonials Swiper Container -->
        <div class="testimonials-swiper swiper">
            <div class="swiper-wrapper">
                
                <?php foreach ($testimonials_slides as $index => $slide): ?>
                <div class="swiper-slide">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                        
                        <!-- Left Column - Polaroid Image -->
                        <div class="order-2 lg:order-1 flex justify-center">
                            <div class="polaroid-frame bg-white p-6 shadow-lg">
                                <?php if ($slide['client_image']): 
                                    $client_img_url = is_array($slide['client_image']) ? $slide['client_image']['url'] : $slide['client_image'];
                                    $client_img_alt = is_array($slide['client_image']) ? $slide['client_image']['alt'] : 'Client Photo';
                                ?>
                                    <img src="<?php echo esc_url($client_img_url); ?>" 
                                         alt="<?php echo esc_attr($client_img_alt); ?>"
                                         class="w-full aspect-[3/3.5] object-cover mb-3">
                                <?php endif; ?>
                                
                                <!-- Polaroid Caption -->
                                <div class="text-center space-y-1">
                                    <?php if ($slide['client_names']): ?>
                                        <p class="font-primary text-sm text-gray-800 italic">
                                            <?php echo esc_html($slide['client_names']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($slide['client_date']): ?>
                                        <p class="text-xs text-gray-600 font-mono">
                                            <?php echo esc_html($slide['client_date']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Testimonials -->
                        <div class="order-1 lg:order-2 space-y-8">
                            
                            <!-- Current Testimonial -->
                            <div class="testimonial-content">
                                
                                <!-- Number -->
                                <div class="flex items-start gap-8">
                                    <span class="text-2xl font-mono text-gray-500 flex-shrink-0 mt-1">
                                        <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                                    </span>
                                    
                                    <!-- Testimonial Text -->
                                    <div class="flex-1">
                                        <?php if ($slide['testimonial_text']): ?>
                                            <p class="text-sm leading-relaxed text-gray-700 font-medium tracking-wide">
                                                <?php echo esc_html($slide['testimonial_text']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- See Moments Button -->
                            <?php if ($slide['see_moments_button']):
                                $button = $slide['see_moments_button']
                            ?>
                            <div class="flex justify-end">
                                <a href="<?php echo esc_url($button['url']); ?>" 
                                   target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                                   class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                                   <span><?php echo esc_html($button['title']); ?></span> 
                                </a>
                            </div>
                            <?php endif; ?>
                            </div>

                            <!-- Other Testimonial Numbers (Inactive) -->
                            <div class="space-y-4">
                                <?php foreach ($testimonials_slides as $other_index => $other_slide): ?>
                                    <?php if ($other_index !== $index): ?>
                                        <div class="flex items-center gap-8 opacity-30">
                                            <span class="text-2xl font-mono text-gray-500 flex-shrink-0 testimonial-number cursor-pointer hover:opacity-70 transition-opacity"
                                                  data-slide="<?php echo $other_index; ?>">
                                                <?php echo str_pad($other_index + 1, 2, '0', STR_PAD_LEFT); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>