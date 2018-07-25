'use strick';

window.addEventListener( 'load', function(){
    var _api = wp.customize;

    /* Footer widget column
    ------------------------------------------------->*/
    _api( 'woostify_footer_column', function( value ) {
        value.bind( function( newval ) {
            var footerWidget = document.getElementsByClassName( 'footer-widget' )[0];
            if( ! footerWidget ) return;
            footerWidget.className = 'footer-widget footer-widget-col-' + newval;
        });
    });

    /* Footer background color
    ------------------------------------------------->*/
    _api( 'woostify_footer_background_color', function( value ) {
        value.bind( function( newval ) {
            console.log( newval );
        });
    });
} );