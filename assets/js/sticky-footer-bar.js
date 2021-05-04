/**
 * Sticky Footer Bar js
 *
 * @package woostify
 */

'use strict';

document.addEventListener(
	'DOMContentLoaded',
	function() {
		var senseSpeed               = 5
		var previousScroll           = 0
		var stickyFooterBarContainer = document.querySelector( '.woostify-sticky-footer-bar' );
		window.onscroll              = function() {
			var stickyFooterBarHeight = stickyFooterBarContainer.clientHeight + 1;
			var scroller              = window.pageYOffset | document.body.scrollTop;
			if ( scroller - senseSpeed > previousScroll ) {
				stickyFooterBarContainer.style.bottom = '-' + stickyFooterBarHeight + 'px';
			} else if ( scroller + senseSpeed < previousScroll ) {
				stickyFooterBarContainer.style.bottom = '0';
			}
			previousScroll = scroller;
		};
	},
);
