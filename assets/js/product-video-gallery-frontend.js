/**
 * Product Video Gallery Frontend JS
 */

(function ($) {
    'use strict';

    var WoostifyProductVideo = {
        init: function () {
            this.bindEvents();
            this.initPhotoswipe();
        },

        bindEvents: function () {
            var self = this;

            // Handle click on video icon in main gallery
            $(document).on('click', '.woostify-video-icon-main', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var wrapper = $(this).closest('.image-item');
                self.playVideo(wrapper);
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

            // Listen for slider change to stop playing videos
            // This depends on the slider library used (Flickity in this case)
            // We'll try to hook into the existing gallery events if possible, or observe changes.
            var $gallery = $('.product-gallery .product-images-container');
            if ($gallery.length) {
                // Using delegation for flickity events if possible, or mutation observer
                // Since we don't have direct access to the flickity instance easily without globals
                // We can simply stop videos when the active slide changes
            }
        },

        playVideo: function (wrapper) {
            var url = wrapper.data('video-url');
            var autoplay = wrapper.data('video-autoplay');
            var mute = wrapper.data('video-mute');

            if (!url) return;

            var videoId = this.getYoutubeId(url);
            if (videoId) {
                var embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0';

                if (mute == 1 || autoplay == 1) { // Force mute if autoplay or mute set
                    embedUrl += '&mute=1';
                }

                var iframe = '<div class="woostify-product-video-container" style="padding-bottom:' + (wrapper.outerHeight() / wrapper.outerWidth() * 100) + '%"><iframe src="' + embedUrl + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';

                // Replace image with iframe
                // We hide the image and icon, append iframe
                wrapper.find('img, .woostify-video-icon').hide();
                wrapper.find('a').hide(); // Hide the anchor tag which might be a zoom link
                if (wrapper.find('.woostify-product-video-container').length === 0) {
                    wrapper.append(iframe);
                }
                wrapper.addClass('playing-video');
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
