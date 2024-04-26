<?php

/**
 * Plugin Name: Custom Elementor Widgets
 * Description: Custom list widgets for Elementor.
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-custom-list-widget
 *
 * Elementor tested up to: 3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Register List Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
define('PLUGIN_DIR', plugins_url() . '/custom-elementor-widget/');

function register_custom_list_widgets($widgets_manager)
{

	if (post_type_exists('news')) {
		require_once(__DIR__ . '/widgets/news-list-widget.php');
		$widgets_manager->register(new \Elementor_News_List_Widget());

		// Loaded file for news archieve page 
		require_once( __DIR__ . '/widgets/news-load-more-list-widget.php' );
		$widgets_manager->register( new \Elementor_News_Load_more_List_Widget() );
	}

	if (post_type_exists('projects')) {
		require_once(__DIR__ . '/widgets/projects-widget.php');
		$widgets_manager->register(new \Elementor_Projects_List_Widget());

		//project-list-page-widget
		require_once(__DIR__ . '/widgets/projects-list-widget.php');
		$widgets_manager->register(new \Elementor_Projects_List_Page_Widget());
	}
	

}
add_action('elementor/widgets/register', 'register_custom_list_widgets');

// General functions file 
require_once( __DIR__ . '/general-functions.php' );