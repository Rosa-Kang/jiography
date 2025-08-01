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

<section class="testimonials bg-texture-neutral py-16 lg:py-[92px] relative">
    <div class="container-xl relative z-10">
        
        <!-- Section Title -->
        <div class="text-center mb-16" data-aos="fade-in" data-aos-delay="100">
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
        <div class="testimonials-swiper swiper" data-aos="fade-in" data-aos-delay="300">
            <div class="swiper-wrapper relative"> 
                <?php foreach ($testimonials_slides as $index => $slide): ?>
                <div class="swiper-slide pl-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                        
                        <!-- Left Column - Polaroid Image -->
                        <div class="order-2 lg:order-1 flex flex-col justify-center w-[390px]">
                            <div class="polaroid-frame">
                                <?php if ($slide['client_image']): 
                                    $client_img_url = is_array($slide['client_image']) ? $slide['client_image']['url'] : $slide['client_image'];
                                    $client_img_alt = is_array($slide['client_image']) ? $slide['client_image']['alt'] : 'Client Photo';
                                ?>
                                    <img src="<?php echo esc_url($client_img_url); ?>" 
                                         alt="<?php echo esc_attr($client_img_alt); ?>"
                                         class="w-full aspect-[3/3.5] object-cover">
                                <?php endif; ?>
                                
                            </div>
                            <!-- Polaroid Caption -->
                            <div class="flex items-center justify-between text-center pt-4">
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

                        <!-- Right Column - Testimonials -->
                        <div class="order-1 lg:order-2 space-y-8">
                            
                            <!-- Current Testimonial -->
                            <div class="testimonial-content">
                                
                                <!-- Number -->
                                <div class="flex items-start gap-8">
                                    <span class="text-xl font-mono text-gray-500 flex-shrink-0 mt-1">
                                        <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                                    </span>
                                    
                                    <!-- Testimonial Text -->
                                    <div class="flex-1">
                                        <?php if ($slide['testimonial_text']): ?>
                                                <?php echo $slide['testimonial_text']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- See Moments Button -->
                            <?php if ($slide['see_moments_button']):
                                $button = $slide['see_moments_button']
                            ?>
                            <div class="flex justify-end mt-4">
                                <a href="<?php echo esc_url($button['url']); ?>" 
                                   target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                                   class="btn-primary up flex text-xs uppercase tracking-widest font-medium">
                                   <span><?php echo esc_html($button['title']); ?></span> 
                                </a>
                            </div>
                            <?php endif; ?>
                            </div>

                            <!-- Other Testimonial Numbers (Inactive) -->
                            <div class="space-y-4">
                                <?php 
                                    $total_slides = count($testimonials_slides);
                                    for ($i = 1; $i < $total_slides; $i++) {
                                    $display_index = ($index + $i) % $total_slides;
                                ?>
                                    <div class="flex items-center gap-8 opacity-30">
                                        <span class="text-xl font-mono text-gray-500 flex-shrink-0 testimonial-number cursor-pointer hover:opacity-70 transition-opacity"
                                            data-slide="<?php echo $display_index; ?>">
                                            <?php echo str_pad($display_index + 1, 2, '0', STR_PAD_LEFT); ?>
                                        </span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <div 
                class="swiper-pagination 
                swiper-pagination-vertical
                testimonial-pagination
                w-[100px]
                absolute
                ">
                </div>
            </div>
        </div>
    </div>
</section>