<?php

/**
 * Template part for displaying Social Icons.
 *
 * @package by Therosessom
 */

$ig_url = get_field('ig_link', 'option');
$pinterest_url = get_field('pinterest_link', 'option');
?>

<?php if ($ig_url || $pinterest_url) : ?>
  <div class="flex flex-col items-start justify-end h-full">
    <div class="social-icons-wrapper flex justify-between mt-16 w-[80px]">
      <?php if ($ig_url) : ?>
      <a href="<?php echo $ig_url; ?>" target="_blank"
        rel="noopener noreferrer">
        <div class="social-ig w-fit"></div>
        <span class="hidden">Instagram</span></a>
      <?php endif; ?>
      <?php if ($pinterest_url) : ?>
      <a href="<?php echo $pinterest_url; ?>" target="_blank"
        rel="noopener noreferrer">
        <div class="social-pinterest w-fit"></div>
        <span class="hidden">Pinterest</span></a>
      <?php endif; ?>
    </div>
  
    <div>
          <?php get_template_part('template-parts/components/Branding/site-logo')?>
    </div>
  </div>
<?php endif; ?>