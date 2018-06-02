/**
 * File functions.js
 *
 * Scripts used in theme
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

( function($) {

	$( document ).ready(
		function(){

			if ( capriGetWidth() <= 992 ) {
				sidebarToggle();
			}

		}
	);

	$( window ).resize(
		function() {

			if ( capriGetWidth() <= 992 ) {
				sidebarToggle();
			}

		}
	);

}(jQuery));


/**
 * Get window width depending on the browser
 *
 * @since   1.0.0
 * @access  public
 */
function capriGetWidth() {
	if (this.innerWidth) {
		return this.innerWidth;
	}

	if (document.documentElement && document.documentElement.clientWidth) {
		return document.documentElement.clientWidth;
	}

	if (document.body) {
		return document.body.clientWidth;
	}
}


/**
 * Sidebar toggle
 */
function sidebarToggle() {

	(function($){
		if ( $( '.capri-sidebar' ).length > 0 ) {

			$( '.capri-sidebar-open' ).click(
				function () {
					$( '.capri-sidebar' ).addClass( 'capri-sidebar-opened' ).css( {'width': '100%'} );
				}
			);

			$( '.capri-sidebar-close' ).click(
				function () {
					$( '.capri-sidebar' ).removeClass( 'capri-sidebar-opened' ).css( {'width': '0%'} );
				}
			);

		}
	})( jQuery );
}
