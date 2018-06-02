/**
 * File customizer_multiple_choice.js
 *
 * Deactivate None item if others are selected.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/* global jQuery */
jQuery( document ).ready(
	function () {
		'use strict';

		var theme_conrols = jQuery( '#customize-theme-controls' );
		var multi_select  = jQuery( '.capri-multiple-select' );
		theme_conrols.on(
			'click', '.capri-multiple-select', function () {
				if ( jQuery( this ).children( ':selected' ).length === 0 ) {
					multi_select.val( 'none' );
				}
				var values = multi_select.val();
				if (values.length > 1) {
					var index = values.indexOf( 'none' );
					if (index > -1) {
						values.splice( index, 1 );
					}
					multi_select.val( values );
				}
				jQuery( this ).trigger( 'change' );
				event.preventDefault();
			}
		);
	}
);
