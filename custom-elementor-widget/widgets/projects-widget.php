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

class Elementor_Projects_List_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'project_widget';
    }

    public function get_title()
    {
        return esc_html__('Projects List Widget', 'custom-elementor-widget');
    }

    public function get_icon()
    {
        return 'eicon-accordion';
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

        wp_register_style('swiper-min-css', PLUGIN_DIR . 'assets/css/swiper-bundle.min.css');
        wp_register_style('latest-article-block-css', PLUGIN_DIR . 'assets/css/latest-news-block.css');

        return [
            'swiper-min-css',
            'latest-article-block-css',
        ];
    }
    public function get_script_depends()
    {

        wp_register_script('swiper-min-js', PLUGIN_DIR . 'assets/js/swiper-bundle.min.js');
        wp_register_script('swiper-js', PLUGIN_DIR . 'assets/js/project-widget-slider.js');
        wp_localize_script('swiper-js', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('ajax-nonce')));
        return [
            'swiper-min-js',
            'swiper-js',
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
                'label' => esc_html__('Pojects List With Filter', 'elementor-custom-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'custom-elementor-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your title', 'custom-elementor-widget'),
            ]
        );
        $this->add_control(
            'no_of_posts',
            [
                'label' => esc_html__('No of Posts', 'custom-elementor-widget'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -1,
                'max' => 100,
                'step' => 1,
                'default' => 6,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo '<h3 class="latest_news_title">' . $settings['title'] . '</h3>';
        $args = array(
            'post_type' => 'projects',
            'posts_per_page' => $settings['no_of_posts'],
            'order' => 'DESC',
        );
        $the_query = new WP_Query($args); ?>
        <div class="news_outer_class">
            <div class="container">
                <div class="filter_section">
                    <div class="select_class">
                        <div class='article-filter-main-outer article_main_for_ajax'>

                        <!-- Projects taxonomy filter starts -->
                            <li class='article-filter-sector-ul'>
                                <div class="select-class"><span class='dropdown-icon sub-title font-medium text-black'>Select Project</span></div>
                                <ul>
                                    <?php
                                    $categories = get_categories('taxonomy=project_type&hide_empty=0');
                                    ?>
                                    <li class="active"><span class='description text-black font-medium call_ajax_for_filter' value=''>All Projects</span></li>
                                    <?php
                                    foreach ($categories as $category) {
                                    ?>
                                        <li><span class='call_ajax_for_filter' value='<?php echo $category->term_id ?>'><?php echo $category->name ?></span></li>
                                    <?php
                                    }
                                    
                                    ?>
                                </ul>
                            </li>
                        <!-- Projects taxonomy filter ends -->
                        </div>
                    </div>
                    <div class="search_class">
                        <!-- Project search filter starts -->
                        <input type="text" name="keyword" id="keyword" onkeyup="get_projects_data_by_filter()" placeholder="Search across all projects"></input>

                        <div id="datafetch"></div><!-- Div to display data -->
                        <!-- Project search filter ends -->
                    </div>
                </div>
                <div class="row swipper-wrapper project_swipper_post">
                    <div class="swiper">
                        <div class="outer_main_class swiper-wrapper">
                            <?php if ($the_query->have_posts()) :
                                while ($the_query->have_posts()) : $the_query->the_post(); ?>
                                
                                    <div class="swiper-slide">
                                        <div class="post_content_class">
                                            <div class="content_image_outer_class" style="background: url(<?php echo get_the_post_thumbnail_url(); ?>) no-repeat center;background-size: cover;">
                                                <div class="overlay-div">
                                                <div class="flag_img_class">
                                                    <?php
                                                    $image = get_field('country_flag');
                                                    if (!empty($image)) : ?>
                                                        <img src="<?php echo $image; ?>" />
                                                    <?php endif; ?>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="inner_content_class">
                                                <p class="date_class"><?php echo get_the_date('M Y'); ?></p>
                                                <h3 class="title_class"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                <p class="text_class"><?php echo wp_trim_words(get_the_content(), 30, ''); ?></p>
                                                <div class="read_more">
                                                    <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo get_home_url(); ?>/wp-content/uploads/2022/09/read-more-img.svg" />Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata(); ?>
                            <?php else :  ?>
                                <p><?php _e('No Projects Found'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="swiper-button-next"><i class="fa fa-arrow-circle-right fa-2x"></i></div>
                    <div class="swiper-button-prev"><i class="fa fa-arrow-circle-left fa-2x"></i></div>
                </div>
            </div>
        </div>
<?php
    }
    protected function content_template()
    {
    }
}
