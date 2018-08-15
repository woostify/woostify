<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package woostify
 */

$woostify_customizer = new Woostify_Customizer();
$woostify_theme_mods = $woostify_customizer->get_woostify_theme_mods();
fw_print( $woostify_theme_mods );

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'woostify_before_site' ); ?>

	<div id="page" class="hfeed site">
		<?php do_action( 'woostify_before_header' ); ?>

		<header id="masthead" class="site-header" style="<?php woostify_header_styles(); ?>">
			<?php
				/**
				 * Functions hooked into woostify_header action
				 *
				 * @hooked woostify_header_container       - 0
				 * @hooked woostify_skip_links             - 5
				 * @hooked woostify_site_branding          - 20
				 * @hooked woostify_primary_navigation     - 30
				 * @hooked woostify_product_search         - 40
				 * @hooked woostify_header_cart            - 50
				 * @hooked woostify_header_container_close - 60
				 */
				do_action( 'woostify_header' );
			?>
		</header>

		<?php
			/**
			 * Functions hooked in to woostify_before_content
			 *
			 * @hooked woostify_header_widget_region - 10
			 * @hooked woocommerce_breadcrumb - 10
			 */
			do_action( 'woostify_before_content' );
		?>

		<div id="content" class="site-content" tabindex="-1">
			<div class="container">

				<?php
					do_action( 'woostify_content_top' );
