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

<section class="intro-section bg-primary-light py-16 lg:py-[92px]">
    <div class="container-lg mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">

            <div class="order-1 p-4 lg:p-[28px] lg:col-span-1 lg:pr-10 lg:pl-0"
                 data-aos="fade-in"
                 data-aos-delay="100"
                 data-aos-duration="900"
                 data-aos-easing="ease-out-cubic">
                <?php if ($intro_image):
                    $image_url = is_array($intro_image) ? $intro_image['url'] : $intro_image;
                    $image_alt = is_array($intro_image) ? $intro_image['alt'] : 'Intro Image';
                ?>
                    <div class="polaroid-frame relative mx-auto max-w-[300px] lg:max-w-none">
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
                            <p class="z-10 text-2xl absolute -top-6 right-5 font-cursive text-gray-600"
                               data-aos="fade-in"
                               data-aos-delay="200"
                               data-aos-duration="600"
                               data-aos-easing="ease-out-quart">
                                <?php echo esc_html($first_word); ?>
                            </p>

                            <?php if($rest_of_decorative): ?>
                                <p class="z-10 text-4xl absolute -top-3 -right-8 font-cursive text-gray-600"
                                   data-aos="fade-in"
                                   data-aos-delay="300"
                                   data-aos-duration="600"
                                   data-aos-easing="ease-out-quart">
                                    <?php echo esc_html($rest_of_decorative); ?>
                                </p>
                            <?php endif;?>
                        <?php endif; ?>

                        <img src="<?php echo esc_url($image_url); ?>"
                             alt="<?php echo esc_attr($image_alt); ?>"
                             class="w-full h-auto object-cover grayscale aspect-[1/1.3]">
                                        <?php if ($intro_subtitle): ?>
                            <div class="absolute bottom-3 left-0 right-0 flex justify-center">
                                <p class="text-2xs text-center uppercase tracking-widest text-gray-600 font-medium"
                                data-aos="fade-in"
                                data-aos-delay="400"
                                data-aos-easing="ease-out-back">
                                    <?php echo esc_html($intro_subtitle); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="order-2 p-6 lg:col-span-2 lg:pl-[174px] space-y-6 max-w-[352px] md:max-w-[650px] m-auto"
                 data-aos="fade-in"
                 data-aos-delay="500"
                 data-aos-duration="900"
                 data-aos-easing="ease-out-cubic">

                <?php if ($intro_title):
                    $words = explode(' ', esc_html($intro_title));
                    $last_word = array_pop($words);
                    $rest_of_title = implode(' ', $words);
                    ?>
                    <h2 class="text-5xl lg:text-7xl font-primary text-gray-900 leading-tight"
                        data-aos="fade-in"
                        data-aos-delay="600"
                        data-aos-duration="700"
                        data-aos-easing="ease-out-quart">
                        <span class="block font-normal">
                            <?php if (!empty($rest_of_title)): ?>
                                <em class="italic"><?php echo esc_html($rest_of_title); ?></em>
                            <?php endif; ?>
                            <?php if (!empty($last_word)): ?>
                                <?php echo ' ' . esc_html($last_word); ?>
                            <?php endif; ?>
                        </span>
                    </h2>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm leading-relaxed text-gray-700">

                    <?php if ($intro_content_left): ?>
                        <div class="space-y-4 font-secondary"
                             data-aos="fade-in"
                             data-aos-delay="650"
                             data-aos-duration="600"
                             data-aos-easing="ease-out-sine">
                              <?php echo $intro_content_left; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($intro_content_right): ?>
                        <div class="space-y-4 font-secondary"
                             data-aos="fade-in"
                             data-aos-delay="650"
                             data-aos-duration="600"
                             data-aos-easing="ease-out-sine">
                             <?php echo $intro_content_right; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($intro_button):
                    $button_url = esc_url($intro_button['url']);
                    $button_text = esc_html($intro_button['title']);
                    $button_target = esc_attr($intro_button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-end"
                         data-aos="fade-in"
                         data-aos-delay="700"
                         data-aos-duration="800"
                         data-aos-easing="ease-out-back">
                        <a href="<?php echo $button_url; ?>"
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>