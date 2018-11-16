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
		$options = woostify_options( false );

		if ( false == $options['blog_single_related_post'] ) {
			return;
		}

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
	 * @return     string real_time relative time
	 */
	function woostify_relative_time( $type = 'comment' ) {
		$time      = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
		$real_time = human_time_diff( $time( 'U' ), current_time( 'timestamp' ) ) . ' ' . esc_html__( 'ago', 'woostify' );

		return apply_filters( 'woostify_real_time_comment', $real_time );
	}
}

if ( ! function_exists( 'woostify_comment' ) ) {
	/**
	 * Woostify comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
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
							<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'woostify' ); ?></em>
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
	 */
	function woostify_footer_widgets() {

		// Default values.
		$option        = woostify_options( false );
		$footer_column = (int) $option['footer_column'];

		if ( 0 == $footer_column ) {
			return;
		}

		if ( is_active_sidebar( 'footer' ) ) {
			?>

		<div class="footer-widget footer-widget-col-<?php echo esc_attr( $footer_column ); ?>">
			<?php dynamic_sidebar( 'footer' ); ?>
		</div>
			<?php
		} elseif ( is_user_logged_in() ) {
			?>
		<div class="footer-widget footer-widget-col-<?php echo esc_attr( $footer_column ); ?>">
			<div class="widget widget_text default-widget">
				<h2 class="widgettitle"><?php esc_html_e( 'Footer Widget', 'woostify' ); ?></h2>
				<div class="textwidget">
					<p>
						<?php
						printf(
							/* translators: 1: admin URL */
							__( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets / Footer Widget</strong></a> and dragging widgets into this widget area.', 'woostify' ),
							esc_url( admin_url( 'widgets.php' ) )
						);  // WPCS: XSS ok.
						?>
					</p>
				</div>
			</div>

			<div class="widget widget_text default-widget">
				<h2 class="widgettitle"><?php esc_html_e( 'Footer Widget', 'woostify' ); ?></h2>
				<div class="textwidget">
					<p>
						<?php
						printf(
							/* translators: 1: admin URL */
							__( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets / Footer Widget</strong></a> and dragging widgets into this widget area.', 'woostify' ),
							esc_url( admin_url( 'widgets.php' ) )
						);  // WPCS: XSS ok.
						?>
					</p>
				</div>
			</div>

			<div class="widget widget_text default-widget">
				<h2 class="widgettitle"><?php esc_html_e( 'Footer Widget', 'woostify' ); ?></h2>
				<div class="textwidget">
					<p>
						<?php
						printf(
							/* translators: 1: admin URL */
							__( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets / Footer Widget</strong></a> and dragging widgets into this widget area.', 'woostify' ),
							esc_url( admin_url( 'widgets.php' ) )
						);  // WPCS: XSS ok.
						?>
					</p>
				</div>
			</div>
		</div>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_footer_custom_text' ) ) {
	/**
	 * Footer custom text
	 *
	 * @return string $content Footer custom text
	 */
	function woostify_footer_custom_text() {
		$content = '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . ' ';

		if ( apply_filters( 'woostify_credit_info', true ) ) {

			if ( apply_filters( 'woostify_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
				$content .= get_the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
			}

			$content .= __( 'All rights reserved. Designed &amp; developed by woostify&trade;', 'woostify' );
		}

		return $content;
	}
}

if ( ! function_exists( 'woostify_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @return void
	 */
	function woostify_credit() {
		$options = woostify_options( false );
		if ( '' == $options['footer_custom_text'] && ! has_nav_menu( 'footer_menu' ) ) {
			return;
		}
		?>
		<div class="site-info">
			<?php if ( '' != $options['footer_custom_text'] ) { ?>
				<div class="site-infor-col">
					<?php echo wp_kses_post( $options['footer_custom_text'] ); ?>
				</div>
			<?php } ?>

			<?php
			if ( has_nav_menu( 'footer_menu' ) ) {
				echo '<div class="site-infor-col">';
					wp_nav_menu( array(
						'theme_location' => 'footer_menu',
						'menu_class'     => 'woostify-footer-menu',
						'container'      => '',
						'depth'          => 1,
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
	 * @return void
	 */
	function woostify_site_branding() {
		// Default values.
		$class           = '';
		$mobile_logo_src = '';
		$options         = woostify_options( false );

		if ( '' != $options['logo_mobile'] ) {
			$mobile_logo_src = $options['logo_mobile'];
			$class           = 'has-custom-mobile-logo';
		}

		?>
		<div class="site-branding <?php echo esc_attr( $class ); ?>">
			<?php
			woostify_site_title_or_logo();

			// Custom mobile logo.
			if ( '' != $mobile_logo_src ) {
				$mobile_logo_id  = attachment_url_to_postid( $mobile_logo_src );
				$mobile_logo_alt = woostify_image_alt( $mobile_logo_id, __( 'Woostify mobile logo', 'woostify' ) );
				?>
					<a class="custom-mobile-logo-url" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
						<img class="custom-mobile-logo" src="<?php echo esc_url( $mobile_logo_src ); ?>" alt="<?php echo esc_attr( $mobile_logo_alt ); ?>" itemprop="logo">
					</a>
				<?php
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_replace_logo_attr' ) ) {
	/**
	 * Replace header logo.
	 *
	 * @param array  $attr Image.
	 * @param object $attachment Image obj.
	 * @param sting  $size Size name.
	 *
	 * @return array Image attr.
	 */
	function woostify_replace_logo_attr( $attr, $attachment, $size ) {

		$custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id == $attachment->ID ) {

			$attr['alt'] = woostify_image_alt( $custom_logo_id, __( 'Woostify logo', 'woostify' ) );

			$attach_data = array();
			if ( ! is_customize_preview() ) {
				$attach_data = wp_get_attachment_image_src( $attachment->ID, 'full' );

				if ( isset( $attach_data[0] ) ) {
					$attr['src'] = $attach_data[0];
				}
			}

			$file_type      = wp_check_filetype( $attr['src'] );
			$file_extension = $file_type['ext'];

			if ( 'svg' == $file_extension ) {
				$attr['width']  = '100%';
				$attr['height'] = '100%';
				$attr['class']  = 'woostify-logo-svg';
			}

			// Retina logo.
			$retina_logo = get_option( 'woostify_retina_logo' );

			$attr['srcset'] = '';

			if ( '' != $retina_logo ) {
				$cutom_logo     = wp_get_attachment_image_src( $custom_logo_id, 'full' );
				$cutom_logo_url = $cutom_logo[0];
				$attr['alt']    = woostify_image_alt( $custom_logo_id, __( 'Woostify retina logo', 'woostify' ) );

				// Replace logo src on IE.
				if ( 'ie' == woostify_browser_detection() ) {
					$attr['src'] = $retina_logo;
				}

				$attr['srcset'] = $cutom_logo_url . ' 1x, ' . $retina_logo . ' 2x';

			}
		}

		return apply_filters( 'woostify_replace_logo_attr', $attr );
	}
	add_filter( 'wp_get_attachment_image_attributes', 'woostify_replace_logo_attr', 10, 3 );
}

if ( ! function_exists( 'woostify_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function woostify_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			// Image logo.
			$logo = get_custom_logo();
			$html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
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
	 */
	function woostify_primary_navigation() {
		// Customize disable primary menu.
		$options        = woostify_options( false );
		$disable_menu   = false == $options['header_primary_menu'] ? true : false;

		// Metabox disable primary menu.
		$page_id        = woostify_get_page_id();
		$metabox_menu   = get_post_meta( $page_id, 'site-header-primary-menu', true );

		if ( ! empty( $metabox_menu ) && 'disabled' == $metabox_menu ) {
			$disable_menu = true;
		}

		// Return.
		if ( true == $disable_menu ) {
			return;
		}
		?>
		<div class="site-navigation">
			<?php do_action( 'woostify_before_main_nav' ); ?>

			<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'woostify' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_class'     => 'primary-navigation',
							'container'      => '',
						)
					);
				} else {
					?>
					<a class="add-menu" href="<?php echo esc_url( get_admin_url() . 'nav-menus.php' ); ?>"><?php esc_html_e( 'Add Menu', 'woostify' ); ?></a>	
				<?php } ?>
			</nav>

			<?php do_action( 'woostify_after_main_nav' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_skip_links' ) ) {
	/**
	 * Skip links
	 */
	function woostify_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'woostify' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'woostify' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'woostify_page_header' ) ) {
	/**
	 * Display the page header
	 */
	function woostify_page_header() {
		// Not showing page title with edited by Elementor.
		if ( true == woostify_is_elementor_page() ) {
			return;
		}

		if ( is_page() ) {
			$page_id            = woostify_get_page_id();
			$metabox_page_title = get_post_meta( $page_id, 'site-post-title', true );
			$disable_page_title = false;

			if ( ! empty( $metabox_page_title ) && 'disabled' == $metabox_page_title ) {
				$disable_page_title = true;
			}

			// Return.
			if ( true == $disable_page_title ) {
				return;
			}
		}
		?>
		<header class="entry-header page-header">
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
	 */
	function woostify_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			$options = woostify_options( false );

			if ( ! is_single() ) {
				if ( true == $options['blog_list_feature_image'] ) {
					?>
					<div class="post-cover-image">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php the_post_thumbnail( $size ); ?>
						</a>
					</div>
					<?php
				}
			} else {
				if ( true == $options['blog_single_feature_image'] ) {
					?>
					<div class="post-cover-image">
						<?php the_post_thumbnail( $size ); ?>
					</div>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'woostify_post_title' ) ) {
	/**
	 * Display the post header with a link to the single post
	 */
	function woostify_post_title() {
		$options            = woostify_options( false );

		// Metabox disable footer.
		$page_id            = woostify_get_page_id();
		$metabox_post_title = get_post_meta( $page_id, 'site-post-title', true );
		$disable_post_title = false;

		if ( ! empty( $metabox_post_title ) && 'disabled' == $metabox_post_title ) {
			$disable_post_title = true;
		}

		if ( is_single() ) {
			if ( true == $disable_post_title ) {
				return;
			}

			if ( true == $options['blog_single_title'] ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			}
		} else {
			if ( true == $options['blog_list_title'] ) {
				the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			}
		}
	}
}

if ( ! function_exists( 'woostify_post_header_wrapper_close' ) ) {
	/**
	 * Post header wrapper close
	 *
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
	 */
	function woostify_post_meta() {
		$options = woostify_options( false );
		?>
		<aside class="entry-meta">
			<?php
			if ( 'post' == get_post_type() ) {
				// Publish date meta.
				if (
					! is_single() && true == $options['blog_list_publish_date'] ||
					is_single() && true == $options['blog_single_publish_date']
				) {
					woostify_posted_on();
				}

				// Author meta.
				if (
					! is_single() && true == $options['blog_list_author'] ||
					is_single() && true == $options['blog_single_author']
				) {
					?>
					<span class="post-meta-item vcard author">
						<?php
							echo '<span class="label">' . esc_html( __( 'by', 'woostify' ) ) . '</span>';
							echo sprintf(
								' <a href="%1$s" class="url fn" rel="author">%2$s</a>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								get_the_author()
							);
						?>
					</span>
					<?php
				}

				// Category meta.
				if (
					! is_single() && true == $options['blog_list_category'] ||
					is_single() && true == $options['blog_single_category']
				) {
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'woostify' ) );

					if ( $categories_list ) :
						?>
							<span class="post-meta-item cat-links">
								<?php
									echo '<span class="label sr-only">' . esc_html( __( 'Posted in', 'woostify' ) ) . '</span>';
									echo wp_kses_post( $categories_list );
								?>
							</span>
						<?php
					endif; // End if categories.
				}
			} // End if 'post' == get_post_type().

			// Comment meta.
			if ( ! is_single() && true == $options['blog_list_comment'] || is_single() && true == $options['blog_single_comment'] ) {
				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
					?>
					<span class="post-meta-item comments-link">
						<?php
							comments_popup_link(
								__( 'No comments yet', 'woostify' ),
								__( '1 Comment', 'woostify' ),
								__( '% Comments', 'woostify' )
							);
						?>
					</span>
					<?php
				}
			}
			?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'woostify_show_excerpt' ) ) {
	/**
	 * Show the blog excerpts or full posts
	 *
	 * @return bool $show_excerpt
	 */
	function woostify_show_excerpt() {
		global $post;

		// Check to see if the more tag is being used.
		$more_tag = apply_filters( 'woostify_more_tag', strpos( $post->post_content, '<!--more-->' ) );

		// Check the post format.
		$format = false != get_post_format() ? get_post_format() : 'standard';

		// If our post format isn't standard, show the full content.
		$show_excerpt = 'standard' != $format ? false : true;

		// If the more tag is found, show the full content.
		$show_excerpt = $more_tag ? false : $show_excerpt;

		// If we're on a search results page, show the excerpt.
		$show_excerpt = is_search() ? true : $show_excerpt;

		// Return our value.
		return apply_filters( 'woostify_show_excerpt', $show_excerpt );
	}
}

if ( ! function_exists( 'woostify_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 */
	function woostify_post_content() {

		do_action( 'woostify_post_content_before' );

		if ( woostify_show_excerpt() && ! is_single() ) {
			?>
				<div class="entry-summary" itemprop="text">
					<?php the_excerpt(); ?>
				</div>
			<?php
		} else {
			?>
			<div class="entry-content" itemprop="text">
				<?php
				the_content();

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
}

if ( ! function_exists( 'woostify_post_read_more_button' ) ) {
	/**
	 * Display read more button
	 */
	function woostify_post_read_more_button() {
		if ( ! is_single() ) {
			?>
			<p class="post-read-more">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php esc_html_e( 'Read more', 'woostify' ); ?>
				</a>
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
			apply_filters( 'woostify_single_post_posted_on_html', '<span class="post-meta-item posted-on">' . $posted_on . '</span>', $posted_on ), array(
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

if ( ! function_exists( 'woostify_container_open' ) ) {
	/**
	 * Woostify container open
	 */
	function woostify_container_open() {
		if ( is_singular( 'product' ) ) {
			return;
		}

		$container = woostify_site_container();
		echo '<div class="' . esc_attr( $container ) . '">';
	}
}

if ( ! function_exists( 'woostify_container_close' ) ) {
	/**
	 * Woostify container close
	 */
	function woostify_container_close() {
		if ( is_singular( 'product' ) ) {
			return;
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_is_product_archive' ) ) {
	/**
	 * Checks if the current page is a product archive
	 *
	 * @return boolean
	 */
	function woostify_is_product_archive() {
		if ( ! class_exists( 'woocommerce' ) || ! woostify_is_woocommerce_activated() ) {
			return false;
		}

		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'woostify_search' ) ) {
	/**
	 * Display Product Search
	 *
	 * @uses  woostify_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function woostify_search() {
		$options = woostify_options( false );
		if ( false == $options['header_search_form'] ) {
			return;
		}
		?>
		<div class="site-search">
			<?php
			if ( false == $options['header_search_only_product'] ) {
				get_search_form();
			} else {
				if ( woostify_is_woocommerce_activated() ) {
					the_widget( 'WC_Widget_Product_Search', 'title=' );
				}
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_product_check_in' ) ) {
	/**
	 * Check product already in cart || product quantity in cart
	 *
	 * @param      int     $pid          Product id.
	 * @param      boolean $in_cart      Check in cart.
	 * @param      boolean $qty_in_cart  Get product quantity.
	 */
	function woostify_product_check_in( $pid = null, $in_cart = true, $qty_in_cart = false ) {
		global $woocommerce;
		$_cart    = $woocommerce->cart->get_cart();
		$_product = wc_get_product( $pid );
		$variable = $_product->is_type( 'variable' );

		// Check product already in cart. Return boolean.
		if ( true == $in_cart ) {
			foreach ( $_cart as $key ) {
				$product_id = $key['product_id'];

				if ( $product_id == $pid ) {
					return true;
				}
			}

			return false;
		}

		// Get product quantity in cart. Return INT.
		if ( true == $qty_in_cart ) {
			if ( $variable ) {
				$arr = array();
				foreach ( $_cart as $key ) {
					if ( $key['product_id'] == $pid ) {
						$qty   = $key['quantity'];
						$arr[] = $qty;
					}
				}

				return array_sum( $arr );
			} else {
				foreach ( $_cart as $key ) {
					if ( $key['product_id'] == $pid ) {
						$qty = $key['quantity'];

						return $qty;
					}
				}
			}

			return 0;
		}
	}
}

if ( ! function_exists( 'woostify_get_sidebar_id' ) ) {
	/**
	 * Get sidebar by id
	 *
	 * @param      string $sidebar_id      The sidebar id.
	 * @param      string $sidebar_layout  The sidebar layout: left, right, full.
	 * @param      string $sidebar_default The sidebar layout default.
	 * @param      string $wc_sidebar      The woocommerce sidebar.
	 */
	function woostify_get_sidebar_id( $sidebar_id, $sidebar_layout, $sidebar_default, $wc_sidebar = false ) {

		$wc_sidebar_class      = true == $wc_sidebar ? ' woocommerce-sidebar' : '';
		$sidebar_layout_class  = 'full' == $sidebar_layout ? 'no-sidebar' : $sidebar_layout . '-sidebar has-sidebar' . $wc_sidebar_class;
		$sidebar_default_class = 'full' == $sidebar_default ? 'no-sidebar' : $sidebar_default . '-sidebar has-sidebar default-sidebar' . $wc_sidebar_class;

		if ( 'default' != $sidebar_layout ) {
			$sidebar = $sidebar_layout_class;
		} else {
			$sidebar = $sidebar_default_class;
		}

		return $sidebar;
	}
}

if ( ! function_exists( 'woostify_sidebar_class' ) ) {
	/**
	 * Get sidebar class
	 *
	 * @return string $sidebar Class name
	 */
	function woostify_sidebar_class() {
		// All theme options.
		$options         = woostify_options( false );

		// Metabox options.
		$page_id         = woostify_get_page_id();
		$metabox_sidebar = get_post_meta( $page_id, 'site-sidebar', true );

		if ( empty( $metabox_sidebar ) ) {
			$metabox_sidebar = 'default';
		}

		// Customize options.
		$sidebar             = '';
		$sidebar_default     = $options['sidebar_default'];
		$sidebar_blog        = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_blog'];
		$sidebar_blog_single = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_blog_single'];
		$sidebar_shop        = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_shop'];
		$sidebar_shop_single = 'default' != $metabox_sidebar ? $metabox_sidebar : $options['sidebar_shop_single'];

		if ( true == woostify_is_elementor_page() ) {
			return $sidebar;
		}

		if ( true == woostify_is_product_archive() ) {
			// Product archive.
			$sidebar = woostify_get_sidebar_id( 'sidebar-shop', $sidebar_shop, $sidebar_default );
		} elseif ( is_singular( 'product' ) ) {
			// Product single.
			$sidebar = woostify_get_sidebar_id( 'sidebar-shop', $sidebar_shop_single, $sidebar_default );
		} elseif ( class_exists( 'woocommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
			// Cart, checkout and account page.
			$sidebar = '';
		} elseif ( is_singular( 'post' ) ) {
			// Blog page.
			$sidebar = woostify_get_sidebar_id( 'sidebar', $sidebar_blog_single, $sidebar_default );
		} else {
			// Other page.
			$sidebar = woostify_get_sidebar_id( 'sidebar', $sidebar_blog, $sidebar_default );
		}

		return $sidebar;
	}
}

if ( ! function_exists( 'woostify_get_sidebar' ) ) {
	/**
	 * Display woostify sidebar
	 *
	 * @uses get_sidebar()
	 */
	function woostify_get_sidebar() {
		$sidebar = woostify_sidebar_class();

		if ( false !== strpos( $sidebar, 'no-sidebar' ) || '' == $sidebar || true == woostify_is_elementor_page() ) {
			return;
		}

		if ( false !== strpos( $sidebar, 'woocommerce-sidebar' ) || true == woostify_is_product_archive() || is_singular( 'product' ) ) {
			get_sidebar( 'shop' );
		} else {
			get_sidebar();
		}
	}
}

if ( ! function_exists( 'woostify_mobile_menu_toggle_btn' ) ) {
	/**
	 * Mobile menu toggle button
	 */
	function woostify_mobile_menu_toggle_btn() {
		$menu_toggle_icon  = apply_filters( 'woostify_header_menu_toggle_icon', 'woostify-icon-bar' );
		$woostify_icon_bar = apply_filters( 'woostify_header_icon_bar', '<span></span>' );
		?>
			<span class="menu-toggle-btn <?php echo esc_attr( $menu_toggle_icon ); ?>">
				<?php echo wp_kses_post( $woostify_icon_bar ); ?>
			</span>
		<?php
	}
}

if ( ! function_exists( 'woostify_overlay' ) ) {
	/**
	 * Woostify overlay
	 */
	function woostify_overlay() {
		echo '<div id="woostify-overlay"></div>';
	}
}

if ( ! function_exists( 'woostify_sidebar_menu_open' ) ) {
	/**
	 * Sidebar menu open
	 */
	function woostify_sidebar_menu_open() {
		echo '<div class="sidebar-menu">';
	}
}

if ( ! function_exists( 'woostify_sidebar_menu_close' ) ) {
	/**
	 * Sidebar menu close
	 */
	function woostify_sidebar_menu_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_header_action' ) ) {
	/**
	 * Display header action
	 *
	 * @uses  woostify_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function woostify_header_action() {
		if ( woostify_is_woocommerce_activated() ) {
			$options = woostify_options( false );

			if ( false == $options['header_shop_cart_icon'] && false == $options['header_account_icon'] ) {
				return;
			}

			global $woocommerce;
			$page_account_id = get_option( 'woocommerce_myaccount_page_id' );
			$logout_url      = wp_logout_url( get_permalink( $page_account_id ) );

			if ( 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) ) {
				$logout_url = str_replace( 'http:', 'https:', $logout_url );
			}

			$count = $woocommerce->cart->cart_contents_count;

			$my_account_icon = apply_filters( 'woostify_header_my_account_icon', 'ti-user' );
			$shop_bag_icon   = apply_filters( 'woostify_header_shop_bag_icon', 'ti-bag' );
			?>
			<div class="site-tools">
				<?php // My account icon. ?>
				<?php if ( true == $options['header_account_icon'] ) { ?>
					<?php do_action( 'woostify_site_tools_before_my_account' ); ?>

					<div class="my-account">
						<a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>" class="tools-icon my-account <?php echo esc_attr( $my_account_icon ); ?>"></a>

						<ul>
							<?php if ( ! is_user_logged_in() ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>" class="text-center"><?php esc_html_e( 'Login / Register', 'woostify' ); ?></a></li>
							<?php else : ?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>"><?php esc_html_e( 'Dashboard', 'woostify' ); ?></a>
								</li>
								<li><a href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Logout', 'woostify' ); ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</div>

					<?php do_action( 'woostify_site_tools_after_my_account' ); ?>
				<?php } ?>
				
				<?php // Shopping cart icon. ?>
				<?php if ( true == $options['header_shop_cart_icon'] ) { ?>
					<?php do_action( 'woostify_site_tools_before_shop_bag' ); ?>

					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="tools-icon shopping-bag-button <?php echo esc_attr( $shop_bag_icon ); ?>">
						<span class="shop-cart-count"><?php echo esc_html( $count ); ?></span>
					</a>

					<?php do_action( 'woostify_site_tools_after_shop_bag' ); ?>
				<?php } ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_sidebar_menu_action' ) ) {
	/**
	 * Sidebar menu action
	 */
	function woostify_sidebar_menu_action() {
		if ( woostify_is_woocommerce_activated() ) {

			global $woocommerce;
			$page_account_id = get_option( 'woocommerce_myaccount_page_id' );
			$logout_url      = wp_logout_url( get_permalink( $page_account_id ) );

			if ( 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) ) {
				$logout_url = str_replace( 'http:', 'https:', $logout_url );
			}
			?>
			<div class="sidebar-menu-bottom">
				<?php do_action( 'woostify_sidebar_account_before' ); ?>

				<ul class="sidebar-account">
					<?php do_action( 'woostify_sidebar_account_top' ); ?>

					<?php if ( ! is_user_logged_in() ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>"><?php esc_html_e( 'Login / Register', 'woostify' ); ?></a></li>
					<?php else : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $page_account_id ) ); ?>"><?php esc_html_e( 'Dashboard', 'woostify' ); ?></a>
						</li>
						<li><a href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Logout', 'woostify' ); ?></a>
						</li>
					<?php endif; ?>

					<?php do_action( 'woostify_sidebar_account_bottom' ); ?>
				</ul>

				<?php do_action( 'woostify_sidebar_account_after' ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_get_page_id' ) ) {
	/**
	 * Get page id
	 *
	 * @return int $page_id Page id
	 */
	function woostify_get_page_id() {
		$page_id = get_queried_object_id();

		if ( class_exists( 'woocommerce' ) && is_shop() ) {
			$page_id = get_option( 'woocommerce_shop_page_id' );
		}

		return $page_id;
	}
}

if ( ! function_exists( 'woostify_site_container' ) ) {

	/**
	 * Woostify site container
	 *
	 * @return $container The site container
	 */
	function woostify_site_container() {
		$options = woostify_options( false );
		$container = 'woostify-container';

		// Metabox.
		$page_id                = woostify_get_page_id();
		$metabox_container      = get_post_meta( $page_id, 'site-container', true );

		if ( empty( $metabox_container ) ) {
			$metabox_container = 'default';
		}

		if ( 'default' != $metabox_container ) {
			if ( 'full-width' == $metabox_container ) {
				$container = 'woostify-container container-fluid';
			}
		} else {
			if ( 'full-width' == $options['default_container'] ) {
				$container = 'woostify-container container-fluid';
			}
		}

		return $container;
	}
}

if ( ! function_exists( 'woostify_site_footer' ) ) {

	/**
	 * Woostify footer
	 */
	function woostify_site_footer() {
		$container = woostify_site_container();

		// Customize disable footer.
		$options        = woostify_options( false );
		$disable_footer = true == $options['footer_disable'] ? true : false;

		// Metabox disable footer.
		$page_id        = woostify_get_page_id();
		$metabox_footer = get_post_meta( $page_id, 'site-footer', true );

		if ( ! empty( $metabox_footer ) && 'disabled' == $metabox_footer ) {
			$disable_footer = true;
		}

		// Return.
		if ( true == $disable_footer ) {
			return;
		}

		?>
			<footer id="colophon" class="site-footer">
				<div class="<?php echo esc_attr( $container ); ?>">

					<?php
					/**
					 * Functions hooked in to woostify_footer action
					 *
					 * @hooked woostify_footer_widgets - 10
					 * @hooked woostify_credit         - 20
					 */
					do_action( 'woostify_footer_content' );
					?>

				</div>
			</footer>
		<?php
	}
}

if ( ! function_exists( 'woostify_topbar_left' ) ) {
	/**
	 * Topbar left content
	 */
	function woostify_topbar_left() {
		$options = woostify_options( false );
		?>
		<div class="topbar-item topbar-left"><?php echo wp_kses_post( $options['topbar_left'] ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'woostify_topbar_center' ) ) {
	/**
	 * Topbar center content
	 */
	function woostify_topbar_center() {
		$options = woostify_options( false );
		?>
		<div class="topbar-item topbar-center"><?php echo wp_kses_post( $options['topbar_center'] ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'woostify_topbar_right' ) ) {
	/**
	 * Topbar right content
	 */
	function woostify_topbar_right() {
		$options = woostify_options( false );
		?>
		<div class="topbar-item topbar-right"><?php echo wp_kses_post( $options['topbar_right'] ); ?></div>
		<?php
	}
}
