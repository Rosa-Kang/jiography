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

<section class="callout-slider relative" style="<?php echo $background_style; ?>">
    <div class="w-full flex flex-col lg:flex-row lg:items-center lg:justify-around">
        <!-- Left Content Section -->
        <div class="<?php echo $class;?> mx-auto lg:mx-0 px-8 pt-16 pb-8 xl:px-16 lg:py-[82px] max-w-[660px] flex-1 flex-col justify-between relative">
            <div>
                <!-- Top Section - The Thought -->
                <div>
                    
                    <!-- Title -->
                    <?php if ($title || $subtitle): ?>
                    <div data-aos="fade-in"  data-aos-delay="100"  data-aos-duration="200" >
                        <?php if ($title): ?>
                            <h2 class="italic lowercase text-5xl lg:text-7xl font-light font-primary text-gray-800 leading-tight">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ($subtitle): ?>
                            <h3 class="italic uppercase text-5xl lg:text-7xl mb-3 font-bold font-primary text-gray-900">
                                <?php echo esc_html($subtitle); ?>
                            </h3>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
    
                    <!-- Content with Image -->
                    <div class="flex flex-col gap-[14px] px-6 xl:pr-6 xl:pl-[85px] items-start">
                        <?php if ($thought_image): 
                            $thought_img_url = is_array($thought_image) ? $thought_image['url'] : $thought_image;
                            $thought_img_alt = is_array($thought_image) ? $thought_image['alt'] : 'Thought Image';
                        ?>
                            <div class="flex-shrink-0 w-[250px]" data-aos="fade-in" data-aos-delay="200"  data-aos-duration="300">
                                <img src="<?php echo esc_url($thought_img_url); ?>" 
                                        alt="<?php echo esc_attr($thought_img_alt); ?>"
                                        class="w-full aspect-[3/3.71] object-cover grayscale">
                            </div>
                        <?php endif; ?>
    
                        <!-- Text Content -->
                        <?php if ($content): ?>
                            <div class="flex-1 text-xs/4 font-light font-secondary" data-aos="fade-in" data-aos-delay="300"  data-aos-duration="500">
                                    <?php echo $content; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
    
                <!-- Bottom Section - The Way I See -->
                <div class="mt-12 px-6 lg:pr-6 xl:pl-[85px]" data-aos="fade-in" data-aos-delay="300"  data-aos-duration="500">
                    <?php if ($way_title): 
                        $words = explode(' ', trim($way_title));
                        $first_two = implode(' ', array_slice($words, 0, 2));
                        $remaining = count($words) > 2 ? ' ' . implode(' ', array_slice($words, 2)) : '';
                        ?>
                        <h3 class="text-4xl lg:text-5xl font-primary text-gray-800 leading-tight mb-4">
                            <span class="italic"><?php echo esc_html($first_two); ?></span> <span><?php echo esc_html($remaining); ?></span>
                        </h3>
                    <?php endif; ?>
    
                    <!-- Two Column Text -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed text-gray-700">
                        
                        <?php if ($way_content_left): ?>
                            <div class="font-secondary" data-aos="fade-in" data-aos-delay="300"  data-aos-duration="700">
                                <?php echo $way_content_left; ?>
                            </div>
                        <?php endif; ?>
    
                        <?php if ($way_content_right): ?>
                            <div class="font-secondary" data-aos="fade-in" data-aos-delay="400"  data-aos-duration="700">
                                <?php echo $way_content_right; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php if ($callout_slides_button): 
                    $button_url = esc_url($callout_slides_button['url']);
                    $button_text = esc_html($callout_slides_button['title']);
                    $button_target = esc_attr($callout_slides_button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-end mt-8">
                        <a href="<?php echo $button_url; ?>" 
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium"
                           data-aos-delay="450"  data-aos-duration="600">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
                            
        <!-- Right Swiper Section -->
        <div class="relative flex items-center px-8 pt-8 pb-16 xl:pl-24 xl:py-[96px]" data-aos="fade-in" data-aos-delay="650">
            <!-- Swiper Container -->
            <div class="callout-swiper swiper max-h-[370px] md:max-h-[727px] ">
                <div class="swiper-wrapper">   
                    <?php foreach ($callout_slides as $index => $slide): ?>
                    <div class="swiper-slide">
                        <!-- Right Image Area -->
                        <div class="relative bg-transparent px-5 overflow-hidden size-fit">
                            <?php if (!empty($slide['slide_image'])): 
                                $slide_img_url = is_array($slide['slide_image']) ? $slide['slide_image']['url'] : $slide['slide_image'];
                                $slide_img_alt = is_array($slide['slide_image']) ? $slide['slide_image']['alt'] : 'Main Slide Image';
                            ?>
                                <img src="<?php echo esc_url($slide_img_url); ?>" 
                                    alt="<?php echo esc_attr($slide_img_alt); ?>"
                                    class="h-[370px] md:h-[727px] aspect-[3/4] object-cover">
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Vertical Dot Navigation -->
                 <?php if (count($callout_slides) > 1): ?>
                    <div class="absolute -left-0 top-1/2 transform -translate-y-1/2 z-20">
                        <div class="swiper-pagination-vertical-bullets"></div>
                    </div>
                <?php endif; ?>
            </div>

                            <!-- Slide Counter -->
                <?php if (count($callout_slides) > 1): ?>
                <div class="absolute bottom-8 lg:bottom-16 left-1/2 -translate-x-1/2 lg:-translate-x-[calc(50%-2rem)] z-30">
                    <span class="callout-counter text-xs text-gray-600 font-secondary">
                        (<span class="current-slide">1</span>/<span class="total-slides"><?php echo count($callout_slides); ?></span>)
                    </span>
                </div>
                <?php endif; ?>
        </div>
    </div>
</section>