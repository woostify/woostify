/**
 * Product images
 *
 * @package woostify
 */

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
	item += '<a href=' + fullSrc + ' data-size=' + size + ' itemprop="contentUrl">';
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
		if ( imageCarousel ) {
			imageCarousel.goTo( 'first' );
		}

		if ( thumbCarousel ) {
			thumbCarousel.goTo( 'first' );
		}
	}

	// Update gallery.
	function updateGallery( data, boolean ) {
		if ( ! data.length ) {
			return;
		}

		var images      = '',
			thumbnails  = '',
			variationId = document.querySelector( 'form.variations_form [name=variation_id]' );

		for ( var i = 0, j = data.length; i < j; i++ ) {
			if ( true === boolean ) {
				// For reset variation.
				var size = data[i].full_src_w + 'x' + data[i].full_src_h;
				images     += createImages( data[i].full_src, data[i].src, size );
				thumbnails += createThumbnails( data[i].gallery_thumbnail_src );
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
		imageCarousel ? imageCarousel.destroy() : false;
		thumbCarousel ? thumbCarousel.destroy() : false;

		// Append new markup html.
		var productImages = document.getElementById( 'product-images' ),
			productThumbs = document.getElementById( 'product-thumbnail-images' );

		// If not have #product-thumbnail-images, create it.
		if ( ! productThumbs ) {
			var productThumbs = document.createElement( 'div' );

			productThumbs.setAttribute( 'id', 'product-thumbnail-images' );
			document.getElementsByClassName( 'product-thumbnail-images' )[0].appendChild( productThumbs );
			gallery ? gallery.classList.add( 'has-product-thumbnails' ) : false;
		}

		productImages.innerHTML = images;
		productThumbs.innerHTML = thumbnails;
		// Rebuild new slider.
		imageCarousel = imageCarousel ? imageCarousel.rebuild() : tns( options );
		thumbCarousel = thumbCarousel ? thumbCarousel.rebuild() : tns( thumbOptions );

		// Re-init easyzoom.
		easyZoomHandle();

		// Re-init Photo Swipe.
		initPhotoSwipe( '#product-images' );
	}

	// Carousel action.
	function carouselAction() {
		// Trigger variation.
		jQuery( document.body ).on( 'found_variation', 'form.variations_form', function() {
			resetCarousel();
			updateGallery( woostify_variation_gallery );
		});

		// Trigger reset.
		jQuery( '.reset_variations' ).on( 'click', function(){
			resetCarousel();
			updateGallery( woostify_default_gallery, true );
		});
	}
	carouselAction();

	// Load event.
	window.addEventListener( 'load', arrowsEvent );

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded( function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
				if ( productThumbnails ) {
					renderSlider( '#product-images', options );
					renderSlider( '#product-thumbnail-images', thumbOptions );
				}
				carouselAction();
				arrowsEvent();
			} );
		} );
	}
} );
