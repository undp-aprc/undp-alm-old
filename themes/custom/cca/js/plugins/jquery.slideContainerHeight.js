(function($){
    $.fn.slideContainerHeight = function(options) {
        options = $.extend({}, $.fn.slideContainerHeight, options);
        this.each(function() {
            var element = $(this);
            
            $(window).load(function() {
                var maxHeight = getMaxElementHeight(options);
                element.height(maxHeight+options.defaultOptions.paddingTop);
                element.parent('.slidesjs').css('visibility','visible');
            });
            var maxHeight = getMaxElementHeight(options);
            element.height(maxHeight+options.defaultOptions.paddingTop);
        });
        
        return this;
    }
    
    function getMaxElementHeight(options) {
        var maxHeight = 0;
        $('.'+options.defaultOptions.childClass).each(function() {
            if ($(this).height() > maxHeight) { 
                maxHeight = $(this).height();
            }
        });
        return maxHeight;
    }
    
    $.fn.slideContainerHeight.defaultOptions = {
        parentClass: 'slidesjs-container',
        childClass: 'slidesjs-slide',
        paddingTop: 40,
    }
})(jQuery);