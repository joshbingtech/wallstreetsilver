$( document ).ready(function() {
    $('.jcarousel')
    .on('jcarousel:create jcarousel:reload', function() {
        var element = $(this),
        width = element.innerWidth();

        if (width > 800) {
            width = width / 4;
        } else if (width > 600) {
            width = width / 3;
        }

        element.jcarousel('items').css('width', width + 'px');
    })
    .jcarousel({
        animation: {
            duration: 800,
            easing:   'linear',
            complete: function() {
            }
        },
        wrap: 'circular'
    })
    .jcarouselAutoscroll({
        interval: 3000,
        target: '+=1',
        autostart: true
    });
});
