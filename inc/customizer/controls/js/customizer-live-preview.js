/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @param id
 * @param selector
 * @param property
 * @param default_value
 * @param get_value
 */
function webpress_colors_live_update( id, selector, property, default_value, get_value ) {
	default_value = typeof default_value !== 'undefined' ? default_value : 'initial';
	get_value = typeof get_value !== 'undefined' ? get_value : '';

	wp.customize( 'webpress_settings[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			default_value = ( '' !== get_value ) ? wp.customize.value( 'webpress_settings[' + get_value + ']' )() : default_value;
			newval = ( '' !== newval ) ? newval : default_value;

			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + ';}' );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + '}</style>' );
				setTimeout( function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 1000 );
			}
		} );
	} );
}

function webpress_classes_live_update( id, classes, selector, prefix ) {
	classes = typeof classes !== 'undefined' ? classes : '';
	prefix = typeof prefix !== 'undefined' ? prefix : '';
	wp.customize( 'webpress_settings[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			jQuery.each( classes, function( i, v ) {
				jQuery( selector ).removeClass( prefix + v );
			} );
			jQuery( selector ).addClass( prefix + newval );
		} );
	} );
}

( function( $ ) {
	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.main-title a' ).html( newval );
		} );
	} );

	//Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );

	wp.customize( 'webpress_settings[logo_width]', function( value ) {
		value.bind( function( newval ) {
			$( '.site-header .header-image' ).css( 'width', newval + 'px' );

			if ( '' == newval ) {
				$( '.site-header .header-image' ).css( 'width', '' );
			}
		} );
	} );

	/**
	 * Container width
	 */
	wp.customize( 'webpress_settings[container_width]', function( value ) {
		value.bind( function( newval ) {
			if ( jQuery( 'style#container_width' ).length ) {
				jQuery( 'style#container_width' ).html( 'body .grid-container, .wp-block-group__inner-container{max-width:' + newval + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="container_width">body .grid-container, .wp-block-group__inner-container{max-width:' + newval + 'px;}</style>' );
				setTimeout( function() {
					jQuery( 'style#container_width' ).not( ':last' ).remove();
				}, 100 );
			}
			jQuery( 'body' ).trigger( 'webpress_spacing_updated' );
		} );
	} );

	/**
	 * Top bar width
	 */
	wp.customize( 'webpress_settings[top_bar_width]', function( value ) {
		value.bind( function( newval ) {
			if ( 'full' == newval ) {
				$( '.top-bar' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
				if ( 'contained' == wp.customize.value( 'webpress_settings[top_bar_inner_width]' )() ) {
					$( '.inside-top-bar' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				}
			}
			if ( 'contained' == newval ) {
				$( '.top-bar' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				$( '.inside-top-bar' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Inner top bar width
	 */
	wp.customize( 'webpress_settings[top_bar_inner_width]', function( value ) {
		value.bind( function( newval ) {
			if ( 'full' == newval ) {
				$( '.inside-top-bar' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
			if ( 'contained' == newval ) {
				$( '.inside-top-bar' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Top bar alignment
	 */
	webpress_classes_live_update( 'top_bar_alignment', [ 'left', 'center', 'right' ], '.top-bar', 'top-bar-align-' );

	/**
	 * Header layout
	 */
	wp.customize( 'webpress_settings[header_layout_setting]', function( value ) {
		value.bind( function( newval ) {
			if ( 'fluid-header' == newval ) {
				$( '.site-header' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
				if ( 'contained' == wp.customize.value( 'webpress_settings[header_inner_width]' )() ) {
					$( '.inside-header' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				}
			}
			if ( 'contained-header' == newval ) {
				$( '.site-header' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				$( '.inside-header' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Inner Header layout
	 */
	wp.customize( 'webpress_settings[header_inner_width]', function( value ) {
		value.bind( function( newval ) {
			if ( 'full-width' == newval ) {
				$( '.inside-header' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
			if ( 'contained' == newval ) {
				$( '.inside-header' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Header alignment
	 */
	webpress_classes_live_update( 'header_alignment_setting', [ 'left', 'center', 'right' ], 'body', 'header-aligned-' );

	/**
	 * Navigation width
	 */
	wp.customize( 'webpress_settings[nav_layout_setting]', function( value ) {
		value.bind( function( newval ) {
			var navLocation = wp.customize.value( 'webpress_settings[nav_position_setting]' )();

			if ( $( 'body' ).hasClass( 'sticky-enabled' ) ) {
				wp.customize.preview.send( 'refresh' );
			} else {
				var mainNavigation = $( '.main-navigation' );

				if ( 'fluid-nav' == newval ) {
					mainNavigation.removeClass( 'grid-container' ).removeClass( 'grid-parent' );
					if ( 'full-width' !== wp.customize.value( 'webpress_settings[nav_inner_width]' )() ) {
						$( '.main-navigation .inside-navigation' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
					}
				}
				if ( 'contained-nav' == newval ) {
					if ( ! mainNavigation.hasClass( 'has-branding' ) && webpress_live_preview.isFlex && ( 'nav-float-right' === navLocation || 'nav-float-left' === navLocation ) ) {
						return;
					}

					mainNavigation.addClass( 'grid-container' ).addClass( 'grid-parent' );
				}
			}
		} );
	} );

	/**
	 * Inner navigation width
	 */
	wp.customize( 'webpress_settings[nav_inner_width]', function( value ) {
		value.bind( function( newval ) {
			if ( 'full-width' == newval ) {
				$( '.main-navigation .inside-navigation' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
			if ( 'contained' == newval ) {
				$( '.main-navigation .inside-navigation' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Navigation alignment
	 */
	wp.customize( 'webpress_settings[nav_alignment_setting]', function( value ) {
		value.bind( function( newval ) {
			var classes = [ 'left', 'center', 'right' ];
			var selector = 'body';
			var prefix = 'nav-aligned-';

			if ( webpress_live_preview.isFlex ) {
				selector = '.main-navigation:not(.slideout-navigation)';
				prefix = 'nav-align-';
			}

			jQuery.each( classes, function( i, v ) {
				jQuery( selector ).removeClass( prefix + v );
			} );

			if ( webpress_live_preview.isFlex && webpress_live_preview.isRTL ) {
				jQuery( selector ).addClass( prefix + newval );
			} else if ( 'nav-align-left' !== prefix + newval ) {
				jQuery( selector ).addClass( prefix + newval );
			}
		} );
	} );

	/**
	 * Footer width
	 */
	wp.customize( 'webpress_settings[footer_layout_setting]', function( value ) {
		value.bind( function( newval ) {
			if ( 'fluid-footer' == newval ) {
				$( '.site-footer' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
			if ( 'contained-footer' == newval ) {
				$( '.site-footer' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Inner footer width
	 */
	wp.customize( 'webpress_settings[footer_inner_width]', function( value ) {
		value.bind( function( newval ) {
			if ( 'full-width' == newval ) {
				if ( $( '.footer-widgets-container' ).length ) {
					$( '.footer-widgets-container' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
				} else {
					$( '.inside-footer-widgets' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
				}
				$( '.inside-site-info' ).removeClass( 'grid-container' ).removeClass( 'grid-parent' );
			}
			if ( 'contained' == newval ) {
				if ( $( '.footer-widgets-container' ).length ) {
					$( '.footer-widgets-container' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				} else {
					$( '.inside-footer-widgets' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
				}
				$( '.inside-site-info' ).addClass( 'grid-container' ).addClass( 'grid-parent' );
			}
		} );
	} );

	/**
	 * Footer bar alignment
	 */
	webpress_classes_live_update( 'footer_bar_alignment', [ 'left', 'center', 'right' ], '.site-footer', 'footer-bar-align-' );

	jQuery( 'body' ).on( 'webpress_spacing_updated', function() {
		var containerAlignment = wp.customize( 'webpress_settings[container_alignment]' ).get(),
			containerWidth = wp.customize( 'webpress_settings[container_width]' ).get(),
			containerLayout = wp.customize( 'webpress_settings[content_layout_setting]' ).get(),
			contentLeft = webpress_live_preview.contentLeft,
			contentRight = webpress_live_preview.contentRight;

		if ( ! webpress_live_preview.isFlex && 'text' === containerAlignment ) {
			if ( typeof wp.customize( 'webpress_spacing_settings[content_left]' ) !== 'undefined' ) {
				contentLeft = wp.customize( 'webpress_spacing_settings[content_left]' ).get();
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[content_right]' ) !== 'undefined' ) {
				contentRight = wp.customize( 'webpress_spacing_settings[content_right]' ).get();
			}

			var newContainerWidth = Number( containerWidth ) + Number( contentLeft ) + Number( contentRight );

			if ( jQuery( 'style#wide_container_width' ).length ) {
				jQuery( 'style#wide_container_width' ).html( 'body:not(.full-width-content) #page{max-width:' + newContainerWidth + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="wide_container_width">body:not(.full-width-content) #page{max-width:' + newContainerWidth + 'px;}</style>' );
				setTimeout( function() {
					jQuery( 'style#wide_container_width' ).not( ':last' ).remove();
				}, 100 );
			}
		}

		if ( webpress_live_preview.isFlex && 'boxes' === containerAlignment ) {
			var topBarPaddingLeft = jQuery( '.inside-top-bar' ).css( 'padding-left' ),
				topBarPaddingRight = jQuery( '.inside-top-bar' ).css( 'padding-right' ),
				headerPaddingLeft = jQuery( '.inside-header' ).css( 'padding-left' ),
				headerPaddingRight = jQuery( '.inside-header' ).css( 'padding-right' ),
				footerWidgetPaddingLeft = jQuery( '.footer-widgets-container' ).css( 'padding-left' ),
				footerWidgetPaddingRight = jQuery( '.footer-widgets-container' ).css( 'padding-right' ),
				footerBarPaddingLeft = jQuery( '.inside-footer-bar' ).css( 'padding-left' ),
				footerBarPaddingRight = jQuery( '.inside-footer-bar' ).css( 'padding-right' );

			if ( typeof wp.customize( 'webpress_spacing_settings[top_bar_left]' ) !== 'undefined' ) {
				topBarPaddingLeft = wp.customize( 'webpress_spacing_settings[top_bar_left]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[top_bar_right]' ) !== 'undefined' ) {
				topBarPaddingRight = wp.customize( 'webpress_spacing_settings[top_bar_right]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[header_left]' ) !== 'undefined' ) {
				headerPaddingLeft = wp.customize( 'webpress_spacing_settings[header_left]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[header_right]' ) !== 'undefined' ) {
				headerPaddingRight = wp.customize( 'webpress_spacing_settings[header_right]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[footer_widget_container_left]' ) !== 'undefined' ) {
				footerWidgetPaddingLeft = wp.customize( 'webpress_spacing_settings[footer_widget_container_left]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[footer_widget_container_right]' ) !== 'undefined' ) {
				footerWidgetPaddingRight = wp.customize( 'webpress_spacing_settings[footer_widget_container_right]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[footer_left]' ) !== 'undefined' ) {
				footerBarPaddingLeft = wp.customize( 'webpress_spacing_settings[footer_left]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[footer_right]' ) !== 'undefined' ) {
				footerBarPaddingRight = wp.customize( 'webpress_spacing_settings[footer_right]' ).get() + 'px';
			}

			var newTopBarWidth = parseFloat( containerWidth ) + parseFloat( topBarPaddingLeft ) + parseFloat( topBarPaddingRight ),
				newHeaderWidth = parseFloat( containerWidth ) + parseFloat( headerPaddingLeft ) + parseFloat( headerPaddingRight ),
				newFooterWidgetWidth = parseFloat( containerWidth ) + parseFloat( footerWidgetPaddingLeft ) + parseFloat( footerWidgetPaddingRight ),
				newFooterBarWidth = parseFloat( containerWidth ) + parseFloat( footerBarPaddingLeft ) + parseFloat( footerBarPaddingRight );

			if ( jQuery( 'style#box_sizing_widths' ).length ) {
				jQuery( 'style#box_sizing_widths' ).html( '.inside-top-bar.grid-container{max-width:' + newTopBarWidth + 'px;}.inside-header.grid-container{max-width:' + newHeaderWidth + 'px;}.footer-widgets-container.grid-container{max-width:' + newFooterWidgetWidth + 'px;}.inside-site-info.grid-container{max-width:' + newFooterBarWidth + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="box_sizing_widths">.inside-top-bar.grid-container{max-width:' + newTopBarWidth + 'px;}.inside-header.grid-container{max-width:' + newHeaderWidth + 'px;}.footer-widgets-container.grid-container{max-width:' + newFooterWidgetWidth + 'px;}.inside-site-info.grid-container{max-width:' + newFooterBarWidth + 'px;}</style>' );
				setTimeout( function() {
					jQuery( 'style#box_sizing_widths' ).not( ':last' ).remove();
				}, 100 );
			}
		}

		if ( webpress_live_preview.isFlex && 'text' === containerAlignment ) {
			var headerPaddingLeft = jQuery( '.inside-header' ).css( 'padding-left' ),
				headerPaddingRight = jQuery( '.inside-header' ).css( 'padding-right' ),
				menuItemPadding = jQuery( '.main-navigation .main-nav ul li a' ).css( 'padding-left' ),
				secondaryMenuItemPadding = jQuery( '.secondary-navigation .main-nav ul li a' ).css( 'padding-left' );

			if ( typeof wp.customize( 'webpress_spacing_settings[header_left]' ) !== 'undefined' ) {
				headerPaddingLeft = wp.customize( 'webpress_spacing_settings[header_left]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[header_right]' ) !== 'undefined' ) {
				headerPaddingRight = wp.customize( 'webpress_spacing_settings[header_right]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[menu_item]' ) !== 'undefined' ) {
				menuItemPadding = wp.customize( 'webpress_spacing_settings[menu_item]' ).get() + 'px';
			}

			if ( typeof wp.customize( 'webpress_spacing_settings[secondary_menu_item]' ) !== 'undefined' ) {
				secondaryMenuItemPadding = wp.customize( 'webpress_spacing_settings[secondary_menu_item]' ).get() + 'px';
			}

			var newNavPaddingLeft = parseFloat( headerPaddingLeft ) - parseFloat( menuItemPadding ),
				newNavPaddingRight = parseFloat( headerPaddingRight ) - parseFloat( menuItemPadding ),
				newSecondaryNavPaddingLeft = parseFloat( headerPaddingLeft ) - parseFloat( secondaryMenuItemPadding ),
				newSecondaryNavPaddingRight = parseFloat( headerPaddingRight ) - parseFloat( secondaryMenuItemPadding );

			if ( jQuery( 'style#navigation_padding' ).length ) {
				jQuery( 'style#navigation_padding' ).html( '.nav-below-header .main-navigation .inside-navigation.grid-container, .nav-above-header .main-navigation .inside-navigation.grid-container{padding: 0 ' + newNavPaddingRight + 'px 0 ' + newNavPaddingLeft + 'px;}' );
				jQuery( 'style#secondary_navigation_padding' ).html( '.secondary-nav-below-header .secondary-navigation .inside-navigation.grid-container, .secondary-nav-above-header .secondary-navigation .inside-navigation.grid-container{padding: 0 ' + newSecondaryNavPaddingRight + 'px 0 ' + newSecondaryNavPaddingLeft + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="navigation_padding">.nav-below-header .main-navigation .inside-navigation.grid-container, .nav-above-header .main-navigation .inside-navigation.grid-container{padding: 0 ' + newNavPaddingRight + 'px 0 ' + newNavPaddingLeft + 'px;}</style>' );
				jQuery( 'head' ).append( '<style id="secondary_navigation_padding">.secondary-nav-below-header .secondary-navigation .inside-navigation.grid-container, .secondary-nav-above-header .secondary-navigation .inside-navigation.grid-container{padding: 0 ' + newSecondaryNavPaddingRight + 'px 0 ' + newSecondaryNavPaddingLeft + 'px;}</style>' );
				setTimeout( function() {
					jQuery( 'style#navigation_padding' ).not( ':last' ).remove();
					jQuery( 'style#secondary_navigation_padding' ).not( ':last' ).remove();
				}, 100 );
			}
		}
	} );

	wp.customize( 'webpress_settings[global_colors]', function( value ) {
		value.bind( function( newval ) {
			var globalColors = '';

			newval.forEach( function( item ) {
				globalColors += '--' + item.slug + ':' + item.color + ';';
			} );

			if ( $( 'style#global_colors' ).length ) {
				$( 'style#global_colors' ).html( ':root{' + globalColors + '}' );
			} else {
				$( 'head' ).append( '<style id="global_colors">:root{' + globalColors + '}</style>' );

				setTimeout( function() {
					$( 'style#global_colors' ).not( ':last' ).remove();
				}, 100 );
			}
		} );
	} );
}( jQuery ) );
