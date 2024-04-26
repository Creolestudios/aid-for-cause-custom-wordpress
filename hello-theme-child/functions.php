<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts()
{
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'hello-elementor-child-custom-style',
		get_stylesheet_directory_uri() . '/assets/css/custom-style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
	wp_enqueue_style(
		'font-css-style',
		get_stylesheet_directory_uri() . '/assets/fonts/font.css',
		"",
		''
	);

	wp_enqueue_script(
		'custom-khalsa-javascript',
		get_stylesheet_directory_uri() . '/assets/js/custom-khalsa.js', 
		array("jquery"),
		false, 
		false
	);

	wp_enqueue_style(
		'custom-swiper-bundle',
		get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css'
	);

	wp_enqueue_script(
		'timeago-js',
		get_stylesheet_directory_uri() . '/assets/js/jquery.timeago.min.js'
	);

	wp_enqueue_script(
		'custom-swiper-min-js',
		get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js'
	);

	wp_enqueue_script( 
        'custom-latest-projects-block-js',
        get_stylesheet_directory_uri() .'/assets/js/latest-projects-block.js'
    );

}
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);


// Added general options setting menu 
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'General Settings',
		'menu_title'	=> 'General Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Twitter Feed Settings',
		'menu_title'	=> 'Twitter Feed Settings',
        'menu_slug' 	=> 'tweeter-videos-settings',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

require get_stylesheet_directory() . '/inc/cpt-functions.php';
require get_stylesheet_directory() . '/inc/shortcodes.php';


function load_mailchimp_script_on_head(){
	$display_cookie_popup = get_field('display_cookie_popup', 'option') ? get_field('display_cookie_popup', 'option') : '';
	$cookies_content   = get_field('cookies_script', 'option') ? get_field('cookies_script', 'option') : '';

    if(get_field( 'mailchimp_script' , 'options' )){
        echo get_field( 'mailchimp_script' , 'options' );
      }

	if(get_field( 'cookies_script' , 'options' ) && $display_cookie_popup == 'true'){
	echo $cookies_content;
	}
	

	
}

add_action('wp_head','load_mailchimp_script_on_head' );

function __search_by_title_only( $search, &$wp_query )
{
    global $wpdb;
    if(empty($search)) {
        return $search; // skip processing - no search term in query
    }
    $q = $wp_query->query_vars;
    $n = !empty($q['exact']) ? '' : '%';
    $search =
    $searchand = '';
    foreach ((array)$q['search_terms'] as $term) {
        $term = esc_sql($wpdb->esc_like($term));
        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
        $searchand = ' AND ';
    }
    if (!empty($search)) {
        $search = " AND ({$search}) ";
        if (!is_user_logged_in())
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }
    return $search;
}
add_filter('posts_search', '__search_by_title_only', 500, 2);