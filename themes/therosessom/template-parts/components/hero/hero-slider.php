<?php

/**
 * Template part for displaying hero - slider.
 *
 * @package by Therosessom
 */


// Get ACF hero slides data
$hero_slides = get_field('hero_slides');
$title = get_field('slide_title');
$bottom_text = get_field('slide_bottom_text');
$bottom_signature = get_field('slide_bottom_signature');
?>

<section class="hero-section relative overflow-hidden" style="height: calc(100vh + 32px);">
    <?php if ($hero_slides && count($hero_slides) > 1): ?>
        <!-- Swiper Container -->
        <div class="hero-swiper swiper absolute inset-0 w-full h-full">
            <div class="swiper-wrapper h-full">
                <?php foreach ($hero_slides as $index => $slide): 
                    $image = $slide['slide_image'];
                    $image_url = is_array($image) ? $image['url'] : $image;
                    $image_alt = is_array($image) && !empty($image['alt']) ? $image['alt'] : 'Toronto Photographer Hero Slide';
                ?>
                    <div class="swiper-slide relative h-full overflow-hidden">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 bg-black/40 z-10"></div>
                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="<?php echo esc_attr($image_alt); ?>"
                             class="hero-parallax absolute inset-0 object-cover w-full h-full">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Content Overlay (Static for all slides) -->
        <div class="absolute inset-0 z-20 h-[51%] top-[calc(50%_-_64px)] flex flex-col justify-between items-center text-center px-4">
            <div class="max-w-6xl mx-auto">
                <?php if ($title): ?>
                    <?php
                    $clean_title = strip_tags($title);
                    $lines = preg_split('/\r\n|\r|\n/', $clean_title);
                    $lines = array_filter($lines, 'strlen');
                    ?>
                        <h1 class="hero-title text-5xl text-white font-primary tracking-wider mb-6" 
                        data-aos="fade-in" 
                        data-aos-delay="300">
                            <?php foreach ($lines as $index => $line): ?>
                                <?php if ($index === 0): ?>
                                    <!-- First line: normal style -->
                                    <span class="block leading-[50px]"><?php echo htmlspecialchars(trim($line)); ?></span>
                                <?php else: ?>
                                    <!-- Second line and beyond: italic style -->
                                    <span class="block italic leading-[50px]"><?php echo htmlspecialchars(trim($line)); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </h1>
                <?php endif; ?>
            </div>

            <!-- Bottom Content (Static for all slides) -->
            <?php if ($bottom_text || $bottom_signature): ?>
                <div data-aos="fade-in" data-aos-delay="300">
                    <?php if ($bottom_text): ?>
                        <p class="text-white text-xs font-light tracking-widest uppercase mb-2">
                            <?php echo esc_html($bottom_text); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ($bottom_signature): 
                            $url = esc_url($bottom_signature['url']);
                            $title_text = esc_html($bottom_signature['title']);
                            $target = esc_attr($bottom_signature['target'] ?: '_self');
                    ?>
                            <div class="text-white text-xs font-light">
                                 <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="hover:text-white transition-colors"><?php echo $title_text; ?></a> 
                            </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
    <?php endif; ?>
</section>
