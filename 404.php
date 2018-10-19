<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package woostify
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main">

			<div class="error-404 not-found">

				<div class="page-content">

					<header class="page-header">
						<h1 class="page-title entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'woostify' ); ?></h1>
					</header><!-- .page-header -->

					<p><?php esc_html_e( 'Nothing was found at this location. Try searching, or check out the links below.', 'woostify' ); ?></p>

					<?php
					echo '<section aria-label="' . esc_html__( 'Search', 'woostify' ) . '">';

					if ( woostify_is_woocommerce_activated() ) {
						the_widget( 'WC_Widget_Product_Search' );
					} else {
						get_search_form();
					}

					echo '</section>';
					?>

				</div>
			</div>

		</main>
	</div>

	<?php woostify_get_sidebar(); ?>

<?php
get_footer();
