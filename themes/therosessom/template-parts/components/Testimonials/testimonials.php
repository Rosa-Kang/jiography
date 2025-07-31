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

// Default values for demo
if (!$testimonials_title) $testimonials_title = "NOTES";
if (!$testimonials_subtitle) $testimonials_subtitle = "from the people i've met";

if (!$testimonials_slides) {
    $testimonials_slides = [
        [
            'client_image' => '', // Add default image URL
            'client_names' => 'Yura and Geoff',
            'client_date' => 'July 28, 2024',
            'testimonial_text' => "WE'RE ENDLESSLY GRATEFUL FOR THE WAY YOU TOLD OUR STORY — NOT JUST WITH BEAUTIFUL IMAGES, BUT WITH HEART. YOUR PHOTOS HOLD SO MUCH MORE THAN JUST HOW EVERYTHING LOOKED; THEY HOLD HOW IT FELT.",
        ],
        [
            'client_image' => '', // Add more testimonials
            'client_names' => 'Sarah and Mike',
            'client_date' => 'June 15, 2024', 
            'testimonial_text' => "YOU CAPTURED MOMENTS WE DIDN'T EVEN KNOW WERE HAPPENING. EVERY TIME WE LOOK AT OUR PHOTOS, WE'RE TRANSPORTED BACK TO THAT PERFECT DAY.",
        ],
        [
            'client_image' => '',
            'client_names' => 'Emma and James',
            'client_date' => 'May 20, 2024',
            'testimonial_text' => "YOUR ABILITY TO MAKE US FEEL COMFORTABLE WAS INCREDIBLE. THE PHOTOS FEEL SO NATURAL AND AUTHENTIC — EXACTLY WHO WE ARE AS A COUPLE.",
        ]
    ];
}

if (!$see_moments_button) {
    $see_moments_button = [
        'url' => '/gallery',
        'title' => 'SEE THE MOMENTS',
        'target' => '_self'
    ];
}
?>

<section class="testimonials bg-texture-neutral py-16 lg:py-24 relative">
    <div class="container-2xl relative z-10">
        
        <!-- Section Title -->
        <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="200">
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
                        <div class="order-2 lg:order-1 flex justify-center" data-aos="fade-right" data-aos-delay="300">
                            <div class="polaroid-frame bg-white p-6 shadow-lg transform rotate-2 hover:rotate-0 transition-transform duration-500">
                                <?php if ($slide['client_image']): 
                                    $client_img_url = is_array($slide['client_image']) ? $slide['client_image']['url'] : $slide['client_image'];
                                    $client_img_alt = is_array($slide['client_image']) ? $slide['client_image']['alt'] : 'Client Photo';
                                ?>
                                    <img src="<?php echo esc_url($client_img_url); ?>" 
                                         alt="<?php echo esc_attr($client_img_alt); ?>"
                                         class="w-full aspect-[4/3] object-cover mb-4">
                                <?php else: ?>
                                    <!-- Placeholder -->
                                    <div class="w-full aspect-[4/3] bg-gray-200 flex items-center justify-center mb-4">
                                        <span class="text-gray-400 text-sm">Client Photo</span>
                                    </div>
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
                        <div class="order-1 lg:order-2 space-y-8" data-aos="fade-left" data-aos-delay="400">
                            
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

                            <!-- See Moments Button -->
                            <?php if ($see_moments_button): ?>
                            <div class="pt-8">
                                <a href="<?php echo esc_url($see_moments_button['url']); ?>" 
                                   target="<?php echo esc_attr($see_moments_button['target'] ?: '_self'); ?>"
                                   class="btn-arrow-simple inline-block text-gray-900 text-xs uppercase tracking-widest font-medium hover:text-gray-700 transition-colors duration-300 relative pr-8">
                                    <?php echo esc_html($see_moments_button['title']); ?>
                                </a>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>
