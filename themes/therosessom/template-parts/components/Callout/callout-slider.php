<?php
/**
 * Template part for displaying callout-slider section.
 *
 * @package by Therosessom
 */

// Get ACF callout slider data
$bg_image = get_field('callout_slides_bg_image');
$title = get_field('callout_slides_title');
$subtitle = get_field('callout_slides_subtitle');
$thought_image = get_field('callout_slides_thought_image');
$content = get_field('callout_slides_content');
$way_title = get_field('way_title');
$way_content_left = get_field('way_content_left');
$way_content_right = get_field('way_content_right');
$callout_slides = get_field('callout_slides');
$callout_slides_button = get_field('callout_slides_button');

// Check if slides exist before rendering
if (!$callout_slides || !is_array($callout_slides)) {
    return;
}

// Prepare background style
$background_style = '';
$class = 'bg-neutral-100';

if ($bg_image && isset($bg_image['url'])) {
    $class = '';
    $background_style = 'background-image: url(' . esc_url($bg_image['url']) . '); background-size: cover; background-position: center;';
}


?>

<section class="callout-slider min-h-screen relative" style="<?php echo $background_style; ?>">
    <div class="w-full h-screen flex flex-col md:flex-row">
        <!-- Left Content Section -->
        <div class="<?php echo $class;?> px-8 py-16 lg:px-16 lg:py-[96px] flex-1 flex flex-col justify-between relative">
            <div>
                <!-- Top Section - The Thought -->
                <div data-aos="fade-up" data-aos-delay="200">
                    
                    <!-- Title -->
                    <?php if ($title || $subtitle): ?>
                    <div class="space-y-2">
                        <?php if ($title): ?>
                            <h2 class="italic lowercase text-2xl lg:text-4xl -mb-6 font-light font-primary text-gray-800 leading-tight">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ($subtitle): ?>
                            <h3 class="italic uppercase text-3xl lg:text-5xl font-bold font-primary text-gray-900">
                                <?php echo esc_html($subtitle); ?>
                            </h3>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
    
                    <!-- Content with Image -->
                    <div class="flex flex-col gap-2 px-6 items-start">
                        <?php if ($thought_image): 
                            $thought_img_url = is_array($thought_image) ? $thought_image['url'] : $thought_image;
                            $thought_img_alt = is_array($thought_image) ? $thought_image['alt'] : 'Thought Image';
                        ?>
                            <div class="flex-shrink-0 w-20 lg:w-36">
                                <img src="<?php echo esc_url($thought_img_url); ?>" 
                                        alt="<?php echo esc_attr($thought_img_alt); ?>"
                                        class="w-full aspect-[3/4] object-cover grayscale">
                            </div>
                        <?php endif; ?>
    
                        <!-- Text Content -->
                        <?php if ($content): ?>
                            <div class="flex-1 text-xs">
                                    <?php echo $content; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
    
                <!-- Bottom Section - The Way I See -->
                <div class="space-y-6 mt-12 px-6" data-aos="fade" data-aos-delay="400">
                    <?php if ($way_title): ?>
                        <h3 class="text-2xl lg:text-3xl font-light font-primary text-gray-800 italic leading-tight">
                            <?php echo esc_html($way_title); ?>
                        </h3>
                    <?php endif; ?>
    
                    <!-- Two Column Text -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed text-gray-700">
                        
                        <?php if ($way_content_left): ?>
                            <div>
                                <?php echo $way_content_left; ?>
                            </div>
                        <?php endif; ?>
    
                        <?php if ($way_content_right): ?>
                            <div>
                                <?php echo $way_content_right; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php if ($callout_slides_button): 
                    $button_url = esc_url($callout_slides_button['url']);
                    $button_text = esc_html($callout_slides_button['title']);
                    $button_target = esc_attr($callout_slides_button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-end"
                         data-aos="fade-in" 
                         data-aos-delay="900" 
                         data-aos-duration="700" 
                         data-aos-easing="ease-out-back">
                        <a href="<?php echo $button_url; ?>" 
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                            <div class="pl-2">
                               <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-forward.svg" 
                                    alt="Arrow" 
                                    class="w-4 h-4 transform rotate-45 transition"> 
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
                            
        <!-- Right Swiper Section -->
        <div class="flex-1 relative px-8 py-16 lg:px-16 lg:py-[96px]">
            <!-- Swiper Container -->
            <div class="callout-swiper swiper w-full h-full">
                <div class="swiper-wrapper">
                    
                    <?php foreach ($callout_slides as $index => $slide): ?>
                    <div class="swiper-slide">
                        <!-- Right Image Area -->
                        <div class="relative bg-white overflow-hidden w-full h-full" data-aos="fade-left" data-aos-delay="300">
                            <?php if (!empty($slide['slide_image'])): 
                                $slide_img_url = is_array($slide['slide_image']) ? $slide['slide_image']['url'] : $slide['slide_image'];
                                $slide_img_alt = is_array($slide['slide_image']) ? $slide['slide_image']['alt'] : 'Main Slide Image';
                            ?>
                                <img src="<?php echo esc_url($slide_img_url); ?>" 
                                    alt="<?php echo esc_attr($slide_img_alt); ?>"
                                    class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Vertical Dot Navigation -->
             <?php if (count($callout_slides) > 1): ?>
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20">
                    <div class="swiper-pagination-vertical-bullets"></div>
                </div>
            <?php endif; ?>

            <!-- Slide Counter -->
            <?php if (count($callout_slides) > 1): ?>
            <div class="absolute bottom-16 left-1/2 -translate-x-1/2 z-20">
                <span class="callout-counter text-xs text-gray-600 font-mono">
                    (<span class="current-slide">1</span>/<span class="total-slides"><?php echo count($callout_slides); ?></span>)
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>