<?php
get_header();
global $post;
$post_id                    = $post->ID;
$get_project_detail_image   = get_field('project_banner_image', 'option') ? get_field('project_banner_image', 'option') : get_stylesheet_directory_uri().'/assets/images/banner-image.png';
$donate_title               = get_field('donate_title', 'option');
$donate_button_cta          = get_field('donate_button_cta','option' );
$date                       = (!empty(get_field('project_date')))?get_field('project_date'):get_field('project_date');
$country                    = (!empty(get_field('country'))) ? get_field('country') : get_field('country');
$country_flag               = (!empty(get_field('country_flag'))) ? get_field('country_flag') : get_field('country_flag');
?>
<main id="content" <?php post_class('single-project-main');?> role="main">
    <div class="banner-image">
        <img src="<?php esc_html_e($get_project_detail_image['url'],'khalsaaid') ?>" alt="<?php esc_html_e($get_project_detail_image['alt'],'khalsaaid') ?>">
    </div>

    <div class="container">

    <div class='product-detail-head'>
        <h3 class="title"><?php esc_html_e(get_the_title(),'khalsaaid'); ?></h3>
        <div class="project-donate-detail">
            <div class='donate-column block'>
                <h3>Donate to Khalsa Aid</h3> 
                <?php      
                if($donate_button_cta):
                $button_link_url    = $donate_button_cta['url'];
                $button_link_title  = $donate_button_cta['title'];
                $button_link_target = $donate_button_cta['target'] ? $donate_button_cta['target'] : '_self';
                ?>

                <a href="<?php esc_html_e($button_link_url,'khalsaaid'); ?>" target="<?php echo esc_html_e($button_link_target,'khalsaaid'); ?>" class="donate-cta common-btn"><?php esc_html_e($button_link_title,'khalsaaid'); ?></a>

                <?php endif; ?>
            </div>

            <div class="country-section block">
                <h3><?php
                $date2 = get_the_date( "M 'y" );
                echo $date2; ?></h3> 
                <img src="<?php echo esc_url($country_flag); ?>" />
                <h3><?php esc_html_e($country,'khalsaaid'); ?></h3>
            </div>

            <div class="update-project-section block">
                <h3>Updates on This Project</h3>
                <a href="#" class="donate-cta common-btn">0 Updates</a>
            </div>
        </div>

    </div>
<?php 

echo the_content();
?>
</div>
</main>
<?php get_footer();
?>