<?php

/**
 * The template for displaying 404 pages (not found).
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header();

$get_news_detail_image   = get_field('news_banner_image', 'option') ? get_field('news_banner_image', 'option') : get_stylesheet_directory_uri().'/assets/images/banner-image.png';

?>
<div class="banner-image">
        <img src="<?php esc_html_e($get_news_detail_image['url'],'khalsaaid') ?>" alt="<?php esc_html_e($get_news_detail_image['alt'],'khalsaaid') ?>">
    </div>
<main id="content" class="site-main page-404" role="main">
    
    <div class="content_class khalsa-404 pad100">
        <div class="content_image_class">
        <?php $image = get_field('404_image','option'); ?>

        <?php if (!empty($image)) : ?>
            <img class="image-404" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
            <?php endif; ?>
        </div>

        <div class="text_class title">
            <?php the_field('404_content', 'option'); ?>
        </div>

        <?php
        $page_not_found_url      = get_field('404_button', 'option');
        $link_url = (!empty($page_not_found_url['url'])) ? $page_not_found_url['url'] : site_url('/');;
        $link_title = $page_not_found_url['title'];
        $link_target = $page_not_found_url['target'] ? $page_not_found_url['target'] : '_self';

        echo "<div class='loadmore home_button_class'><a class='custom_btn ctm-btn' target=$link_target href=$link_url>$link_title</a></div>";
        ?>

    </div>

</main>

<?php get_footer(); ?>