<?php
/**
 * The header for our theme.
 *
 * @package woostify
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'woostify_before_site' ); ?>

	<div id="page" class="hfeed site">

		<?php do_action( 'woostify_before_view' ); ?>
		<div id="view">
			
			<?php do_action( 'woostify_before_topbar' ); ?>
			<div class="topbar">
				<?php do_action( 'woostify_topbar' ); ?>
			</div>

			<?php do_action( 'woostify_before_header' ); ?>
			<header id="masthead" <?php woostify_header_class(); ?>>
				<?php
					/**
					 * Functions hooked into woostify_header action
					 *
					 * @hooked woostify_container_open     - 0
					 * @hooked woostify_skip_links         - 5
					 * @hooked woostify_site_branding      - 20
					 * @hooked woostify_primary_navigation - 30
					 * @hooked woostify_header_action      - 50
					 * @hooked woostify_container_close    - 200
					 */
					do_action( 'woostify_header' );
				?>
			</header>

			<?php
				/**
				 * Functions hooked in to woostify_before_content
				 *
				 * @hooked woostify_header_widget_region - 10
				 * @hooked woostify_breadcrumb           - 20
				 */
				do_action( 'woostify_before_content' );
			?>

			<div id="content" class="site-content" tabindex="-1">
				<?php
					do_action( 'woostify_content_top' );
