<?php

/**
 * Template part for displaying hero - about.
 *
 * @package by Therosessom
 */

$hero_photo = get_field('hero_photo');
$title = get_field('hero_title');
$content_right = get_field('hero_content_right');
$content_left = get_field('hero_content_left');
?>

<section class="hero-about bg-primary-light py-[92px]">
    <div class="container-xl m-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-end">

            <div class="order-1 lg:mb-16">
                <?php if ($hero_photo):
                    $image_url = is_array($hero_photo) ? $hero_photo['url'] : $hero_photo;
                    $image_alt = is_array($hero_photo) && !empty($hero_photo['alt']) ? $hero_photo['alt'] : 'Toronto Photographer Intro Image';
                ?>
                    <div    class="relative mx-auto max-w-[464px]"
                            data-aos="fade-in"
                            data-aos-delay="600"
                            data-aos-duration="1200"
                            data-aos-easing="ease-in-out">
                        <img src="<?php echo esc_url($image_url); ?>"
                             alt="<?php echo esc_attr($image_alt); ?>"
                             class="w-full h-auto object-cover aspect-[1/1.3]">
                    </div>
                <?php endif; ?>
            </div>

            <div class="order-2 px-3 space-y-6 max-w-[464px] mx-auto">

                <?php if ($title):
                    $words = explode(' ', esc_html($title));
                    $last_word = array_pop($words);
                    $rest_of_title = implode(' ', $words);
                    ?>
                    <h1 class="text-5xl lg:text-7xl font-primary text-gray-900 leading-tight"
                        data-aos="fade-in"
                        data-aos-delay="400"
                        data-aos-duration="1200"
                        data-aos-easing="ease-in-out">
                        <span class="block font-normal">
                            <?php if (!empty($rest_of_title)): ?>
                                <em class="italic"><?php echo esc_html($rest_of_title); ?></em>
                            <?php endif; ?>
                            <?php if (!empty($last_word)): ?>
                                <?php echo ' ' . esc_html($last_word); ?>
                            <?php endif; ?>
                        </span>
                    </h1>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm font-light leading-relaxed text-gray-700">

                    <?php if ($content_left): ?>
                        <div class="space-y-4 font-secondary"
                             data-aos="fade-in"
                             data-aos-delay="500"
                             data-aos-duration="1200"
                             data-aos-easing="ease-in-out">
                              <?php echo $content_left; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($content_right): ?>
                        <div class="space-y-4 font-secondary"
                             data-aos="fade-in"
                             data-aos-delay="550"
                             data-aos-duration="1200"
                             data-aos-easing="ease-in-out">
                             <?php echo $content_right; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>