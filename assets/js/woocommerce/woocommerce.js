/**
 * Woocommerce js
 *
 * @package woostify
 */

/*global woostify_woocommerce_general*/

'use strict';

function woostifyInfiniteScroll( addEventClick ) {
	let container      = document.querySelector( '.products' ),
	view_more_btn_wrap = document.querySelector( '.woostify-view-more' )

	if ( null == view_more_btn_wrap || 'undefined' === typeof( view_more_btn_wrap ) ) {
		return false;
	}
	let loading_status = view_more_btn_wrap.querySelector( '.woostify-loading-status' ),
	loading_type       = view_more_btn_wrap.getAttribute( 'data-loading_type' ),
	view_more_btn      = view_more_btn_wrap.querySelector( '.w-view-more-button' ),
	pagination         = document.querySelector( '.woocommerce-pagination ul.page-numbers' )

	let options = {
		path: function() {
			let curr_host_name = window.location.hostname,
			curr_protocol      = window.location.protocol,
			curr_path_name     = window.location.pathname,
			page               = this.loadCount + 2,
			curr_query         = window.location.search.substring( 1 ),
			regex              = /(page\/)[0-9]+/;

			if ( ! curr_path_name.match( regex )) {
				curr_path_name = curr_path_name + 'page/' + page;
			}
			let path = '' === curr_query ? curr_protocol + '//' + curr_host_name + curr_path_name + '/' : curr_protocol + '//' + curr_host_name + curr_path_name + '/?' + curr_query;
			return path;
		},
		append: '.product',
		history: false,
		hideNav: '.woocommerce-pagination',
		loadOnScroll: 'button' === loading_type ? false : true
	}

	if ( null == pagination || 'undefined' === typeof( pagination ) ) {
		if ( 'button' === loading_type ) {
			view_more_btn_wrap.style.display = 'none';
		} else {
			options.loadOnScroll = false;
		}
	} else {
		if ( 'button' === loading_type ) {
			view_more_btn_wrap.style.display = 'block';
			view_more_btn.style.display      = 'inline-flex';
		} else {
			options.loadOnScroll = true;
		}
	}

	let infScroll = new InfiniteScroll(
		container,
		options
	)

	infScroll.loadCount = 0;

	infScroll.on(
		'request',
		function( path, fetchPromise ) {
			if ( 'button' === loading_type ) {
				view_more_btn.classList.add( 'circle-loading' )
			} else {
				loading_status.style.display = 'inline-block'
			}
		}
	)

	infScroll.on(
		'load',
		function( body, path, fetchPromise ) {
			let all_page        = document.querySelectorAll( '.woocommerce-pagination .page-numbers .page-numbers:not(.next):not(.prev)' );
			let curr_load_count = this.loadCount + 1;

			if ( 'button' === loading_type ) {
				view_more_btn.classList.remove( 'circle-loading' );
			} else {
				loading_status.style.display = 'none'
			}

			if ( all_page.length ) {
				if ( curr_load_count >= all_page.length ) {
					if ( 'button' === loading_type ) {
						view_more_btn.style.display = 'none'
					} else {
						loading_status.style.display = 'none'
						infScroll.option(
							{
								loadOnScroll: false
							}
						)
					}
				} else {
					if ( 'button' !== loading_type ) {
						infScroll.option(
							{
								loadOnScroll: true
							}
						)
					}
				}
			} else {
				if ( 'button' === loading_type ) {
					view_more_btn.style.display = 'inline-flex'
				} else {
					loading_status.style.display = 'inline-block'
				}
			}
		}
	)

	infScroll.on(
		'last',
		function( body, path ) {
			if ( 'button' === loading_type ) {
				view_more_btn.style.display = 'none'
			} else {
				loading_status.style.display = 'none'
			}
		}
	)

	if ( 'button' === loading_type && addEventClick ) {
		view_more_btn.addEventListener(
			'click',
			function() {
				infScroll.loadNextPage()
			}
		)
	}
}

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
									productCount             = document.querySelectorAll( '.shop-cart-count, .boostify-count-product' );

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
		priceFormat              = '',
		headerCartPriceContainer = document.querySelectorAll( '.woostify-header-total-price' );

	if ( headerCartPriceContainer.length ) {
		switch ( woostify_woocommerce_general.currency_pos ) {
			case 'left':
				priceFormat = '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' + woostify_woocommerce_general.currency_symbol + '</span>0</bdi></span>';
				break;
			case 'right':
				priceFormat = '<span class="woocommerce-Price-amount amount"><bdi>0<span class="woocommerce-Price-currencySymbol">' + woostify_woocommerce_general.currency_symbol + '</span></bdi></span>';
				break;
			case 'left_space':
				priceFormat = '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' + woostify_woocommerce_general.currency_symbol + '</span>&nbsp;0</bdi></span>';
				break;
			case 'right_space':
				priceFormat = '<span class="woocommerce-Price-amount amount"><bdi>0&nbsp;<span class="woocommerce-Price-currencySymbol">' + woostify_woocommerce_general.currency_symbol + '</span></bdi></span>';
				break;

			default:
				break;
		}
		for ( var si = 0, sc = headerCartPriceContainer.length; si < sc; si++ ) {
			if (total) {
				headerCartPriceContainer[si].innerHTML = '<span class="woocommerce-Price-amount amount">' + total.innerHTML + '</span>';
			} else {
				headerCartPriceContainer[si].innerHTML = priceFormat;
			}
		}
	}
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		shoppingBag();
		woostifyQuantityMiniCart();

		window.addEventListener(
			'load',
			function() {
				woostifyStockQuantityProgressBar();
			}
		);

		woostifyInfiniteScroll( true );

		jQuery( document.body ).on(
			'adding_to_cart',
			function() {
				eventCartSidebarOpen();

				if ( ! document.body.classList.contains( 'disabled-sidebar-cart' ) ) {
					cartSidebarOpen();
				}
			}
		).on(
			'added_to_cart',
			function() {
				woostifyQuantityMiniCart();
				updateHeaderCartPrice();
				eventCartSidebarClose();
				closeAll();
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
			}
		).on(
			'wc_cart_emptied', /* Reload Cart page if it's empty */
			function() {
				location.reload();
			}
		);
	}
);
