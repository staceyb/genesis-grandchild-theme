/**
 * This file is for any custom JavaScript.
 *
 * @author SunlitStudio
 * @link https://sunlitstud.io
 * @version 1.1.0
 * @license GPL-2.0+
 */
(function($) {

	'use strict';

	/*
	 * Toggles Search Field on and off
	 *
	 */
	$(document).ready(function($) {
		$(".search-toggle").click(function() {
			$("#search-container").slideToggle('slow', function() {
				$(".search-toggle").toggleClass('active');
			});
		});

		var $window = $(window);

		function check_if_in_view() {
			var window_height = $window.height();
			var window_top_position = $window.scrollTop();
			var window_bottom_position = (window_top_position + window_height);
			var $animation_elements = $('.animation-element');

			$.each($animation_elements, function() {
				var $element = $(this);
				var element_height = $element.outerHeight();
				var element_top_position = $element.offset().top;
				var element_bottom_position = (element_top_position + element_height);

				//check to see if this current container is within viewport
				if ((element_bottom_position >= window_top_position) &&
					(element_top_position <= window_bottom_position)) {
					$element.addClass('in-view');
				} else {
					$element.removeClass('in-view');
				}
			});
		}

		$window.on('scroll resize', check_if_in_view);
		$window.trigger('scroll');

	});

})(jQuery);
