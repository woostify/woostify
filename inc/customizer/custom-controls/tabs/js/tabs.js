/**
 * Load media uploader on pages with our custom metabox
 *
 * @package woostify
 */

( function( $ ) {

	'use strict';

	wp.customize.bind(
		'ready',
		function () {
			var controls = {
				"general" : [
					'sticky_footer_bar_enable',
					'sticky_footer_bar_enable_on',
					'sticky_footer_bar_items'
				],
				"design": [

				]
			};


			$(document).on( 'click', '.woostify-tab-button', function() {
				var curr_tab = $(this),
					curr_tab_data = curr_tab.data('tab'),
					pane_child = curr_tab.closest('.customize-pane-child');

				curr_tab.parent().find('li').removeClass('active');
				curr_tab.addClass('active');

				var curr_controls = controls[curr_tab_data];
				pane_child.find('li.customize-control').each( function() {
					var curr_control_id = $(this).attr('id').split('-')[3];

					console.log(curr_control_id);
					if($.inArray( curr_control_id, curr_controls) !== -1) {
						$(this).show();
					}
					if ( 'general' === curr_tab_data ) {
						if($.inArray( curr_control_id, controls['design']) !== -1) {
							$(this).hide();
						}
					} else {
						if($.inArray( curr_control_id, controls['general']) !== -1) {
							$(this).hide();
						}
					}
				} );
			});

			$('.woostify-component-tabs').each( function() {
				var curr_comp_tab = $(this);
				curr_comp_tab.find('li.woostify-tab-button').first().trigger('click');
			} );
		}
	);
} )( jQuery );
