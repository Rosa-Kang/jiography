<?php

/**
 * Template part for displaying Section Services.
 *
 * @package by Therosessom
 */
?>


<section class="section-services pb-16 md:pb-24 z-20 relative bg-primary-light">
    <div class="max-w-[80%] lg:container-lg mx-auto px-4">

        <?php if ( have_rows( 'service_sections' ) ) :
            while ( have_rows( 'service_sections' ) ) :
                the_row();

                if ( get_row_layout() == 'layout1' ) :
                    $image  = get_sub_field( 'image' );
                    $button = get_sub_field( 'button' );
                ?>
                <div class="layout-container py-16">
                    <div class="title-wrapper mb-6">
                        <h2 data-aos="fade-in" data-aos-duration="300"  class="text-2xl text-gray-800 uppercase font-primary"><?php the_sub_field( 'title' ); ?></h2>
                        <p data-aos="fade-in" data-aos-duration="300"  class="text-sm font-extralight uppercase tracking-wider font-secondary"><?php the_sub_field( 'subtitle' ); ?></p>
                    </div>

                    <div class="flex flex-col md:flex-row items-stretch gap-12 lg:gap-14">
                        <div class="w-full">
                            <?php if ( $image ) : ?>
                                <img 
                                data-aos="fade-in" data-aos-duration="400"
                                class="w-full h-full max-h-[450px] lg:min-h-[526px] lg:max-h-none object-cover"
                                src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" 
                                >
                            <?php endif; ?>
                        </div>

                        <div class="w-full h-full lg:mr-[13vw] flex flex-col gap-16">
                            <div class="section-desc font-primary text-gray-700" data-aos="fade-in" data-aos-duration="500" data-aos-delay="500">
                                <?php the_sub_field( 'description' ); ?>
                            </div>

                            <?php if($button) : 
                            $button_url = esc_url($button['url']);
                            $button_text = esc_html($button['title']);
                            $button_target = esc_attr($button['target'] ?: '_self');
                            ?>
                                <div class="flex flex-col justify-start" data-aos="fade-up">
                                <span class="text-xs font-light underline underline-offset-1">CONTACT FOR FULL PRICING GUIDE</span>
                                <a href="<?php echo $button_url; ?>"
                                target="<?php echo $button_target; ?>"
                                class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                                <span><?php echo $button_text; ?></span>
                                </a>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>

                <?php
                elseif ( get_row_layout() == 'layout2' ) :
                    $image        = get_sub_field( 'image' );
                    $button       = get_sub_field( 'button' );
                    $service_list = get_sub_field( 'service_list' );
                ?>
                <div class="layout-container py-16">
                    <div class="title-wrapper mb-6">
                        <h2 data-aos="fade-in" data-aos-duration="300" class="text-2xl text-gray-800 uppercase font-primary"><?php the_sub_field( 'title' ); ?></h2>
                        <p  data-aos="fade-in" data-aos-duration="300" class="text-sm capitalize italic tracking-wider font-primary"><?php the_sub_field( 'subtitle' ); ?></p>
                    </div>
                    <div class="flex flex-col md:flex-row items-stretch gap-12 lg:gap-24"> 
                        <div class="w-full md:w-1/2 md:mb-8">
                            <?php if ( $image ) : ?>
                            <img 
                            src="<?php echo esc_url( $image['url'] ); ?>" 
                            alt="<?php echo esc_attr( $image['alt'] ); ?>" 
                            data-aos="fade-in" data-aos-duration="500"
                            class="w-full h-full lg:min-h-[406px] aspect-square object-cover p-2 border-[1px] border-solid border-black">
                            <?php endif; ?>
                        </div>


                        <div class="w-full md:w-1/2 flex flex-col justify-between">
                            <?php if ( have_rows( 'service_list' ) ) : ?>
                                <div class="space-y-10">
                                    <?php
                                    while ( have_rows( 'service_list' ) ) :
                                        the_row();
                                        ?>
                                        <div class="lg:pl-12">
                                            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between w-full">
                                                <div class="flex items-baseline">
                                                    <span data-aos="fade-in" class="text-sm font-light text-gray-400">0<?php echo get_row_index(); ?> /</span>
                                                    <h3 data-aos="fade-in" class="ml-2 text-lg text-gray-800 capitalize font-primary italic"><?php the_sub_field( 'service_title' ); ?></h3>
                                                </div>
                                                <span class="text-xs text-gray-400 uppercase tracking-wider text-left lg:text-right"><?php the_sub_field( 'service_price' ); ?></span>
                                            </div>
                                            <div data-aos="fade-in" class="font-secondary text-sm/6 tracking-wide text-light max-w-none prose-p:my-2 mt-2 text-gray-700">
                                                <?php the_sub_field( 'service_description' ); ?>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                                        
                                <div class="lg:pl-12">    
                                     <?php if($button) : 
                                        $button_url = esc_url($button['url']);
                                        $button_text = esc_html($button['title']);
                                        $button_target = esc_attr($button['target'] ?: '_self');
                                        ?>
                                        <div 
                                        data-aos="fade-up"
                                        class="flex justify-end items-end">
                                            <a href="<?php echo $button_url; ?>"
                                            target="<?php echo $button_target; ?>"
                                            class="btn-primary flex text-xs uppercase tracking-widest font-medium">
                                            <span><?php echo $button_text; ?></span>
                                            </a>
                                     </div>
                                    <?php endif;?>
                                </div>

                        </div>
                    </div>
                </div>          
                <?php
                endif;
            endwhile;
        endif;
        ?>

        </div>
</section>