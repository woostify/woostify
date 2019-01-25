<?php
/**
 * Footer template
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
<?php // #page. ?>
</div>

