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
	if ( button ) {
		button.classList.remove( 'loading' );
	}

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
	var forms = document.querySelectorAll( 'form.cart' );
	if ( ! forms.length ) {
		return;
	}

	forms.forEach(
		function( form ) {
			form.addEventListener(
				'submit',
				function( e ) {
					e.preventDefault();

					var button = form.querySelector( '.button' );

					// Add loading.
					if ( button ) {
						button.classList.add( 'loading' );
					}

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
							body: new FormData( e.target )
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
								woostifyAjaxSingleHandleError( button );

								return;
							}

							// Update fragments.
							woostifyAjaxSingleUpdateFragments( button );
						}
					).catch(
						function() {
							// Handle.
							woostifyAjaxSingleHandleError( button );
						}
					);
				}
			);
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		woostifyAjaxSingleAddToCartButton();
	}
);
