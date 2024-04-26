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

class Elementor_Tweeter_Tweet_List_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'tweeter_widget';
	}

	public function get_title()
	{
		return esc_html__('Tweeter Post Caraousal', 'plugin-name');
	}

	public function get_icon()
	{
		return 'eicon-social-icons';
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

        wp_register_script('tweeter-tweetslider-js', PLUGIN_DIR . 'assets/js/tweeter-tweetslider.js');
        wp_localize_script('tweeter-tweetslider-js', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        return [
            'tweeter-tweetslider-js',
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
				'label' => esc_html__('Tweeter Post Caraousal', 'elementor-custom-list-widget'),
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
		$this->add_control(
			'no_of_posts',
			[
				'label' => esc_html__('No of Posts', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 3,
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
		?>
		<section class="skyBlue-bg twitter-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="left-icon">
							<p><img src="<?php echo ASSETS_IMAGE . 'frontsite/' ?>tw-lg-icon.png"></p>
							<p class="follower_count">0 Followers<br>
								Follow Us:</p>
							<h3><a href="https://twitter.com/khalsa_aid" target="_blank" style="color: #fff;" title="Follow Us On Twitter">@Khalsa_Aid</a></h3>
						</div>
					</div>
					<div class=" col-sm-9">
						<div id="carousel-background-twitter" class="carousel slide" data-ride="carousel" data-interval="5000" style="margin-top:25px" data-pause="false">
							<div class="carousel-inner tweets-rotator" role="listbox">                   

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>	
<?php
	}
	protected function content_template()
	{
	}
}
