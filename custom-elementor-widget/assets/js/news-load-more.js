jQuery(document).ready(function () {
    jQuery('.load_more_spinner').hide();
    load_more_posts = false
    jQuery(function ($) {
        jQuery('body').on('click', '.loadmore', function () {
            var paged = jQuery('.news_page_value').val();
            jQuery('.news_page_value').val(1);
            var load_more_posts = true;
            var data = {
                'action': 'load_posts_by_ajax',
                'paged': paged,
                'security': my_ajax_object.security
            };

            jQuery.ajax({
                type: "post",
                url: my_ajax_object.ajax_url,
                data: data,
                beforeSend: function () {
                    jQuery('.load_more_spinner').show();
                    jQuery('.loadmore').hide();
                },
                success: function (response) {
                    if (load_more_posts) {
                        jQuery('.blog-posts').append(response.data.html_response);
                    } else {
                        jQuery('.blog-posts').html(response.data.html_response);
                    }
                    if (response.data.paged == '') {

                        jQuery('.loadmore').hide();

                    } else {
                        jQuery('.news_page_value').val(response.data.paged);
                        jQuery('.loadmore').show();
                    }
                },
                complete: function () {
                    jQuery('.load_more_spinner').hide();
                    
                }
            });

        });
    });
});