<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package woostify
 */

do_action( 'woostify_content_bottom' );
?>
			</div><?php // #content. ?>

		<?php
			do_action( 'woostify_before_footer' );
			do_action( 'woostify_site_footer' );
			do_action( 'woostify_after_footer' );
		?>

	</div><?php // #view. ?>

	<?php do_action( 'woostify_after_view' ); ?>

</div><?php // #page. ?>

<?php wp_footer(); ?>
</body>
</html>
