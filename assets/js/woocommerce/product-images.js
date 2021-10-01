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
	var imageEl       = document.createElement( 'figure' );
	imageEl.className = 'image-item ez-zoom';
	imageEl.setAttribute( 'itemprop', 'associatedMedia' );
	imageEl.setAttribute( 'itemscope', '' );
	imageEl.setAttribute( 'itemtype', 'http://schema.org/ImageObject' );

	var item  = '<a href=' + fullSrc + ' data-size=' + size + ' itemprop="contentUrl" data-elementor-open-lightbox="no">';
		item += '<img src=' + src + ' itemprop="thumbnail">';
		item += '</a>';

	imageEl.innerHTML = item;

	return imageEl;
}

// Create product thumbnails item.
function createThumbnails( src ) {
	var thumbEl       = document.createElement( 'div' );
	thumbEl.className = 'thumbnail-item';
	thumbEl.innerHTML = '<img src="' + src + '">';

	return thumbEl;
}

// For Grid layout on mobile.
function woostifyGalleryCarouselMobile() {
	var gallery = document.querySelector( '.has-gallery-list-layout .product-gallery.has-product-thumbnails' );
	if ( ! gallery || window.innerWidth > 991 ) {
		return;
	}

	var options      = woostify_product_images_slider_options.main;
	var slider       = new Flickity( '#product-images', options );
	var imageNextBtn = document.querySelector( '.flickity-button.next' );
	var imagePrevBtn = document.querySelector( '.flickity-button.previous' );

	if ( imageNextBtn ) {
		imageNextBtn.innerHTML = woostify_product_images_slider_options.next_icon;
	}

	if ( imagePrevBtn ) {
		imagePrevBtn.innerHTML = woostify_product_images_slider_options.prev_icon;
	}
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

		var prevBtn = document.createElement( "button" );
		var nextBtn = document.createElement( "button" );

		// Product images.
		var imageCarousel,
			options = woostify_product_images_slider_options.main;

		// Product thumbnails.
		var firstImage       = gallery ? gallery.querySelector( '.image-item img' ) : false,
			firstImageHeight = firstImage ? firstImage.offsetHeight : 0;

		var thumbCarousel,
			thumbOptions = woostify_product_images_slider_options.thumb;

		if (
			window.matchMedia( '( min-width: 768px )' ).matches &&
			gallery &&
			gallery.classList.contains( 'vertical-style' )
		) {
			thumbOptions.draggable = false;
		}

		if ( productThumbnails ) {
			imageCarousel = new Flickity( options.container, options );
			changeImageCarouselButtonIcon();

			if ( window.matchMedia( '( max-width: 767px )' ).matches ) {
				if ( gallery ) {
					thumbCarousel = new Flickity( thumbOptions.container, thumbOptions );
				}
			} else {
				if ( gallery && gallery.classList.contains( 'vertical-style' ) ) {
					productThumbnails.style.maxHeight = firstImageHeight + 'px';
					verticalThumbnailSliderAction();
					addThumbButtons();
				} else {
					thumbCarousel = new Flickity( thumbOptions.container, thumbOptions );
				}
			}
		}

		function changeImageCarouselButtonIcon() {
			var imageNextBtn = document.querySelector( '.flickity-button.next' );
			var imagePrevBtn = document.querySelector( '.flickity-button.previous' );

			if ( imageNextBtn ) {
				imageNextBtn.innerHTML = woostify_product_images_slider_options.next_icon;
			}

			if ( imagePrevBtn ) {
				imagePrevBtn.innerHTML = woostify_product_images_slider_options.prev_icon;
			}
		}

		window.addEventListener(
			'resize',
			function() {
				if ( window.matchMedia( '( min-width: 768px )' ).matches && gallery && gallery.classList.contains( 'vertical-style' ) && productThumbnails ) {
					var totalThumbHeight     = 0;
					var thumbs               = productThumbnails.querySelectorAll( '.thumbnail-item' );
					var currFirstImageHeight = firstImage ? firstImage.offsetHeight : 0;

					productThumbnails.style.maxHeight = currFirstImageHeight + 'px';
					verticalThumbnailSliderAction();

					if ( thumbs.length ) {
						thumbs.forEach(
							function( thumb ) {
								var thumbHeight   = thumb.offsetHeight;
								thumbHeight      += parseInt( window.getComputedStyle( thumb ).getPropertyValue( 'margin-top' ) );
								thumbHeight      += parseInt( window.getComputedStyle( thumb ).getPropertyValue( 'margin-bottom' ) );
								totalThumbHeight += thumbHeight;
							}
						)
					}

					if ( totalThumbHeight > productThumbnails.offsetHeight ) {
						productThumbnails.classList.add( 'has-buttons' );
						nextBtn.style.display = 'block';
						prevBtn.style.display = 'block';
					} else {
						productThumbnails.classList.remove( 'has-buttons' );
						nextBtn.style.display = 'none';
						prevBtn.style.display = 'none';
					}
				}
			}
		);

		function addThumbButtons() {
			var productThumbnailsWrapper = productThumbnails.parentElement;
			prevBtn.classList.add( 'thumb-btn', 'thumb-prev-btn', 'prev' );
			prevBtn.innerHTML = woostify_product_images_slider_options.vertical_prev_icon;

			nextBtn.classList.add( 'thumb-btn', 'thumb-next-btn', 'next' );
			nextBtn.innerHTML = woostify_product_images_slider_options.vertical_next_icon;

			productThumbnailsWrapper.appendChild( prevBtn );
			productThumbnailsWrapper.appendChild( nextBtn );

			var thumbs           = productThumbnails.querySelectorAll( '.thumbnail-item' );
			var totalThumbHeight = 0;
			if ( thumbs.length ) {
				thumbs.forEach(
					function( thumb ) {
						var thumbHeight   = thumb.offsetHeight;
						thumbHeight      += parseInt( window.getComputedStyle( thumb ).getPropertyValue( 'margin-top' ) );
						thumbHeight      += parseInt( window.getComputedStyle( thumb ).getPropertyValue( 'margin-bottom' ) );
						totalThumbHeight += thumbHeight;
					}
				)
			}

			if ( totalThumbHeight > productThumbnails.offsetHeight ) {
				productThumbnails.classList.add( 'has-buttons' );
				nextBtn.style.display = 'block';
				prevBtn.style.display = 'block';
			} else {
				productThumbnails.classList.remove( 'has-buttons' );
				nextBtn.style.display = 'none';
				prevBtn.style.display = 'none';
			}

			var thumbButtons = document.querySelectorAll( '.thumb-btn' );
			if ( thumbButtons.length ) {
				thumbButtons.forEach(
					function( thumbBtn ) {
						thumbBtn.addEventListener(
							'click',
							function() {
								var currBtn = this;
								if ( currBtn.classList.contains( 'prev' ) ) {
									imageCarousel.previous();
								} else {
									imageCarousel.next();
								}
							}
						)
					}
				)
			}
		}

		function verticalThumbnailSliderAction() {
			var thumbNav       = productThumbnails;
			var thumbNavImages = thumbNav.querySelectorAll( '.thumbnail-item' );

			thumbNavImages[0].classList.add( 'is-nav-selected' );
			thumbNavImages[0].classList.add( 'is-selected' );

			thumbNavImages.forEach(
				function( thumbNavImg, thumbIndex ) {
					thumbNavImg.addEventListener(
						'click',
						function() {
							imageCarousel.select( thumbIndex );
						}
					);
				}
			);

			var thumbImgHeight = 0 < imageCarousel.selectedIndex ? thumbNavImages[imageCarousel.selectedIndex].offsetHeight : thumbNavImages[0].offsetHeight;
			var thumbHeight    = thumbNav.offsetHeight;

			imageCarousel.on(
				'select',
				function() {
					thumbNav.querySelectorAll( '.thumbnail-item' ).forEach(
						function( thumb ) {
							thumb.classList.remove( 'is-nav-selected', 'is-selected' );
						}
					)

					setTimeout(
						function() {
							var selected = 0 < imageCarousel.selectedIndex ? thumbNavImages[ imageCarousel.selectedIndex ] : thumbNavImages[ 0 ];
							selected.classList.add( 'is-nav-selected' );
							selected.classList.add( 'is-selected' );

							var scrollY = selected.offsetTop + thumbNav.scrollTop - ( thumbHeight + thumbImgHeight ) / 2;
							thumbNav.scrollTo(
								{
									top: scrollY,
									behavior: 'smooth',
								}
							);
						},
						100
					);

				}
			);
		}

		// Reset carousel.
		function resetCarousel() {
			if ( imageCarousel && imageCarousel.slider ) {
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
				gallery = document.querySelector( '.product-gallery' );
			}

			var images     = [],
				thumbnails = [];

			for ( var i = 0, j = data.length; i < j; i++ ) {
				if ( reset ) {
					// For reset variation.
					var size = data[i].full_src_w + 'x' + data[i].full_src_h;

					images.push( createImages( data[i].full_src, data[i].src, size ) );
					thumbnails.push( createThumbnails( data[i].gallery_thumbnail_src ) );
				} else if ( variationId && variationId == data[i][0].variation_id ) {
					// Render new item for new Slider.
					for ( var x = 1, y = data[i].length; x < y; x++ ) {
						var size = data[i][x].full_src_w + 'x' + data[i][x].full_src_h;
						images.push( createImages( data[i][x].full_src, data[i][x].src, size ) );
						thumbnails.push( createThumbnails( data[i][x].gallery_thumbnail_src ) );
					}
				}
			}

			if ( ( 0 < images.length ) && document.querySelector( '.product-images' ) ) {
				if ( imageCarousel && imageCarousel.slider ) {
					imageCarousel.remove( document.querySelectorAll( '#product-images .image-item' ) );
					imageCarousel.append( images );
					imageCarousel.reposition();
					imageCarousel.reloadCells();
				}
			}

			if ( document.querySelector( '.product-thumbnail-images' ) ) {
				if ( thumbnails.length > 0 ) {
					if ( thumbCarousel && thumbCarousel.slider ) { // Case thumbnails is slider.
						thumbCarousel.remove( document.querySelectorAll( '#product-thumbnail-images .thumbnail-item' ) );
							thumbCarousel.append( thumbnails );
					} else { // Case thumbnails is vertical layout in desktop.
						document.querySelector( '.product-thumbnail-images' ).querySelector( '#product-thumbnail-images' ).innerHTML = '';
						for ( var i = 0, thumbnailsLength = thumbnails.length; i < thumbnailsLength; i++ ) {
							document.querySelector( '.product-thumbnail-images' ).querySelector( '#product-thumbnail-images' ).appendChild( thumbnails[i] );
						}

						// Get current height of first image in main.
						var currFirstImage   = gallery ? gallery.querySelector( '.image-item img' ) : false,
						currFirstImageHeight = currFirstImage ? currFirstImage.offsetHeight : 0;

						setTimeout(
							function() {
								// Update Product thumbnail wrapper height.
								productThumbnails.style.maxHeight = currFirstImageHeight + 'px';
							},
							200
						);
					}
				} else {
					document.querySelector( '.product-thumbnail-images' ).querySelector( '#product-thumbnail-images' ).innerHTML = '';
				}
			}

			// Re-init easyzoom.
			if ( 'function' === typeof( easyZoomHandle ) ) {
				easyZoomHandle();
			}

			// Re-init Photo Swipe.
			if ( 'function' === typeof( initPhotoSwipe ) ) {
				if ( gallery.classList.contains( 'wc-default-gallery' ) ) {
					initPhotoSwipe( '#product-images', 'image' );
				} else {
					if ( noSliderLayout ) {
						if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
							initPhotoSwipe( '#product-images', 'image' );
						} else {
							initPhotoSwipe( '#product-images', 'button' );
						}
					} else {
						initPhotoSwipe( '#product-images', 'button' );
					}
				}
			}
		}

		// Carousel action.
		function carouselAction() {
			// Trigger variation.
			jQuery( 'form.variations_form' ).on(
				'found_variation',
				function( e, variation ) {

					// Update slider height.
					setTimeout(
						function() {
							resetCarousel();
							window.dispatchEvent( new Event( 'resize' ) );
						},
						100
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
							resetCarousel();
							window.dispatchEvent( new Event( 'resize' ) );
						},
						100
					);

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
