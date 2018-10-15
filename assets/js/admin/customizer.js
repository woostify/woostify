/* global _wpCustomizeSFGuidedTourSteps */
( function( wp, $ ) {
	'use strict';

	if ( ! wp || ! wp.customize ) {
		return;
	}

	// Set up our namespace.
	var api = wp.customize;

	api.SFGuidedTourSteps = [];

	if ( 'undefined' !== typeof _wpCustomizeSFGuidedTourSteps ) {
		$.extend( api.SFGuidedTourSteps, _wpCustomizeSFGuidedTourSteps );
	}

	/**
	 * Wp.customize.SFGuidedTour
	 */
	api.SFGuidedTour = {
		$container: null,
		currentStep: -1,

		init: function() {
			this._setupUI();
		},

		_setupUI: function() {
			var self = this,
				$wpCustomize = $( 'body.wp-customizer .wp-full-overlay' );

			this.$container = $( '<div/>' ).addClass( 'woostify-guided-tour' );

			// Add guided tour div.
			$wpCustomize.prepend( this.$container );

			// Add listeners.
			this._addListeners();

			// Initial position.
			this.$container.css( 'left', ( $( '#customize-controls' ).width() + 10 ) + 'px' ).on( 'transitionend', function() {
				self.$container.addClass( 'woostify-loaded' );
			});

			// Show first step.
			this._showNextStep();

			$( document ).on( 'click', '.woostify-guided-tour-step .woostify-nux-button', function() {
				self._showNextStep();
				return false;
			});

			$( document ).on( 'click', '.woostify-guided-tour-step .woostify-guided-tour-skip', function() {
				if ( 0 === self.currentStep ) {
					self._hideTour( true );
				} else {
					self._showNextStep();
				}

				return false;
			});
		},

		_addListeners: function() {
			var self = this;

			api.state( 'expandedSection' ).bind( function() {
				self._adjustPosition();
			});

			api.state( 'expandedPanel' ).bind( function() {
				self._adjustPosition();
			});
		},

		_adjustPosition: function() {
			var step            = this._getCurrentStep(),
				expandedSection = api.state( 'expandedSection' ).get(),
				expandedPanel   = api.state( 'expandedPanel' ).get();

			if ( ! step ) {
				return;
			}

			this.$container.removeClass( 'woostify-inside-section' );

			if ( expandedSection && step.section === expandedSection.id ) {
				this._moveContainer( $( expandedSection.container[1] ).find( '.customize-section-title' ) );
				this.$container.addClass( 'woostify-inside-section' );
			} else if ( false === expandedSection && false === expandedPanel ) {
				if ( this._isTourHidden() ) {
					this._revealTour();
				} else {
					var selector = this._getSelector( step.section );
					this._moveContainer( selector );
				}
			} else {
				this._hideTour();
			}
		},

		_hideTour: function( remove ) {
			var self = this;

			// Already hidden?
			if ( this._isTourHidden() ) {
				return;
			}

			this.$container.css({
				transform: '',
				top: this.$container.offset().top
			});

			$( document.body ).addClass( 'woostify-exiting' ).on( 'animationend.woostify webkitAnimationEnd.woostify', function() {
				$( this ).removeClass( 'woostify-exiting' ).off( 'animationend.woostify webkitAnimationEnd.woostify' ).addClass( 'woostify-hidden' );
				self.$container.hide();

				if ( ! _.isUndefined( remove ) && true === remove ) {
					self._removeTour();
				}
			});
		},

		_revealTour: function() {
			 var self = this;

			$( document.body ).removeClass( 'woostify-hidden' );

			self.$container.show();

			$( document.body ).addClass( 'woostify-entering' ).on( 'animationend.woostify webkitAnimationEnd.woostify', function() {
				$( this ).removeClass( 'woostify-entering' ).off( 'animationend.woostify webkitAnimationEnd.woostify' );

				self.$container.css({
					top: 'auto',
					transform: 'translateY(' + parseInt( self.$container.offset().top, 10 ) + 'px)'
				});
			});
		},

		_removeTour: function() {
			this.$container.remove();
		},

		_closeAllSections: function() {
			api.section.each( function ( section ) {
				section.collapse( { duration: 0 } );
			});

			api.panel.each( function ( panel ) {
				panel.collapse( { duration: 0 } );
			});
		},

		_showNextStep: function() {
			var step, template;

			if ( this._isLastStep() ) {
				this._hideTour( true );
				return;
			}

			this._closeAllSections();

			// Get next step.
			step = this._getNextStep();

			// Convert line breaks to paragraphs.
			step.message = this._lineBreaksToParagraphs( step.message );

			// Load template.
			template = wp.template( 'woostify-guided-tour-step' );

			this.$container.removeClass( 'woostify-first-step' );

			if ( 0 === this.currentStep ) {
				step.first_step = true;
				this.$container.addClass( 'woostify-first-step' );
			}

			if ( this._isLastStep() ) {
				step.last_step = true;
				this.$container.addClass( 'woostify-last-step' );
			}

			this._moveContainer( this._getSelector( step.section ) );

			this.$container.html( template( step ) );
		},

		_moveContainer: function( $selector ) {
			var self = this, position;

			if ( ! $selector ) {
				return;
			}

			position = parseInt( $selector.offset().top, 10 ) + ( $selector.height() / 2 ) - 44;

			this.$container.addClass( 'woostify-moving' ).css( { 'transform': 'translateY(' + parseInt( position, 10 ) + 'px)' } ).on( 'transitionend.woostify', function() {
				self.$container.removeClass( 'woostify-moving' );
				self.$container.off( 'transitionend.woostify' );
			} );
		},

		_getSelector: function( pointTo ) {
			var sectionOrPanel = api.section( pointTo ) ? api.section( pointTo ) : api.panel( pointTo );

			// Check whether this is a section, panel, or a regular selector.
			if ( ! _.isUndefined( sectionOrPanel ) ) {
				return $( sectionOrPanel.container[0] );
			}

			return $( pointTo );
		},

		_getCurrentStep: function() {
			return api.SFGuidedTourSteps[ this.currentStep ];
		},

		_getNextStep: function() {
			this.currentStep = this.currentStep + 1;
			return api.SFGuidedTourSteps[ this.currentStep ];
		},

		_isTourHidden: function() {
			return ( ( $( document.body ).hasClass( 'woostify-hidden' ) ) ? true : false );
		},

		_isLastStep: function() {
			return ( ( ( this.currentStep + 1 ) < api.SFGuidedTourSteps.length ) ? false : true );
		},

		_lineBreaksToParagraphs: function( message ) {
			return '<p>' + message.replace( '\n\n', '</p><p>' ) + '</p>';
		}
	};

	$( document ).ready( function() {
		api.SFGuidedTour.init();
	});
} )( window.wp, jQuery );
