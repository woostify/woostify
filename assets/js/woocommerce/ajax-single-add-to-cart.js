/**
 * Ajax single add to cart
 *
 * @package Woostify Pro
 */

'use strict';

function woostifyAjaxSingleHandleError( button ) {
	// Event when added to cart.
	if ( 'function' === typeof( eventCartSidebarClose ) ) {
		eventCartSidebarClose();
	}

	// Remove loading.
	button.classList.remove( 'loading' );

	// Hide quick view popup when product added to cart.
	document.documentElement.classList.remove( 'quick-view-open' );
}

function woostifyAjaxSingleUpdateFragments( button ) {
	fetch(
		wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
		{
			method: 'POST'
		}
	).then(
		function( response ) {
			return response.json();
		}
	).then(
		function( fr ) {
			if ( 'undefined' === typeof( fr.fragments ) ) {
				return;
			}

			Object.entries( fr.fragments ).forEach(
				function( [key, value] ) {
					let newEl = document.querySelectorAll( key );
					if ( ! newEl.length ) {
						return;
					}

					newEl.forEach(
						function( el ) {
							el.insertAdjacentHTML( 'afterend', value );
							el.remove();
						}
					);
				}
			);
		}
	).finally(
		function() {
			// Handle.
			woostifyAjaxSingleHandleError( button );

			jQuery( document.body ).trigger( 'added_to_cart' );
		}
	);
}

function woostifyAjaxSingleAddToCartButton() {
	var buttons = document.querySelectorAll( '.single_add_to_cart_button' );
	if ( ! buttons.length ) {
		return;
	}

	buttons.forEach(
		function( ele ) {
			ele.onclick = function( e ) {
				var form = ele.closest( 'form.cart' );
				if ( ! form ) {
					return;
				}

				if ( 'POST' !== form.method.toUpperCase() ) {
					return;
				}

				e.preventDefault();
				let input      = form.querySelector( 'input.qty' ),
					inputValue = input ? Number( input.value.trim() ) : false;
				if ( ! inputValue || isNaN( inputValue ) || inputValue <= 0 ) {
					alert( woostify_woocommerce_general.qty_warning );
					return;
				}

				// Add loading.
				ele.classList.add( 'loading' );

				// Events.
				if ( 'function' === typeof( eventCartSidebarOpen ) ) {
					eventCartSidebarOpen();
				}

				if ( 'function' === typeof( cartSidebarOpen ) ) {
					cartSidebarOpen();
				}

				if ( 'function' === typeof( closeAll ) ) {
					closeAll();
				}

				// Send post request.
				fetch(
					form.action,
					{
						method: 'POST',
						body: new FormData( form )
					}
				).then(
					function( r ) {
						return r.text();
					}
				).then(
					function( text ) {
						var div = document.createElement( 'div' );
						div.innerHTML = text;

						var error = div.querySelector( '.woocommerce-error' );
						if ( error ) {
							var notices = document.querySelector( '.content-top .woocommerce' );

							// Remove current error.
							if ( notices.querySelector( '.woocommerce-error' ) ) {
								notices.querySelector( '.woocommerce-error' ).remove();
							}

							// Update new error.
							if ( notices ) {
								notices.appendChild( error );
							}

							// Handle.
							woostifyAjaxSingleHandleError( ele );

							return;
						}

						// Update fragments.
						woostifyAjaxSingleUpdateFragments( ele );

						// Support Buy now addon.
						if ( ele.getAttribute( 'data-checkout_url' ) ) {
							window.location = ele.getAttribute( 'data-checkout_url' );
						}
					}
				).catch(
					function() {
						// Handle.
						woostifyAjaxSingleHandleError( ele );
					}
				);
			}
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		woostifyAjaxSingleAddToCartButton();
	}
);
