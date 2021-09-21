/**
 * Product images
 *
 * @package woostify
 */

/* global woostify_product_images_slider_options, woostify_variation_gallery, woostify_default_gallery */

'use strict';

// Carousel widget.
function renderSlider( selector, options ) {
	var element = document.querySelectorAll( selector );
	if ( ! element.length ) {
		return;
	}

	for ( var i = 0, j = element.length; i < j; i++ ) {
		if ( element[i].classList.contains( 'flickity-enabled' ) ) {
			continue;
		}

		var slider = new Flickity( options.container, options );
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

	var options = {
		adaptiveHeight: true,
		pageDots: false,
		cellAlign: 'left',
	};
	var slider = new Flickity( '#product-images', options );
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

	var sidebarStickCmnKy = new WSYSticky(
		'.summary.entry-summary',
		{
			stickyContainer: '.product-page-container',
			marginTop: parseInt( woostify_woocommerce_general.sticky_top_space ),
			marginBottom: parseInt( woostify_woocommerce_general.sticky_bottom_space )
		}
	);

	// Update sticky when found variation.
	jQuery( 'form.variations_form' ).on(
		'found_variation',
		function() {
			sidebarStickCmnKy.update();
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function(){
		var gallery           = document.querySelector( '.product-gallery' ),
			productThumbnails = document.getElementById( 'product-thumbnail-images' ),
			noSliderLayout    = gallery ? ( gallery.classList.contains( 'column-style' ) || gallery.classList.contains( 'grid-style' ) ) : false;

		// Product images.
		var imageCarousel,
			options = woostify_product_images_slider_options.main;

		// Product thumbnails.
		var firstImage       = gallery ? gallery.querySelector( '.image-item img' ) : false,
			firstImageHeight = firstImage ? firstImage.offsetHeight : 0;

		var thumbCarousel,
			thumbOptions = woostify_product_images_slider_options.thumb;

		thumbOptions.direction = 'horizontal';

		if (
			window.matchMedia( '( min-width: 768px )' ).matches &&
			gallery &&
			gallery.classList.contains( 'vertical-style' )
		) {
			document.querySelector( thumbOptions.container ).style.width = firstImageHeight + 'px';

			thumbOptions.direction = 'vertical';
			thumbOptions.draggable = false;
		}

		if ( productThumbnails ) {
			imageCarousel = new Flickity( options.container, options );
			thumbCarousel = new Flickity( thumbOptions.container, thumbOptions );
		}

		var needInitZoomEffect = false;

		window.addEventListener(
			'resize',
			function() {
				if ( thumbCarousel ) {
					var oldThumbOptions = thumbCarousel.options;
					if ( window.matchMedia( '( min-width: 768px )' ).matches ) {
						if ( gallery && gallery.classList.contains( 'vertical-style' ) ) {
							var currFirstImageHeight = firstImage.offsetHeight;

							document.querySelector( thumbOptions.container ).style.width = currFirstImageHeight + 'px';

							if ( oldThumbOptions.direction !== 'vertical' ) {
								needInitZoomEffect     = true;
								thumbOptions.draggable = false;
								thumbOptions.direction = 'vertical';
								reInitThumbnailSlider();
							}
						}
						if ( needInitZoomEffect && 'function' === typeof( easyZoomHandle ) ) {
							easyZoomHandle();
							needInitZoomEffect = false;
						}
					} else {
						document.querySelector( thumbOptions.container ).style.width = '100%';
						if ( oldThumbOptions.direction !== 'horizontal' ) {
							thumbOptions.draggable = true;
							thumbOptions.direction = 'horizontal';
							reInitThumbnailSlider();
						}
					}
				}
			}
		);

		// Re-init thumbnail slider.
		function reInitThumbnailSlider() {
			thumbCarousel.destroy();
			thumbCarousel = new Flickity( thumbOptions.container, thumbOptions );
		}

		// Reset carousel.
		function resetCarousel() {
			if ( imageCarousel ) {
				imageCarousel.select( 0 )
			}
		}

		// Update gallery.
		function updateGallery( data, reset, variationId ) {
			if ( ! data.length || document.documentElement.classList.contains( 'quick-view-open' ) ) {
				return;
			}

			// For Elementor Preview Mode.
			if ( ! gallery ) {
				gallery                = document.querySelector( '.product-gallery' );
				thumbOptions.direction = gallery.classList.contains( 'vertical-style' ) ? 'vertical' : 'horizontal';
			}

			var images            = '',
				thumbnails        = '',
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
				} else if ( variationId && variationId == data[i][0].variation_id ) {
					// Render new item for new Slider.
					for ( var x = 1, y = data[i].length; x < y; x++ ) {
						var size        = data[i][x].full_src_w + 'x' + data[i][x].full_src_h;
							images     += createImages( data[i][x].full_src, data[i][x].src, size );
							thumbnails += createThumbnails( data[i][x].gallery_thumbnail_src );
					}
				}
			}

			// Destroy current slider.
			if ( imageCarousel && imageCarousel.version ) {
				imageCarousel.destroy();

				let propsImages = Object.getOwnPropertyNames( imageCarousel );
				for ( let i = 0, j = propsImages.length; i < j; i++ ) {
					delete imageCarousel[ propsImages[ i ] ];
				}
			}
			if ( thumbCarousel && thumbCarousel.version ) {
				thumbCarousel.destroy();

				let propsThumbnail = Object.getOwnPropertyNames( thumbCarousel );
				for ( let i = 0, j = propsThumbnail.length; i < j; i++ ) {
					delete thumbCarousel[ propsThumbnail[ i ] ];
				}
			}

			// Append new markup html.
			if ( images && document.querySelector( '.product-images' ) ) {
				document.querySelector( '.product-images' ).innerHTML = '<div id="product-images">' + images + '</div>';;
			}

			if ( document.querySelector( '.product-thumbnail-images' ) ) {
				if ( thumbnails ) {
					document.querySelector( '.product-thumbnail-images' ).innerHTML = '<div id="product-thumbnail-images">' + thumbnails + '</div>';

					if ( document.querySelector( '.product-gallery' ) ) {
						document.querySelector( '.product-gallery' ).classList.add( 'has-product-thumbnails' );
					}
				} else {
					document.querySelector( '.product-thumbnail-images' ).innerHTML = '';
				}
			}

			// Rebuild new slider.
			if ( ! thumbnails ) {
				options.navContainer = false;
			}

			// Re-init slider.
			if ( ! noSliderLayout ) {
				if ( 'undefined' === typeof( imageCarousel ) || ! Object.getOwnPropertyNames( imageCarousel ).length ) {
					imageCarousel = new Flickity( options.container, options );
				}
				if ( thumbnails && ( 'undefined' === typeof( thumbCarousel ) || ! Object.getOwnPropertyNames( thumbCarousel ).length ) ) {
					thumbCarousel = new Flickity( thumbOptions.container, thumbOptions );
				}
			}

			// Hide thumbnail slider if only thumbnail item.
			var getThumbnailSlider = document.querySelectorAll( '.product-thumbnail-images .thumbnail-item' );
			if ( document.querySelector( '.product-thumbnail-images' ) ) {
				if ( getThumbnailSlider.length < 2 ) {
					document.querySelector( '.product-thumbnail-images' ).classList.add( 'has-single-thumbnail-image' );
				} else if ( document.querySelector( '.product-thumbnail-images' ) ) {
					document.querySelector( '.product-thumbnail-images' ).classList.remove( 'has-single-thumbnail-image' );
				}
			}

			// Update main slider height.
			var mainViewSlider = document.getElementById( 'product-images-mw' );
			if ( mainViewSlider ) {
				setTimeout(
					function() {
						mainViewSlider.style.height = 'auto';
					},
					500
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
				function( e, variation ) {
					resetCarousel();

					// Update slider height.
					setTimeout(
						function() {
							if ( 'object' === typeof( imageCarousel ) ) {
								imageCarousel.reloadCells();
							}
						},
						200
					);

					if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
						updateGallery( woostify_variation_gallery, false, variation.variation_id );
					}
				}
			);

			// Trigger reset.
			jQuery( '.reset_variations' ).on(
				'click',
				function(){
					if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
						updateGallery( woostify_default_gallery, true );
					}

					// Apply for slider layout.
					if ( ! document.body.classList.contains( 'has-gallery-slider-layout' ) ) {
						return;
					}

					// Update slider height.
					setTimeout(
						function() {
							if ( 'object' === typeof( imageCarousel ) ) {
								imageCarousel.reloadCells();
							}
						},
						200
					);

					resetCarousel();

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
								renderSlider( options.container, options );

								thumbOptions.axis = document.querySelector( '.product-gallery' ).classList.contains( 'vertical-style' ) ? 'vertical' : 'horizontal';
								renderSlider( thumbOptions.container, thumbOptions );
							}
							carouselAction();
						}
					);
				}
			);
		}
	}
);
