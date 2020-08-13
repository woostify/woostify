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
	var item  = '<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
		item += '<a href=' + fullSrc + ' data-size=' + size + ' itemprop="contentUrl" data-elementor-open-lightbox="no">';
		item += '<img src=' + src + ' itemprop="thumbnail">';
		item += '</a>';
		item += '</figure>';

	return item;
}

// Create product thumbnails item.
function createThumbnails( src ) {
	var item  = '<div class="thumbnail-item">';
		item += '<img src="' + src + '">';
		item += '</div>';

	return item;
}

// For Grid layout on mobile.
function woostifyGalleryCarouselMobile() {
	var gallery = document.querySelector( '.has-gallery-list-layout .product-gallery.has-product-thumbnails' );
	if ( ! gallery || window.innerWidth > 991 ) {
		return;
	}

	var slider = tns(
		{
			container: gallery.querySelector( '#product-images' ),
			items: 1,
			loop: false,
			autoHeight: true
		}
	);
}

// Sticky summary for list layout.
function woostifyStickySummary() {
	var gallery = document.querySelector( '.has-gallery-list-layout .product-gallery.has-product-thumbnails' ),
		summary = document.querySelector( '.has-gallery-list-layout .product-summary' );
	if ( ! gallery || ! summary || window.innerWidth < 992 ) {
		return;
	}

	if ( gallery.offsetHeight <= summary.offsetHeight ) {
		return;
	}

	var sidebar = new StickySidebar(
		'.product-summary',
		{
			innerWrapperSelector: '.summary.entry-summary',
			topSpacing: 50,
			bottomSpacing: 50,
			minWidth: 992
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function(){
		var gallery           = document.querySelector( '.product-gallery' ),
			productThumbnails = document.getElementById( 'product-thumbnail-images' );

		// Product images.
		var imageCarousel,
			options = {
				loop: false,
				container: '#product-images',
				navContainer: '#product-thumbnail-images',
				items: 1,
				navAsThumbnails: true,
				autoHeight: true
		}

		// Product thumbnails.
		var firstImage       = gallery ? gallery.querySelector( '.image-item img' ) : false,
			firstImageHeight = firstImage ? firstImage.offsetHeight : 0,
			firstImageWidth  = firstImage ? firstImage.offsetWidth : 0,
			firstImageSize   = gallery ? gallery.classList.contains( 'vertical-style' ) ? firstImageHeight : firstImageWidth : false,
			imageSize        = gallery ? gallery.classList.contains( 'vertical-style' ) ? 60 : 80 : false,
			thumbItems       = firstImageSize && imageSize ? parseInt( firstImageSize / imageSize ) : 5;

		var thumbCarousel,
			thumbOptions = {
				loop: false,
				container: '#product-thumbnail-images',
				gutter: 10,
				nav: false,
				controls: true,
				responsive: {
					0: {
						items: 5
					},
					720: {
						items: ( thumbItems > 7 ? 7 : thumbItems )
					},
					992: {
						items: thumbItems
					}
				}
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

			buttons.forEach(
				function( el ) {
					el.addEventListener(
						'click',
						function() {
							var nav = el.getAttribute( 'data-controls' );

							if ( 'next' === nav ) {
								thumbCarousel.goTo( 'next' );
							} else {
								thumbCarousel.goTo( 'prev' );
							}
						}
					);
				}
			);
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
						var size        = data[i][x].full_src_w + 'x' + data[i][x].full_src_h;
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
				document.querySelectorAll( '#product-thumbnail-images' ).forEach(
					function( el ) {
						el.parentNode.removeChild( el );
					}
				);
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
			jQuery( 'form.variations_form' ).on(
				'found_variation',
				function() {
					resetCarousel();

					if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
						updateGallery( woostify_variation_gallery );
					}
				}
			);

			// Trigger reset.
			jQuery( '.reset_variations' ).on(
				'click',
				function(){
					// Apply for slider layout.
					if ( ! document.body.classList.contains( 'has-gallery-slider-layout' ) ) {
						return;
					}

					resetCarousel();

					if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
						updateGallery( woostify_default_gallery, true );
					}

					if ( document.body.classList.contains( 'elementor-editor-active' ) || document.body.classList.contains( 'elementor-editor-preview' ) ) {
						if ( ! document.getElementById( 'product-thumbnail-images' ) ) {
							document.querySelector( '.product-gallery' ).classList.remove( 'has-product-thumbnails' );
						}
					} else if ( ! productThumbnails ) {
						gallery.classList.remove( 'has-product-thumbnails' );
					}
				}
			);
		}
		carouselAction();

		// Grid and One column to caousel layout on mobile.
		woostifyGalleryCarouselMobile();

		// Load event.
		window.addEventListener(
			'load',
			function() {
				woostifyStickySummary();
				arrowsEvent();
			}
		);

		// For Elementor Preview Mode.
		if ( 'function' === typeof( onElementorLoaded ) ) {
			onElementorLoaded(
				function() {
					window.elementorFrontend.hooks.addAction(
						'frontend/element_ready/global',
						function() {
							if ( document.getElementById( 'product-thumbnail-images' ) ) {
								renderSlider( '#product-images', options );

								thumbOptions.axis = document.getElementsByClassName( 'product-gallery' )[0].classList.contains( 'vertical-style' ) ? 'vertical' : 'horizontal';
								renderSlider( '#product-thumbnail-images', thumbOptions );
							}
							carouselAction();
							arrowsEvent();
						}
					);
				}
			);
		}
	}
);
