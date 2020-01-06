<?php
/**
 * The header for our theme.
 *
 * @package woostify
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
			do_action( 'woostify_theme_header' );
