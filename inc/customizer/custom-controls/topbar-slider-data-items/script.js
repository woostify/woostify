/**
 * Topbar Slider Data Items JS
 *
 * @package woostify
 */


( function ( api ) {
    
    api.controlConstructor['woostify-topbar-slider-data-items'] = api.Control.extend({
        ready: function() {
            'use strict';
            var control = this;
            var list_item_wrap    = control.container.find( '.woostify-slider-list-items' );
            var latest_item_index = list_item_wrap.find( '.woostify-sortable-list-item-wrap:not(.example-item-tmpl)' ).length - 1;

            function update_value() {
                var value = {};

                list_item_wrap = control.container.find( '.woostify-slider-list-items' );
                list_item_wrap.find( '.woostify-sortable-list-item-wrap:not(.example-item-tmpl)' ).each(
                    function( item_idx, item_obj ) {
                        var item_wrap   = jQuery( item_obj )
                        value[item_idx] = {}
                        item_wrap.each(
                            function( control_idx, control_obj ) {
                                var item_control = jQuery( control_obj )
                                item_control.find( '.woostify-slider-list-control' ).each(
                                    function( input_idx, input_obj ) {
                                        var field_name              = jQuery( input_obj ).data( 'field_name' );
                                        value[item_idx][field_name] = jQuery( input_obj ).find( '.woostify-slider-list-input' ).val();
                                    },
                                );
                            },
                        )
                    },
                );
                value = jQuery.map(
                    value,
                    function(val, idx) {
                        return [val];
                    }
                );
                control.settings['default'].set( JSON.stringify( value ) );
            }

            function add_custom_item() {
                control.container.find( '.slider-list-add-item-btn' ).on(
                    'click',
                    function( e ) {
                        e.preventDefault();

                        var example_item_tmpl = control.container.find( '.woostify-sortable-list-item-wrap.example-item-tmpl' );
                        var new_item_tmpl     = example_item_tmpl.clone();

                        ++latest_item_index;

                        new_item_tmpl.removeClass( 'example-item-tmpl' );
                        new_item_tmpl.find( '.sortable-item-name' ).text( 'Item' );
                        new_item_tmpl.find( 'input.woostify-slider-list-input--name' ).attr( 'value', 'Item' );
                        new_item_tmpl.html(
                            function( i, oldHTML ) {
                                return oldHTML.replace( /{{ITEM_ID}}/g, latest_item_index );
                            }
                        )

                        var textarea_id = new_item_tmpl.find( 'textarea' ).attr( 'id' );

                        // Append new item to list.
                        list_item_wrap = control.container.find( '.woostify-slider-list-items' );
                        list_item_wrap.append( new_item_tmpl );

                        init_editor( textarea_id );

                        update_value();
                    }
                )
            }

            function init_editor( textarea_id ) {
                var $input          = jQuery( 'input[data-editor-id="' + textarea_id + '"]' ),
                setChange,
                content;
                var editor_settings = {
                    tinymce: {
                        wpautop: true,
                        plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                        toolbar1: 'bold italic underline strikethrough | bullist numlist | blockquote hr wp_more | alignleft aligncenter alignright | link unlink | fullscreen | wp_adv',
                        toolbar2: 'formatselect alignjustify forecolor | pastetext removeformat charmap | outdent indent | undo redo | wp_help'
                    },
                    quicktags: true,
                    mediaButtons: true,
                }
                wp.editor.initialize( textarea_id, editor_settings );

                var editor = tinyMCE.get( textarea_id );

                editor.on(
                    'change',
                    function ( e ) {
                        editor.save();
                        content = editor.getContent();
                        clearTimeout( setChange );
                        setChange = setTimeout(
                            function ()  {
                                $input.val( content ).trigger( 'change' );
                            },
                            500
                        );
                    }
                );
            }

            add_custom_item();

            jQuery( document ).on(
                'blur change',
                '.slider-list-item-content .woostify-slider-list-input',
                function() {
                    update_value();
                }
            );

            jQuery( document ).on(
                'click',
                '.woostify-slider-list-items .sortable-item-icon-del',
                function() {
                    var currBtn = jQuery( this );
                    var result  = confirm( "Are you sure delete this item?" );
                    if ( result ) {
                        currBtn.closest( '.woostify-sortable-list-item-wrap' ).remove();
                        update_value();
                    }
                }
            );

            jQuery( document ).on(
                'click',
                '.woostify-slider-list-items .sortable-item-icon-expand',
                function() {
                    var btn          = jQuery( this )
                    var item_wrap    = btn.closest( '.woostify-sortable-list-item-wrap' )
                    var item_content = item_wrap.find( '.slider-list-item-content' )
                    if ( item_wrap.hasClass( 'checked' ) ) {
                        item_content.slideToggle();
                    }
                }
            )

        }
    });

})( wp.customize );