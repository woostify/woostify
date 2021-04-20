/**
 * Sticky Footer Bar js
 *
 * @package woostify
 */

'use strict';

document.addEventListener(
	'DOMContentLoaded',
	function() {
		let senseSpeed                = 5, previousScroll = 0, stickyFooterBarContainer  = document.querySelector( '.woostify-sticky-footer-bar' );
		window.onscroll               = () => {
			let stickyFooterBarHeight = stickyFooterBarContainer.clientHeight + 1;
			let scroller              = window.pageYOffset | document.body.scrollTop;
			if ( scroller - senseSpeed > previousScroll ) {
				stickyFooterBarContainer.style.bottom = '-' + stickyFooterBarHeight + 'px';
			} else if ( scroller + senseSpeed < previousScroll ) {
				stickyFooterBarContainer.style.bottom = '0';
			}
			previousScroll = scroller;
		};
	},
);
