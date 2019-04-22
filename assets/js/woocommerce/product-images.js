/**
 * Product images
 *
 * @package woostify
 */

/* global woostify_variation_gallery, woostify_default_gallery */

'use strict';


// Carousel widget.
function renderSlider( selector, options ) {
	var element = document.querySelectorAll( selector );
	if ( ! element.length ) {
		return;
	}

	for ( var i = 0, j = element.length; i < j; i++ ) {
		if ( element[i].classList.contains( 'tns-slider' ) ) {
			continue;
		}

		var slider = tns( options );
	}
}

// Create product images item.
function createImages( fullSrc, src, size ) {
	var item = '<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
	item += '<a href=' + fullSrc + ' data-size=' + size + ' itemprop="contentUrl" data-elementor-open-lightbox="no">';
	item += '<img src=' + src + ' itemprop="thumbnail">';
	item += '</a>';
	item += '</figure>';

	return item;
}

// Create product thumbnails item.
function createThumbnails( src ) {
	var item = '<div class="thumbnail-item">';
	item += '<img src="' + src + '">';
	item += '</div>';

	return item;
}

document.addEventListener( 'DOMContentLoaded', function(){
	var gallery           = document.getElementsByClassName( 'product-gallery' )[0],
		productThumbnails = document.getElementById( 'product-thumbnail-images' );

	// Product images.
	var imageCarousel,
		options = {
			loop: false,
			container: '#product-images',
			navContainer: '#product-thumbnail-images',
			items: 1,
			navAsThumbnails: true,
			autoHeight: true,
			mouseDrag: true
	}

	// Product thumbnails.
	var thumbCarousel,
		thumbOptions = {
			loop: false,
			container: '#product-thumbnail-images',
			gutter: 10,
			items: 5,
			mouseDrag: true,
			nav: false,
			controls: true
	}

	if (
		window.matchMedia( '( min-width: 768px )' ).matches &&
		gallery &&
		gallery.classList.contains( 'vertical-style' )
	) {
		thumbOptions.axis = 'vertical';
	}

	if ( productThumbnails ) {
		imageCarousel = tns( options );
		thumbCarousel = tns( thumbOptions );
	}

	// Arrow event.
	function arrowsEvent() {
		if ( ! thumbCarousel ) {
			return;
		}

		var buttons = document.querySelectorAll( '.product-images .tns-controls button' );

		if ( ! buttons.length ) {
			return;
		}

		buttons.forEach( function( el ) {
			el.addEventListener( 'click', function() {
				var nav = el.getAttribute( 'data-controls' );

				if ( 'next' === nav ) {
					thumbCarousel.goTo( 'next' );
				} else {
					thumbCarousel.goTo( 'prev' );
				}
			} );
		} );
	}

	// Reset carousel.
	function resetCarousel() {
		if ( imageCarousel && imageCarousel.goTo ) {
			imageCarousel.goTo( 'first' );
		}

		if ( thumbCarousel && thumbCarousel.goTo ) {
			thumbCarousel.goTo( 'first' );
		}
	}

	// Update gallery.
	function updateGallery( data, reset ) {
		if ( ! data.length || document.documentElement.classList.contains( 'quick-view-open' ) ) {
			return;
		}

		// For Elementor Preview Mode.
		if ( ! gallery ) {
			gallery           = document.getElementsByClassName( 'product-gallery' )[0];
			thumbOptions.axis = gallery.classList.contains( 'vertical-style' ) ? 'vertical' : 'horizontal';
		}

		var images            = '',
			thumbnails        = '',
			variationId       = document.querySelector( 'form.variations_form [name=variation_id]' ),
			defaultThumbnails = false;

		for ( var i = 0, j = data.length; i < j; i++ ) {
			if ( reset ) {
				// For reset variation.
				var size = data[i].full_src_w + 'x' + data[i].full_src_h;

				images     += createImages( data[i].full_src, data[i].src, size );
				thumbnails += createThumbnails( data[i].gallery_thumbnail_src );

				if ( data[i].has_default_thumbnails ) {
					defaultThumbnails = true;
				}
			} else if ( variationId && data[i][0].variation_id && parseInt( variationId.value ) === data[i][0].variation_id ) {
				// Render new item for new Slider.
				for ( var x = 1, y = data[i].length; x < y; x++ ) {
					var size = data[i][x].full_src_w + 'x' + data[i][x].full_src_h;
					images     += createImages( data[i][x].full_src, data[i][x].src, size );
					thumbnails += createThumbnails( data[i][x].gallery_thumbnail_src );
				}
			}
		}

		// Destroy current slider.
		( imageCarousel && imageCarousel.destroy ) ? imageCarousel.destroy() : false;
		( thumbCarousel && thumbCarousel.destroy ) ? thumbCarousel.destroy() : false;

		// If not have #product-thumbnail-images, create it.
		if ( ! document.getElementById( 'product-thumbnail-images' ) ) {
			var productThumbs = document.createElement( 'div' );

			productThumbs.setAttribute( 'id', 'product-thumbnail-images' );
			document.getElementsByClassName( 'product-thumbnail-images' )[0].appendChild( productThumbs );
			document.getElementsByClassName( 'product-gallery' )[0].classList.add( 'has-product-thumbnails' );
		}

		// Append new markup html.
		document.getElementById( 'product-images' ).innerHTML           = images;
		document.getElementById( 'product-thumbnail-images' ).innerHTML = thumbnails;

		// Rebuild new slider.
		imageCarousel = ( imageCarousel && imageCarousel.rebuild ) ? imageCarousel.rebuild() : tns( options );
		thumbCarousel = ( thumbCarousel && thumbCarousel.rebuild ) ? thumbCarousel.rebuild() : tns( thumbOptions );

		if ( reset && ! defaultThumbnails ) {
			( thumbCarousel && thumbCarousel.destroy ) ? thumbCarousel.destroy() : false;

			// Remove all '#product-thumbnail-images' item.
			document.querySelectorAll( '#product-thumbnail-images' ).forEach( function( el ) {
				el.parentNode.removeChild( el );
			} );
		}

		// Re-init easyzoom.
		if ( 'function' === typeof( easyZoomHandle ) ) {
			easyZoomHandle();
		}

		// Re-init Photo Swipe.
		if ( 'function' === typeof( initPhotoSwipe ) ) {
			initPhotoSwipe( '#product-images' );
		}
	}

	// Carousel action.
	function carouselAction() {
		// Trigger variation.
		jQuery( document.body ).on( 'found_variation', 'form.variations_form', function() {
			resetCarousel();
			if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
				updateGallery( woostify_variation_gallery );
			}
		});

		// Trigger reset.
		jQuery( '.reset_variations' ).on( 'click', function(){
			resetCarousel();
			if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
				updateGallery( woostify_default_gallery, true );
			}

			if ( document.body.classList.contains( 'elementor-editor-active' ) || document.body.classList.contains( 'elementor-editor-preview' ) ) {
				if ( ! document.getElementById( 'product-thumbnail-images' ) ) {
					document.getElementsByClassName( 'product-gallery' )[0].classList.remove( 'has-product-thumbnails' );
				}
			} else if ( ! productThumbnails ) {
				gallery.classList.remove( 'has-product-thumbnails' );
			}
		});
	}
	carouselAction();

	// Load event.
	window.addEventListener( 'load', arrowsEvent );

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded( function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
				if ( document.getElementById( 'product-thumbnail-images' ) ) {
					renderSlider( '#product-images', options );

					thumbOptions.axis = document.getElementsByClassName( 'product-gallery' )[0].classList.contains( 'vertical-style' ) ? 'vertical' : 'horizontal';
					renderSlider( '#product-thumbnail-images', thumbOptions );
				}
				carouselAction( true );
				arrowsEvent();
			} );
		} );
	}
} );
