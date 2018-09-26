<?php
/**
 * Woostify Get CSS
 *
 * @package  woostify
 */

/**
 * The Woostify Get CSS class
 */
class Woostify_Get_CSS {
	/**
	 * Wp enqueue scripts
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
	}

	/**
	 * Get Customizer css.
	 *
	 * @see get_woostify_theme_mods()
	 * @return array $styles the css
	 */
	public function get_css() {
		$woostify_settings = wp_parse_args(
			get_option( 'woostify_settings', array() ),
			woostify_default_fonts()
		);

		$woostify_customizer = new Woostify_Customizer();
		$woostify_theme_mods = $woostify_customizer->get_woostify_theme_mods();

		// Remove outline select on Firefox.
		$styles = '
			select:-moz-focusring{
				text-shadow: 0 0 0 ' . $woostify_theme_mods['text_color'] . ';
			}
		';

		// Body css.
		$styles .= '
			body, select, button, input, textarea{
				font-family: ' . $woostify_settings['body_font_family'] . ';
				font-weight: ' . $woostify_settings['body_font_weight'] . ';
				line-height: ' . $woostify_settings['body_line_height'] . ';
				text-transform: ' . $woostify_settings['body_font_transform'] . ';
				font-size: ' . $woostify_settings['body_font_size'] . 'px;
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			.woocommerce-pagination a,
			.woocommerce-loop-product__title,
			.price del,
			.stars a,
			.woocommerce-review-link,
			.woocommerce-tabs .tabs li:not(.active) a,
			.woocommerce-cart-form__contents .product-remove a,
			.comment-body .comment-meta .comment-date,
			.woostify-breadcrumb a,
			.breadcrumb-separator{
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			.price_slider_wrapper .price_slider{
				background-color: ' . $woostify_theme_mods['text_color'] . ';
			}
		';

		// Primary menu css.
		$styles .= '
			@media ( min-width: 991px ) {
				.primary-navigation a{
					font-family: ' . $woostify_settings['menu_font_family'] . ';
					font-weight: ' . $woostify_settings['menu_font_weight'] . ';
					text-transform: ' . $woostify_settings['menu_font_transform'] . ';
					color: ' . $woostify_theme_mods['primary_menu_color'] . ';
				}
				
				.site-header .primary-navigation > li > a{
					font-size: ' . $woostify_settings['parent_menu_font_size'] . 'px;
					line-height: ' . $woostify_settings['parent_menu_line_height'] . 'px;
				}

				.site-header .primary-navigation .sub-menu a{
					line-height: ' . $woostify_settings['sub_menu_line_height'] . 'px;
					font-size: ' . $woostify_settings['sub_menu_font_size'] . 'px;
				}
			}
		';

		// Heading css.
		$styles .= '
			h1, h2, h3, h4, h5, h6{
				font-family: ' . $woostify_settings['heading_font_family'] . ';
				font-weight: ' . $woostify_settings['heading_font_weight'] . ';
				text-transform: ' . $woostify_settings['heading_font_transform'] . ';
				line-height: ' . $woostify_settings['heading_line_height'] . ';
				color: ' . $woostify_theme_mods['heading_color'] . ';
			}
			h1{
				font-size: ' . $woostify_settings['heading_h1_font_size'] . 'px;
			}
			h2{
				font-size: ' . $woostify_settings['heading_h2_font_size'] . 'px;
			}
			h3{
				font-size: ' . $woostify_settings['heading_h3_font_size'] . 'px;
			}
			h4{
				font-size: ' . $woostify_settings['heading_h4_font_size'] . 'px;
			}
			h5{
				font-size: ' . $woostify_settings['heading_h5_font_size'] . 'px;
			}
			h6{
				font-size: ' . $woostify_settings['heading_h6_font_size'] . 'px;
			}

			.product-loop-meta .price,
			.variations label,
			.woocommerce-review__author,
			[name="apply_coupon"],
			[name="update_cart"],
			.quantity .qty,
			.form-row label,
			.select2-container--default .select2-selection--single .select2-selection__rendered,
			.form-row .input-text:focus,
			.wc_payment_method label,
			.woocommerce-checkout-review-order-table thead th,
			.woocommerce-checkout-review-order-table .product-name,
			.woocommerce-thankyou-order-details strong,
			.woocommerce-table--order-details th,
			.woocommerce-table--order-details .amount,
			.wc-breadcrumb .woostify-breadcrumb,
			.sidebar-menu .primary-navigation .menu-item-has-children:after{
				color: ' . $woostify_theme_mods['heading_color'] . ';
			}

			.variations label{
				font-weight: ' . $woostify_settings['heading_font_weight'] . ';
			}
		';

		// Link color.
		$styles .= '
			a{
				color: ' . $woostify_theme_mods['accent_color'] . ';
			}
			a:hover{
				color: ' . $woostify_theme_mods['theme_color'] . ';
			}
		';

		// Button.
		$styles .= '
			.buttons .button,
			.button:not([name="apply_coupon"]):not([name="update_cart"]):not(a),
			.woocommerce-widget-layered-nav-dropdown__submit,
			.clear-cart-btn,
			.form-submit .submit,
			.checkout-button{
				background-color: ' . $woostify_theme_mods['button_background_color'] . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			.buttons .button:hover,
			.button:not([name="apply_coupon"]):not([name="update_cart"]):not(a):hover,
			.woocommerce-widget-layered-nav-dropdown__submit:hover,
			#commentform input[type="submit"]:hover,
			.clear-cart-btn:hover,
			.form-submit .submit:hover,
			.checkout-button:hover{
				background-color: ' . $woostify_theme_mods['button_hover_background_color'] . ';
				color: ' . $woostify_theme_mods['button_hover_text_color'] . ';
			}

			.select2-container--default .select2-results__option--highlighted[aria-selected],
			.select2-container--default .select2-results__option--highlighted[data-selected]{
				background-color: ' . $woostify_theme_mods['button_background_color'] . ' !important;
			}

			.clear-cart-btn{
				line-height: ' . $woostify_settings['body_line_height'] . ';
			}
		';

		// Theme color.
		$styles .= '
			.site-header .primary-navigation li.current-menu-item a,
			.site-header .primary-navigation > li.current-menu-ancestor > a,
			.site-header .primary-navigation > li.current-menu-parent > a,
			.site-header .primary-navigation > li.current_page_parent > a,
			.site-header .primary-navigation > li.current_page_ancestor > a,
			.woocommerce-pagination a:hover,
			.woocommerce-cart-form__contents .product-subtotal,
			.woocommerce-checkout-review-order-table .order-total,
			.woocommerce-table--order-details .product-name a{
				color: ' . $woostify_theme_mods['theme_color'] . ';
			}
			
			.onsale,
			.woocommerce-pagination li .page-numbers.current,
			.tagcloud a:hover,
			.price_slider_wrapper .ui-widget-header,
			.price_slider_wrapper .ui-slider-handle,
			.cart-sidebar-head .shop-cart-count,
			.shop-cart-count,
			.sidebar-menu .primary-navigation a:before{
				background-color: ' . $woostify_theme_mods['theme_color'] . ';
			}

			.single_add_to_cart_button:not(.disabled),
			.checkout-button{
				box-shadow: 0px 10px 40px 0px ' . woostify_hex_to_rgba( $woostify_theme_mods['theme_color'], 0.3 ) . ';
			}
		';

		// Spinner color.
		$styles .= '
			.circle-loading:before,
			.product_list_widget .remove_from_cart_button:focus:before,
			.updating-cart.ajax-single-add-to-cart .single_add_to_cart_button:before,
			.product-loop-meta .loading:before,
			.updating-cart #shop-cart-sidebar:before,
			#product-images:not(.tns-slider) .image-item:first-of-type:before,
			#product-thumbnail-images:not(.tns-slider) .thumbnail-item:first-of-type:before{
				border-top-color: ' . $woostify_theme_mods['theme_color'] . ';
			}
		';

		return apply_filters( 'woostify_customizer_css', $styles );
	}

	/**
	 * Add CSS in <head> for styles handled by the theme customizer
	 *
	 * @since 1.0
	 * @return void
	 */
	public function add_customizer_css() {
		wp_add_inline_style( 'woostify-style', $this->get_css() );
	}
}

return new Woostify_Get_CSS();
