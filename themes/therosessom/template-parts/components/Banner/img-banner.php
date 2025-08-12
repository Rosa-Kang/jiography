<?php
/**
 * Template part for displaying Image Banner section.
 *
 * @package by Therosessom
 */
$image = get_field('image_banner_image');
$blurb = get_field('image_banner_text');
$button = get_field('image_banner_button');

?>

<section class="img-banner py-16">
    <div class="max-w-[90%] lg:container-2xl flex flex-col justify-center mx-auto">
        <div class="w-full mb-8 aspect-[2.58/1] min-h-[235px]">
            <?php if ( $image ) : 
            $image_alt = is_array($image) && !empty($image['alt']) ? $image['alt'] : 'Toronto Photographer Banner Image';
                ?>
                <img 
                data-aos="fade-in" data-aos-delay="300" data-aos-duration="600"
                class="w-full h-full max-h-[450px] lg:min-h-[526px] lg:max-h-none object-cover"
                src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr($image_alt); ?>" 
                >
            <?php endif; ?>
        </div>
        <?php if($blurb):?>
            <div class="font-secondary font-light text-center mt-6 px-16" data-aos="fade-in" data-aos-delay="300" data-aos-duration="400">
                <?php echo $blurb;?>
            </div>
        <?php endif; ?>

        <?php if($button) : 
            $button_url = esc_url($button['url']);
            $button_text = esc_html($button['title']);
            $button_target = esc_attr($button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-center mt-8" data-aos="fade-up" data-aos-duration="800">
                        <a href="<?php echo $button_url; ?>"
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
        <?php endif;?>
    </div>
</section>