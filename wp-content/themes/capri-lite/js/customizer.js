/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

( function( $ ) {

	// Header text color.
	wp.customize(
		'header_textcolor', function( value ) {
			value.bind(
				function( to ) {
					var site_details = $( '.site-title a, .site-description' );
					if ( 'blank' === to ) {
						site_details.css(
							{
								'clip': 'rect(1px, 1px, 1px, 1px)',
								'position': 'absolute'
							}
						);
					} else {
						site_details.css(
							{
								'clip': 'auto',
								'position': 'relative'
							}
						);
						site_details.css(
							{
								'color': to
							}
						);
					}
				}
			);
		}
	);

} )( jQuery );
