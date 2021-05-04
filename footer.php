<?php
/**
 * The template for displaying the footer.
 *
 * @package woostify
 */

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	do_action( 'woostify_theme_footer' );
}

wp_footer();
?>

</body>
</html>
