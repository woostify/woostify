/**
 * Photo Swipe on Product Images
 *
 * @package woostify
 */

'use strict';

function initPhotoSwipe(gallerySelector) {
	var added = false;

	// Helper function to extract YouTube video ID
	var getYoutubeId = function (url) {
		var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
		var match = url.match(regExp);
		if (match && match[2].length == 11) {
			return match[2];
		} else {
			return null;
		}
	};

	// parse slide data (url, title, size ...) from DOM elements
	// (children of gallerySelector).
	var parseThumbnailElements = function (el) {
		var thumbElements = el.childNodes,
			numNodes = thumbElements.length,
			items = [],
			figureEl,
			linkEl,
			size,
			item;

		for (var i = 0; i < numNodes; i++) {

			figureEl = thumbElements[i]; // <figure> element.

			// include only element nodes.
			if (1 !== figureEl.nodeType) {
				continue;
			}

			// Check if this is a video item
			var isVideo = figureEl.classList.contains('has-video');
			var videoSource = figureEl.getAttribute('data-video-source');
			var videoUrl = figureEl.getAttribute('data-video-url');
			var videoAutoplay = figureEl.getAttribute('data-video-autoplay');
			var videoMute = figureEl.getAttribute('data-video-mute');

			linkEl = figureEl.children[0]; // <a> element.
			if (!linkEl.getAttribute('href') && !isVideo) {
				continue;
			}

			if (isVideo && videoUrl) {
				// Video item
				item = {
					html: '', // Will be populated dynamically
					w: 1280,
					h: 720,
					isVideo: true,
					videoSource: videoSource || 'youtube',
					videoUrl: videoUrl,
					videoAutoplay: videoAutoplay,
					videoMute: videoMute
				};

				if (linkEl.children.length > 0) {
					item.msrc = linkEl.children[0].getAttribute('src');
				}
			} else {
				// Image item
				size = linkEl.getAttribute('data-size').split('x');

				item = {
					src: linkEl.getAttribute('href'),
					w: parseInt(size[0], 10),
					h: parseInt(size[1], 10)
				};

				if (linkEl.children.length > 0) {
					item.msrc = linkEl.children[0].getAttribute('src');
				}
			}

			item.el = figureEl; // save link to element for getThumbBoundsFn.
			items.push(item);
		}

		return items;
	};

	// find nearest parent element.
	var closest = function closest(el, fn) {
		return el && (fn(el) ? el : closest(el.parentNode, fn));
	};

	var onToggleButtonClick = function (e) {
		e = e || window.event;
		e.preventDefault ? e.preventDefault() : e.returnValue = false;

		var eTarget = e.target || e.srcElement;

		var productImages = eTarget.closest('.product-images');

		var clickedListItem = productImages.querySelectorAll('.image-item')[0];

		// find root element of slide.
		var slider = productImages.querySelector('.flickity-slider');
		if (slider) {
			clickedListItem = productImages.querySelector('.image-item.is-selected');
		}

		if (!clickedListItem) {
			return;
		}

		// find index of clicked item by looping through all child nodes
		// alternatively, you may define index via data- attribute.
		var clickedGallery = clickedListItem.parentNode,
			childNodes = clickedListItem.parentNode.childNodes,
			numChildNodes = childNodes.length,
			nodeIndex = 0,
			index;

		for (var i = 0; i < numChildNodes; i++) {
			if (childNodes[i].nodeType !== 1) {
				continue;
			}

			if (childNodes[i] === clickedListItem) {
				index = nodeIndex;
				break;
			}
			nodeIndex++;
		}

		if (index >= 0) {
			// open PhotoSwipe if valid index found.
			openPhotoSwipe(index, clickedGallery);
		}
		return false;
	}

	// triggers when user clicks on thumbnail.
	var onThumbnailsClick = function (e) {
		e = e || window.event;
		e.preventDefault ? e.preventDefault() : e.returnValue = false;

		var eTarget = e.target || e.srcElement;

		if ('A' === eTarget.tagName.toUpperCase()) {
			return;
		}

		// find root element of slide.
		var clickedListItem = closest(
			eTarget,
			function (el) {
				return (el.tagName && 'FIGURE' === el.tagName.toUpperCase());
			}
		);

		if (!clickedListItem) {
			return;
		}

		// find index of clicked item by looping through all child nodes
		// alternatively, you may define index via data- attribute.
		var clickedGallery = clickedListItem.parentNode,
			childNodes = clickedListItem.parentNode.childNodes,
			numChildNodes = childNodes.length,
			nodeIndex = 0,
			index;

		for (var i = 0; i < numChildNodes; i++) {
			if (childNodes[i].nodeType !== 1) {
				continue;
			}

			if (childNodes[i] === clickedListItem) {
				index = nodeIndex;
				break;
			}
			nodeIndex++;
		}

		if (index >= 0) {
			// open PhotoSwipe if valid index found.
			openPhotoSwipe(index, clickedGallery);
		}
		return false;
	};

	var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
		var productGallery = galleryElement.closest('.product-gallery');

		var pswpElement,
			gallery,
			options,
			items;

		if (productGallery.querySelector('.pswp')) {
			pswpElement = productGallery.querySelector('.pswp');
		} else {
			pswpElement = productGallery.nextElementSibling;
		}

		items = parseThumbnailElements(galleryElement);

		// define options (if needed).
		options = {

			// define gallery index (for URL).
			galleryUID: galleryElement.getAttribute('data-pswp-uid'),

			getThumbBoundsFn: function (index) {
				// See Options -> getThumbBoundsFn section of documentation for more info.
				var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail.
					pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
					rect = thumbnail.getBoundingClientRect();

				return {
					x: rect.left,
					y: rect.top + pageYScroll,
					w: rect.width
				};
			}

		};

		// PhotoSwipe opened from URL.
		if (fromURL) {
			if (options.galleryPIDs) {
				// parse real index when custom PIDs are used
				// http://photoswipe.com/documentation/faq.html#custom-pid-in-url.
				for (var j = 0, ji = items.length; j < ji; j++) {
					if (items[j].pid == index) {
						options.index = j;
						break;
					}
				}
			} else {
				// in URL indexes start from 1.
				options.index = parseInt(index, 10) - 1;
			}
		} else {
			options.index = parseInt(index, 10);
		}

		// exit if index not found.
		if (isNaN(options.index)) {
			return;
		}

		if (disableAnimation) {
			options.showAnimationDuration = 0;
		}

		// Pass data to PhotoSwipe and initialize it.
		gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
		gallery.init();

		// Handle video rendering
		gallery.listen('gettingData', function (index, item) {
			if (item.isVideo && !item.html) {
				var videoHtml = '';

				if (item.videoSource === 'mp4') {
					// MP4 Video
					videoHtml = '<div class="pswp__video-container">';
					videoHtml += '<video controls autoplay';

					if (item.videoMute == 1 || item.videoAutoplay == 1) {
						videoHtml += ' muted';
					}

					videoHtml += ' playsinline style="width:100%;height:100%;object-fit:contain;">';
					videoHtml += '<source src="' + item.videoUrl + '" type="video/mp4">';
					videoHtml += 'Your browser does not support the video tag.';
					videoHtml += '</video>';
					videoHtml += '</div>';
				} else {
					// YouTube Video
					var videoId = getYoutubeId(item.videoUrl);
					if (videoId) {
						var embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&enablejsapi=1';

						if (item.videoMute == 1 || item.videoAutoplay == 1) {
							embedUrl += '&mute=1';
						}

						videoHtml = '<div class="pswp__video-container">';
						videoHtml += '<iframe src="' + embedUrl + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%;height:100%;"></iframe>';
						videoHtml += '</div>';
					}
				}

				item.html = videoHtml;
			}
		});

		var selector = '.pswp__thumbnails';

		gallery.listen(
			'gettingData',
			function () {
				if (added) {
					return;
				}
				added = true;

				var oldThumbnailEls = document.querySelectorAll(selector);
				if (oldThumbnailEls.length) {
					oldThumbnailEls.forEach(
						function (odlThumb) {
							odlThumb.remove();
						}
					)
				}
				setTimeout(
					function () {
						addPreviews(gallery);
					},
					200
				);
			}
		)

		gallery.listen(
			'close',
			function () {
				var scrollWrap = gallery.scrollWrap;
				var pswpThumbEl = scrollWrap.closest('.pswp').querySelector('.pswp__thumbnails');

				// Stop all videos when closing lightbox
				var videos = scrollWrap.querySelectorAll('video');
				for (var i = 0; i < videos.length; i++) {
					videos[i].pause();
				}

				var iframes = scrollWrap.querySelectorAll('iframe');
				for (var j = 0; j < iframes.length; j++) {
					iframes[j].src = '';
				}

				if (!pswpThumbEl) {
					return;
				}

				pswpThumbEl.remove();
				added = false;
			}
		)
		gallery.listen(
			'afterChange',
			function () {
				var scrollWrap = gallery.scrollWrap;
				var pswpThumbEl = scrollWrap.closest('.pswp').querySelector('.pswp__thumbnails');

				if (!pswpThumbEl) {
					return;
				}

				Object.keys(gallery.items).forEach(
					function (k) {
						var currThumbItem = pswpThumbEl.children[k];

						currThumbItem.classList.remove('active');

						if (gallery.getCurrentIndex() == k) {
							currThumbItem.classList.add('active');
						}
					}
				)
			}
		)
	};

	function addPreviews(gallery) {
		var scrollWrap = gallery.scrollWrap;
		var productImagesWrapperEl = document.querySelector('.product-gallery');
		var thumbnailEl = document.createElement('div');
		thumbnailEl.classList.add('pswp__thumbnails');

		if (!productImagesWrapperEl) {
			return;
		}

		var productThumbWrapperEl = productImagesWrapperEl.querySelector('.product-thumbnail-images-container');

		if (!productThumbWrapperEl) {
			Object.keys(gallery.items).forEach(
				function (k) {
					var currItem = gallery.items[k];
					var newThumbEl = document.createElement('div');
					var newImgEl = document.createElement('img');

					newImgEl.setAttribute('src', currItem.msrc);
					newThumbEl.classList.add('thumbnail-item');
					newThumbEl.appendChild(newImgEl)
					thumbnailEl.appendChild(newThumbEl);
				}
			)
		} else {
			var thumbSlider = productThumbWrapperEl.querySelector('.flickity-slider');
			if (thumbSlider) {
				thumbnailEl.innerHTML = thumbSlider.innerHTML;
			} else {
				thumbnailEl.innerHTML = productThumbWrapperEl.innerHTML;
			}
		}

		Object.keys(gallery.items).forEach(
			function (k) {
				var currThumbItem = thumbnailEl.children[k];
				currThumbItem.removeAttribute('style');
				currThumbItem.classList.remove('is-selected', 'is-nav-selected');

				if (gallery.getCurrentIndex() == k) {
					currThumbItem.classList.add('active');
				}

				// Add play icon for video items
				if (gallery.items[k].isVideo) {
					currThumbItem.classList.add('has-video-thumb');
					var playIcon = document.createElement('div');
					playIcon.className = 'pswp__thumb-play-icon';
					playIcon.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M8 5v14l11-7z" fill="currentColor"/></svg>';
					currThumbItem.appendChild(playIcon);
				}

				currThumbItem.addEventListener(
					'click',
					function () {
						gallery.goTo(gallery.items.indexOf(gallery.items[k]))
					}
				)
			}
		)

		scrollWrap.parentNode.insertBefore(thumbnailEl, scrollWrap.nextSibling);
	}

	// loop through all gallery elements and bind events.
	var galleryElements = document.querySelectorAll(gallerySelector);
	for (var i = 0, l = galleryElements.length; i < l; i++) {
		var buttonEl = galleryElements[i].closest('.product-images').querySelector('.photoswipe-toggle-button');

		galleryElements[i].setAttribute('data-pswp-uid', i + 1);

		buttonEl.onclick = onToggleButtonClick;
		galleryElements[i].onclick = onThumbnailsClick;
	}
}

initPhotoSwipe('.product-images-container');