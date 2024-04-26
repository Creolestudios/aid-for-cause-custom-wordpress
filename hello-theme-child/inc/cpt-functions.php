<?php
// Register Custom Post Type - News
function news_post_type() {

    $labels = array(
        'name'                  => _x( 'News', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'News', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'News', 'text_domain' ),
        'name_admin_bar'        => __( 'News', 'text_domain' ),
        'archives'              => __( 'News Archives', 'text_domain' ),
        'attributes'            => __( 'News Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent News:', 'text_domain' ),
        'all_items'             => __( 'All News', 'text_domain' ),
        'add_new_item'          => __( 'Add New News', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New News', 'text_domain' ),
        'edit_item'             => __( 'Edit News', 'text_domain' ),
        'update_item'           => __( 'Update News', 'text_domain' ),
        'view_item'             => __( 'View News', 'text_domain' ),
        'view_items'            => __( 'View News', 'text_domain' ),
        'search_items'          => __( 'Search News', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into News', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this News', 'text_domain' ),
        'items_list'            => __( 'News list', 'text_domain' ),
        'items_list_navigation' => __( 'News list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter News list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'News', 'text_domain' ),
        'description'           => __( 'News', 'text_domain' ),
        'labels'                => $labels,
        'show_in_rest'          => true,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
        'menu_icon'             => 'dashicons-format-status',
        'taxonomies'            => array( '' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );

    register_post_type( 'news', $args );
}
add_action( 'init', 'news_post_type', 0 );


// Register Custom Post Type - Projects
function projects_post_type() {

    $labels = array(
        'name'                  => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Projects', 'text_domain' ),
        'name_admin_bar'        => __( 'Projects', 'text_domain' ),
        'archives'              => __( 'Projects Archives', 'text_domain' ),
        'attributes'            => __( 'Projects Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Projects:', 'text_domain' ),
        'all_items'             => __( 'All Projects', 'text_domain' ),
        'add_new_item'          => __( 'Add New Projects', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Projects', 'text_domain' ),
        'edit_item'             => __( 'Edit Projects', 'text_domain' ),
        'update_item'           => __( 'Update Projects', 'text_domain' ),
        'view_item'             => __( 'View Projects', 'text_domain' ),
        'view_items'            => __( 'View Projects', 'text_domain' ),
        'search_items'          => __( 'Search Projects', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Projects', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Projects', 'text_domain' ),
        'items_list'            => __( 'Projects list', 'text_domain' ),
        'items_list_navigation' => __( 'Projects list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Projects list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Projects', 'text_domain' ),
        'description'           => __( 'Projects', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
        'menu_icon'             => 'dashicons-format-aside',
        'taxonomies'            => array( '' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_rest'          => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );

    register_post_type( 'projects', $args );
}
add_action( 'init', 'projects_post_type', 0 );


/**
 * Add custom taxonomies for Country & Region
 *
 * Additional custom taxonomy for Country & Region
 */
function hello_add_custom_taxonomies() {
    
    register_taxonomy('project_type', array('projects'), array(
      // Hierarchical taxonomy (like categories)
      'hierarchical' => true,
      "show_in_rest" => true,
      'show_admin_column' => true,
      // This array of options controls the labels displayed in the WordPress Admin UI
      'labels' => array(
        'name' => _x( 'Project type', 'Project type' ),
        'singular_name' => _x( 'Project type', 'Project type' ),
        'search_items' =>  __( 'Search Project type' ),
        'all_items' => __( 'All Project type' ),
        'parent_item' => __( 'Parent Project type' ),
        'parent_item_colon' => __( 'Parent Project type:' ),
        'edit_item' => __( 'Edit Project type' ),
        'update_item' => __( 'Update Project type' ),
        'add_new_item' => __( 'Add New Project type' ),
        'new_item_name' => __( 'New Project type' ),
        'menu_name' => __( 'Project type' ),
      ),
    ));
  }
  add_action( 'init', 'hello_add_custom_taxonomies', 0 );