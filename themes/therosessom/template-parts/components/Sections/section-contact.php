<?php

/**
 * Template part for displaying Contact Form Section.
 *
 * @package by Therosessom
 */

$background_image = get_field('contact_page_illustration');
$deco_subtitle = get_field('decorative_subtitle');
$deco_title = get_field('decorative_title');
$deco_blurb = get_field('decorative_blurb');
$deco_image = get_field('decorative_image');


$background_style = '';
if ($background_image && isset($background_image['url'])) {
    $background_style = 'background-image: url(' . esc_url($background_image['url']) . '); background-size: cover; background-position: center;';
}
?>

<section class="contact-form pb-16 md:pb-24 z-20 relative bg-primary-light">
    <div class="flex flex-col items-center lg:flex-row lg:items-stretch">
        <div class="w-full lg:w-1/2 background-illust"  style="<?php echo $background_style; ?>"></div>

        <div class="w-full lg:w-1/2 lg:px-32 contact-form-container py-0 px-12 flex flex-col items-center">
            <div class="text-container lg:max-w-[405px] mx-auto pt-48 pb-12">
                <?php if($deco_subtitle) : ?>
                    <h1 data-aos="fade-in" class="italic lowercase text-4xl leading-[0.8] font-light font-primary text-gray-800"><?php echo esc_html($deco_subtitle); ?></h1>
                <?php endif;?>
                <?php if($deco_title) : ?>
                    <h2 data-aos="fade-in" class="uppercase text-5xl leading-[0.9] mb-4 font-bold font-primary text-gray-900"><?php echo esc_html($deco_title); ?></h2>
                <?php endif;?>
                <?php if($deco_image) : 
                    $url = is_array($deco_image) ? $deco_image['url'] : $deco_image;
                    $alt = is_array($deco_image) && !empty($deco_image['alt']) ? $deco_image['alt'] : 'photographer in toronto decorative-image';
                    ?>
                <div data-aos="fade-in" data-aos-delay="450" data-aos-duration="450">
                    <img src="<?php echo esc_url($url); ?>" alt="<?php echo $alt; ?>" class="w-[250px] h-[309px] lg:ml-12 pb-6">
                </div>
                <?php endif;?>

                <?php if($deco_blurb): ?>
                    <div data-aos="fade-in" data-aos-delay="450" data-aos-duration="450" class="lg:pl-12 text-light">
                        <?php echo preg_replace('/<p>/', '<p class="font-secondary text-2xs">', $deco_blurb, 1); ?>
                    </div>
                <?php endif;?>
            </div>

            <?php get_template_part('template-parts/components/Contact/contact-form')?>
        </div>
    </div>

</section>