<?php
/**
 * The header for our theme.
 *
 * @package woostify
 */

$wc         = Woostify_Woocommerce::get_instance();
$product_id = $wc->woostify_get_last_product_id();
$product    = wc_get_product( $product_id );
$gallery    = $wc->woostify_get_variation_gallery( $product );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php woostify_pingback(); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'woostify_theme_header' ); ?>
