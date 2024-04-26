<?php
// Ajax function for load more News Post
function load_posts_by_ajax_callback()
{
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['paged'];
    $default_posts_per_page = get_field('no_of_news_posts_to_show', 'option');
    $args = array(
        'post_type' => 'news',
        'post_status' => 'publish',
        'posts_per_page' => $default_posts_per_page,
        'paged' => $paged,
        'orderby' => array(
            'date' => 'DESC',
        ),
    );
    $blog_posts = new WP_Query($args);
    $response = '';
?>


    <?php if ($blog_posts->have_posts()) : ?>
<?php while ($blog_posts->have_posts()) : $blog_posts->the_post();
            $post_id = get_the_ID();
            $background_img_url = get_the_post_thumbnail_url($post_id);
           
            $shortcode = do_shortcode('[Sassy_Social_Share]');
            $permalink = get_the_permalink();
            $title = get_the_title($post_id);
            $the_content = get_the_content();
            $get_the_time = get_the_date( 'd M Y' );
            $news_time_picker = get_the_date('h i A');
            if (get_field('is_features_image_or_video') == true ) { ?>
                <?php
                $iframe = get_field('featured_video');
                preg_match('/src="(.+?)"/', $iframe, $matches);
                $src = $matches[1];
                $params = array(
                    'controls'  => 0,
                    'hd'        => 1,
                    'autohide'  => 1
                );
                $new_src = add_query_arg($params, $src);
                $iframe = str_replace($src, $new_src, $iframe);
                $attributes = 'frameborder="0"';
                $iframe = str_replace('><iframe>', ' ' . $attributes . '></iframe>', $iframe);

                $div_url = '<div class="content_image_outer_class">
                                '.$iframe.'
                                <div class="overlay-div"></div>
                            </div>';
            } else { 
                $featured_url = get_field('featured_image')['url']; 
                $div_url = '<div class="content_image_outer_class" style="background: url('.$featured_url.') no-repeat center;background-size: cover;">
                                <div class="overlay-div"></div>
                            </div>';
            }

            if (get_field('show_news_published_time') == true ) { 
                $time_picker = '<span class="news_time_picker">'.$news_time_picker.'</span>';
            } else { 
                $time_picker = '<span class="news_time_picker"></span>';
            }

            $response .= '<div class="col-6 col-md-4">
                        <div class="post_content_class">
                            '.$div_url.'
                            <div class="inner_content_class">
                                <div class="text-social">
                                    <p class="date_class">' . $get_the_time . ''.$time_picker.'</p>
                                    ' . $shortcode . '
                                </div>
                                
                                <h3 class="title_class"><a href="' . $permalink . '">' . $title . '</a></h3>
                                <div class="text-content-class">' . $the_content . '</div>
                                <div class="read_more">
                                    <a href="' . $permalink . '"><i class="fa fa-book"></i>Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>';
        endwhile;
        wp_reset_postdata();
    else :
        $response .= '<h1>No Projects Found</h1>';
    endif;
    if ($blog_posts->max_num_pages > 1 && $paged != $blog_posts->max_num_pages) {
        $paged = $paged + 1;
    } else {
        $paged = '';
    }
    $response_array = array(
        'html_response' => $response,
        'paged' => $paged,
    );
    wp_send_json_success($response_array);
    die();
}
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');

add_action('wp_ajax_function_for_get_posts_by_filters_options', 'function_for_get_posts_by_filters_options');
add_action('wp_ajax_nopriv_function_for_get_posts_by_filters_options', 'function_for_get_posts_by_filters_options');


//function for filter project option starts
function function_for_get_posts_by_filters_options()
{
    $project_type     = (!empty($_POST['project_type'])) ? $_POST['project_type'] : ''; //project category 
    $search_text = esc_attr($_POST['keyword']); //project search keyword
    $active_project_type     = (!empty($_POST['active_project_type'])) ? $_POST['active_project_type'] : '';
    $default_posts_per_page = get_field('project_per_page', 'option');
    $tax_query = array(
        'taxonomy' => 'project_type',
        'field' => 'id',
        'terms' => $active_project_type,
    );

    //filter query conditions starts
    if (($project_type == '') && (!empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            's' => $search_text,
        );
    } elseif (($project_type == '') && (empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
        );
    } elseif (($project_type != '') && (!empty($project_type)) && (empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'tax_query' => array(
                $tax_query,
            ),
        );
    } elseif (($project_type != '') && (!empty($project_type)) &&  (!empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'tax_query' => array(
                'relation' => 'AND',
                $tax_query,
            ),
            's' => $search_text,
            'paged' => $paged,
        );
    } elseif ((empty($project_type)) &&  (!empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'tax_query' => array(
                'relation' => 'AND',
                $tax_query,
            ),
            's' => $search_text,
        );
    }
    $arr_posts = new WP_Query($query_array);
    $content = "";
    if ($arr_posts->have_posts()) :


        while ($arr_posts->have_posts()) : $arr_posts->the_post();
            $post_id = get_the_ID();
            $background_img_url = get_the_post_thumbnail_url($post_id);
            $flag_image = get_field('country_flag');
            $project_date = get_field('project_date');
            $flag_image_url = esc_url($flag_image);
            $permalink = get_the_permalink();
            $title = get_the_title($post_id);
            $the_content = wp_trim_words(get_the_content(), 30, '');
            $content .= '<div class="swiper-slide">
                                <div class="post_content_class">
                                    <div class="content_image_outer_class" style="background: url(' . $background_img_url . ') no-repeat center;background-size: cover;">
                                        <div class="overlay-div">
                                            <div class="flag_img_class">
                                                <img src="' . $flag_image_url . '"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inner_content_class">
                                        <p class="date_class">' . $project_date . '</p>
                                        <h3 class="title_class"><a href="' . $permalink . '">' . $title . '</a></h3>
                                        <p class="text_class">' . $the_content . '</p>
                                        <div class="read_more">
                                            <a href="' . $permalink . '"><i class="fa fa-book"></i>Read More</a>
                                        </div>
                                    </div>
                                </div>
                        </div>';
        endwhile;
        wp_reset_postdata();
    else :
        $content .= '<h1>No Projects Found</h1>';
    endif;

    $response_array = array(
        'html_response' => $content,
    );
    wp_send_json_success($response_array);
    die();
}
//function for filter project option ends


add_action('wp_ajax_project_load_more_function', 'project_load_more_function');
add_action('wp_ajax_nopriv_project_load_more_function', 'project_load_more_function');

//function for filter project load more option starts
function project_load_more_function()
{
    $paged     = (!empty($_POST['paged'])) ? $_POST['paged'] : 1;
    $project_type     = (!empty($_POST['project_type'])) ? $_POST['project_type'] : ''; //project category 
    $search_text = esc_attr($_POST['keyword']); //project search keyword
    $active_project_type     = (!empty($_POST['active_project_type'])) ? $_POST['active_project_type'] : '';
    $default_posts_per_page = get_field('project_per_page', 'option');
    $tax_query = array(
        'taxonomy' => 'project_type',
        'field' => 'id',
        'terms' => $active_project_type,
    );

    //filter query conditions starts
    if (($project_type == '') && (!empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            's' => $search_text,
            'paged' => $paged,
        );
    } elseif (($project_type == '') && (empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'paged' => $paged,
        );
    } elseif (($project_type != '') && (!empty($project_type)) && (empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'tax_query' => array(
                $tax_query,
            ),
            'paged' => $paged,
        );
    } elseif (($project_type != '') && (!empty($project_type)) &&  (!empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'tax_query' => array(
                'relation' => 'AND',
                $tax_query,
            ),
            's' => $search_text,
            'paged' => $paged,
        );
    } elseif ((empty($project_type)) &&  (!empty($search_text))) {
        $query_array = array(
            'post_type' => 'projects',
            'post_status' => 'publish',
            'orderby' => array(
                'date' => 'DESC',
            ),
            'posts_per_page' => $default_posts_per_page,
            'tax_query' => array(
                'relation' => 'AND',
                $tax_query,
            ),
            's' => $search_text,
            'paged' => $paged,
        );
    }


    $arr_posts = new WP_Query($query_array);
    $content = "";
    if ($arr_posts->have_posts()) :


        while ($arr_posts->have_posts()) : $arr_posts->the_post();
            $post_id = get_the_ID();
            $background_img_url = get_the_post_thumbnail_url($post_id);
            $flag_image = get_field('country_flag');
            $project_date = get_the_date('M Y');
            $flag_image_url = esc_url($flag_image);
            $permalink = get_the_permalink();
            $title = get_the_title($post_id);
            $the_content = wp_trim_words(get_the_content(), 30, '');
            $content .= '<div class="col-6 col-md-4"><div class="swiper-slide">
                                <div class="post_content_class">
                                    <div class="content_image_outer_class" style="background: url(' . $background_img_url . ') no-repeat center;background-size: cover;">
                                        <div class="overlay-div">
                                            <div class="flag_img_class">
                                                <img src="' . $flag_image_url . '"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inner_content_class">
                                       
                                        <p class="date_class">' . $project_date . '</p>
                                        <h3 class="title_class"><a href="' . $permalink . '">' . $title . '</a></h3>
                                        <p class="text_class">' . $the_content . '</p>
                                        <div class="read_more">
                                            <a href="' . $permalink . '"><i class="fa fa-book"></i>Read More</a>
                                        </div>
                                    </div>
                                </div>
                        </div></div>';
        endwhile;
        wp_reset_postdata();
    else :
        $content .= '<h1>No Projects Found</h1>';
    endif;
    if ($arr_posts->max_num_pages > 1 && $paged != $arr_posts->max_num_pages) {
        $paged = $paged + 1;
    } else {
        $paged = '';
    }
    $response_array = array(
        'html_response' => $content,
        'paged' => $paged,
    );
    wp_send_json_success($response_array);
    die();
}
//function for filter project load more option ends