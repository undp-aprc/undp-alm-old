// Avoid `console` errors in browsers that lack a console.
;(function($) {
    $(document).ready(function() {

        // Align .nav to left hand side of container
        var windowWidth = $(window).width();
        var containerWidth = $('header > .container').width();
        var leftMarginWidth = (windowWidth - containerWidth) / 2;
        $('.nav.navbar-nav').css('margin-left',leftMarginWidth);
        console.log(containerWidth);

        $('.view-featured-resources .node').matchHeight();
        $('.pane-resource-blocks .views-row').matchHeight();
        $('.pane-news .cca-content-box').matchHeight();
    });
})(jQuery);

// Place any jQuery/helper plugins in here.

