<?php
/**
 * Woostify template functions.
 *
 * @package woostify
 */

if ( ! function_exists( 'woostify_post_related' ) ) {
	/**
	 * Display related post.
	 */
	function woostify_post_related() {
		$id = get_queried_object_id();
		$args = array(
			'post_type'           => 'post',
			'post__not_in'        => array( $id ),
			'posts_per_page'      => 3,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			?>
			<div class="related-box">
				<div class="row">
					<h3 class="related-title"><?php esc_html_e( 'Related Posts', 'woostify' ); ?></h3>
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();

						$post_id = get_the_ID();
						?>
						<div class="related-post col-md-4">
							<?php if ( has_post_thumbnail() ) { ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="entry-header">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							<?php } ?>

							<div class="posted-on"><?php echo get_the_date(); ?></div>
							<h2 class="entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h2>
							<a class="post-read-more" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'woostify' ); ?></a>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		endif;
	}
}

if ( ! function_exists( 'woostify_display_comments' ) ) {
	/**
	 * Woostify display comments
	 *
	 * @since  1.0
	 */
	function woostify_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( is_single() || is_page() ) {
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		}
	}
}

if ( ! function_exists( 'woostify_relative_time' ) ) {

	/**
	 * Display relative time for comment
	 *
	 * @param      string $type `comment` or `post`.
	 * @return     statement relative time
	 */
	function woostify_relative_time( $type = 'comment' ) {
		$time = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
		return human_time_diff( $time( 'U' ), current_time( 'timestamp' ) ) . ' ' . esc_html__( 'ago', 'woostify' );
	}
}

if ( ! function_exists( 'woostify_comment' ) ) {
	/**
	 * Woostify comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since 1.0
	 */
	function woostify_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>

		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
			<div class="comment-body">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 70 ); ?>
				</div>

				<?php if ( 'div' != $args['style'] ) : ?>
				<div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
				<?php endif; ?>

					<div class="comment-meta commentmetadata">
						<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'woostify' ), get_comment_author_link() ); ?>
						
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'woostify' ); ?></em>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-date">
							<?php echo esc_html( woostify_relative_time() ); ?>
							<?php echo '<time datetime="' . esc_attr( get_comment_date( 'c' ) ) . '" class="sr-only">' . esc_html( get_comment_date() ) . '</time>'; ?>
						</a>
					</div>

					<div class="comment-text">
					  <?php comment_text(); ?>
					</div>

					<div class="reply">
						<?php
							comment_reply_link(
								array_merge(
									$args, array(
										'add_below' => $add_below,
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);
						?>
						<?php edit_comment_link( __( 'Edit', 'woostify' ), '  ', '' ); ?>
					</div>

				<?php if ( 'div' != $args['style'] ) : ?>
				</div>
				<?php endif; ?>
			</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions.
	 *
	 * @since  1.0
	 * @return void
	 */
	function woostify_footer_widgets() {
		if ( is_active_sidebar( 'footer' ) ) :
			$footer_column = (int) get_theme_mod( 'woostify_footer_column', 4 );
			?>
			<div class="footer-widget footer-widget-col-<?php echo esc_attr( $footer_column ); ?>">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'woostify_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @since  1.0
	 * @return void
	 */
	function woostify_credit() {
		?>
		<div class="site-info">
			<div class="site-infor-col">
				<?php
				$content = '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . ' ';
				echo wp_kses_post( apply_filters( 'woostify_copyright_text', $content ) );

				if ( apply_filters( 'woostify_credit_info', true ) ) {

					if ( apply_filters( 'woostify_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
					}

					esc_html_e( 'All rights reserved. Designed &amp; developed by woostify&trade;', 'woostify' );
				}
				?>
			</div>

			<?php
			if ( has_nav_menu( 'footer_menu' ) ) {
				echo '<div class="site-infor-col">';
					wp_nav_menu( array(
						'theme_location' => 'footer_menu',
						'menu_class'     => 'woostify-footer-menu',
						'container'      => '',
					));
				echo '</div>';
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_header_widget_region' ) ) {
	/**
	 * Display header widget region
	 *
	 * @since  1.0
	 */
	function woostify_header_widget_region() {
		if ( is_active_sidebar( 'header-1' ) ) {
			?>
		<div class="header-widget-region" role="complementary">
			<div class="container">
				<?php dynamic_sidebar( 'header-1' ); ?>
			</div>
		</div>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0
	 * @return void
	 */
	function woostify_site_branding() {
		?>
		<div class="site-branding">
			<?php woostify_site_title_or_logo(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @since 2.1.0
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function woostify_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
		} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			// Copied from jetpack_the_site_logo() function.
			$logo    = site_logo()->logo;
			$logo_id = get_theme_mod( 'custom_logo' ); // Check for WP 4.5 Site Logo.
			$logo_id = $logo_id ? $logo_id : $logo['id']; // Use WP Core logo if present, otherwise use Jetpack's.
			$size    = site_logo()->theme_size();
			$html    = sprintf(
				'<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image(
					$logo_id,
					$size,
					false,
					array(
						'class'     => 'site-logo attachment-' . $size,
						'data-size' => $size,
						'itemprop'  => 'logo',
					)
				)
			);

			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
		} else {
			$tag = is_home() ? 'h1' : 'div';

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) . '>';
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html; // WPCS: XSS ok.
	}
}

if ( ! function_exists( 'woostify_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0
	 * @return void
	 */
	function woostify_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'woostify' ); ?>">

			<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
				<span><?php echo esc_attr( apply_filters( 'woostify_menu_toggle_text', __( 'Menu', 'woostify' ) ) ); ?></span>
			</button>

			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_class'      => 'primary-navigation',
						'container'       => '',
					)
				);
			}
			?>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'woostify_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @since  1.4.1
	 * @return void
	 */
	function woostify_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'woostify' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'woostify' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'woostify_homepage_header' ) ) {
	/**
	 * Display the page header without the featured image
	 *
	 * @since 1.0
	 */
	function woostify_homepage_header() {
		edit_post_link( __( 'Edit this section', 'woostify' ), '', '', '', 'button woostify-hero__button-edit' );
		?>
		<header class="entry-header">
			<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'woostify_page_header' ) ) {
	/**
	 * Display the page header
	 *
	 * @since 1.0
	 */
	function woostify_page_header() {
		?>
		<header class="entry-header">
			<?php
			woostify_post_thumbnail( 'full' );
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'woostify_page_content' ) ) {
	/**
	 * Display the post content
	 *
	 * @since 1.0
	 */
	function woostify_page_content() {
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'woostify' ),
				'after'  => '</div>',
			)
		);
	}
}

if ( ! function_exists( 'woostify_post_header_wrapper' ) ) {
	/**
	 * Post header wrapper
	 *
	 * @since 1.0
	 * @return void
	 */
	function woostify_post_header_wrapper() {
		?>
			<header class="entry-header">
		<?php
	}
}

if ( ! function_exists( 'woostify_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.0
	 */
	function woostify_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			?>
			<div class="post-cover-image">
				<?php if ( ! is_single() ) : ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php the_post_thumbnail( $size ); ?>
					</a>
					<?php
				else :
					the_post_thumbnail( $size );
				endif;
				?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_post_title' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0
	 */
	function woostify_post_title() {
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}
	}
}

if ( ! function_exists( 'woostify_post_header_wrapper_close' ) ) {
	/**
	 * Post header wrapper close
	 *
	 * @since 1.0
	 * @return void
	 */
	function woostify_post_header_wrapper_close() {
		?>
			</header>
		<?php
	}
}

if ( ! function_exists( 'woostify_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0
	 */
	function woostify_post_meta() {
		?>
		<aside class="entry-meta">
			<?php
			if ( 'post' == get_post_type() ) :
				woostify_posted_on();
				?>

				<span class="vcard author">
					<?php
						echo '<span class="label">' . esc_attr( __( 'by', 'woostify' ) ) . '</span>';
						echo sprintf(
							' <a href="%1$s" class="url fn" rel="author">%2$s</a>',
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							get_the_author()
						);
					?>
				</span>

				<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'woostify' ) );

				if ( $categories_list ) :
					?>
						<div class="cat-links sr-only">
							<?php
								echo '<div class="label">' . esc_attr( __( 'Posted in', 'woostify' ) ) . '</div>';
								echo wp_kses_post( $categories_list );
							?>
						</div>
					<?php
				endif; // End if categories.
			endif; // End if 'post' == get_post_type().
			?>

			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
				<span class="comments-link">
					<?php
						comments_popup_link(
							__( 'No comments yet', 'woostify' ),
							__( '1 Comment', 'woostify' ),
							__( '% Comments', 'woostify' )
						);
					?>
				</span>
			<?php endif; ?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'woostify_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0
	 */
	function woostify_post_content() {
		?>
		<div class="entry-content">
			<?php
			do_action( 'woostify_post_content_before' );

			if ( is_single() ) {
				the_content();
			} else {
				the_excerpt();
			}

			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . __( 'Pages:', 'woostify' ),
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				)
			);

			/**
			 * Functions hooked in to woostify_post_content_after action
			 *
			 * @hooked woostify_post_read_more_button - 5
			 */
			do_action( 'woostify_post_content_after' );
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_post_read_more_button' ) ) {
	/**
	 * Display read more button
	 */
	function woostify_post_read_more_button() {
		if ( ! is_single() ) {
			?>
			<p class="post-read-more">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read more', 'woostify' ); ?></a>
			</p>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_post_tags' ) ) {
	/**
	 * Display post tags
	 */
	function woostify_post_tags() {
		$tags_list = get_the_tag_list( '<span class="label">' . esc_html__( 'Tags', 'woostify' ) . '</span>: ', __( ', ', 'woostify' ) );
		if ( $tags_list ) :
			?>
			<footer class="entry-footer">
				<div class="tags-links">
					<?php echo wp_kses_post( $tags_list ); ?>
				</div>
			</footer>
			<?php
		endif;
	}
}

if ( ! function_exists( 'woostify_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function woostify_paging_nav() {
		global $wp_query;

		$args = array(
			'type'      => 'list',
			'next_text' => _x( 'Next', 'Next post', 'woostify' ),
			'prev_text' => _x( 'Prev', 'Previous post', 'woostify' ),
		);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'woostify_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function woostify_post_nav() {
		$args = array(
			'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'woostify' ) . ' </span>%title',
			'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'woostify' ) . ' </span>%title',
		);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'woostify_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function woostify_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<span class="sr-only">' . esc_html__( 'Posted on', 'woostify' ) . '</span>';
		$posted_on .= '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo wp_kses(
			apply_filters( 'woostify_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span>', $posted_on ), array(
				'span' => array(
					'class'  => array(),
				),
				'a'    => array(
					'href'  => array(),
					'title' => array(),
					'rel'   => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
			)
		);
	}
}

if ( ! function_exists( 'woostify_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0
	 * @return  void
	 */
	function woostify_homepage_content() {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'homepage' );

		} // end of the loop.
	}
}

if ( ! function_exists( 'woostify_header_container' ) ) {
	/**
	 * The header container
	 */
	function woostify_header_container() {
		echo '<div class="container">';
	}
}

if ( ! function_exists( 'woostify_header_container_close' ) ) {
	/**
	 * The header container close
	 */
	function woostify_header_container_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_content_open' ) ) {
	/**
	 * Woostify content open
	 */
	function woostify_content_open() {
		if ( ! is_singular( 'product' ) ) {
			echo '<div class="container">';
		}
	}
}

if ( ! function_exists( 'woostify_content_close' ) ) {
	/**
	 * Woostify content close
	 */
	function woostify_content_close() {
		if ( ! is_singular( 'product' ) ) {
			echo '</div>';
		}
	}
}
