function inIframe () {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

(function ($) {
	Drupal.behaviors.hide_regions = {
		attach: function (context, settings) {
			
			if (inIframe()) {
				$('body').addClass('gsp-hide');
			}
		}
	}
}) (jQuery);