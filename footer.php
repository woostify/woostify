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
?>
			<?php // #content. ?>
			</div>

		<footer id="colophon" class="site-footer">
			<div class="container">

				<?php
				/**
				 * Functions hooked in to woostify_footer action
				 *
				 * @hooked woostify_footer_widgets - 10
				 * @hooked woostify_credit         - 20
				 */
				do_action( 'woostify_footer' );
				?>

			</div><!-- .container -->
		</footer>

		<?php do_action( 'woostify_after_footer' ); ?>

	<?php // #view. ?>
	</div>

	<?php do_action( 'woostify_after_view' ); ?>

<?php // #page. ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
