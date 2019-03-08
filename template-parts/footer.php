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
			/**
			 * Functions hooked in to woostify_site_footer
			 *
			 * @hooked woostify_site_footer   - 10
			 */
			do_action( 'woostify_site_footer' );
		?>
	</div><?php // #view. ?>
<?php // #page. ?>
</div>
