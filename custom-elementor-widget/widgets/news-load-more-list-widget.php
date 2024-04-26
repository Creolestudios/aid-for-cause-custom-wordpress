<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_News_Load_more_List_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'news_with_load_more';
    }

    public function get_title()
    {
        return esc_html__('News With Load More', 'plugin-name');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_custom_help_url()
    {
        return 'https://go.elementor.com/widget-name';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_style_depends()
    {

        wp_register_style('latest-article-block-css', PLUGIN_DIR . 'assets/css/latest-news-block.css');

        return [
            'latest-article-block-css',
        ];
    }

    /**
     * Add widget script.
     *
     * Add script and load js files for our custom widget.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget scripts.
     */
    public function get_script_depends()
    {

        wp_register_script('news-load-more-js', PLUGIN_DIR . 'assets/js/news-load-more.js');
        wp_localize_script('news-load-more-js', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'security' => wp_create_nonce('load_more_posts')));
        return [
            'news-load-more-js',
        ];
    }

    public function get_keywords()
    {
        return ['keyword', 'keyword'];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('News Load More List', 'elementor-custom-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your title', 'plugin-name'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo '<h3 class="latest_news_title">' . $settings['title'] . '</h3>';
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => get_field('no_of_news_posts_to_show', 'option'),
            'post_status' => 'publish',
            'paged' => 1,
            'orderby' => array(
                'date' => 'DESC',
            ),
        );
        $recent_news = new WP_Query($args); ?>
        <input type="hidden" name="news_page_value" class="news_page_value" value="2">
        <div class="news_outer_class">
            <div class="container">
                <!-- <div class="row"> -->
                <?php if ($recent_news->have_posts()) : ?>
                    <div class="row blog-posts news-post-load-more">
                        <?php while ($recent_news->have_posts()) : $recent_news->the_post(); ?>
                            <div class="col-6 col-md-4">
                                <div class="post_content_class">

                                    <?php if (get_field('is_features_image_or_video') == true) { ?>
                                        <div class="content_image_outer_class">
                                            <?php
                                            $iframe = get_field('featured_video');
                                            preg_match('/src="(.+?)"/', $iframe, $matches);
                                            $src = $matches[1];
                                            // Add extra parameters to src and replace HTML.
                                            $params = array(
                                                'controls'  => 0,
                                                'hd'        => 1,
                                                'autohide'  => 1
                                            );
                                            $new_src = add_query_arg($params, $src);
                                            $iframe = str_replace($src, $new_src, $iframe);
                                            // Add extra attributes to iframe HTML.
                                            $attributes = 'frameborder="0"';
                                            $iframe = str_replace('><iframe>', ' ' . $attributes . '></iframe>', $iframe);
                                            // Display customized HTML.
                                            echo $iframe;
                                            ?>

                                            <div class="overlay-div"></div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="content_image_outer_class" style="background: url('<?php echo get_field('featured_image')['url']; ?>') no-repeat center;background-size: cover;">
                                            <div class="overlay-div"></div>
                                        </div>
                                    <?php } ?>
                                    <div class="inner_content_class">
                                        <div class="text-social">
                                            <p class="date_class"><?php echo get_the_date( 'd M Y' ); ?>
                                            <?php if (get_field('show_news_published_time') == true ) { ?>
													<span class="news_time_picker"><?php echo get_the_date('h i A'); ?></span>
												<?php } else { ?>
													<span class="news_time_picker"></span>
												<?php } ?>
                                            </p>
                                            <?php echo do_shortcode('[Sassy_Social_Share]') ?>
                                        </div>
                                        <h3 class="title_class"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <div class="text-content-class"><?php echo get_the_content(); ?></div>
                                        <div class="read_more">
                                            <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo get_home_url(); ?>/wp-content/uploads/2022/09/read-more-img.svg" />Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                <?php endif; ?>
                <div class="loadmore">Load More</div>
                <div class="load_more_spinner"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
                <span class="no-more-post"></span>
                <!-- </div> -->
            </div>
        </div>
<?php
    }
    protected function content_template()
    {
    }
}
