<?php
/**
 * The header for our theme.
 *
 * @package woostify
 */

if ( class_exists( 'Woostify_Product_Filter' ) ) {
	global $wpdb;
	$table_name = Woostify_Product_Filter::init()->table_name();

	$sql    = "SELECT DISTINCT term_id, filter_label, filter_name, count FROM $table_name WHERE filter_name='product_cat' AND term_id <> 0";
	$output = $wpdb->get_results( $sql, ARRAY_A ); // phpcs:ignore

	var_dump( count( $output ) ); // phpcs:ignore
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head><?php wp_head(); ?></head>

	<body <?php body_class(); ?>>
		<?php
			wp_body_open();
			do_action( 'woostify_theme_header' );
