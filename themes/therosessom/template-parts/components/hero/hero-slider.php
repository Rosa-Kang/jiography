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

<section class="hero-section relative h-screen overflow-hidden">
    <?php if ($hero_slides && count($hero_slides) > 0): ?>
        <!-- Swiper Container -->
        <div class="hero-swiper swiper h-full">
            <div class="swiper-wrapper">
                <?php foreach ($hero_slides as $index => $slide): 
                    $image = $slide['slide_image'];
                    $image_url = is_array($image) ? $image['url'] : $image;
                    $image_alt = is_array($image) ? $image['alt'] : 'Hero Slide';
                ?>
                    <div class="swiper-slide relative">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 bg-black/40 z-10"></div>
                        <div class="absolute inset-0 hero-parallax">
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr($image_alt); ?>"
                                 class="w-full h-full object-cover scale-110 lazy">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Content Overlay (Static for all slides) -->
        <div class="absolute inset-0 z-20 flex flex-col items-center text-center px-4">
            <div class="max-w-6xl mx-auto">
                <?php if ($title): ?>
                    <h1 class="hero-title text-white font-light tracking-wider mb-6" data-aos="fade-up" data-aos-delay="300">
                        <?php  
                        // Split title into two lines for better typography
                        $title_words = explode(' ', trim($title));
                        $word_count = count($title_words);
                        
                        if ($word_count > 2) {
                            $split_point = ceil($word_count / 2);
                            $first_line = array_slice($title_words, 0, $split_point);
                            $second_line = array_slice($title_words, $split_point);
                        } else {
                            $first_line = $title_words;
                            $second_line = [];
                        }
                        ?>
                        <span class="block font-primary leading-tight">
                            <?php echo esc_html(implode(' ', $first_line)); ?>
                        </span>
                        <?php if (!empty($second_line)): ?>
                            <span class="block font-primary leading-tight mt-2">
                                <span class="hero-subtitle-prefix">for</span> <?php echo esc_html(implode(' ', $second_line)); ?>
                            </span>
                        <?php endif; ?>
                    </h1>

                    <!-- Bottom Content (Static for all slides) -->
                    <?php if ($bottom_text || $bottom_signature): ?>
                        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 z-30 text-center" data-aos="fade-up" data-aos-delay="700">
                            <?php if ($bottom_text): ?>
                                <p class="text-white/90 text-sm md:text-base font-light tracking-widest uppercase mb-2">
                                    <?php echo esc_html($bottom_text); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($bottom_signature): 
                                    $url = esc_url($bottom_signature['url']);
                                    $title_text = esc_html($bottom_signature['title']);
                                    $target = esc_attr($bottom_signature['target'] ?: '_self');
                            ?>
                                    <div class="text-white/70 text-xs md:text-sm italic font-light">
                                        ( <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="hover:text-white transition-colors"><?php echo $title_text; ?></a> )
                                    </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
    <?php endif; ?>
</section>
