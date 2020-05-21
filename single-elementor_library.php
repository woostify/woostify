<?php // phpcs:ignore
/**
 * Elementor Library Single
 *
 * @package woostify
 */

?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		wp_body_open();

		// Do not display content on single Woo Builder post type.
		if ( ! woostify_is_elementor_editor() && is_singular( 'woo_builder' ) ) {
			return;
		}

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				the_content();
			}
		}

		wp_footer();
		?>
	</body>
</html>
