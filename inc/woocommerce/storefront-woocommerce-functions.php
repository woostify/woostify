<?php
/**
 * Woostify WooCommerce functions.
 *
 * @package woostify
 */

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
