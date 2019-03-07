<?php
/**
 * Header template
 *
 * @package woostify
 */

do_action( 'woostify_before_site' );
?>

<div id="page" class="hfeed site">
	<?php
		/**
		 * Functions hooked in to woostify_before_view
		 *
		 * @hooked woostify_sidebar_menu_open   - 10
		 * @hooked woostify_search              - 20
		 * @hooked woostify_primary_navigation  - 30
		 * @hooked woostify_sidebar_menu_action - 40
		 * @hooked woostify_sidebar_menu_close  - 100
		 * @hooked woostify_dialog_search       - 110
		 */
		do_action( 'woostify_before_view' );
	?>

	<div id="view">
			<?php
				/**
				 * Functions hooked in to woostify_topbar_section
				 *
				 * @hooked woostify_topbar   - 10
				 */
				do_action( 'woostify_topbar_section' );

				/**
				 * Functions hooked in to woostify_header_section
				 *
				 * @hooked woostify_site_header   - 10
				 */
				do_action( 'woostify_header_section' );

				/**
				 * Functions hooked in to woostify_before_content
				 *
				 * @hooked woostify_page_header   - 10
				 */
				do_action( 'woostify_before_content' );
			?>

			<div id="content" class="site-content" tabindex="-1">
				<?php
					/**
					 * Functions hooked in to woostify_content_top
					 *
					 * @hooked woostify_container_open    - 10
					 * @hooked woostify_content_top_open  - 20
					 * @hooked woostify_shop_messages     - 30
					 * @hooked woostify_breadcrumb        - 30
					 * @hooked woostify_content_top_close - 40
					 */
					do_action( 'woostify_content_top' );
