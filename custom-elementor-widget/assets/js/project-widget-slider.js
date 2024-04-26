jQuery(document).ready(function() {
    var swiper = new Swiper(".swiper", {
        // slidesPerView: 3,
        // spaceBetween: 30,
        // direction: getDirection(),


        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        // on: {
        //   resize: function () {
        //     swiper.changeDirection(getDirection());
        //   },
        // },
        breakpoints: {
            0: {
                slidesPerGroup: 1,
                slidesPerView: 1,
                spaceBetween: 10,
            },
            575: {
                slidesPerGroup: 2,
                slidesPerView: 2,
                spaceBetween: 10,
            },
            800: {
                slidesPerGroup: 3,
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1024: {
                slidesPerGroup: 3,
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1440: {
                slidesPerGroup: 3,
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    // function getDirection() {
    //   var windowWidth = window.innerWidth;
    //   var direction = window.innerWidth <= 760 ? "vertical" : "horizontal";

    //   return direction;
    // }

    jQuery(".article_main_for_ajax .article-filter-sector-ul .call_ajax_for_filter").click(function() {
        var project_type = jQuery(this).attr("value");
        jQuery(".call_ajax_for_filter.active_project_type").removeClass("active_project_type");
        jQuery(this).closest(".call_ajax_for_filter").addClass("active_project_type");
        get_projects_data_by_filter(project_type);
    });
});

function get_projects_data_by_filter(project_type) {
    var project_type = jQuery(".call_ajax_for_filter.active_project_type").attr("value");
    var active_project_type = jQuery(".call_ajax_for_filter.active_project_type").attr("value");

    var keyword = jQuery("#keyword").val();
    jQuery.ajax({
        type: "post",
        url: my_ajax_object.ajax_url,
        data: {
            action: "function_for_get_posts_by_filters_options",
            nonce: my_ajax_object.nonce,
            project_type: project_type,
            active_project_type: active_project_type,
            keyword: keyword,
        },
        success: function(response) {
            jQuery(".outer_main_class").html(response.data.html_response);
        },
    });
}