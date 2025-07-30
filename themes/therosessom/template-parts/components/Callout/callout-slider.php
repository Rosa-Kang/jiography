<?php
/**
 * Template part for displaying callout-slider section.
 *
 * @package by Therosessom
 */

// Get ACF callout slider data
$callout_slides = get_field('callout_slides');
$works_button = get_field('works_button');

// Default data for demo
if (!$callout_slides) {
    $callout_slides = [
        [
            'thought_title' => 'the thought',
            'thought_subtitle' => 'BEHIND MY WORK',
            'thought_image' => '', // Add default image URL
            'thought_content' => 'You might forget the words, but the feeling—that quiet, full kind of magic—stays. It\'s words may fade, but the dangerous lingering goes on, dense, untouchable. I remember it frame by frame.',
            'way_title' => 'the way I see',
            'way_content_left' => 'I\'ve always believed photography is about more than just capturing how things look—it\'s about discovering who people are when they think no one is watching, and how they interact with how they feel. When I work with people, I see more than just subjects for photos. I see their energy, their spirit, their connection, and their unique stories. These moments deserve to be remembered, not just for how they appear, but for the emotions they hold.',
            'way_content_right' => 'Perfectly posed and polished photos have their place, and yes, grandma might love one for the fridge, but I\'m interested in more than that. It\'s the stolen glances, the unexpected laughter, and the beautiful, messy chaos in between. You deserve photos that reflect how you felt in those moments—alive, connected, and completely yourself. The ones that make you laugh, maybe blush, and most importantly, the ones that make you say, "That\'s so us."',
            'main_image' => '', // Add default image URL
        ],
        // Add more slides as needed
    ];
}

if (!$works_button) {
    $works_button = [
        'url' => '/works',
        'title' => 'WORKS',
        'target' => '_self'
    ];
}
?>

<section class="callout-slider bg-neutral-100 min-h-screen relative">
    <div class="w-full h-screen flex">
        
        <!-- Swiper Container -->
        <div class="callout-swiper swiper w-full h-full">
            <div class="swiper-wrapper">
                
                <?php foreach ($callout_slides as $index => $slide): ?>
                <div class="swiper-slide">
                    <div class="grid grid-cols-1 lg:grid-cols-2 h-full">
                        
                        <!-- Left Content Area -->
                        <div class="bg-neutral-100 p-8 lg:p-16 flex flex-col justify-between relative">
                            
                            <!-- Top Section - The Thought -->
                            <div class="space-y-6" data-aos="fade-up" data-aos-delay="200">
                                
                                <!-- Title -->
                                <?php if ($slide['thought_title'] || $slide['thought_subtitle']): ?>
                                <div class="space-y-2">
                                    <?php if ($slide['thought_title']): ?>
                                        <h2 class="text-2xl lg:text-3xl font-light font-primary text-gray-800 italic leading-tight">
                                            <?php echo esc_html($slide['thought_title']); ?>
                                        </h2>
                                    <?php endif; ?>
                                    
                                    <?php if ($slide['thought_subtitle']): ?>
                                        <h3 class="text-xl lg:text-2xl font-bold font-primary text-gray-900 uppercase tracking-wide">
                                            <?php echo esc_html($slide['thought_subtitle']); ?>
                                        </h3>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <!-- Content with Image -->
                                <div class="flex gap-6 items-start">
                                    
                                    <!-- Small Image -->
                                    <?php if ($slide['thought_image']): 
                                        $thought_img_url = is_array($slide['thought_image']) ? $slide['thought_image']['url'] : $slide['thought_image'];
                                        $thought_img_alt = is_array($slide['thought_image']) ? $slide['thought_image']['alt'] : 'Thought Image';
                                    ?>
                                        <div class="flex-shrink-0 w-20 lg:w-24">
                                            <img src="<?php echo esc_url($thought_img_url); ?>" 
                                                 alt="<?php echo esc_attr($thought_img_alt); ?>"
                                                 class="w-full aspect-[3/4] object-cover grayscale">
                                        </div>
                                    <?php endif; ?>

                                    <!-- Text Content -->
                                    <?php if ($slide['thought_content']): ?>
                                        <div class="flex-1">
                                            <p class="text-sm leading-relaxed text-gray-700 max-w-xs">
                                                <?php echo esc_html($slide['thought_content']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Bottom Section - The Way I See -->
                            <div class="space-y-6 mt-12" data-aos="fade-up" data-aos-delay="400">
                                
                                <!-- Title -->
                                <?php if ($slide['way_title']): ?>
                                    <h3 class="text-2xl lg:text-3xl font-light font-primary text-gray-800 italic leading-tight">
                                        <?php echo esc_html($slide['way_title']); ?>
                                    </h3>
                                <?php endif; ?>

                                <!-- Two Column Text -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed text-gray-700">
                                    
                                    <?php if ($slide['way_content_left']): ?>
                                        <div>
                                            <p><?php echo esc_html($slide['way_content_left']); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($slide['way_content_right']): ?>
                                        <div>
                                            <p><?php echo esc_html($slide['way_content_right']); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Works Button -->
                            <div class="mt-8" data-aos="fade-up" data-aos-delay="600">
                                <a href="<?php echo esc_url($works_button['url']); ?>" 
                                   target="<?php echo esc_attr($works_button['target'] ?: '_self'); ?>"
                                   class="btn-arrow-simple inline-block text-gray-900 text-xs uppercase tracking-widest font-medium hover:text-gray-700 transition-colors duration-300 relative pr-8">
                                    <?php echo esc_html($works_button['title']); ?>
                                </a>
                            </div>
                        </div>

                        <!-- Right Image Area -->
                        <div class="relative bg-white overflow-hidden" data-aos="fade-left" data-aos-delay="300">
                            <?php if ($slide['main_image']): 
                                $main_img_url = is_array($slide['main_image']) ? $slide['main_image']['url'] : $slide['main_image'];
                                $main_img_alt = is_array($slide['main_image']) ? $slide['main_image']['alt'] : 'Main Slide Image';
                            ?>
                                <img src="<?php echo esc_url($main_img_url); ?>" 
                                     alt="<?php echo esc_attr($main_img_alt); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <!-- Placeholder for demo -->
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Studio Image Placeholder</span>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- Vertical Dot Navigation -->
        <?php if (count($callout_slides) > 1): ?>
        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
            <div class="callout-pagination flex flex-col space-y-4">
                <?php foreach ($callout_slides as $index => $slide): ?>
                    <button class="w-2 h-2 rounded-full bg-gray-400 opacity-50 transition-all duration-300 hover:opacity-100 pagination-dot" 
                            data-slide="<?php echo $index; ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Slide Counter -->
        <?php if (count($callout_slides) > 1): ?>
        <div class="absolute bottom-8 right-8 z-20">
            <span class="callout-counter text-xs text-gray-600 font-mono">
                (<span class="current-slide">1</span>/<span class="total-slides"><?php echo count($callout_slides); ?></span>)
            </span>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
/* Simple arrow button styling - using config defined durations */
.btn-arrow-simple::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 1px;
    background-color: currentColor;
    transition: all var(--duration-300) ease;
}

.btn-arrow-simple::before {
    content: '';
    position: absolute;
    right: -2px;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    width: 6px;
    height: 6px;
    border-right: 1px solid currentColor;
    border-top: 1px solid currentColor;
    transition: all var(--duration-300) ease;
}

.btn-arrow-simple:hover::after,
.btn-arrow-simple:hover::before {
    transform: translateY(-50%) translateX(4px);
}

.btn-arrow-simple:hover::before {
    transform: translateY(-50%) translateX(4px) rotate(45deg);
}

/* Pagination active state - using config defined colors */
.callout-pagination .pagination-dot.active {
    background-color: var(--color-gray-800);
    opacity: 1;
    transform: scale(1.2);
}

/* Swiper overrides */
.callout-swiper .swiper-slide {
    height: auto;
}
</style>

<script>
// Swiper initialization - using config defined transition durations
document.addEventListener('DOMContentLoaded', function() {
    const calloutSwiper = new Swiper('.callout-swiper', {
        direction: 'vertical',
        loop: false,
        speed: 500, // Using duration-500 equivalent
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        on: {
            slideChange: function() {
                // Update counter
                const currentSlide = document.querySelector('.current-slide');
                if (currentSlide) {
                    currentSlide.textContent = this.activeIndex + 1;
                }
                
                // Update pagination dots
                const dots = document.querySelectorAll('.pagination-dot');
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === this.activeIndex);
                });
            }
        }
    });

    // Pagination dot click handlers
    const paginationDots = document.querySelectorAll('.pagination-dot');
    paginationDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            calloutSwiper.slideTo(index);
        });
    });

    // Initialize first dot as active
    if (paginationDots.length > 0) {
        paginationDots[0].classList.add('active');
    }
});
</script>