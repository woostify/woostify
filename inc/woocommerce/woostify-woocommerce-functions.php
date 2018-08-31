<?php
/**
 * Woostify WooCommerce functions.
 *
 * @package woostify
 */

if ( ! function_exists( 'woostify_is_product_archive' ) ) {
	/**
	 * Checks if the current page is a product archive
	 *
	 * @return boolean
	 */
	function woostify_is_product_archive() {
		if ( woostify_is_woocommerce_activated() ) {
			if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'woostify_sidebar_class' ) ) {
	/**
	 * Get sidebar class
	 *
	 * @return string $sidebar Class name
	 */
	function woostify_sidebar_class() {
		$sidebar_default     = get_theme_mod( 'woostify_default_sidebar', $layout = is_rtl() ? 'left' : 'right' );
		$sidebar_blog        = get_theme_mod( 'woostify_blog_archive_sidebar', 'default' );
		$sidebar_blog_single = get_theme_mod( 'woostify_blog_single_sidebar', 'default' );
		$sidebar_shop        = get_theme_mod( 'woostify_shop_page_sidebar', 'default' );
		$sidebar_shop_single = get_theme_mod( 'woostify_product_page_sidebar', 'full' );
		$sidebar             = '';

		if ( ! is_active_sidebar( 'sidebar' ) && ! is_active_sidebar( 'sidebar-shop' ) ) {
			return $sidebar;
		}

		if ( true == woostify_is_product_archive() ) {
			// Product archive.
			if ( is_active_sidebar( 'sidebar-shop' ) ) {
				if ( 'default' != $sidebar_shop ) {
					$sidebar = $sidebar_shop . '-sidebar is-active-sidebar woocommerce-sidebar';
				} else {
					$sidebar = $sidebar_default . '-sidebar is-active-sidebar woocommerce-sidebar';
				}
			}
		} elseif ( is_singular( 'product' ) ) {
			// Product single.
			if ( is_active_sidebar( 'sidebar-shop' ) ) {
				if ( 'default' != $sidebar_shop_single ) {
					$sidebar = $sidebar_shop_single . '-sidebar is-active-sidebar woocommerce-sidebar';
				} else {
					$sidebar = $sidebar_default . '-sidebar is-active-sidebar woocommerce-sidebar';
				}
			}
		} elseif ( is_home() ) {
			// Blog page.
			if ( is_active_sidebar( 'sidebar' ) ) {
				if ( 'default' != $sidebar_blog ) {
					$sidebar = $sidebar_blog . '-sidebar is-active-sidebar';
				} else {
					$sidebar = $sidebar_default . '-sidebar is-active-sidebar';
				}
			}
		} elseif ( is_singular( 'post' ) ) {
			// Blog single.
			if ( is_active_sidebar( 'sidebar' ) ) {
				if ( 'default' != $sidebar_blog_single ) {
					$sidebar = $sidebar_blog_single . '-sidebar is-active-sidebar';
				} else {
					$sidebar = $sidebar_default . '-sidebar is-active-sidebar';
				}
			}
			// Other page.
		} else {
			if ( is_active_sidebar( 'sidebar' ) ) {
				$sidebar = $sidebar_default . '-sidebar is-active-sidebar';
			}
		}

		return $sidebar;
	}
}

if ( ! function_exists( 'woostify_get_sidebar' ) ) {
	/**
	 * Display woostify sidebar
	 *
	 * @uses get_sidebar()
	 * @since 1.0
	 */
	function woostify_get_sidebar() {
		$sidebar = woostify_sidebar_class();

		if ( false !== strpos( $sidebar, 'full-sidebar' ) || empty( $sidebar ) ) {
			return;
		}

		if ( false !== strpos( $sidebar, 'woocommerce' ) || true == woostify_is_product_archive() || is_singular( 'product' ) ) {
			get_sidebar( 'shop' );
		} else {
			get_sidebar();
		}
	}
}

if ( ! function_exists( 'woostify_product_check_in' ) ) {
	/**
	 * Check product already in cart || product quantity in cart
	 *
	 * @param      int     $pid          Product id.
	 * @param      boolean $in_cart      Check in cart.
	 * @param      boolean $qty_in_cart  Get product quantity.
	 */
	function woostify_product_check_in( $pid = null, $in_cart = true, $qty_in_cart = false ) {
		global $woocommerce;
		$_cart    = $woocommerce->cart->get_cart();
		$_product = wc_get_product( $pid );
		$variable = $_product->is_type( 'variable' );

		// Check product already in cart. Return boolean.
		if ( true == $in_cart ) {
			foreach ( $_cart as $key ) {
				$product_id = $key['product_id'];

				if ( $product_id == $pid ) {
					return true;
				}
			}

			return false;
		}

		// Get product quantity in cart. Return INT.
		if ( true == $qty_in_cart ) {
			if ( $variable ) {
				$arr = array();
				foreach ( $_cart as $key ) {
					if ( $key['product_id'] == $pid ) {
						$qty   = $key['quantity'];
						$arr[] = $qty;
					}
				}

				return array_sum( $arr );
			} else {
				foreach ( $_cart as $key ) {
					if ( $key['product_id'] == $pid ) {
						$qty = $key['quantity'];

						return $qty;
					}
				}
			}

			return 0;
		}
	}
}
