<?php
/**
 * The template used for displaying page content in template-homepage.php
 *
 * @package woostify
 */

?>
<?php
$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="<?php woostify_homepage_content_styles(); ?>" data-featured-image="<?php echo esc_url( $featured_image ); ?>">
	<div class="container">
		<?php
		/**
		 * Functions hooked in to woostify_page add_action
		 *
		 * @hooked woostify_homepage_header      - 10
		 * @hooked woostify_page_content         - 20
		 */
		do_action( 'woostify_homepage' );
		?>
	</div>
</div><!-- #post-## -->
