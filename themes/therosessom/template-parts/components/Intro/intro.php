<?php
/**
 * Template part for displaying intro section.
 *
 * @package by Therosessom
 */

// Get ACF intro section data
$intro_image = get_field('intro_image');
$intro_subtitle = get_field('intro_subtitle'); 
$intro_decorative_text = get_field('intro_decorative_text');
$intro_title = get_field('intro_title');
$intro_content_left = get_field('intro_content_left');
$intro_content_right = get_field('intro_content_right');
$intro_button = get_field('intro_button');
?>  

<section class="intro-section bg-primary-light py-16 lg:py-[9.5rem]">
    <div class="container-lg">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
            
            <div class="order-1 p-[28px] lg:col-span-1 lg:pr-10 lg:pl-0" data-aos="fade-in" data-aos-delay="400" data-aos-duration="700" >
                <?php if ($intro_image): 
                    $image_url = is_array($intro_image) ? $intro_image['url'] : $intro_image;
                    $image_alt = is_array($intro_image) ? $intro_image['alt'] : 'Intro Image';
                ?>
                    <div class="polaroid-frame relative aspect-portrait shadow-lg">
                         <?php if ($intro_decorative_text): 
                            $decorative_words = explode(' ', trim(esc_html($intro_decorative_text)));
                            $word_count = count($decorative_words);
                            if ($word_count > 1) {
                                $first_word = $decorative_words[0];
                                $rest_of_decorative = implode(' ', array_slice($decorative_words, 1));
                            } else {
                                $first_word = $decorative_words;
                            }
                            ?>
                            <p class="text-2xl absolute -top-6 right-5 font-cursive text-gray-600">
                                <?php echo esc_html($first_word); ?>
                            </p>

                            <?php if($rest_of_decorative): ?>
                                <p class="text-4xl absolute -top-3 -right-8 font-cursive text-gray-600">
                                    <?php echo esc_html($rest_of_decorative); ?>
                                </p>
                            <?php endif;?>
                        <?php endif; ?>

                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="<?php echo esc_attr($image_alt); ?>"
                             class="w-full h-full object-cover">
                                        <!-- Subtitle -->
                        <?php if ($intro_subtitle): ?>
                            <p class="text-2xs text-center absolute bottom-3 left-1/2 translate-x-[-50%] uppercase tracking-widest text-gray-600 font-medium">
                                <?php echo esc_html($intro_subtitle); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Content -->
            <div class="order-2 p-6 lg:col-span-2 lg:pl-[174px] space-y-6" data-aos="fade-in" data-aos-delay="400" data-aos-duration="700" >
                
                <!-- Title -->
                <?php if ($intro_title): ?>
                    <h2 class="text-4xl lg:text-5xl font-primary text-gray-900 leading-tight">
                        <span class="block font-normal"><?php echo esc_html($intro_title); ?></span>
                    </h2>
                <?php endif; ?>

                <!-- Content Columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm leading-relaxed text-gray-700">
                    
                    <!-- Left Content -->  
                    <?php if ($intro_content_left): ?>
                        <div class="space-y-4">
                              <?php echo $intro_content_left; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Right Content -->
                    <?php if ($intro_content_right): ?>
                        <div class="space-y-4">
                             <?php echo $intro_content_right; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Button -->
                <?php if ($intro_button): 
                    $button_url = esc_url($intro_button['url']);
                    $button_text = esc_html($intro_button['title']);
                    $button_target = esc_attr($intro_button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-end">
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
</section>