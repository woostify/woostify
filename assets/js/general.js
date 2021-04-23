/**
 * General js
 *
 * @package woostify
 */

'use strict';

// Run scripts only elementor loaded.
function onElementorLoaded( callback ) {
	if ( undefined === window.elementorFrontend || undefined === window.elementorFrontend.hooks ) {
		setTimeout(
			function() {
				onElementorLoaded( callback )
			}
		);

		return;
	}

	callback();
}

// Disable popup/sidebar/menumobile.
function closeAll() {
	// Use ESC key.
	document.body.addEventListener(
		'keyup',
		function( e ) {
			if ( 27 === e.keyCode ) {
				document.documentElement.classList.remove( 'cart-sidebar-open' );
			}
		}
	);

	// Use `X` close button.
	var closeCartSidebarBtn = document.getElementById( 'close-cart-sidebar-btn' );

	if ( closeCartSidebarBtn ) {
		closeCartSidebarBtn.addEventListener(
			'click',
			function() {
				document.documentElement.classList.remove( 'cart-sidebar-open' );
			}
		);
	}

	// Use overlay.
	var overlay = document.getElementById( 'woostify-overlay' );

	if ( overlay ) {
		overlay.addEventListener(
			'click',
			function() {
				document.documentElement.classList.remove( 'cart-sidebar-open', 'sidebar-menu-open' );
			}
		);
	}
}

// Dialog search form.
function dialogSearch() {
	var headerSearchIcon = document.getElementsByClassName( 'header-search-icon' ),
		dialogSearchForm = document.querySelector( '.site-dialog-search' ),
		searchField      = document.querySelector( '.site-dialog-search .search-field' ),
		closeBtn         = document.querySelector( '.site-dialog-search .dialog-search-close-icon' );

	if ( ! headerSearchIcon.length || ! dialogSearchForm || ! searchField || ! closeBtn ) {
		return;
	}

	// Disabled field suggestions.
	searchField.setAttribute( 'autocomplete', 'off' );

	// Field must not empty.
	searchField.setAttribute( 'required', 'required' );

	var dialogOpen = function() {
		document.documentElement.classList.add( 'dialog-search-open' );
		document.documentElement.classList.remove( 'dialog-search-close' );

		if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
			searchField.focus();
		}
	}

	var dialogClose = function() {
		document.documentElement.classList.add( 'dialog-search-close' );
		document.documentElement.classList.remove( 'dialog-search-open' );
	}

	for ( var i = 0, j = headerSearchIcon.length; i < j; i++ ) {
		headerSearchIcon[i].addEventListener(
			'click',
			function() {
				dialogOpen();

				// Use ESC key.
				document.body.addEventListener(
					'keyup',
					function( e ) {
						if ( 27 === e.keyCode ) {
							dialogClose();
						}
					}
				);

				// Use dialog overlay.
				dialogSearchForm.addEventListener(
					'click',
					function( e ) {
						if ( this !== e.target ) {
							return;
						}

						dialogClose();
					}
				);

				// Use closr button.
				closeBtn.addEventListener(
					'click',
					function() {
						dialogClose();
					}
				);
			}
		);
	}
}

// Scroll action.
function scrollAction( selector, position ) {
	var scroll = function() {
		var item = document.querySelector( selector );
		if ( ! item ) {
			return;
		}

		var pos = arguments.length > 0 && undefined !== arguments[0] ? arguments[0] : window.scrollY;

		if ( pos > position ) {
			item.classList.add( 'active' );
		} else {
			item.classList.remove( 'active' );
		}
	}

	window.addEventListener(
		'load',
		function() {
			scroll();
		}
	);

	window.addEventListener(
		'scroll',
		function() {
			scroll();
		}
	);
}

// Go to top button.
function toTopButton() {
	var top               = jQuery( '#scroll-to-top' );
	var sticky_footer_bar = jQuery( '.woostify-sticky-footer-bar' );
	if ( ! top.length ) {
		return;
	}

	if ( sticky_footer_bar.length ) {
		var bar_height = sticky_footer_bar.outerHeight()
		top.css( 'bottom', (bar_height + 10) + 'px' )
	}

	top.on(
		'click',
		function() {
			jQuery( 'html, body' ).animate( { scrollTop: 0 }, 300 );
		}
	);
}

// Scrolling detect direction.
function scrollingDetect() {
	var body = document.body;

	if ( window.oldScroll > window.scrollY ) {
		body.classList.add( 'scrolling-up' );
		body.classList.remove( 'scrolling-down' );
	} else {
		body.classList.remove( 'scrolling-up' );
		body.classList.add( 'scrolling-down' );
	}

	// Reset state.
	window.oldScroll = window.scrollY;
}

// Get all Prev element siblings.
function prevSiblings( target ) {
	var siblings = [],
		n        = target;

	if ( n && n.previousElementSibling ) {
		while ( n = n.previousElementSibling ) {
			siblings.push( n );
		}
	}

	return siblings;
}

// Get all Next element siblings.
function nextSiblings( target ) {
	var siblings = [],
		n        = target;

	if ( n && n.nextElementSibling ) {
		while ( n = n.nextElementSibling ) {
			siblings.push( n );
		}
	}

	return siblings;
}

// Get all element siblings.
function siblings( target ) {
	var prev = prevSiblings( target ) || [],
		next = nextSiblings( target ) || [];

	return prev.concat( next );
}

// Remove class with prefix.
function woostifyRemoveClassPrefix() {
	var selector = ( arguments.length > 0 && undefined !== arguments[0] ) ? arguments[0] : false,
		prefix   = ( arguments.length > 0 && undefined !== arguments[1] ) ? arguments[1] : false;

	if ( ! selector || ! prefix ) {
		return false;
	}

	var _classList = Array.from( selector.classList );

	if ( ! _classList.length ) {
		return false;
	}

	var results = _classList.filter(
		function( item ) {
			return ! item.includes( prefix );
		}
	);

	selector.className = results.join( ' ' );
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		dialogSearch();
		scrollAction( '#scroll-to-top', 200 );
		toTopButton();
	}
);
