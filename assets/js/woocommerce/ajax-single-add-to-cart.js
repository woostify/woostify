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
	let progress_bar = document.querySelectorAll( '.free-shipping-progress-bar' );
		let percent  = 0;
	if ( progress_bar.length ) {
		percent = parseInt( progress_bar[0].getAttribute( 'data-progress' ) );
	}

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

			let curr_progress_bar = document.querySelectorAll( '.free-shipping-progress-bar' );
				let curr_percent  = 0;
			if ( curr_progress_bar.length ) {
				curr_percent = parseInt( curr_progress_bar[0].getAttribute( 'data-progress' ) );
			}

				// Effect.
			if ( ( ! progress_bar.length && curr_percent >= 100 ) || ( percent < curr_percent && curr_percent >= 100 ) ) {
				let confetti_canvas = document.createElement( 'canvas' );

				confetti_canvas.className = 'confetti-canvas';

				document.querySelector( '#shop-cart-sidebar' ).appendChild( confetti_canvas );

				let wConfetti = confetti.create(
					confetti_canvas,
					{
						resize: true,
						}
				);

				confettiSnowEffect( wConfetti, 4000 )

				setTimeout(
					function() {
						wConfetti.reset();
						document.querySelector( '.confetti-canvas' ).remove();
					},
					4000
				);
			}

				percent = curr_percent;
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
				e.preventDefault();

				var form = ele.closest( 'form.cart' );
				if ( ! form ) {
					return;
				}

				// Add loading.
				ele.classList.add( 'loading' );

				// Events.
				if ( 'function' === typeof( eventCartSidebarOpen ) ) {
					eventCartSidebarOpen();
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
						var div       = document.createElement( 'div' );
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
