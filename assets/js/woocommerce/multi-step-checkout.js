/**
 * Multi step checkout
 *
 * @package woostify
 */

'use strict';


// Email input validate.
var woostifyValidateEmail = function( email ) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test( String( email ).toLowerCase() );
}

// Expand order review on mobile.
var woostifyExpandOrderReview = function() {
	var checkout = document.querySelector( 'form.woocommerce-checkout' ),
		expand   = checkout ? checkout.querySelector( '.woostify-before-order-review' ) : false,
		state    = 1;

	if ( ! expand ) {
		return;
	}

	expand.onclick = function() {
		if ( 1 === state ) {
			checkout.classList.add( 'expanded-order-review' );
			state = 2;
		} else {
			checkout.classList.remove( 'expanded-order-review' );
			state = 1;
		}
	}
}

// Multi step checkout.
var woostifyMultiStepCheckout = function() {
	var box = document.querySelector( '.multi-step-checkout' );
	if ( ! box ) {
		return;
	}

	var items    = box.querySelectorAll( '.multi-step-item' ),
		checkout = document.querySelector( 'form.woocommerce-checkout' );

	if ( ! items.length || ! checkout ) {
		return;
	}

	var shipping       = checkout.querySelector( '#shipping_method' ), // Shipping methods.
		payment        = checkout.querySelector( '.wc_payment_methods' ), // Payment methods.
		termConditions = checkout.querySelector( '.woocommerce-terms-and-conditions-wrapper' ), // Terms and conditions.
		wrapperContent = checkout.querySelector( '.multi-step-checkout-wrapper' ), // Wrapper content.
		firstStep      = checkout.querySelector( '.multi-step-checkout-content[data-step="first"]' ), // First step.
		secondStep     = checkout.querySelector( '.multi-step-checkout-content[data-step="second"]' ), // Second step.
		lastStep       = checkout.querySelector( '.multi-step-checkout-content[data-step="last"]' ), // Last step.
		wrapperButton  = checkout.querySelector( '.multi-step-checkout-button-wrapper' ), // Wrapper button action.
		fields         = checkout.querySelectorAll( '.woocommerce-billing-fields__field-wrapper .validate-required' ), // Required input.
		buttonAction   = wrapperButton ? wrapperButton.querySelectorAll( '.multi-step-checkout-button' ) : []; // Back and continue action.

	// Button action.
	if ( buttonAction.length ) {
		buttonAction.forEach(
			function( button ) {
				button.onclick = function() {
					var buttonAction  = button.getAttribute( 'data-action' ),
						currentActive = box.querySelector( '.multi-step-item.active' ),
						prevStep      = currentActive ? currentActive.previousElementSibling : false,
						nextStep      = currentActive ? currentActive.nextElementSibling : false,
						// Term copy.
						termConditionsCopy = checkout.querySelector( '.multi-step-checkout-content .woocommerce-terms-and-conditions-wrapper' ),
						terms              = termConditionsCopy ? termConditionsCopy.querySelector( '.multi-step-checkout-content [name="terms"]' ) : false,
						termsChecked       = terms ? terms.checked : true;

					if ( 'back' == buttonAction && prevStep ) {
						prevStep.click();
					}

					if ( 'continue' == buttonAction && nextStep ) {
						nextStep.click();
					}

					if ( 'place_order' == buttonAction ) {
						if ( termConditionsCopy ) {
							if ( ! termsChecked ) {
								termConditionsCopy.classList.add( 'required-item' );
								return;
							} else {
								termConditionsCopy.classList.remove( 'required-item' );
							}
						}

						document.getElementById( 'place_order' ).click();
					}
				}
			}
		);
	}

	// Shipping methods.
	if ( shipping && secondStep ) {
		var methods         = shipping.querySelectorAll( '.shipping_method' ),
			shippingContent = '';

		if ( methods.length ) {
			shippingContent += '<div class="shipping-methods-modified">';
			methods.forEach(
				function( method, ix ) {
					var checked = 'checked' == method.getAttribute( 'checked' ) ? 'checked="checked"' : '',
						label   = method.nextElementSibling;

					shippingContent += '<div class="shipping-methods-modified-item">';
					shippingContent += '<label class="shipping-methods-modified-label" for="shipping-methods-index-' + ix + '"><input type="radio" ' + checked + ' name="ahihi-dongu-name" id="shipping-methods-index-' + ix + '" class="shipping-methods-modified-input"><span>' + label.innerHTML + '</span></label>';
					shippingContent += '</div>';
				}
			);
			shippingContent += '</div>';
		}

		secondStep.insertAdjacentHTML( 'beforeend', shippingContent );

		// Trigger shipping method change.
		var modifiedInput = document.querySelectorAll( '.shipping-methods-modified-input' );
		if ( modifiedInput.length ) {
			modifiedInput.forEach(
				function( _inputed, _i ) {
					_inputed.onclick = function() {
						var currentIndex = _i + 1,
							currentInput = document.querySelector( '#shipping_method li:nth-of-type(' + currentIndex + ') input[type="radio"]' );

						if ( currentInput ) {
							currentInput.click();
						}
					}
				}
			);
		}
	}

	// Payment methods.
	if ( payment && lastStep ) {
		var paymentContent = '<ul class="wc_payment_methods payment_methods methods">' + payment.innerHTML + '</ul>';
		lastStep.insertAdjacentHTML( 'beforeend', paymentContent );

		// Trigger payment method change.
		var paymentMethods = document.querySelectorAll( '.multi-step-checkout-content .wc_payment_methods [name="payment_method"]' );
		if ( paymentMethods.length ) {
			paymentMethods.forEach(
				function( pm ) {
					var placeOrder        = document.querySelector( '.multi-step-checkout-button[data-action="place_order"]' ),
						defaultButtonText = placeOrder.innerHTML;

					pm.onclick = function() {
						var buttonText = pm.getAttribute( 'data-order_button_text' );
						if ( ! placeOrder || ! buttonText ) {
							placeOrder.innerHTML = defaultButtonText;
							return;
						}

						placeOrder.innerHTML = buttonText;
					}
				}
			);
		}

		// Terms and conditions.
		if ( termConditions ) {
			var termsHtml = '<div class="woocommerce-terms-and-conditions-wrapper">' + termConditions.innerHTML + '</div>';
			lastStep.insertAdjacentHTML( 'beforeend', termsHtml );
		}
	}

	// Validate input.
	if ( fields.length ) {
		fields.forEach(
			function( field ) {
				var input = field.querySelector( '[name]' );
				if ( ! input ) {
					return;
				}

				input.addEventListener(
					'input',
					function() {
						var inputValue = input.value.trim();

						if ( inputValue ) {
							if ( 'email' == input.type ) {
								if ( woostifyValidateEmail( inputValue ) ) {
									field.classList.remove( 'field-required' );
								} else {
									field.classList.add( 'field-required' );
								}
							} else {
								field.classList.remove( 'field-required' );
							}
						} else {
							field.classList.add( 'field-required' );
						}
					}
				);
			}
		);
	}

	items.forEach(
		function( ele, i ) {
			ele.onclick = function() {
				// Check validate.
				var validate = false;
				if ( fields.length ) {
					fields.forEach(
						function( field ) {
							var input = field.querySelector( '[name]' );
							if ( ! input ) {
								return;
							}

							var inputValue = input.value.trim();

							if ( inputValue ) {
								if ( 'email' == input.type ) {
									if ( woostifyValidateEmail( inputValue ) ) {
										field.classList.remove( 'field-required' );
									} else {
										validate = true;
										field.classList.add( 'field-required' );
										return;
									}
								} else {
									field.classList.remove( 'field-required' );
								}
							} else {
								validate = true;
								field.classList.add( 'field-required' );
								return;
							}
						}
					);
				}

				if ( validate ) {
					return;
				}

				// Active for step.
				var sib = siblings( ele );
				ele.classList.add( 'active' );
				if ( sib.length ) {
					sib.forEach(
						function( e ) {
							e.classList.remove( 'active' );
						}
					);
				}

				var termConditionsCopy = checkout.querySelector( '.multi-step-checkout-content .woocommerce-terms-and-conditions-wrapper' ),
					terms              = termConditionsCopy ? termConditionsCopy.querySelector( '.multi-step-checkout-content [name="terms"]' ) : false;
				if ( terms ) {
					terms.addEventListener(
						'change',
						function() {
							if ( this.checked ) {
								termConditionsCopy.classList.remove( 'required-item' );
							}
						}
					);
				}

				// Get review information.
				var reviewBlock    = document.querySelectorAll( '.multi-step-review-information' ),
					_email         = document.getElementById( 'billing_email' ),
					_emailValue    = _email ? _email.value.trim() : '',
					_address1      = document.getElementById( 'billing_address_1' ),
					_address2      = document.getElementById( 'billing_address_2' ),
					_city          = document.getElementById( 'billing_city' ),
					_countryField  = document.getElementById( 'billing_country' ),
					_country       = _countryField ? _countryField.querySelector( '#billing_country option[' + _countryField.value + ']' ) : false,
					_shippingField = document.querySelector( '#shipping_method .shipping_method[checked="checked"]' ),
					_shippingID    = _shippingField ? _shippingField.id : false,
					_shipping      = _shippingID ? document.querySelector( '#shipping_method label[for="' + _shippingID + '"]' ) : false,
					_addressValue  = _address1 ? _address1.value.trim() : '';

					_addressValue += _address2 ? ' ' + _address2.value.trim() : '';
					_addressValue += _city ? ' ' + _city.value.trim() : '';
					_addressValue += _country ? ' ' + _country.value.trim() : '';

				if ( reviewBlock.length ) {
					reviewBlock.forEach(
						function( rb ) {
							var reviewEmail    = rb.querySelector( '.multi-step-review-information-row[data-type="email"] .review-information-content' ),
								reviewAddress  = rb.querySelector( '.multi-step-review-information-row[data-type="address"] .review-information-content' ),
								reviewShipping = rb.querySelector( '.multi-step-review-information-row[data-type="shipping"] .review-information-content' );

							if ( reviewEmail ) {
								reviewEmail.innerHTML = _emailValue;
							}

							if ( reviewAddress ) {
								reviewAddress.innerHTML = _addressValue;
							}

							if ( reviewShipping && _shipping ) {
								reviewShipping.innerHTML = _shipping.innerHTML;
							}
						}
					);
				}

				// Update review information.
				var updateReview = document.querySelectorAll( '.review-information-link' );
				if ( updateReview.length ) {
					updateReview.forEach(
						function( ur ) {
							ur.onclick = function() {
								var urParent = ur.closest( '.multi-step-review-information-row' ),
									urType   = urParent ? urParent.getAttribute( 'data-type' ) : false;

								if ( urType ) {
									switch ( urType ) {
										default:
										case 'email':
											items[0].click();
											if ( _email ) {
												_email.focus();
											}
											break;
										case 'address':
											items[0].click();
											if ( _address1 ) {
												_address1.focus();
											}
											break;
										case 'shipping':
											items[1].click();
											break;
									}
								}
							}
						}
					);
				}

				// Active for content.
				var index       = i + 1,
					currentItem = wrapperContent.querySelector( '.multi-step-checkout-content.active' ),
					nearlyItem  = wrapperContent.querySelector( '.multi-step-checkout-content:nth-of-type(' + index + ')' );

				if ( currentItem ) {
					currentItem.classList.remove( 'active' );
				}

				if ( nearlyItem ) {
					nearlyItem.classList.add( 'active' );
				}

				// Active for wrapper.
				var firstStep = 0 == i ? true : false,
					lastStep  = index == items.length ? true : false;

				wrapperContent.classList.remove( 'first', 'last' );
				if ( firstStep ) {
					wrapperContent.classList.add( 'first' );
				} else if ( lastStep ) {
					wrapperContent.classList.add( 'last' );
				}
			}
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		woostifyMultiStepCheckout();
		woostifyExpandOrderReview();
	}
);
