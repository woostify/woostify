/**
 * General js
 *
 * @package woostify
 */

'use strict';

Number.prototype.countDecimals = function () {

	if ( Math.floor( this.valueOf() ) === this.valueOf() ) {
		return 0;
	}

	var str = this.toString();
	if ( str.indexOf( "." ) !== -1 && str.indexOf( "-" ) !== -1 ) {
		return str.split( "-" )[1] || 0;
	} else if ( str.indexOf( "." ) !== -1 ) {
		return str.split( "." )[1].length || 0;
	}
	return str.split( "-" )[1] || 0;
}

function get_svg_icon( icon ) {
	var output    = '';
	var icon_list = JSON.parse( woostify_svg_icons.list );

	output += '<span class="woostify-svg-icon">';

	if ( icon_list.hasOwnProperty( icon ) ) {
		output += icon_list[icon];
	} else {
		output += '';
	}

	output += '</span>';

	return output;
}

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

function getScrollbarWidth() {
    return window.innerWidth - document.documentElement.clientWidth;
}

function onTouchStart( isCartSidebarOpen = true ) {

	var on_touch_start = false;
	var scrollbar_width = getScrollbarWidth();

    if (
		'ontouchstart' in window ||
		navigator.maxTouchPoints > 0 ||
		window.matchMedia( '(pointer:coarse)' ).matches
	){
        on_touch_start = true;
    }
	
	if (isCartSidebarOpen) {
		if (on_touch_start) {
			Object.assign(document.body.style, {
				paddingRight: 0 + 'px',
			});
		}else{
			Object.assign(document.body.style, {
				paddingRight: scrollbar_width + 'px',
			});
		}
	}else{
		Object.assign(document.body.style, {
			paddingRight: '',
		});
	}
}

// Disable popup/sidebar/menumobile.
function closeAll() {
	// Use ESC key.
	document.body.addEventListener(
		'keyup',
		function( e ) {
			if ( 27 === e.keyCode ) {
				document.documentElement.classList.remove( 'cart-sidebar-open' );
				onTouchStart(false);
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
				onTouchStart(false);
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
				onTouchStart(false);
			}
		);
	}
}

// Dialog Popup.
function dialogPopup( targetClickClass, popupTarget, type ) {
	var targetClickEl = document.getElementsByClassName( targetClickClass ),
		popupEl       = document.querySelector( popupTarget ),
		popupCloseBtn = document.querySelector( popupTarget + ' .dialog-' + type + '-close-icon' ),
		searchField,popupInnerEl,popupContentEl,aslSearchField;

	if ( 'search' === type ) {
		searchField = document.querySelector( popupTarget + ' .search-field' );
		// Get input search of plugin Ajax Search Lite.
		aslSearchField = document.querySelector( popupTarget + ' .proinput input.orig' );
		if ( ! searchField ) {
			if ( '1' === woostify_general_params.is_active_asl ) {
				if ( ! aslSearchField ) {
					return;
				}
			} else {
				return;
			}
		}
	}

	if ( ! targetClickEl.length || ! popupEl || ! popupCloseBtn ) {
		return;
	}

	if ( 'search' === type && searchField ) {
		// Disabled field suggestions.
		searchField.setAttribute( 'autocomplete', 'off' );

		// Field must not empty.
		searchField.setAttribute( 'required', 'required' );

		// clear text search
		window.addEventListener("load", (event) => {
			searchField.value = "";		
		});
	}

	if ( 'account' === type ) {
		popupInnerEl   = popupEl.querySelector( '.dialog-popup-inner' );
		popupContentEl = popupEl.querySelector( '.dialog-popup-content' );
	}

	var popupOpen = function() {
		document.documentElement.classList.add( 'dialog-' + type + '-open' );
		document.documentElement.classList.remove( 'dialog-' + type + '-close' );
		if ( 'search' === type && searchField ) {
			if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
				searchField.focus();
			}
		}
	}

	var popupClose = function() {
		document.documentElement.classList.add( 'dialog-' + type + '-close' );
		document.documentElement.classList.remove( 'dialog-' + type + '-open' );
	}

	for ( var i = 0, j = targetClickEl.length; i < j; i++ ) {
		if ( 'account' === type ) {
			if ( ! targetClickEl[i].classList.contains( 'open-popup' ) ) {
				return;
			}
		}
		targetClickEl[i].addEventListener(
			'click',
			function( e ) {
				e.preventDefault();
				popupOpen();

				// Use ESC key.
				document.body.addEventListener(
					'keyup',
					function( e ) {
						if ( 27 === e.keyCode ) {
							popupClose();
						}
					}
				);

				if ( popupInnerEl ) {
					popupInnerEl.addEventListener(
						'click',
						function( e ) {
							if ( this !== e.target ) {
								return;
							}

							popupClose();
						}
					);
				}

				if ( popupContentEl ) {
					popupContentEl.addEventListener(
						'click',
						function( e ) {
							if ( this !== e.target ) {
								return;
							}

							popupClose();
						}
					);
				}

				// Use dialog overlay.
				popupEl.addEventListener(
					'click',
					function( e ) {
						if ( this !== e.target ) {
							return;
						}

						popupClose();
					}
				);

				// Use closr button.
				popupCloseBtn.addEventListener(
					'click',
					function() {
						popupClose();
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

function noticesLoginRegisterAccout() {
	var woocommerce_account = document.querySelector('.woostify-login-form-popup-content.woocommerce-account');
	if ( !woocommerce_account ) {
		return;
	}

	var wc_notices_wrapper = woocommerce_account.querySelector('.woocommerce-notices-wrapper');
	var wc_form_login = woocommerce_account.querySelector('.woocommerce-form-login');
	var wc_form_register = woocommerce_account.querySelector('.woocommerce-form-register');

	if( wc_form_register ){
		var wc_form_register_username = wc_form_register.querySelector('input[name="username"]');
		var wc_form_register_email = wc_form_register.querySelector('input[type="email"]');
		var wc_form_register_password = wc_form_register.querySelector('input[type="password"]');
		var wc_form_register_redirect = wc_form_register.querySelector('input[name="redirect"]');
		var wc_register_nonce = wc_form_register.querySelector('#woocommerce-register-nonce');
		var wc_form_register_submit = wc_form_register.querySelector('.woocommerce-form-register__submit');

		wc_form_register_submit.addEventListener('click', function (e) {
			e.preventDefault();

			var username = wc_form_register_username ? wc_form_register_username.value : '';
			var email = wc_form_register_email.value;
			var password = wc_form_register_password ? wc_form_register_password.value : '';
			var redirect = wc_form_register_redirect ? wc_form_register_redirect.value : '';

			var data = {
				'action': 'notices_register_account',
				'woocommerce-register-nonce' : wc_register_nonce.value, 
				'username': username,
				'email' : email,
				'password' : password,
				'redirect' : redirect,
			};

			jQuery.ajax({
				type:"POST",
				url: woostify_woocommerce_general.ajax_url,
				dataType: 'json',
				data: data,
				success: function(res)
				{

					if ( !res.success ) {
						return;
					}
					
					var data = res.data;
					var notices = data.notices;
					var successfully = data.successfully;
					var wp_redirect = data.wp_redirect;
	
					wc_notices_wrapper.innerHTML = notices;
					if ( successfully ) {
						// Refresh the page after a delay of 1 seconds
						setTimeout(function(){
							location.replace(wp_redirect);
						}, 1000);
					}
					
				}
		
			});
		});
	}

	if ( wc_form_login ) {
		var wc_form_login_username = wc_form_login.querySelector('input[name="username"]');
		var wc_form_login_password = wc_form_login.querySelector('input[type="password"]');
		var wc_form_login_rememberme = wc_form_login.querySelector('input[name="rememberme"]');
		var wc_form_login_redirect = wc_form_login.querySelector('input[name="redirect"]');
		var wc_login_nonce = wc_form_login.querySelector('#woocommerce-login-nonce');
		var wc_form_login_submit = wc_form_login.querySelector('.woocommerce-form-login__submit');

		wc_form_login_submit.addEventListener('click', function (e) {
			e.preventDefault();

			var username = wc_form_login_username.value;
			var password = wc_form_login_password.value;
			var rememberme = wc_form_login_rememberme ? wc_form_login_rememberme.value : '';
			var redirect = wc_form_login_redirect ? wc_form_login_redirect.value : '';

			var data = {
				'action': 'notices_login_account',
				'woocommerce-login-nonce' : wc_login_nonce.value, 
				'username': username,
				'password' : password,
				'rememberme' : rememberme,
				'redirect' : redirect,
			};

			jQuery.ajax({
				type:"POST",
				url: woostify_woocommerce_general.ajax_url,
				dataType: 'json',
				data: data,
				success: function(res)
				{

					if ( !res.success ) {
						return;
					}
		
					var data = res.data;
					var notices = data.notices;
					var successfully = data.successfully;
					var wp_redirect = data.wp_redirect;
	
					wc_notices_wrapper.innerHTML = notices;
					if ( successfully ) {
						location.replace(wp_redirect);
					}
					
				}
		
			});

		});
	}

}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		dialogPopup( 'my-account-icon', '#woostify-login-form-popup', 'account' );
		dialogPopup( 'my-account-login-link', '#woostify-login-form-popup', 'account' );
		dialogPopup( 'header-search-icon', '.site-dialog-search', 'search' );
		scrollAction( '#scroll-to-top', 200 );
		toTopButton();
		noticesLoginRegisterAccout();
	}
);
