<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package woostify
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}

$sidebar = get_theme_mod( 'woostify_layout', 'right' );

?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar' ); ?>
</div>