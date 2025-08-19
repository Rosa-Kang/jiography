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
                             class="hero-parallax absolute inset-0 object-cover w-full h-full lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Content Overlay (Static for all slides) -->
        <div class="absolute inset-0 z-20 h-[58%] top-[31%] flex flex-col justify-between items-center text-center px-4">
            <div class="max-w-6xl mx-auto">
                <?php if ($title): ?>
                <h1 class="hero-title text-5xl text-white font-light tracking-wider mb-6" data-aos="fade-in" data-aos-delay="300">
                <?php  
                $cleaned_title = strip_tags($title); 
                $cleaned_title = html_entity_decode($cleaned_title); 
                $lines = preg_split('/\r\n|\r|\n|<br\s*\/?>/i', $cleaned_title);

                // Remove empty lines and trim whitespace
                $lines = array_filter(array_map('trim', $lines), function($line) {
                return !empty($line);
                });

                // Reindex array to ensure sequential keys
                $lines = array_values($lines);

                if (count($lines) >= 2) {
                // If we have multiple lines, use WYSIWYG line breaks
                $first_line = $lines[0];
                $second_line = $lines[1];

                // Split second line into first word and remaining words
                $second_line_words = explode(' ', trim($second_line));
                $first_word_second_line = array_shift($second_line_words);
                $remaining_words_second_line = implode(' ', $second_line_words);
                } else {
                // Fallback: if no line breaks detected, use word-based splitting
                $title_words = explode(' ', trim($cleaned_title));
                $word_count = count($title_words);

                if ($word_count >= 3) {
                    $middle_index = floor($word_count / 2);
                    $first_line = implode(' ', array_slice($title_words, 0, $middle_index));
                    $first_word_second_line = $title_words[$middle_index];
                    $remaining_words_second_line = implode(' ', array_slice($title_words, $middle_index + 1));
                } else {
                    $first_line = $cleaned_title;
                    $first_word_second_line = '';
                    $remaining_words_second_line = '';
                }
                }
                ?>

                <!-- First line with capitalize styling -->
                <span class="block capitalize font-primary leading-tight">
                <?php echo esc_html($first_line); ?>
                </span>

                <!-- Second line if exists -->
                <?php if (!empty($first_word_second_line)): ?>
                <span class="flex flex-col items-center md:flex-row md:items-end justify-center font-primary italic leading-tight mt-2">
                <!-- First word of second line with hero-subtitle-prefix -->
                <span class="hero-subtitle-prefix mb-1"><?php echo esc_html($first_word_second_line); ?></span>

                <!-- Remaining words of second line with capitalize -->
                <?php if (!empty($remaining_words_second_line)): ?>
                    <span class="capitalize"><?php echo esc_html($remaining_words_second_line); ?></span>
                <?php endif; ?>
                </span>
                <?php endif; ?>
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
