<?php
/**
 * Update the query args for Archive page
 *
 * @package woostify
 */

defined( 'ABSPATH' ) || exit;

function move_outofstock_products_to_bottom( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ( is_shop() || is_product_taxonomy() ) &&  is_archive() ) {
		$meta_query = array(
			'relation' => 'OR',
			array(
				'key'     => '_stock_status',
				'value'   => 'instock',
				'compare' => '=',
			),
			array(
				'key'     => '_stock_status',
				'value'   => 'outofstock',
				'compare' => '=',
			),
		);
  
		$query->set( 'meta_query', $meta_query );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', '_stock_status' );
		$query->set( 'order', 'ASC' );

		// echo '<pre>';
		// var_dump( $query );
		// echo '</pre>';
	}
}

$options = woostify_options( false );
if( isset( $options['outofstock_to_bottom'] ) && ( $options['outofstock_to_bottom'] == 1 ) ) {
	add_action( 'pre_get_posts', 'move_outofstock_products_to_bottom' );
}
