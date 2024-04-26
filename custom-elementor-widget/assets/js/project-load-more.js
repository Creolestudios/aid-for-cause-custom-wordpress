jQuery(document).ready(function() {
    jQuery('.load_more_spinner').hide();
    var paged = 2;
    jQuery('.loadmore').click(function() {
        var project_type = jQuery(".call_ajax_for_filter.active_project_type").attr("value");
        var active_project_type = jQuery(".call_ajax_for_filter.active_project_type").attr("value");
        var load_more_posts = true;
        var paged = jQuery('.project_page_value').val();
        jQuery('.project_page_value').val(1);
        var keyword = jQuery("#keyword").val();
        get_projects_data_by_filter(project_type, active_project_type, keyword, paged, load_more_posts);

    });
    jQuery(".article_main_for_ajax .article-filter-sector-ul .call_ajax_for_filter").click(function() {
        var project_type = jQuery(this).attr("value");
        jQuery(".call_ajax_for_filter.active_project_type").removeClass("active_project_type");

        jQuery(this).closest(".call_ajax_for_filter").addClass("active_project_type");
        jQuery('.project_page_value').val(1);
        get_projects_data_by_filter(project_type);
    });
});

function get_projects_data_by_filter(project_type, active_project_type, keyword, paged, load_more_posts = false) {
    
    var project_type = jQuery(".call_ajax_for_filter.active_project_type").attr("value");
    var active_project_type = jQuery(".call_ajax_for_filter.active_project_type").attr("value");

    var keyword = jQuery("#keyword").val();
    jQuery.ajax({
        type: "post",
        url: my_ajax_object.ajax_url,
        data: {
            action: "project_load_more_function",
            nonce: my_ajax_object.nonce,
            project_type: project_type,
            active_project_type: active_project_type,
            keyword: keyword,
            paged: paged,
        },
        beforeSend: function () {
            jQuery('.load_more_spinner').show();
            jQuery('.loadmore').hide();
        },
        success: function(response) {
            if (load_more_posts) {
                jQuery('.blog-posts').append(response.data.html_response);
            } else {
                jQuery('.blog-posts').html(response.data.html_response);
            }
            if (response.data.paged == '') {

                jQuery('.loadmore').hide();

            } else {
                jQuery('.project_page_value').val(response.data.paged);
                jQuery('.loadmore').show();
            }
        },
        complete: function () {
            jQuery('.load_more_spinner').hide();
            
        }
    });
}