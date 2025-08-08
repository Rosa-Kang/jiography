<?php
/**
 * Template part for displaying Portfolio Section.
 * UPDATED: The complex layout logic is now handled by a separate template part.
 *
 * @package by Therosessom
 */
?>

<section class="section-portfolio bg-primary-light py-[92px] max-w-screen-xl mx-auto px-4">
    <div class="max-w-[80%] lg:container-lg mx-auto px-4">
        <?php
        get_template_part('template-parts/components/Filter/portfolio-filter');
        ?>
    
        <div id="portfolio-grid" class="portfolio-grid flex flex-col gap-8 mt-8">
            <?php
            $args = [
                'post_type'      => 'portfolio',
                'posts_per_page' => 4,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];
    
            $query = new WP_Query($args);
    
            if ($query->have_posts()) :
                $post_counter = 0;
                $is_row_open = false; // 이 변수는 참조로 전달됩니다.
    
                while ($query->have_posts()) : $query->the_post();
                    
                    // ▼▼▼▼▼ 수정된 부분 ▼▼▼▼▼
                    // 복잡한 if/else 블록 대신, 새로 만든 파일을 호출하는 한 줄로 대체합니다.
                    get_template_part('template-parts/components/Sections/portfolio-layout-item', null, [
                        'post_counter' => $post_counter,
                        'is_row_open'  => &$is_row_open,
                    ]);
                    // ▲▲▲▲▲ 수정된 부분 ▲▲▲▲▲

                    $post_counter++;
                endwhile;
    
                // 루프가 끝난 후에도 2열 div가 열려있다면 닫아줍니다.
                if ($is_row_open) { echo '</div>'; }
                
                $initial_post_count = $query->post_count;
                wp_reset_postdata();
    
            else :
                $initial_post_count = 0;
                echo '<p class="text-center text-gray-500">No portfolios found.</p>';
            endif;
            ?>
        </div>
    
        <?php if ($query->max_num_pages > 1) : ?>
            <div 
                data-aos="fade-up"
                class="flex justify-center mt-10">
                    <button
                    id="portfolio-loadmore"
                    data-page="1"
                    data-category="all"
                    data-max-pages="<?php echo $query->max_num_pages; ?>"
                    data-post-count="<?php echo $initial_post_count; ?>"
                    class="flex text-xs uppercase tracking-widest font-medium">
                        View More
                    </button>
            </div>
        <?php endif; ?>
    </div>
</section>