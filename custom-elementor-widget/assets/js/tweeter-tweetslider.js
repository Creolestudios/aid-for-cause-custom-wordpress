jQuery(document).ready(function($) {

    var $carousel = $('#carousel-background-twitter');
    var $carouselCaptions = $carousel.find('.item .cl-icon');
    //var $carouselImages = $carousel.find('.item img');
    var carouselTimeout;

    $carousel.on('slid.bs.carousel', function() {

        var $item = $carousel.find('.item.active');
        $('.cl-icon').animate({ 'opacity': 1 }, 300);
        carouselTimeout = setTimeout(function() { // start the delay
            carouselTimeout = false;
            $('.cl-icon').animate({ 'opacity': 0 }, 300);
        }, 5000);
    }).on('slide.bs.carousel', function() {

        $('.cl-icon').animate({ 'opacity': 0 }, 300);
        if (carouselTimeout) { // Carousel is sliding, stop pending animation if any
            clearTimeout(carouselTimeout);
            carouselTimeout = false;
        }
        // Reset styles
        $('.cl-icon').animate({ 'opacity': 0 }, 300);

    });
});