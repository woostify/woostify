/**
 * Woocommerce js
 *
 * @package woostify
 */

/*global woostify_woocommerce_general*/

'use strict';

function cartSidebarOpen() {
	if ( document.body.classList.contains( 'no-cart-sidebar' ) ) {
		return;
	}

	document.documentElement.classList.add( 'cart-sidebar-open' );
}

function eventCartSidebarOpen() {
	document.body.classList.add( 'updating-cart' );
	document.body.classList.remove( 'cart-updated' );
}

function eventCartSidebarClose() {
	document.body.classList.add( 'cart-updated' );
	document.body.classList.remove( 'updating-cart' );
}

// Event when click shopping bag button.
function shoppingBag() {
	var shoppingBag = document.getElementsByClassName( 'shopping-bag-button' ),
		cartSidebar = document.getElementById( 'shop-cart-sidebar' );

	if (
		! shoppingBag.length ||
		! cartSidebar ||
		document.body.classList.contains( 'woocommerce-cart' ) ||
		document.body.classList.contains( 'woocommerce-checkout' )
	) {
		return;
	}

	for ( var i = 0, j = shoppingBag.length; i < j; i++ ) {
		shoppingBag[i].addEventListener(
			'click',
			function( e ) {
				e.preventDefault();

				cartSidebarOpen();
				closeAll();
			}
		);
	}
}

// Condition for Add 'scrolling-up' and 'scrolling-down' class to body.
var woostifyConditionScrolling = function() {
	if (
		// When Demo store enable.
		( document.body.classList.contains( 'woocommerce-demo-store' ) && -1 === document.cookie.indexOf( 'store_notice' ) ) ||
		// When sticky button on mobile, Cart and Checkout page enable.
		( ( document.body.classList.contains( 'has-order-sticky-button' ) || document.body.classList.contains( 'has-proceed-sticky-button' ) ) && window.innerWidth < 768 )
	) {
		return true;
	}

	return false;
}

// Stock progress bar.
var woostifyStockQuantityProgressBar = function() {
	var selector = document.querySelectorAll( '.woostify-single-product-stock-progress-bar' );
	if ( ! selector.length ) {
		return;
	}

	selector.forEach(
		function( element, index ) {
			var number = element.getAttribute( 'data-number' ) || 0;

			element.style.width = number + '%';
		}
	);
}

var progressBarConfetti = function( progress_bar, percent ) {
	if ( woostify_woocommerce_general.shipping_threshold.enabled_shipping_threshold && woostify_woocommerce_general.shipping_threshold.enabled_shipping_threshold_effect ) {
		var curr_progress_bar = document.querySelectorAll( '.free-shipping-progress-bar' ),
		curr_percent          = 0;

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

			confettiSnowEffect( wConfetti, 5000 )

			setTimeout(
				function() {
					wConfetti.reset();
					document.querySelector( '.confetti-canvas' ).remove();
				},
				6000
			);
		}

		percent = curr_percent;
	}
}

var confettiSnowEffect = function( confetti, duration ) {
	var animationEnd = Date.now() + duration,
	skew             = 1,
	gravity          = 1,
	startVelocity = 0;

	function randomInRange(min, max) {
		return Math.random() * (max - min) + min;
	}

	( function frame() {
		var timeLeft = animationEnd - Date.now(),
		ticks        = Math.max( 200, 500 * (timeLeft / duration) );

		confetti(
			{
				particleCount: 1,
				startVelocity: startVelocity,
				ticks: ticks,
				origin: {
					x: Math.random(),
					// since particles fall down, skew start toward the top
					y: 0
				},
				colors: ["#EF2964"],
				shapes: ['circle', 'square'],
				gravity: gravity,
				scalar: randomInRange( 0.4, 1 ),
				drift: randomInRange( -0.4, 0.4 )
			}
		);
		// confetti(
		// 	{
		// 		particleCount: 1,
		// 		startVelocity: startVelocity,
		// 		ticks: ticks,
		// 		origin: {
		// 			x: Math.random(),
		// 			// since particles fall down, skew start toward the top
		// 			y: 0
		// 		},
		// 		colors: ["#00C09D"],
		// 		shapes: ['circle', 'square'],
		// 		gravity: gravity,
		// 		scalar: randomInRange( 0.4, 1 ),
		// 		drift: randomInRange( -0.4, 0.4 )
		// 	}
		// );
		confetti(
			{
				particleCount: 1,
				startVelocity: startVelocity,
				ticks: ticks,
				origin: {
					x: Math.random(),
					// since particles fall down, skew start toward the top
					y: 0
				},
				colors: ["#2D87B0"],
				shapes: ['circle', 'square'],
				gravity: gravity,
				scalar: randomInRange( 0.4, 1 ),
				drift: randomInRange( -0.4, 0.4 )
			}
		);

		if (timeLeft > 0) {
			requestAnimationFrame( frame );
		}
	}() );
	// ( function frame() {
	// 	var timeLeft = animationEnd - Date.now(),
	// 	ticks        = Math.max( 200, 500 * (timeLeft / duration) );
	// 	skew         = Math.max( 0.8, skew - 0.001 );
	// 	confetti(
	// 		{
	// 			particleCount: 1,
	// 			startVelocity: 0,
	// 			ticks: ticks,
	// 			origin: {
	// 				x: Math.random(),
	// 				// since particles fall down, skew start toward the top
	// 				y: 0
	// 			},
	// 			colors: ["#00C09D"],
	// 			shapes: ['circle'],
	// 			gravity: gravity,
	// 			scalar: randomInRange( 0.4, 1 ),
	// 			drift: randomInRange( -0.4, 0.4 )
	// 		}
	// 	);

	// 	if (timeLeft > 0) {
	// 		requestAnimationFrame( frame );
	// 	}
	// }() );
	// ( function frame() {
	// 	var timeLeft = animationEnd - Date.now(),
	// 	ticks        = Math.max( 200, 500 * (timeLeft / duration) );
	// 	skew         = Math.max( 0.8, skew - 0.001 );

	// 	confetti(
	// 		{
	// 			particleCount: 1,
	// 			startVelocity: 0,
	// 			ticks: ticks,
	// 			origin: {
	// 				x: Math.random(),
	// 				// since particles fall down, skew start toward the top
	// 				y: 0
	// 			},
	// 			colors: ["#2D87B0"],
	// 			shapes: ['circle'],
	// 			gravity: gravity,
	// 			scalar: randomInRange( 0.4, 1 ),
	// 			drift: randomInRange( -0.4, 0.4 )
	// 		}
	// 	);

	// 	if (timeLeft > 0) {
	// 		requestAnimationFrame( frame );
	// 	}
	// }() );
}

// Product quantity on mini cart.
var woostifyQuantityMiniCart = function() {
	var cartCountContainer = document.querySelector( '.shopping-bag-button .shop-cart-count, .boostify-count-product' );
	var infor              = document.querySelectorAll( '.mini-cart-product-infor' );

	if ( ! infor.length || ! cartCountContainer ) {
		if ( cartCountContainer ) {
			cartCountContainer.classList.add( 'hide' );
		}
		return;
	}

	cartCountContainer.classList.remove( 'hide' );

	infor.forEach(
		function( ele, i ) {
			var quantityBtn = ele.querySelectorAll( '.mini-cart-product-qty' ),
				input       = ele.querySelector( 'input.qty' ),
				cartItemKey = input.getAttribute( 'data-cart_item_key' ) || '',
				eventChange = new Event( 'change' ),
				qtyUpdate   = new Event( 'quantity_updated' );

			if ( ! quantityBtn.length || ! input ) {
				return;
			}

			for ( var i = 0, j = quantityBtn.length; i < j; i++ ) {
				quantityBtn[i].onclick = function() {
					var t        = this,
						current  = Number( input.value || 0 ),
						step     = Number( input.getAttribute( 'step' ) || 1 ),
						min      = Number( input.getAttribute( 'min' ) || 1 ),
						max      = Number( input.getAttribute( 'max' ) ),
						dataType = t.getAttribute( 'data-qty' );

					if ( current < 1 || isNaN( current ) ) {
						alert( woostify_woocommerce_general.qty_warning );
						return;
					}

					if ( 'minus' === dataType ) { // Minus button.
						if ( current <= min || ( current - step ) < min || current <= step ) {
							return;
						}

						input.value = ( current - step );
					} else if ( 'plus' === dataType ) { // Plus button.
						if ( max && ( current >= max || ( current + step ) >= max ) ) {
							return;
						}

						input.value = ( current + step );
					}

					// Trigger event.
					input.dispatchEvent( eventChange );
				}
			}

			// Check valid quantity.
			input.addEventListener(
				'change',
				function() {
					var inputVal = Number( input.value || 0 );

					// Valid quantity.
					if ( inputVal < 1 || isNaN( inputVal ) ) {
						alert( woostify_woocommerce_general.qty_warning );
						return;
					}

					// Request.
					var request = new Request(
						woostify_woocommerce_general.ajax_url,
						{
							method: 'POST',
							body: 'action=update_quantity_in_mini_cart&ajax_nonce=' + woostify_woocommerce_general.ajax_nonce + '&key=' + cartItemKey + '&qty=' + inputVal,
							credentials: 'same-origin',
							headers: new Headers(
								{
									'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
								}
							)
						}
					);

					// Add loading.
					document.documentElement.classList.add( 'mini-cart-updating' );

					// Fetch API.
					fetch( request )
						.then(
							function( res ) {
								if ( 200 !== res.status ) {
									alert( woostify_woocommerce_general.ajax_error );
									console.log( 'Status Code: ' + res.status );
									throw res;
								}

								return res.json();
							}
						).then(
							function( json ) {
								if ( ! json.success ) {
									return;
								}

								var data                     = json.data,
									totalPrice               = document.querySelector( '.cart-sidebar-content .woocommerce-mini-cart__total .woocommerce-Price-amount.amount' ),
									headerCartPriceContainer = document.querySelectorAll( '.woostify-header-total-price, .boostify-subtotal' ),
									productCount             = document.querySelectorAll( '.shop-cart-count, .boostify-count-product' ),
									shipping_threshold       = document.querySelectorAll( '.free-shipping-progress-bar' );

								// Update total price.
								if ( totalPrice ) {
									totalPrice.innerHTML = data.total_price;
									if ( headerCartPriceContainer.length ) {
										for ( var si = 0, sc = headerCartPriceContainer.length; si < sc; si++ ) {
											headerCartPriceContainer[si].innerHTML = data.total_price;
										}
									}
								}

								// Update product count.
								if ( productCount.length ) {
									for ( var c = 0, n = productCount.length; c < n; c++ ) {
										productCount[c].innerHTML = data.item;
									}
								}

								// Update free shipping threshold.
								if ( shipping_threshold.length && data.hasOwnProperty( 'free_shipping_threshold' ) ) {
									let prev_percent = shipping_threshold[0].getAttribute( 'data-progress' );
									for ( var fsti = 0, fstc = shipping_threshold.length; fsti < fstc; fsti++ ) {
										shipping_threshold[fsti].setAttribute( 'data-progress', data.free_shipping_threshold.percent );
										shipping_threshold[fsti].querySelector( '.progress-bar-message' ).innerHTML               = data.free_shipping_threshold.message;
										shipping_threshold[fsti].querySelector( '.progress-percent' ).innerHTML                   = data.free_shipping_threshold.percent + '%';
										shipping_threshold[fsti].querySelector( '.progress-bar-status' ).style.minWidth           = data.free_shipping_threshold.percent + '%';
										shipping_threshold[fsti].querySelector( '.progress-bar-status' ).style.transitionDuration = '.6s';
										if ( 100 <= parseInt( data.free_shipping_threshold.percent ) ) {
											shipping_threshold[fsti].querySelector( '.progress-bar-status' ).classList.add( 'success' );
										} else {
											shipping_threshold[fsti].querySelector( '.progress-bar-status' ).classList.remove( 'success' );
										}
									}

									if ( woostify_woocommerce_general.shipping_threshold.enabled_shipping_threshold && woostify_woocommerce_general.shipping_threshold.enabled_shipping_threshold_effect ) {
										if ( prev_percent < 100 && data.free_shipping_threshold.percent >= 100 ) {
											var confetti_canvas = document.createElement( 'canvas' );

											confetti_canvas.className = 'confetti-canvas';

											document.querySelector( '#shop-cart-sidebar' ).appendChild( confetti_canvas );

											var wConfetti = confetti.create(
												confetti_canvas,
												{
													resize: true,
												}
											);

											confettiSnowEffect( wConfetti, 5000 )

											setTimeout(
												function() {
													wConfetti.reset();
													document.querySelector( '.confetti-canvas' ).remove();
												},
												6000
											);
										}
									}
								}
							}
						).catch(
							function( err ) {
								console.log( err );
							}
						).finally(
							function() {
								document.documentElement.classList.remove( 'mini-cart-updating' );
								document.dispatchEvent( qtyUpdate );
							}
						);
				}
			);
		}
	);
}

var updateHeaderCartPrice = function () {
	var total                    = document.querySelector( '.cart-sidebar-content .woocommerce-mini-cart__total .woocommerce-Price-amount.amount' ),
		headerCartPriceContainer = document.querySelectorAll( '.woostify-header-total-price' ),
		currencySymbol           = document.querySelector( '.woostify-header-total-price .woocommerce-Price-currencySymbol, .boostify-subtotal .woocommerce-Price-currencySymbol' );
	if ( headerCartPriceContainer.length ) {
		for ( var si = 0, sc = headerCartPriceContainer.length; si < sc; si++ ) {
			if (total) {
				headerCartPriceContainer[si].innerHTML = '<span class="woocommerce-Price-amount amount">' + total.innerHTML + '</span>';
			} else {
				headerCartPriceContainer[si].innerHTML = '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' + currencySymbol.innerHTML + '</span>0</bdi></span>';
			}
		}
	}
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		if ( woostify_woocommerce_general.shipping_threshold.enabled_shipping_threshold && woostify_woocommerce_general.shipping_threshold.enabled_shipping_threshold_effect ) {
			var progress_bar = document.querySelectorAll( '.free-shipping-progress-bar' );
			var percent      = 0;
			if ( progress_bar.length ) {
				percent = parseInt( progress_bar[0].getAttribute( 'data-progress' ) );
			}
		}

		shoppingBag();
		woostifyQuantityMiniCart();

		window.addEventListener(
			'load',
			function() {
				woostifyStockQuantityProgressBar();
			}
		);

		jQuery( document.body ).on(
			'adding_to_cart',
			function() {
				eventCartSidebarOpen();
			}
		).on(
			'added_to_cart',
			function( e, fragments, cart_hash, $button ) {
				cartSidebarOpen();
				woostifyQuantityMiniCart();
				updateHeaderCartPrice();
				eventCartSidebarClose();
				closeAll();

				$button = typeof $button === 'undefined' ? false : $button;

				if ( $button ) {
					$button.removeClass( 'loading' );

					if ( fragments ) {
						$button.addClass( 'added' );
					}

					// View cart text.
					if ( fragments && ! wc_add_to_cart_params.is_cart && $button.parent().find( '.added_to_cart' ).length === 0 ) {
						var icon = get_svg_icon( 'shopping-cart-full' );
						$button.after(
							'<a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' + wc_add_to_cart_params.i18n_view_cart + '">' + icon + wc_add_to_cart_params.i18n_view_cart + '</a>'
						);
					}

					jQuery( document.body ).trigger( 'wc_cart_button_updated', [ $button ] );
				}
			}
		).on(
			'removed_from_cart', /* For mini cart */
			function() {
				woostifyQuantityMiniCart();
				updateHeaderCartPrice();
			}
		).on(
			'updated_cart_totals',
			function() {
				if ( 'function' === typeof( customQuantity ) ) {
					customQuantity();
				}
				woostifyQuantityMiniCart();
				updateHeaderCartPrice();
			}
		).on(
			'wc_fragments_loaded wc_fragments_refreshed',
			function() {
				woostifyQuantityMiniCart();
				updateHeaderCartPrice();

				progressBarConfetti( progress_bar, percent );
			}
		).on(
			'wc_cart_emptied', /* Reload Cart page if it's empty */
			function() {
				location.reload();
			}
		);
	}
);
