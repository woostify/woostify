<?php
/**
 * The template for displaying all single posts.
 *
 * @package woostify
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			do_action( 'woostify_single_post_before' );

			get_template_part( 'template-parts/content', 'single' );

			do_action( 'woostify_single_post_after' );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'woostify_sidebar' );
get_footer();
