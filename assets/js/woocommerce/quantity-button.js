/**
 * Quantity button
 *
 * @package woostify
 */

'use strict';

// Create Minus button.
var minusBtn = function() {
	var minusBtn = document.createElement( 'span' );
	var icon     = get_svg_icon( 'minus' );

	minusBtn.setAttribute( 'class', 'product-qty' );
	minusBtn.setAttribute( 'data-qty', 'minus' );
	minusBtn.innerHTML = icon;

	return minusBtn;
}

// Create Plus button.
var plusBtn = function() {
	var plusBtn = document.createElement( 'span' );
	var icon    = get_svg_icon( 'plus' );

	plusBtn.setAttribute( 'class', 'product-qty' );
	plusBtn.setAttribute( 'data-qty', 'plus' );
	plusBtn.innerHTML = icon;

	return plusBtn;
}

// Add Minus and Plus button on Product Quantity.
function customQuantity() {
	var quantity = document.querySelectorAll( '.quantity' );
	if ( ! quantity.length ) {
		return;
	}

	// Foreach.
	quantity.forEach(
		function( ele ) {
			// Input.
			var input = ele.querySelector( 'input.qty' );
			var body = document.querySelector('body');
			if ( ! input ) {
				return;
			}
			
			// Add style display none when input type hidden 
			if ( input.type == 'hidden' && body.classList.contains('single-product') ) {
				input.closest('.quantity').style.display = "none";
			}

			// Add class ajax-ready on first load.
			input.classList.add( 'ajax-ready' );

			// Append Minus button before Input.
			if ( ! ele.querySelector( '.product-qty[data-qty="minus"]' ) ) {
				ele.insertBefore( minusBtn(), input );
			}

			// Append Plus button after Input.
			if ( ! ele.querySelector( '.product-qty[data-qty="plus"]' ) ) {
				ele.appendChild( plusBtn() );
			}

			// Vars.
			var cart         = ele.closest( 'form.cart' ),
				buttons      = ele.querySelectorAll( '.product-qty' ),
				maxInput     = Number( input.getAttribute( 'max' ) || -1 ),
				currInputVal = input.value,
				eventChange  = new Event( 'change', { bubbles: true } );

			// Check valid quantity.
			input.addEventListener(
				'change',
				function() {
					var inputVal  = input.value,
						min       = Number( input.getAttribute( 'min' ) || 0 ),
						ajaxReady = function() {
							input.classList.remove( 'ajax-ready' );
						};

					if ( Number( inputVal ) < min || isNaN( inputVal ) || ( maxInput > 0 && ( Number( inputVal ) > maxInput ) ) ) {
						alert( woostify_woocommerce_general.qty_warning );
						input.value = currInputVal
						return;
					}

					// When quantity updated.
					input.classList.add( 'ajax-ready' );

					var loopWrapper = input.closest( '.product-loop-wrapper' );
					if ( loopWrapper ) {
						var ajaxAddToCartBtn = loopWrapper.querySelector( '.add_to_cart_button' );
						if ( ajaxAddToCartBtn ) {
							ajaxAddToCartBtn.setAttribute( 'data-quantity', inputVal );
						}
					}
				}
			);

			// Minus & Plus button click.
			for ( var i = 0, j = buttons.length; i < j; i++ ) {
				buttons[i].onclick = function() {
					// Variables.
					var t        = this,
						current  = Number( input.value || 0 ),
						step     = Number( input.getAttribute( 'step' ) || 1 ),
						min      = Number( input.getAttribute( 'min' ) || 0 ),
						max      = Number( input.getAttribute( 'max' ) ),
						dataType = t.getAttribute( 'data-qty' );

					if ( 'minus' === dataType && current >= step ) { // Minus button.
						if ( current <= min || ( current - step ) < min ) {
							return;
						}

						input.value = Number( ( current - step ).toFixed( step.countDecimals() ) );
					} else if ( 'plus' === dataType ) { // Plus button.
						if ( max && ( current >= max || ( current + step ) > max ) ) {
							return;
						}

						input.value = Number( ( current + step ).toFixed( step.countDecimals() ) );
					}

					// Trigger event.
					input.dispatchEvent( eventChange );

					// Remove disable attribute on Update Cart button on Cart page.
					var updateCart = document.querySelector( '[name=\'update_cart\']' );
					if ( updateCart ) {
						updateCart.disabled = false;
					}
				}
			}
		}
	);
}

// Check valid quantity disable button add to cart
function woostifyValidAddToCartButton(ele) {

	var product = ele.closest( '.product' ); 
				
	if ( ! product ) {
		return;
	}
	
	var add_to_cart_button = product.querySelector( '.add_to_cart_button' );
	
	if ( ! add_to_cart_button ) {
		return;
	}

	let product_id = add_to_cart_button.getAttribute('data-product_id');
	let product_qty = add_to_cart_button.getAttribute('data-quantity');
	let input = product.querySelector( 'input.qty' );
	let variation_input = product.querySelector( 'input.variation_id' );

	if ( null == input ) {
		input = product.querySelector( 'input[name="quantity"]' );
	}

	let inputValue = input ? Number( input.value.trim() ) : false;
	let variationValue = variation_input ? Number( variation_input.value.trim() ) : false;

	try {
		var cart_content = document.querySelector('div.cart-sidebar-content');
		var cart_item_count = 0;
		cart_content.querySelectorAll('.woocommerce-mini-cart-item').forEach(function(item, index) { 
			let remove_button = item.querySelector('a.remove_from_cart_button');
			let cart_product_id = remove_button.getAttribute('data-product_id')||0;
			if( cart_product_id == product_id ){
				let cart_qty_input = item.querySelector( 'input.qty' );
				if ( null == cart_qty_input ) {
					cart_qty_input = item.querySelector( 'input[name="quantity"]' );
				}
				cart_item_count = cart_qty_input ? Number( cart_qty_input.value.trim() ) : false;
			}

		});

		if (variationValue) {
			cart_item_count = 0;
			let variation_cart_item = cart_content.querySelector( 'input[data-variation_id="' + variationValue + '"]' );
			if (variation_cart_item) {
				cart_item_count = Number( variation_cart_item.value.trim() );
			}
		}
		var product_max_quantity = parseInt(input.getAttribute('max'));			
		var total_count          = cart_item_count + inputValue;
		
		if( product_max_quantity || 0 ){			
			if ( cart_item_count >= product_max_quantity || total_count > product_max_quantity ){
				add_to_cart_button.classList.add('disabled');
			}
			else if( cart_item_count >= product_max_quantity && total_count == product_max_quantity) {
				add_to_cart_button.classList.add('disabled');
			}
			else{
				add_to_cart_button.classList.remove('disabled');
			}
		}

	} catch( err ) {
		console.warn( err );
	}

}

function woostifyValidLoopItemAddToCartButton() {

	var quantity = document.querySelectorAll( '.quantity' );
	if (quantity && quantity.length != 0) {
		quantity.forEach(
			function( ele ) {
				var input = ele.querySelector( 'input.qty' );
				input.addEventListener('change',
					function() {
						woostifyValidAddToCartButton(ele);
					}
				);
				woostifyValidAddToCartButton(ele);
			}
		);
	}

	jQuery( document.body ).on('added_to_cart removed_from_cart',function() {
		var quantity = document.querySelectorAll( '.quantity' );
		if (quantity && quantity.length != 0) {
			quantity.forEach(
				function( ele ) {
					setTimeout(() => {
						woostifyValidAddToCartButton(ele);
					}, 25);
				}
			);
		}
	}).trigger('added_to_cart');

	jQuery( document.body ).on( 'wc_fragment_refresh updated_wc_div',function() {
		var quantity = document.querySelectorAll( '.quantity' );
		if (quantity && quantity.length != 0) {
			quantity.forEach(
				function( ele ) {
					setTimeout(() => {
						woostifyValidAddToCartButton(ele);
					}, 25);
				}
			);
		}
	});

}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		// For preview mode.
		if ( 'function' === typeof( onElementorLoaded ) ) {
			onElementorLoaded(
				function() {
					window.elementorFrontend.hooks.addAction(
						'frontend/element_ready/woostify-product-add-to-cart.default',
						function() {
							customQuantity();
						}
					);
				}
			);
		}

		// For frontend mode.
		customQuantity();
		woostifyValidLoopItemAddToCartButton();
	}
);
