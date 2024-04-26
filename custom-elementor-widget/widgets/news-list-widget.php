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

class Elementor_News_List_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'widget_name';
	}

	public function get_title()
	{
		return esc_html__('News List Widget', 'custom-elementor-widget');
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

	public function get_keywords()
	{
		return ['keyword', 'keyword'];
	}
	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('News List With Filter', 'elementor-custom-list-widget'),
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
				'label' => esc_html__('No of News Posts', 'custom-elementor-widget'),
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
		$args = array(
			'post_type' => 'news',
			'posts_per_page' => $settings['no_of_posts'],
			'orderby'   => array(
				'date' => 'DESC',
			)
		);
		$the_query = new WP_Query($args); ?>
		<div class="news_outer_class">
			<div class="container">
				<div class="row">
					<?php if ($the_query->have_posts()) :
						while ($the_query->have_posts()) : $the_query->the_post(); ?>
							<div class="col-6 col-md-4">
								<div class="post_content_class">
									<?php if (get_field('is_features_image_or_video') == true ) { ?>
										<div class="content_image_outer_class">
											<?php
											$iframe = get_field('featured_video');
											// Use preg_match to find iframe src.
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
											<p class="date_class">
												<?php echo get_the_date( 'd M Y' ); ?>
												<?php if (get_field('show_news_published_time') == true ) { ?>
													<span class="news_time_picker"><?php echo get_the_date('h i A'); ?></span>
												<?php } else { ?>
													<span class="news_time_picker"></span>
												<?php } ?>
											</p>
											<?php echo do_shortcode('[Sassy_Social_Share]') ?>
										</div>
										<a href="<?php echo get_the_permalink(); ?>">
											<h3 class="title_class"><?php the_title(); ?></h3>
										</a>
										<div class="text-content-class"><?php echo get_the_content(); ?></div>


										<div class="read_more">
											<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo get_home_url(); ?>/wp-content/uploads/2022/09/read-more-img.svg" />Read More</a>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					<?php else :  ?>
						<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
<?php
	}
	protected function content_template()
	{
	}
}
