'use strict';

/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
function generatepress_colors_live_update( id, selector, property, default_value ) {
    default_value = typeof default_value !== 'undefined' ? default_value : 'initial';
    wp.customize( 'woostify_settings[' + id + ']', function( value ) {
        value.bind( function( newval ) {
            newval = ( '' !== newval ) ? newval : default_value;
            if ( jQuery( 'style#' + id ).length ) {
                jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + ';}' );
            } else {
                jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + '}</style>' );
                setTimeout(function() {
                    jQuery( 'style#' + id ).not( ':last' ).remove();
                }, 1000);
            }
        } );
    } );
}

function generatepress_classes_live_update( id, classes, selector, prefix ) {
    classes = typeof classes !== 'undefined' ? classes : '';
    prefix = typeof prefix !== 'undefined' ? prefix : '';
    wp.customize( 'woostify_settings[' + id + ']', function( value ) {
        value.bind( function( newval ) {
            jQuery.each( classes, function( i, v ) {
                jQuery( selector ).removeClass( prefix + v );
            });
            jQuery( selector ).addClass( prefix + newval );
        } );
    } );
}

( function( $ ) {

    // Update the site title in real time...
    wp.customize( 'blogname', function( value ) {
        value.bind( function( newval ) {
            $( '.main-title a' ).html( newval );
        } );
    } );

    //Update the site description in real time...
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( newval ) {
            $( '.site-description' ).html( newval );
        } );
    } );

    /**
     * Body background color
     * Empty:  white
     */
    generatepress_colors_live_update( 'background_color', 'body', 'background-color', '#FFFFFF' );

    /**
     * Text color
     * Empty:  black
     */
    generatepress_colors_live_update( 'text_color', 'body', 'color', '#000000' );

    /**
     * Link color
     * Empty:  initial
     */
    generatepress_colors_live_update( 'link_color', 'a, a:visited', 'color', 'initial' );

    /**
     * Link color hover
     * Empty:  initial
     */
    generatepress_colors_live_update( 'link_color_hover', 'a:hover', 'color', 'initial' );

    /**
     * Body font size
     */
    wp.customize( 'woostify_settings[body_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#body_font_size' ).length ) {
                jQuery( 'style#body_font_size' ).html( 'body, button, input, select, textarea{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="body_font_size">body, button, input, select, textarea{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#body_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            console.log( 1 );
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * Body line height
     */
    wp.customize( 'woostify_settings[body_line_height]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#body_line_height' ).length ) {
                jQuery( 'style#body_line_height' ).html( 'body{line-height:' + newval + ';}' );
            } else {
                jQuery( 'head' ).append( '<style id="body_line_height">body{line-height:' + newval + ';}</style>' );
                setTimeout(function() {
                    jQuery( 'style#body_line_height' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * Body font weight
     */
    wp.customize( 'woostify_settings[body_font_weight]', function( value ) {
        value.bind( function( newval ) {
            jQuery( 'head' ).append( '<style id="body_font_weight">body, button, input, select, textarea{font-weight:' + newval + ';}</style>' );
            setTimeout(function() {
                jQuery( 'style#body_font_weight' ).not( ':last' ).remove();
            }, 100);
        } );
    } );

    /**
     * Body text transform
     */
    wp.customize( 'woostify_settings[body_font_transform]', function( value ) {
        value.bind( function( newval ) {
            jQuery( 'head' ).append( '<style id="body_font_transform">body, button, input, select, textarea{text-transform:' + newval + ';}</style>' );
            setTimeout(function() {
                jQuery( 'style#body_font_transform' ).not( ':last' ).remove();
            }, 100);
        } );
    } );

    /**
     * Heading line height
     */
    wp.customize( 'woostify_settings[heading_line_height]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_line_height' ).length ) {
                jQuery( 'style#heading_line_height' ).html( 'h1, h2, h3, h4, h5, h6{line-height:' + newval + ';}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_line_height">h1, h2, h3, h4, h5, h6{line-height:' + newval + ';}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_line_height' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * Heading font weight
     */
    wp.customize( 'woostify_settings[heading_font_weight]', function( value ) {
        value.bind( function( newval ) {
            jQuery( 'head' ).append( '<style id="heading_font_weight">h1, h2, h3, h4, h5, h6{font-weight:' + newval + ';}</style>' );
            setTimeout(function() {
                jQuery( 'style#heading_font_weight' ).not( ':last' ).remove();
            }, 100);
        } );
    } );

    /**
     * Heading text transform
     */
    wp.customize( 'woostify_settings[heading_font_transform]', function( value ) {
        value.bind( function( newval ) {
            jQuery( 'head' ).append( '<style id="heading_font_transform">h1, h2, h3, h4, h5, h6{text-transform:' + newval + ';}</style>' );
            setTimeout(function() {
                jQuery( 'style#heading_font_transform' ).not( ':last' ).remove();
            }, 100);
        } );
    } );

    /**
     * H1 font size
     */
    wp.customize( 'woostify_settings[heading_h1_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_h1_font_size' ).length ) {
                jQuery( 'style#heading_h1_font_size' ).html( 'h1{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_h1_font_size">h1{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_h1_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * H2 font size
     */
    wp.customize( 'woostify_settings[heading_h2_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_h2_font_size' ).length ) {
                jQuery( 'style#heading_h2_font_size' ).html( 'h2{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_h2_font_size">h2{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_h2_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * H3 font size
     */
    wp.customize( 'woostify_settings[heading_h3_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_h3_font_size' ).length ) {
                jQuery( 'style#heading_h3_font_size' ).html( 'h3{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_h3_font_size">h3{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_h3_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * H4 font size
     */
    wp.customize( 'woostify_settings[heading_h4_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_h4_font_size' ).length ) {
                jQuery( 'style#heading_h4_font_size' ).html( 'h4{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_h4_font_size">h4{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_h4_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * H5 font size
     */
    wp.customize( 'woostify_settings[heading_h5_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_h5_font_size' ).length ) {
                jQuery( 'style#heading_h5_font_size' ).html( 'h5{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_h5_font_size">h5{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_h5_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * H6 font size
     */
    wp.customize( 'woostify_settings[heading_h6_font_size]', function( value ) {
        value.bind( function( newval ) {
            if ( jQuery( 'style#heading_h6_font_size' ).length ) {
                jQuery( 'style#heading_h6_font_size' ).html( 'h6{font-size:' + newval + 'px;}' );
            } else {
                jQuery( 'head' ).append( '<style id="heading_h6_font_size">h6{font-size:' + newval + 'px;}</style>' );
                setTimeout(function() {
                    jQuery( 'style#heading_h6_font_size' ).not( ':last' ).remove();
                }, 100);
            }
            setTimeout("jQuery('body').trigger('woostify_spacing_updated');", 1000);
        } );
    } );

    /**
     * Footer widget column
     */
    wp.customize( 'woostify_footer_column', function( value ) {
        value.bind( function( newval ) {
            var footerWidget = document.getElementsByClassName( 'footer-widget' )[0];
            if( ! footerWidget ) return;
            footerWidget.className = 'footer-widget footer-widget-col-' + newval;
        });
    });

    /**
     * Footer background color
     */
    wp.customize( 'woostify_footer_background_color', function( value ) {
        value.bind( function( newval ) {
        });
    });

} )( jQuery );