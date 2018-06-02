/**
 * File capri-text-editor.js
 *
 * This file checks when user write in the editor and saves the content for this control.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/* global tinyMCE */
( function( $ ) {
	$( document ).on(
		'tinymce-editor-init', function() {
			$( '.customize-control' ).find( '.wp-editor-area' ).each(
				function(){
					var tArea = $( this ),
					id        = tArea.attr( 'id' ),
					input     = $( 'input[data-customize-setting-link="' + id + '"]' ),
					editor    = tinyMCE.get( id ),
					content;

					if (editor) {
						editor.onChange.add(
							function () {
								this.save();
								content = editor.getContent();
								input.val( content ).trigger( 'change' );
							}
						);
					}

					tArea.css(
						{
							visibility: 'visible'
						}
					).on(
						'keyup', function(){
							content = tArea.val();
							input.val( content ).trigger( 'change' );
						}
					);
				}
			);
		}
	);
} )( jQuery );
