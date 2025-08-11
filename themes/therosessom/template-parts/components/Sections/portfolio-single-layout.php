<main id="primary" class="site-main single-portfolio">
    <?php
    while ( have_posts() ) :
        the_post();

        $two_images   = get_field('image_on_top');
        $subheading = get_field('subheading');
        $heading  = get_field('heading');
        $slider_bottom_blurb = get_field('slider_bottom_blurb');
        $slider_images  = get_field('slider_images');
        $button = get_field('slider_button');
    ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16'); ?>>

    <div class="max-w-[80%] lg:container-lg mx-auto px-4 flex flex-col py-16">

        <div class="flex flex-col md:flex-row md:gap-x-12 lg:gap-x-20 items-start">
            
            <div class="w-full mb-8 md:mb-0">
                <?php if ( $two_images ) : ?>
                    <div class="flex gap-4 mb-6 items-stretch">
                        <?php foreach( $two_images as $item ) : 
                            $image = $item['image'];
                            if( $image ): ?>
                            <div class="w-1/2 h-full">
                                <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full aspect-square object-cover">
                            </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
                <heading>
                    <?php the_title( '<h1 class="text-4xl font-semibold font-secondary text-gray-800 mb-4">', '</h1>' ); ?>
                </heading>
                
                <div class="entry-content lg:mt-36">
                        <?php the_content(); ?>
                </div>
            </div>

            <div class="h-full">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="aspect-[2/3]">
                        <?php the_post_thumbnail( 'large', ['class' => 'w-full h-full object-cover'] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-gray-600 py-16 mx-auto">
                <?php if ( $subheading ) : ?>
                    <p class="text-6xl italic font-primary lowercase leading-none"> <?php echo $subheading; ?></p>
                <?php endif; ?>
                
                <?php if ( $heading ) : ?>
                    <h2 class="uppercase text-6xl font-primary leading-none"> <?php echo $heading; ?></h2>
                <?php endif; ?>

        </div>
        
        <?php if ( $slider_images ) : ?>
        <div class="my-20 md:my-32">
            <div class="portfolio-gallery-swiper swiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $slider_images as $slide ) : 
                        $image = $slide['image'];
                        if ( $image ) : ?>
                        <div class="swiper-slide w-[150px] md:w-[180px]">
                            <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full h-24 md:h-28 object-cover">
                        </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>

            <?php if ($slider_bottom_blurb) : ?>
                <div class="text-left text-xs text-gray-800 my-4 mx-auto max-w-md">
                    <?php echo $slider_bottom_blurb; ?>
                </div>
            <?php endif; ?>

            <?php if($button) : 
            $button_url = esc_url($button['url']);
            $button_text = esc_html($button['title']);
            $button_target = esc_attr($button['target'] ?: '_self');
                ?>
                    <div class="pt-4 flex justify-end mt-8">
                        <a href="<?php echo $button_url; ?>"
                           target="<?php echo $button_target; ?>"
                           class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                            <span><?php echo $button_text; ?></span>
                        </a>
                    </div>
        <?php endif;?>
        </div>
        <?php endif; ?>

    </div>
    </article>

    <?php  endwhile; ?>
</main>