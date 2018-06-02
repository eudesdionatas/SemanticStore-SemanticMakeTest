/**
 * File woocommerce.js
 *
 * Scripts for WooCommerce compatibility
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/* global capriGetWidth */

( function($) {

	$( window ).load(
		function(){

			if ( capriGetWidth() <= 768 ) {
				setCartProductHeight();
			}

			detectiOS();

		}
	);

	$( document ).ready(
		function(){

			if ( capriGetWidth() >= 992 ) {
				headerCartBounce();
			}

		}
	);

	$( window ).resize(
		function() {

			if ( capriGetWidth() <= 768 ) {
				setCartProductHeight();
			}

			if ( capriGetWidth() >= 992 ) {
				headerCartBounce();
			}

		}
	);

	/**
	 * Set height for each .product-remove element on Cart page, under 768px
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	function setCartProductHeight() {
		if ( $( '.woocommerce-cart .woocommerce-cart-form' ).length > 0 ) {
			$( '.woocommerce-cart-form .product-remove' ).each(
				function() {
						$( this ).css(
							{
								'height': $( this ).parent().find( '.product-name' ).outerHeight()
							}
						);
				}
			);
		}
	}

	/**
	 * Header cart animation on hover
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	function headerCartBounce() {
		$( '.header-shopping-cart .navbar-cart-inner a' ).hover(
			function () {
				$( '.header-shopping-cart' ).toggleClass( 'anim-bounce-cart' );
			}
		);
	}

	/**
	 * Detect if browser is iPhone or iPad then add body class
	 */
	function detectiOS() {
		if ( $( '.single-product' ).length > 0 || $( '.woocommerce-cart' ).length > 0 ) {
			var iOS = /iPad|iPhone|iPod/.test( navigator.userAgent ) && ! window.MSStream;

			if ( iOS ) {
				$( 'body' ).addClass( 'is-ios' );
			}
		}
	}

}(jQuery));
