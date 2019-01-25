<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package woostify
 */

get_header();

if ( is_archive() || is_home() || is_search() ) {
	get_template_part( 'template-parts/archive' );
} elseif ( is_singular() ) {
	get_template_part( 'template-parts/single' );
} else {
	get_template_part( 'template-parts/404' );
}

get_footer();
