<?php
/**
 * Template part for displaying intro section.
 *
 * @package by Therosessom
 */

// Get ACF intro section data
$intro_image = get_field('intro_image');
$intro_title = get_field('intro_title');
$intro_subtitle = get_field('intro_subtitle'); 
$intro_content_left = get_field('intro_content_left');
$intro_content_right = get_field('intro_content_right');
$intro_button = get_field('intro_button');

// Default values for demo
if (!$intro_title) $intro_title = "hi, i'm Jio";
if (!$intro_content_left) $intro_content_left = "I've always believed photography is about more than just capturing how things look—it's about discovering who people are when they think no one is watching, and how they interact with the world around them.";
if (!$intro_content_right) $intro_content_right = "Perfectly posed and polished photos have their place, and yes, grandma might love one for the fridge, but I'm interested in more than that. It's the stolen glances, the unexpected laughter, and the beautiful, messy chaos in between.";
?>

<section class="intro-section bg-primary-light py-16 lg:py-[9.5rem]">
    <div class="container-lg">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-[25vw] items-center">
            
            <!-- Left Column - Image -->
            <div class="order-2 lg:order-1" data-aos="fade-right" data-aos-delay="200">
                <?php if ($intro_image): 
                    $image_url = is_array($intro_image) ? $intro_image['url'] : $intro_image;
                    $image_alt = is_array($intro_image) ? $intro_image['alt'] : 'Intro Image';
                ?>
                    <div class="aspect-square bg-white p-6 shadow-lg">
                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="<?php echo esc_attr($image_alt); ?>"
                             class="w-full h-full object-cover grayscale">
                    </div>
                <?php else: ?>
                    <!-- Placeholder if no image -->
                    <div class="aspect-square bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">Image Placeholder</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Content -->
            <div class="order-1 lg:order-2 space-y-6" data-aos="fade-left" data-aos-delay="400">
                
                <!-- Title -->
                <?php if ($intro_title): ?>
                    <h2 class="text-4xl lg:text-5xl font-primary text-gray-900 leading-tight">
                        <span class="block font-normal"><?php echo esc_html($intro_title); ?></span>
                    </h2>
                <?php endif; ?>

                <!-- Subtitle -->
                <?php if ($intro_subtitle): ?>
                    <p class="text-sm uppercase tracking-widest text-gray-600 font-medium">
                        <?php echo esc_html($intro_subtitle); ?>
                    </p>
                <?php endif; ?>

                <!-- Content Columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm leading-relaxed text-gray-700">
                    
                    <!-- Left Content -->  
                    <?php if ($intro_content_left): ?>
                        <div class="space-y-4">
                            <?php 
                            // Split content by paragraphs
                            $paragraphs_left = explode("\n\n", $intro_content_left);
                            foreach ($paragraphs_left as $paragraph): 
                                if (trim($paragraph)):
                            ?>
                                <p><?php echo esc_html(trim($paragraph)); ?></p>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Right Content -->
                    <?php if ($intro_content_right): ?>
                        <div class="space-y-4">
                            <?php 
                            // Split content by paragraphs
                            $paragraphs_right = explode("\n\n", $intro_content_right);
                            foreach ($paragraphs_right as $paragraph): 
                                if (trim($paragraph)):
                            ?>
                                <p><?php echo esc_html(trim($paragraph)); ?></p>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Button -->
                <?php if ($intro_button): 
                    $button_url = esc_url($intro_button['url']);
                    $button_text = esc_html($intro_button['title']);
                    $button_target = esc_attr($intro_button['target'] ?: '_self');
                ?>
                    <div class="pt-4 text-right">
                        <a href="<?php echo $button_url; ?>" 
                           target="<?php echo $button_target; ?>"
                           class="inline-block text-xs uppercase tracking-widest font-medium transition-colors duration-300">
                            <?php echo $button_text; ?>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Default button -->
                    <div class="pt-4 text-right">
                        <a href="/about" 
                           class="inline-block text-xs uppercase tracking-widest font-medium transition-colors duration-300">
                            About Me
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>