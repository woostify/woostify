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
		add_action( 'wp_enqueue_scripts', array( $this, 'woostify_add_customizer_css' ), 130 );
	}

	/**
	 * Get Customizer css.
	 *
	 * @see get_woostify_theme_mods()
	 * @return array $styles the css
	 */
	public function woostify_get_css() {

		// Get all theme option value.
		$options = woostify_options( false );

		// GENERATE CSS.
		// Remove outline select on Firefox.
		$styles = '
			select:-moz-focusring{
				text-shadow: 0 0 0 ' . esc_attr( $options['text_color'] ) . ';
			}
		';

		// Logo width.
		$logo_width        = $options['logo_width'];
		$tablet_logo_width = $options['tablet_logo_width'];
		$mobile_logo_width = $options['mobile_logo_width'];
		if ( '' != $logo_width && $logo_width > 0 ) {
			$styles .= '
				@media ( min-width: 769px ) {
					.site-branding img{
						max-width: ' . esc_attr( $logo_width ) . 'px;
					}
				}
			';
		}

		if ( '' != $tablet_logo_width && $tablet_logo_width > 0 ) {
			$styles .= '
				@media ( min-width: 321px ) and ( max-width: 768px ) {
					.site-branding img{
						max-width: ' . esc_attr( $tablet_logo_width ) . 'px;
					}
				}
			';
		}

		if ( '' != $mobile_logo_width && $mobile_logo_width > 0 ) {
			$styles .= '
				@media ( max-width: 320px ) {
					.site-branding img{
						max-width: ' . esc_attr( $mobile_logo_width ) . 'px;
					}
				}
			';
		}

		// Topbar.
		$styles .= '
			.topbar{
				background-color: ' . esc_attr( $options['topbar_background_color'] ) . ';
				padding: ' . esc_attr( $options['topbar_space'] ) . 'px 0;
			}
			.topbar .topbar-item{
				color: ' . esc_attr( $options['topbar_text_color'] ) . ';
			}
		';

		// Body css.
		$styles .= '
			body, select, button, input, textarea{
				font-family: ' . esc_attr( $options['body_font_family'] ) . ';
				font-weight: ' . esc_attr( $options['body_font_weight'] ) . ';
				line-height: ' . esc_attr( $options['body_line_height'] ) . 'px;
				text-transform: ' . esc_attr( $options['body_font_transform'] ) . ';
				font-size: ' . esc_attr( $options['body_font_size'] ) . 'px;
				color: ' . esc_attr( $options['text_color'] ) . ';
			}
			
			.pagination a,
			.pagination a,
			.woocommerce-pagination a,
			.woocommerce-loop-product__category a,
			.woocommerce-loop-product__title,
			.price del,
			.stars a,
			.woocommerce-review-link,
			.woocommerce-tabs .tabs li:not(.active) a,
			.woocommerce-cart-form__contents .product-remove a,
			.comment-body .comment-meta .comment-date,
			.woostify-breadcrumb a,
			.breadcrumb-separator,
			#secondary .widget a,
			.has-woostify-text-color{
				color: ' . esc_attr( $options['text_color'] ) . ';
			}

			.price_slider_wrapper .price_slider,
			.has-woostify-text-background-color{
				background-color: ' . esc_attr( $options['text_color'] ) . ';
			}

			.product .woocommerce-loop-product__title,
			.has-woostify-text-font-size{
				font-size: ' . esc_attr( $options['body_font_size'] ) . 'px;
			}
		';

		// Primary menu css.
		$styles .= '
			@media ( min-width: 991px ) {
				.primary-navigation a{
					font-family: ' . esc_attr( $options['menu_font_family'] ) . ';
					font-weight: ' . esc_attr( $options['menu_font_weight'] ) . ';
					text-transform: ' . esc_attr( $options['menu_font_transform'] ) . ';
				}

				.site-header .primary-navigation > li > a{
					font-size: ' . esc_attr( $options['parent_menu_font_size'] ) . 'px;
					line-height: ' . esc_attr( $options['parent_menu_line_height'] ) . 'px;
					color: ' . esc_attr( $options['primary_menu_color'] ) . ';
				}

				.site-header .primary-navigation .sub-menu a{
					line-height: ' . esc_attr( $options['sub_menu_line_height'] ) . 'px;
					font-size: ' . esc_attr( $options['sub_menu_font_size'] ) . 'px;
					color: ' . esc_attr( $options['primary_sub_menu_color'] ) . ';
				}
			}
		';

		// Heading css.
		$styles .= '
			h1, h2, h3, h4, h5, h6{
				font-family: ' . esc_attr( $options['heading_font_family'] ) . ';
				font-weight: ' . esc_attr( $options['heading_font_weight'] ) . ';
				text-transform: ' . esc_attr( $options['heading_font_transform'] ) . ';
				line-height: ' . esc_attr( $options['heading_line_height'] ) . ';
				color: ' . esc_attr( $options['heading_color'] ) . ';
			}
			h1,
			.has-woostify-heading-1-font-size{
				font-size: ' . esc_attr( $options['heading_h1_font_size'] ) . 'px;
			}
			h2,
			.has-woostify-heading-2-font-size{
				font-size: ' . esc_attr( $options['heading_h2_font_size'] ) . 'px;
			}
			h3,
			.has-woostify-heading-3-font-size{
				font-size: ' . esc_attr( $options['heading_h3_font_size'] ) . 'px;
			}
			h4,
			.has-woostify-heading-4-font-size{
				font-size: ' . esc_attr( $options['heading_h4_font_size'] ) . 'px;
			}
			h5,
			.has-woostify-heading-5-font-size{
				font-size: ' . esc_attr( $options['heading_h5_font_size'] ) . 'px;
			}
			h6,
			.has-woostify-heading-6-font-size{
				font-size: ' . esc_attr( $options['heading_h6_font_size'] ) . 'px;
			}

			.product-loop-meta .price,
			.variations label,
			.woocommerce-review__author,
			.button[name="apply_coupon"],
			.button[name="apply_coupon"]:hover,
			.button[name="update_cart"],
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
			.sidebar-menu .primary-navigation .menu-item-has-children:after,
			.default-widget a strong:hover,
			.woostify-subscribe-form input,
			.woostify-shop-category .elementor-widget-image .widget-image-caption,
			.shop_table_responsive td:before,
			.dialog-search-title,
			.cart-collaterals th,
			.woocommerce-mini-cart__total strong,
			.woocommerce-form-login-toggle .woocommerce-info a,
			.has-woostify-heading-color{
				color: ' . esc_attr( $options['heading_color'] ) . ';
			}

			.has-woostify-heading-background-color{
				background-color: ' . esc_attr( $options['heading_color'] ) . ';
			}

			.variations label{
				font-weight: ' . esc_attr( $options['heading_font_weight'] ) . ';
			}
		';

		// Link color.
		$styles .= '
			.cart-sidebar-content .woocommerce-mini-cart__buttons a:not(.checkout),
			.site-tools .header-search-icon,
			.ps-layout-1 .product-loop-meta .button,
			a{
				color: ' . esc_attr( $options['accent_color'] ) . ';
			}

			.site-tools .header-search-icon:hover,
			a:hover,
			.ps-layout-1 .product-loop-meta .button:hover,
			#secondary .widget a:not(.tag-cloud-link):hover,
			.cart-sidebar-content .woocommerce-mini-cart__buttons a:not(.checkout):hover{
				color: ' . esc_attr( $options['theme_color'] ) . ';
			}
		';

		// Button.
		$styles .= '
			.button,
			.woocommerce-widget-layered-nav-dropdown__submit,
			.clear-cart-btn,
			.form-submit .submit,
			.elementor-button-wrapper .elementor-button,
			.has-woostify-contact-form input[type="submit"],
			#secondary .widget a.button{
				background-color: ' . esc_attr( $options['button_background_color'] ) . ';
				color: ' . esc_attr( $options['button_text_color'] ) . ';
			}

			.button:hover,
			.woocommerce-widget-layered-nav-dropdown__submit:hover,
			#commentform input[type="submit"]:hover,
			.clear-cart-btn:hover,
			.form-submit .submit:hover,
			#secondary .widget a.button:hover,
			.woostify-contact-form input[type="submit"]:hover{
				background-color: ' . esc_attr( $options['button_hover_background_color'] ) . ';
				color: ' . esc_attr( $options['button_hover_text_color'] ) . ';
			}

			.select2-container--default .select2-results__option--highlighted[aria-selected],
			.select2-container--default .select2-results__option--highlighted[data-selected]{
				background-color: ' . esc_attr( $options['button_background_color'] ) . ' !important;
			}

			@media ( max-width: 600px ) {
				.woocommerce-cart-form__contents [name="update_cart"],
				.woocommerce-cart-form__contents .coupon button,
				.checkout_coupon.woocommerce-form-coupon [name="apply_coupon"]{
					background-color: ' . esc_attr( $options['button_background_color'] ) . ';
				}
				.woocommerce-cart-form__contents [name="update_cart"],
				.woocommerce-cart-form__contents .coupon button,
				.checkout_coupon.woocommerce-form-coupon [name="apply_coupon"]{
					color: ' . esc_attr( $options['button_text_color'] ) . ';
				}
			}
		';

		// Theme color.
		$styles .= '
			.site-header .primary-navigation li.current-menu-item a,
			.site-header .primary-navigation > li.current-menu-ancestor > a,
			.site-header .primary-navigation > li.current-menu-parent > a,
			.site-header .primary-navigation > li.current_page_parent > a,
			.site-header .primary-navigation > li.current_page_ancestor > a,
			.woocommerce-cart-form__contents .product-subtotal,
			.woocommerce-checkout-review-order-table .order-total,
			.woocommerce-table--order-details .product-name a,
			.site-header .primary-navigation a:hover,
			.site-header .primary-navigation .menu-item-has-children:hover > a,
			.default-widget a strong,
			.woocommerce-mini-cart__total .amount,
			.woocommerce-form-login-toggle .woocommerce-info a:hover,
			.has-woostify-primary-color,
			.blog-layout-grid .site-main .post-read-more a,
			.site-footer a:hover,
			.woostify-simple-subsbrice-form input[type="submit"]{
				color: ' . esc_attr( $options['theme_color'] ) . ';
			}

			.onsale,
			.pagination li .page-numbers.current,
			.woocommerce-pagination li .page-numbers.current,
			.tagcloud a:hover,
			.price_slider_wrapper .ui-widget-header,
			.price_slider_wrapper .ui-slider-handle,
			.cart-sidebar-head .shop-cart-count,
			.shop-cart-count,
			.sidebar-menu .primary-navigation a:before,
			.woocommerce-message,
			.woocommerce-info,
			#scroll-to-top,
			.woocommerce-store-notice,
			.has-woostify-primary-background-color,
			.woostify-simple-subsbrice-form input[type="submit"]:hover,
			.woostify-simple-subsbrice-form:focus-within input[type="submit"]{
				background-color: ' . esc_attr( $options['theme_color'] ) . ';
			}

			.single_add_to_cart_button:not(.disabled),
			.checkout-button{
				box-shadow: 0px 10px 40px 0px ' . woostify_hex_to_rgba( esc_attr( $options['theme_color'] ), 0.3 ) . ';
			}
		';

		// Header.
		$styles .= '
			.site-header{
				background-color: ' . esc_attr( $options['header_background_color'] ) . ';
			}
		';

		// Footer.
		$styles .= '
			.site-footer{
				margin-top: ' . esc_attr( $options['footer_space'] ) . 'px;
			}

			.site-footer a{
				color: ' . esc_attr( $options['footer_link_color'] ) . ';
			}

			.site-footer{
				background-color: ' . esc_attr( $options['footer_background_color'] ) . ';
				color: ' . esc_attr( $options['footer_text_color'] ) . ';
			}

			.site-footer .widget-title,
			.woostify-footer-social-icon a{
				color: ' . esc_attr( $options['footer_heading_color'] ) . ';
			}

			.woostify-footer-social-icon a:hover{
				background-color: ' . esc_attr( $options['footer_heading_color'] ) . ';
			}

			.woostify-footer-social-icon a {
				border-color: ' . esc_attr( $options['footer_heading_color'] ) . ';
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
				border-top-color: ' . esc_attr( $options['theme_color'] ) . ';
			}
		';

		// Woocommerce.
		// Shop single.
		$styles .= '
			.single-product .content-top,
			.product-page-container{
				background-color:  ' . esc_attr( $options['shop_single_content_background'] ) . ';
			}
		';

		// 404.
		$error_404_bg = $options['error_404_image'];
		if ( $error_404_bg ) {
			$styles .= '
				.error404 .site-content{
					background-image: url(' . esc_url( $error_404_bg ) . ');
				}
			';
		}

		return apply_filters( 'woostify_customizer_css', $styles );
	}

	/**
	 * Add CSS in <head> for styles handled by the theme customizer
	 *
	 * @return void
	 */
	public function woostify_add_customizer_css() {
		wp_add_inline_style( 'woostify-style', $this->woostify_get_css() );
	}
}

return new Woostify_Get_CSS();
