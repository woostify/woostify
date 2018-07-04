<?php
/**
 * Template used to display post content.
 *
 * @package woostify
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to woostify_loop_post action.
	 *
	 * @hooked woostify_post_header          - 10
	 * @hooked woostify_post_meta            - 20
	 * @hooked woostify_post_content         - 30
	 */
	do_action( 'woostify_loop_post' );
	?>

</article><!-- #post-## -->
