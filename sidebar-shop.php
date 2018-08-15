<?php
/**
 * The sidebar containing the shop page widget area.
 *
 * @package woostify
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
	return;
}

?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-shop' ); ?>
</div>
