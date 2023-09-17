<?php
/**
 * Update the query args for Archive page
 *
 * @package woostify
 */

defined( 'ABSPATH' ) || exit;

$options = woostify_options( false );
$hide_outstock = get_option( 'woocommerce_hide_out_of_stock_items' );
$outofstock_to_bottom = isset( $options['outofstock_to_bottom'] ) && ( $options['outofstock_to_bottom'] == 1 );
if(  $outofstock_to_bottom && $hide_outstock != 'yes' ) {
	add_action( 'posts_clauses', 'woostify_order_outofstock_products_to_bottom', 60, 2 );
}
function woostify_order_outofstock_products_to_bottom( $posts_clauses, $query ){

	if ( is_admin() || ! $query->is_main_query() ) {
		return $posts_clauses;
	}

	if ( ( is_shop() || is_product_taxonomy() ) &&  is_archive() ) {
		global $wpdb;
		$posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
		$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
		$posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
	}

	return $posts_clauses;
}
