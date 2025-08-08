<main id="primary" class="site-main single-portfolio">
    <?php
    while ( have_posts() ) :
        the_post();

        $two_images   = get_field('image_on_top');
        $subheading = get_field('subheading');
        $heading  = get_field('heading');
        $slider_bottom_blurb = get_field('slider_bottom_blurb');
        $slider_images  = get_field('slider_images');
    ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16'); ?>>

    <div class="max-w-[80%] lg:container-lg mx-auto px-4 flex flex-col py-16">

        <div class="flex flex-col md:flex-row md:gap-x-12 lg:gap-x-20 items-start">
            
            <div class="md:w-2/5 lg:w-1/2 w-full mb-8 md:mb-0">
                <?php if ( $two_images ) : ?>
                    <div class="flex gap-4 mb-6 items-stretch">
                        <?php foreach( $two_images as $item ) : 
                            $image = $item['image'];
                            if( $image ): ?>
                            <div class="w-1/2 h-full">
                                <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full h-full object-cover">
                            </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>

                <header>
                    <?php the_title( '<h1 class="text-xl font-semibold text-gray-800 mb-4">', '</h1>' ); ?>
                </header>

                <div class="entry-content">
                        <?php the_content(); ?>
                </div>
            </div>

            <div class="lg:w-1/2 h-full">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="w-full h-auto">
                        <?php the_post_thumbnail( 'large', ['class' => 'w-full h-full object-cover'] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

         <?php if ( $heading ) : ?>
                    <div class="prose prose-sm text-gray-600 max-w-none">
                        <?php echo $heading; ?>
                    </div>
        <?php endif; ?>
        
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
                <div class="text-center text-xs text-gray-500 mt-4 max-w-xs mx-auto">
                    <?php echo $slider_bottom_blurb; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
    </article>

    <?php  endwhile; ?>
</main>