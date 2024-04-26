jQuery(document).ready(function($) {
    $(".hfe-nav-menu-icon").on("click", function() {
        $("body").toggleClass("body-active");
        $(".fixed-header").toggleClass("box-shadow");
        // if ($(".stickyheadersection").hasClass("fixed-header")) {
        //   $(".fixed-header").css("box-shadow", "none");
        // } else {
        //   $(".fixed-header").css("box-shadow", " 0 0 20px rgb(0 0 0 / 8%)");
        // }
    });

    jQuery(".timeago").timeago();
    var follownumber = jQuery('.follower_count').text();
    var FollowerCount = parseInt(follownumber) > 999 ? (parseInt(follownumber) / 1000).toFixed(1) + 'k Followers' : parseInt(follownumber);

    jQuery(".follower_count").html(FollowerCount);

    $(".article-filter-sector-ul .select-class").on("click", function() {
        $(this).toggleClass("active");
        $(".article-filter-sector-ul ul").toggleClass("open");
    });
    $(".article-filter-sector-ul ul li").on("click", function() {
        $(".article-filter-sector-ul ul").removeClass("open");
        $(".article-filter-sector-ul .select-class").removeClass("active");
        if ($(this).hasClass("active")) {
            //   $(this).removeClass("active");
        } else {
            $(this).addClass("active").siblings().removeClass("active");
        }
    });
});

jQuery(window).scroll(function($) {
    //sticky header
    if (jQuery(window).scrollTop() >= 80) {
        jQuery(".stickyheadersection").addClass("fixed-header");
    } else {
        jQuery(".stickyheadersection").removeClass("fixed-header");
    }
});