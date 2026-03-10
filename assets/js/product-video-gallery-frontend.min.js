/**
 * Product Video Gallery Frontend JS
 */

(function ($) {
    'use strict';

    var WoostifyProductVideo = {
        init: function () {
            this.bindEvents();
            this.initPhotoswipe();

            // Check for autoplay on first load
            var $gallery = $('.product-gallery .product-images-container');
            var $mainImage = $gallery.find('.image-item').first();
            var $lightboxToggleButton = $('.photoswipe-toggle-button');

            if ($mainImage.length && $mainImage.data('video-autoplay') == 1) {
                this.playVideo($mainImage);
            }

            // Initial check for lightbox button visibility
            if ($mainImage.hasClass('has-video')) {
                $lightboxToggleButton.css('display', 'none'); // or visibility: hidden
            } else {
                $lightboxToggleButton.css('display', '');
            }

            // Listen for Flickity change event to toggle button visibility
            if ($gallery.length) {
                $gallery.on('change.flickity', function (event, index) {
                    var $activeSlide = $(this).find('.image-item').eq(index);
                    if ($activeSlide.hasClass('has-video')) {
                        $lightboxToggleButton.css('display', 'none');
                    } else {
                        $lightboxToggleButton.css('display', '');
                    }
                });
            }

            // Failsafe: Remove ez-zoom and loading classes from any video slides
            $('.image-item.has-video').removeClass('ez-zoom is-loading is-error');
            $('.image-item.has-video .easyzoom-notice').remove();
        },

        bindEvents: function () {
            var self = this;

            // Use Capture Phase to intercept clicks on the video icon BEFORE they reach other handlers (like Photoswipe)
            // This is critical because Photoswipe might be bound to the container with onclick or similar checks
            // Use Capture Phase to intercept clicks on the video icon or container BEFORE they reach other handlers
            // This is critical because Photoswipe might be bound to the container with onclick or similar checks
            document.addEventListener('click', function (e) {
                var target = e.target;

                // If clicking inside a playing video iframe or control, let it pass (though iframe usually captures it)
                if (target.tagName === 'IFRAME') return;

                // Check if clicking on video icon OR anywhere on a video slide that is NOT yet playing
                var videoSlide = target.closest('.image-item.has-video');

                if (videoSlide) {
                    // If video is already playing, we generally want to do nothing (let controls work)
                    // unless we want to pause? But for now, we just want to avoid lighting up lightbox.
                    if (videoSlide.classList.contains('playing-video')) {
                        // If clicking on the wrapper while playing (e.g. side padding), prevent lightbox
                        // But clicking on iframe usually won't bubble here anyway.
                        // Let's safe guard:
                        if (!target.closest('.woostify-product-video-container')) {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                        }
                        return;
                    }

                    // Loop prevents opening lightbox
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    self.playVideo($(videoSlide));
                }
            }, true); // true = Capture phase

            // Prevent lightbox when clicking on the image if it has video (optional, depending on UX)
            // But since we removed ez-zoom, the anchor might still open lightbox. 
            // We want to ensure clicking anywhere on the video slide plays the video if not playing.
            $(document).on('click', '.image-item.has-video', function (e) {
                if (!$(this).hasClass('playing-video')) {
                    // Check if click is on the play icon (already handled by capture)
                    if ($(e.target).closest('.woostify-video-icon-main').length) return;

                    e.preventDefault();
                    e.stopPropagation();
                    self.playVideo($(this));
                }
            });

            // Specific blocker for anchor tags inside video slides to prevent opening image link
            $(document).on('click', '.image-item.has-video a', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                // Trigger play on the parent wrapper
                var wrapper = $(this).closest('.image-item');
                if (!wrapper.hasClass('playing-video')) {
                    self.playVideo(wrapper);
                }
            });

            // Handle click on video icon in thumbnails
            // Note: Thumbnails usually trigger slider change, so we might not need specific logic 
            // other than ensuring the main slide updates, which it does by default.
            // But if we want to auto-play when a video thumbnail is clicked:
            /*
            $(document).on('click', '.thumbnail-item.has-video', function() {
                // Logic to auto-play main video could go here if requested
            });
            */

            // Handle slider change
            var $gallery = $('.product-gallery .product-images-container');
            if ($gallery.length) {
                // Stop videos when slide changes (including arrow clicks)
                $gallery.on('select.flickity', function () {
                    self.stopAllVideos();
                });
            }

            // Explicitly handle arrow button clicks as well, just in case
            $(document).on('click', '.flickity-prev-next-button', function () {
                self.stopAllVideos();
            });

            // Remove is-loading/is-error when hovering main image video slides
            $(document).on('mouseenter', '.image-item.has-video', function () {
                var $this = $(this);
                $this.removeClass('is-loading is-error');
                $this.find('.easyzoom-notice').remove();

                // Try to destroy EasyZoom if it's still attached
                if ($.data(this, 'easyZoom')) {
                    var api = $this.data('easyZoom');
                    if (api && typeof api.teardown === 'function') {
                        api.teardown();
                    }
                }
            });
        },

        stopAllVideos: function () {
            var self = this;
            $('.image-item.playing-video').each(function () {
                var $wrapper = $(this);

                // Pause HTML5 video
                var $video = $wrapper.find('video');
                if ($video.length) {
                    $video[0].pause();
                }

                // Stop YouTube by resetting src or sending pause command via JS API
                var $iframe = $wrapper.find('iframe');
                if ($iframe.length) {
                    var src = $iframe.attr('src');
                    $iframe.attr('src', '');
                    $iframe.attr('src', src.replace('&autoplay=1', '&autoplay=0'));
                }

                $wrapper.removeClass('playing-video');
                $wrapper.find('.woostify-video-icon').css('display', '');
                $wrapper.find('.woostify-product-video-container').remove();
            });
        },

        playVideo: function (wrapper) {
            var source = wrapper.data('video-source') || 'youtube';
            var url = wrapper.data('video-url');
            var autoplay = wrapper.data('video-autoplay');
            var mute = wrapper.data('video-mute');

            if (!url) return;

            // Hide icon explicitly
            wrapper.find('.woostify-video-icon').css('display', 'none');

            if (source === 'mp4') {
                // MP4 Video - Use HTML5 video element
                var videoHtml = '<div class="woostify-product-video-container">';
                videoHtml += '<video controls autoplay';

                if (mute == 1 || autoplay == 1) {
                    videoHtml += ' muted';
                }

                videoHtml += ' playsinline style="width:100%;height:100%;object-fit:cover;">';
                videoHtml += '<source src="' + url + '" type="video/mp4">';
                videoHtml += 'Your browser does not support the video tag.';
                videoHtml += '</video>';
                videoHtml += '</div>';

                if (wrapper.find('.woostify-product-video-container').length === 0) {
                    wrapper.append(videoHtml);
                }
                wrapper.addClass('playing-video');
            } else {
                // YouTube Video - Use iframe
                var videoId = this.getYoutubeId(url);
                if (videoId) {
                    var embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0&enablejsapi=1';

                    if (mute == 1 || autoplay == 1) {
                        embedUrl += '&mute=1';
                    }

                    var iframe = '<div class="woostify-product-video-container"><iframe src="' + embedUrl + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';

                    if (wrapper.find('.woostify-product-video-container').length === 0) {
                        wrapper.append(iframe);
                    }
                    wrapper.addClass('playing-video');
                }
            }
        },

        getYoutubeId: function (url) {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                return match[2];
            } else {
                return null;
            }
        },

        initPhotoswipe: function () {
            // Hook into Photoswipe open event if possible
            // Woostify uses 'photoswipe-init.js'

            // We can listen to the 'pswpBeforeOpen' event on the global PhotoSwipe object if available, 
            // but often it's encapsulated. 
            // Alternatively, observe the DOM for .pswp being open
        }
    };

    $(document).ready(function () {
        WoostifyProductVideo.init();
    });

})(jQuery);
