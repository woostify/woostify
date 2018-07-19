<?php
/**
 * Template used to display post content on single pages.
 *
 * @package woostify
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'woostify_single_post_top' );

	/**
	 * Functions hooked into woostify_single_post add_action
	 *
	 * @hooked woostify_post_header          - 10
	 * @hooked woostify_post_meta            - 20
	 * @hooked woostify_post_content         - 30
	 */
	do_action( 'woostify_single_post' );

	/**
	 * Functions hooked in to woostify_single_post_bottom action
	 *
	 * @hooked woostify_post_nav         - 10
	 * @hooked woostify_display_comments - 20
	 */
	do_action( 'woostify_single_post_bottom' );
	?>

</article><!-- #post-## -->
