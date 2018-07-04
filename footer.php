<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package woostify
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'woostify_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to woostify_footer action
			 *
			 * @hooked woostify_footer_widgets - 10
			 * @hooked woostify_credit         - 20
			 */
			do_action( 'woostify_footer' );
			?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'woostify_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
