<?php
/**
 * Template part for displaying Image Banner section.
 *
 * @package by Therosessom
 */
$image = get_field('image_banner_image');
$blurb = get_field('image_banner_text');
$button = get_field('image_banner_button');

$background_style = '';
if ($image && isset($image['url'])) {
    $background_style = 'background-image: url(' . esc_url($image['url']) . '); background-size: cover; background-position: center;';
}

?>

<section class="img-banner py-16">
    <div class="max-w-[90%] lg:container-2xl flex flex-col justify-center mx-auto">
        <div class="w-full mb-8 aspect-[2.58/1] min-h-[235px]" style="<?php echo $background_style; ?>"></div>
        <?php if($blurb):?>
            <div class="text-center mt-6 px-16">
                <?php echo $blurb;?>
            </div>
        <?php endif; ?>

        <?php if($button) : 
            $button_url = esc_url($button['url']);
            $button_text = esc_html($button['title']);
            $button_target = esc_attr($button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-center mt-8">
                        <a href="<?php echo $button_url; ?>"
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
        <?php endif;?>
    </div>
</section>