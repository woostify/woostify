<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package woostify
 */

	do_action( 'woostify_content_bottom' );
	do_action( 'woostify_before_footer' );
	$container = woostify_site_container();
?>
			</div><?php // #content. ?>

		<footer id="colophon" class="site-footer">
			<div class="<?php echo esc_attr( $container ); ?>">

				<?php
				/**
				 * Functions hooked in to woostify_footer action
				 *
				 * @hooked woostify_footer_widgets - 10
				 * @hooked woostify_credit         - 20
				 */
				do_action( 'woostify_footer' );
				?>

			</div>
		</footer>

		<?php do_action( 'woostify_after_footer' ); ?>

	</div><?php // #view. ?>

	<?php do_action( 'woostify_after_view' ); ?>

</div><?php // #page. ?>

<?php wp_footer(); ?>
</body>
</html>
