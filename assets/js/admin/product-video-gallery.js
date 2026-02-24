jQuery(document).ready(function ($) {
    'use strict';

    var VideoGallery = {
        init: function () {
            this.currentAttachmentId = null;
            this.modal = $('#woostify-product-video-modal');
            this.saveBtn = this.modal.find('.woostify-save-video');
            this.closeBtn = this.modal.find('.woostify-modal-close, .woostify-modal-overlay');

            this.injectVideoButtons();

            // Re-inject buttons when WooCommerce gallery updates
            $(document).ajaxComplete(function (event, xhr, settings) {
                if (settings.data && settings.data.indexOf('action=woocommerce_add_product_gallery_image') !== -1) {
                    setTimeout(function () {
                        VideoGallery.injectVideoButtons();
                    }, 500);
                }
            });

            this.bindEvents();
        },

        injectVideoButtons: function () {
            var videoMap = woostify_product_video_gallery.video_exists || {};

            // Main Product Image
            var mainImageContainer = $('#postimagediv .inside');
            if (mainImageContainer.find('.woostify-add-video-btn').length === 0 && mainImageContainer.find('#set-post-thumbnail img').length > 0) {
                var mainThumbId = $('#_thumbnail_id').val();
                var mainClass = (videoMap[mainThumbId]) ? 'has-video' : '';
                $('<button type="button" class="button woostify-add-video-btn ' + mainClass + '" data-attachment-id="' + mainThumbId + '">Video</button>')
                    .insertAfter('#remove-post-thumbnail');
            }

            // Gallery Images
            $('#product_images_container .image').each(function () {
                var $li = $(this);
                if ($li.find('.woostify-add-video-btn').length === 0) {
                    var attachmentId = $li.attr('data-attachment_id');
                    var galClass = (videoMap[attachmentId]) ? 'has-video' : '';
                    $li.append('<button type="button" class="button woostify-add-video-btn ' + galClass + '" data-attachment-id="' + attachmentId + '">Video</button>');
                }
            });
        },

        bindEvents: function () {
            var self = this;

            // Open Modal
            $(document).on('click', '.woostify-add-video-btn', function (e) {
                e.preventDefault();
                self.currentAttachmentId = $(this).data('attachment-id');
                self.currentButton = $(this); // Store reference

                // If main image button clicked, update ID just in case it changed
                if ($(this).parent().attr('id') === 'postimagediv') {
                    self.currentAttachmentId = $('#_thumbnail_id').val();
                }

                self.openModal();
                self.loadData(self.currentAttachmentId);
            });

            // Close Modal
            this.closeBtn.on('click', function () {
                self.closeModal();
            });

            // Tab Switching
            this.modal.on('click', '.woostify-tab-btn', function () {
                var tab = $(this).data('tab');

                // Tabs
                $('.woostify-tab-btn').removeClass('active');
                $(this).addClass('active');

                // Content
                $('.woostify-tab-content').hide();
                $('#woostify-tab-' + tab).show();

                // Hidden input
                $('#woostify-video-source').val(tab);
            });

            // MP4 Upload
            this.modal.on('click', '#woostify-upload-mp4-btn', function (e) {
                e.preventDefault();

                var frame = wp.media({
                    title: 'Select or Upload Video',
                    button: {
                        text: 'Use this video'
                    },
                    multiple: false,
                    library: {
                        type: 'video'
                    }
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#woostify-mp4-url').val(attachment.url);
                });

                frame.open();
            });

            // Audio Status Buttons
            this.modal.on('click', '.woostify-btn-audio', function () {
                var value = $(this).data('value');
                $('.woostify-btn-audio').removeClass('active');
                $(this).addClass('active');
                $('#woostify-video-mute').val(value);
            });

            // Autoplay Toggle
            $('#woostify-video-autoplay').on('change', function () {
                self.toggleAudioOption();
            });

            // Save Data
            this.saveBtn.on('click', function () {
                self.saveData();
            });
        },

        toggleAudioOption: function () {
            var isAutoplay = $('#woostify-video-autoplay').is(':checked');
            var audioGroup = $('#woostify-video-mute').closest('.woostify-form-group');

            if (isAutoplay) {
                audioGroup.hide();
            } else {
                audioGroup.show();
            }
        },

        openModal: function () {
            this.modal.fadeIn(200);
        },

        closeModal: function () {
            this.modal.fadeOut(200);
            this.currentAttachmentId = null;
            this.currentButton = null;

            // Reset fields
            $('#woostify-video-source').val('youtube');
            $('#woostify-video-url').val('');
            $('#woostify-mp4-url').val('');
            $('#woostify-video-autoplay').prop('checked', false);

            // Reset Tabs
            $('.woostify-tab-btn').removeClass('active');
            $('.woostify-tab-btn[data-tab="youtube"]').addClass('active');
            $('.woostify-tab-content').hide();
            $('#woostify-tab-youtube').show();

            // Default to Unmute (0)
            $('#woostify-video-mute').val('0');
            $('.woostify-btn-audio').removeClass('active');
            $('.woostify-btn-audio[data-value="0"]').addClass('active');

            // Reset visibility
            this.toggleAudioOption();
        },

        loadData: function (id) {
            var self = this;
            if (!id) return;

            // Show loading state if needed
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'woostify_get_attachment_video_data',
                    nonce: woostify_product_video_gallery.nonce,
                    attachment_id: id
                },
                success: function (response) {
                    if (response.success) {
                        var data = response.data;
                        var source = data.source || 'youtube';

                        // Set Source Tab
                        $('.woostify-tab-btn[data-tab="' + source + '"]').trigger('click');

                        // Set URL
                        if (source === 'mp4') {
                            $('#woostify-mp4-url').val(data.url || '');
                        } else {
                            $('#woostify-video-url').val(data.url || '');
                        }

                        // Set Autoplay
                        var isAutoplay = (data.autoplay === 'true' || data.autoplay === '1' || data.autoplay === true);
                        $('#woostify-video-autoplay').prop('checked', isAutoplay);

                        // Set Mute Status
                        var muteStatus = (data.mute === '1' || data.mute === 1) ? '1' : '0';
                        $('#woostify-video-mute').val(muteStatus);
                        $('.woostify-btn-audio').removeClass('active');
                        $('.woostify-btn-audio[data-value="' + muteStatus + '"]').addClass('active');

                        // Update UI visibility
                        self.toggleAudioOption();
                    }
                }
            });
        },

        saveData: function () {
            var self = this;
            if (!this.currentAttachmentId) return;

            var source = $('#woostify-video-source').val();
            var url = (source === 'mp4') ? $('#woostify-mp4-url').val() : $('#woostify-video-url').val();
            var autoplay = $('#woostify-video-autoplay').is(':checked');
            var mute = $('#woostify-video-mute').val();

            this.saveBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'woostify_save_attachment_video_data',
                    nonce: woostify_product_video_gallery.nonce,
                    attachment_id: self.currentAttachmentId,
                    source: source,
                    url: url,
                    autoplay: autoplay,
                    mute: mute
                },
                success: function (response) {
                    self.saveBtn.prop('disabled', false).text('Save');

                    // Update frontend state
                    if (url && url.length > 0) {
                        if (self.currentButton) self.currentButton.addClass('has-video');
                        // Update global map just in case
                        if (!woostify_product_video_gallery.video_exists) woostify_product_video_gallery.video_exists = {};
                        woostify_product_video_gallery.video_exists[self.currentAttachmentId] = true;
                    } else {
                        if (self.currentButton) self.currentButton.removeClass('has-video');
                        if (woostify_product_video_gallery.video_exists) {
                            delete woostify_product_video_gallery.video_exists[self.currentAttachmentId];
                        }
                    }

                    self.closeModal();
                },
                error: function () {
                    self.saveBtn.prop('disabled', false).text('Save');
                    alert('Error saving data.');
                }
            });
        }
    };

    VideoGallery.init();
});
