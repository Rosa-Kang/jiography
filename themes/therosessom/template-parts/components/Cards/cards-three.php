<?php
/**
 * Template part for displaying cards - three.
 *
 * @package by Therosessom
 */

$title = get_field('cards_three_title');
$subtitle = get_field('cards_three_subtitle');
$images = get_field('cards_three_images'); 
$blurb = get_field('cards_three_blurb');   
$button = get_field('cards_three_button');

?>

<section class="cards-three bg-primary-light py-16 lg:py-[92px] z-20 relative">
    <div class="max-w-[80%] lg:container-md mx-auto px-4 flex flex-col">

        <div 
        class="mb-12 flex flex-col lg:flex-row items-center justify-center lg:justify-start text-center font-serif">
            <?php if ($title) : ?>
                <span data-aos="fade-in" data-aos-duration="300" data-aos-delay="300" class="text-2xl text-gray-800 capitalize italic font-primary"><?php echo esc_html($title); ?></span>
            <?php endif; ?>

            
            <?php if ($subtitle) : ?>
                <span data-aos="fade-in" data-aos-duration="300" data-aos-delay="500" class="text-gray-400 mx-4 hidden lg:inline">/</span>
                <span data-aos="fade-in" data-aos-duration="300" data-aos-delay="500" class="mt-2 md:mt-0 text-sm font-primary text-gray-500 uppercase tracking-widest">
                    <?php echo esc_html($subtitle); ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if ($images) : ?>
            <div 
            data-aos="fade-in"
            class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <?php foreach ($images as $image) : ?>
                    <div>
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt']); ?>"
                             class="w-full h-full object-cover max-h-[540px] aspect-[3/4]">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($blurb) : ?>
            <div 
            data-aos="fade-in"
            class="font-primary prose prose-lg mx-auto lg:mr-0 lg:ml-auto justify-end text-gray-700 mb-10">
                <?php echo $blurb; ?>
            </div>
        <?php endif; ?>

       <?php if($button) : 
            $button_url = esc_url($button['url']);
            $button_text = esc_html($button['title']);
            $button_target = esc_attr($button['target'] ?: '_self');
                ?>
                    <div 
                    data-aos="fade-up"
                    class="flex justify-end">
                        <a href="<?php echo $button_url; ?>"
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
        <?php endif;?>

    </div>
</section>