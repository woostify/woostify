<?php

/**
 * Class Woostify_Get_CSS
 */
class Woostify_Get_CSS
{

    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
    }

    /**
     * Get all of the Woostify theme mods.
     *
     * @return array $woostify_theme_mods The Woostify Theme Mods.
     */
    public function get_woostify_theme_mods()
    {
        $woostify_theme_mods = array(
            'background_color' => woostify_get_content_background_color(),
            'accent_color' => get_theme_mod('woostify_accent_color'),
            'hero_heading_color' => get_theme_mod('woostify_hero_heading_color'),
            'hero_text_color' => get_theme_mod('woostify_hero_text_color'),
            'header_background_color' => get_theme_mod('woostify_header_background_color'),
            'header_link_color' => get_theme_mod('woostify_header_link_color'),
            'header_text_color' => get_theme_mod('woostify_header_text_color'),
            'footer_background_color' => get_theme_mod('woostify_footer_background_color'),
            'footer_link_color' => get_theme_mod('woostify_footer_link_color'),
            'footer_heading_color' => get_theme_mod('woostify_footer_heading_color'),
            'footer_text_color' => get_theme_mod('woostify_footer_text_color'),
            'text_color' => get_theme_mod('woostify_text_color'),
            'heading_color' => get_theme_mod('woostify_heading_color'),
            'button_background_color' => get_theme_mod('woostify_button_background_color'),
            'button_text_color' => get_theme_mod('woostify_button_text_color'),
            'button_alt_background_color' => get_theme_mod('woostify_button_alt_background_color'),
            'button_alt_text_color' => get_theme_mod('woostify_button_alt_text_color'),
        );

        return apply_filters('woostify_theme_mods', $woostify_theme_mods);
    }

    /**
     * Get Customizer css.
     *
     * @see get_woostify_theme_mods()
     * @return array $styles the css
     */
    public function get_css()
    {
        $woostify_settings = wp_parse_args(
            get_option('woostify_settings', array()),
            Woostify_Font_Helpers::woostify_get_default_fonts()
        );

        $woostify_theme_mods = $this->get_woostify_theme_mods();
        $brighten_factor = apply_filters('woostify_brighten_factor', 25);
        $darken_factor = apply_filters('woostify_darken_factor', -25);
        $body_font = $body_family = Woostify_Font_Helpers::woostify_get_font_family_css('font_body', 'woostify_settings', Woostify_Font_Helpers::woostify_get_default_fonts());
        //var_dump($body_font);

        $styles = '
			h2{
			    font-family: ' . $body_font . ';
			}
			.main-navigation ul li a,
			.site-title a,
			ul.menu li a,
			.site-branding h1 a,
			.site-footer .woostify-handheld-footer-bar a:not(.button),
			button.menu-toggle,
			button.menu-toggle:hover {
				color: ' . $woostify_theme_mods['header_link_color'] . ';
			}
            
			button.menu-toggle,
			button.menu-toggle:hover {
				border-color: ' . $woostify_theme_mods['header_link_color'] . ';
			}

			.main-navigation ul li a:hover,
			.main-navigation ul li:hover > a,
			.site-title a:hover,
			.site-header ul.menu li.current-menu-item > a {
				color: ' . woostify_adjust_color_brightness($woostify_theme_mods['header_link_color'], 65) . ';
			}

			table th {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['background_color'], -7) . ';
			}

			table tbody td {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['background_color'], -2) . ';
			}

			table tbody tr:nth-child(2n) td,
			fieldset,
			fieldset legend {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['background_color'], -4) . ';
			}

			.site-header,
			.secondary-navigation ul ul,
			.main-navigation ul.menu > li.menu-item-has-children:after,
			.secondary-navigation ul.menu ul,
			.woostify-handheld-footer-bar,
			.woostify-handheld-footer-bar ul li > a,
			.woostify-handheld-footer-bar ul li.search .site-search,
			button.menu-toggle,
			button.menu-toggle:hover {
				background-color: ' . $woostify_theme_mods['header_background_color'] . ';
			}

			p.site-description,
			.site-header,
			.woostify-handheld-footer-bar {
				color: ' . $woostify_theme_mods['header_text_color'] . ';
			}

			button.menu-toggle:after,
			button.menu-toggle:before,
			button.menu-toggle span:before {
				background-color: ' . $woostify_theme_mods['header_link_color'] . ';
			}

			h1, h2, h3, h4, h5, h6 {
				color: ' . $woostify_theme_mods['heading_color'] . ';
			}

			.widget h1 {
				border-bottom-color: ' . $woostify_theme_mods['heading_color'] . ';
			}

			body,
			.secondary-navigation a {
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			.widget-area .widget a,
			.hentry .entry-header .posted-on a,
			.hentry .entry-header .byline a {
				color: ' . woostify_adjust_color_brightness($woostify_theme_mods['text_color'], 5) . ';
			}

			a  {
				color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			a:focus,
			.button:focus,
			.button.alt:focus,
			button:focus,
			input[type="button"]:focus,
			input[type="reset"]:focus,
			input[type="submit"]:focus {
				outline-color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			button,
            input[type="button"],
            input[type="reset"],
            input[type="file"],
            input[type="submit"],
            .button,
            .widget a.button {
				background-color: ' . $woostify_theme_mods['button_background_color'] . ';
				border-color: ' . $woostify_theme_mods['button_background_color'] . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .widget a.button:hover {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['button_background_color'], $darken_factor) . ';
				border-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['button_background_color'], $darken_factor) . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .widget-area .widget a.button.alt {
				background-color: ' . $woostify_theme_mods['button_alt_background_color'] . ';
				border-color: ' . $woostify_theme_mods['button_alt_background_color'] . ';
				color: ' . $woostify_theme_mods['button_alt_text_color'] . ';
			}

			button.alt:hover, input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover, .button.alt:hover, .widget-area .widget a.button.alt:hover {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['button_alt_background_color'], $darken_factor) . ';
				border-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['button_alt_background_color'], $darken_factor) . ';
				color: ' . $woostify_theme_mods['button_alt_text_color'] . ';
			}

			.pagination .page-numbers li .page-numbers.current {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['background_color'], $darken_factor) . ';
				color: ' . woostify_adjust_color_brightness($woostify_theme_mods['text_color'], -10) . ';
			}

			#comments .comment-list .comment-content .comment-text {
				background-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['background_color'], -7) . ';
			}

			.site-footer {
				background-color: ' . $woostify_theme_mods['footer_background_color'] . ';
				color: ' . $woostify_theme_mods['footer_text_color'] . ';
			}

			.site-footer a:not(.button) {
				color: ' . $woostify_theme_mods['footer_link_color'] . ';
			}

			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 {
				color: ' . $woostify_theme_mods['footer_heading_color'] . ';
			}

			.page-template-template-homepage.has-post-thumbnail .type-page.has-post-thumbnail .entry-title {
				color: ' . $woostify_theme_mods['hero_heading_color'] . ';
			}

			.page-template-template-homepage.has-post-thumbnail .type-page.has-post-thumbnail .entry-content {
				color: ' . $woostify_theme_mods['hero_text_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.secondary-navigation ul.menu a:hover {
					color: ' . woostify_adjust_color_brightness($woostify_theme_mods['header_text_color'], $brighten_factor) . ';
				}

				.secondary-navigation ul.menu a {
					color: ' . $woostify_theme_mods['header_text_color'] . ';
				}

				.site-header {
					border-bottom-color: ' . woostify_adjust_color_brightness($woostify_theme_mods['header_background_color'], -15) . ';
				}
			}';

        return apply_filters('woostify_customizer_css', $styles);
    }

    /**
     * Add CSS in <head> for styles handled by the theme customizer
     *
     * @since 1.0.0
     * @return void
     */
    public function add_customizer_css() {
        wp_add_inline_style( 'woostify-style', $this->get_css() );
    }
}

return new Woostify_Get_CSS();
