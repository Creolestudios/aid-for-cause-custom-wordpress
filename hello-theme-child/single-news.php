<?php
get_header();
global $post;
$post_id                    = $post->ID;
$get_news_detail_image   = get_field('news_banner_image', 'option') ? get_field('news_banner_image', 'option') : get_stylesheet_directory_uri().'/assets/images/banner-image.png';
?>
<main id="content" <?php post_class('single-news-main');?> role="main">

    <div class="banner-image">
        <img src="<?php esc_html_e($get_news_detail_image['url'],'khalsaaid') ?>" alt="<?php esc_html_e($get_news_detail_image['alt'],'khalsaaid') ?>">
    </div>

<div class="conatiner">

    <h3 class="title"><?php esc_html_e(get_the_title(),'khalsaaid'); ?></h3>
    <?php 
    echo the_content();?>
    <div class="image_outer_class"><img class="single_news_image" src="<?php echo get_field('featured_image')['url']; ?>"></div>
    

</div>
</main>
<?php get_footer();
?>