<?php
/**
 * Woostify Walker Menu Class
 *
 * @package  Woostify Pro
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woostify_Walker_Menu' ) ) {
	/**
	 * Woostify Walker Menu Class
	 */
	class Woostify_Walker_Menu extends Walker_Nav_Menu {
		/**
		 * @see Walker::start_el()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
			$indent      = $depth ? str_repeat( "\t", $depth ) : '';
			$class_names = '';
			$value       = '';

			// Classes name.
			$classes   = empty( $item->classes ) ? [] : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			if ( 'mega_menu' == $item->object ) {
				$this->megamenu_width = get_post_meta( $item->ID, 'woostify_mega_menu_item_width', true );
				$this->megamenu_width = '' != $this->megamenu_width ? $this->megamenu_width : 'content';
				$this->megamenu_icon  = get_post_meta( $item->ID, 'woostify_mega_menu_item_icon', true );

				$classes[] = 'menu-item-has-children';
				$classes[] = 'menu-item-has-mega-menu';
				$classes[] = 'has-mega-menu-' . $this->megamenu_width . '-width';
				$classes[] = woostify_is_elementor_page( $item->object_id ) ? 'mega-menu-elementor' : '';
			}
			$classes = array_filter( $classes );

			// Check this item has children.
			$has_child = false;
			if ( in_array( 'menu-item-has-children', $classes ) ) {
				$has_child = true;
			}

			// Join classes name.
			$class_names = join( ' ', apply_filters( 'woostify_mega_menu_css_class', $classes, $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			// Ids.
			$id = apply_filters( 'woostify_mega_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			// Start output.
			$output .= $indent . '<li' . $id . $value . $class_names . '>';

			// Attributes.
			$atts           = [];
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';
			$atts           = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value      = 'href' === $attr ? esc_url( $value ) : esc_attr( $value );
					$value      = 'mega_menu' == $item->object ? '#' : $value;
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			if ( ! empty( $item->attr_title ) ) {
				$item_output .= '<a' . $attributes . ' title="' . esc_attr( $item->attr_title ) . '">';
			} else {
				$item_output .= '<a' . $attributes . '>';
			}

			// Menu icon.
			if ( 'mega_menu' == $item->object && $this->megamenu_icon ) {
				$item_output .= '<span class="menu-item-icon ' . esc_attr( $this->megamenu_icon ) . '"></span>';
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			// Menu item text.
			$item_output .= $args->link_before . '<span class="menu-item-text">' . $title . '</span>' . $args->link_after;

			// Add arrow icon.
			if ( $has_child ) {
				$item_output .= '<span class="menu-item-arrow arrow-icon"></span>';
			}

			$item_output .= '</a>';

			// Start Mega menu content.
			if ( 'mega_menu' == $item->object && 0 == $depth ) {
				$item_output .= '<ul class="sub-menu sub-mega-menu">';
				$item_output .= '<div class="mega-menu-wrapper">';
				$mega_args   = [
					'p'                   => $item->object_id,
					'post_type'           => 'mega_menu',
					'post_status'         => 'publish',
					'posts_per_page'      => 1,
					'ignore_sticky_posts' => 1,
				];

				$query = new WP_Query( $mega_args );

				if ( $query->have_posts() ) {
					ob_start();
						while ( $query->have_posts() ) {
							$query->the_post();

							the_content();
						}
					$item_output .= ob_get_clean();
					$query->reset_postdata();
				}

				$item_output .= '</div>';
				$item_output .= '</ul>';
			} // End Mega menu content.

			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}
