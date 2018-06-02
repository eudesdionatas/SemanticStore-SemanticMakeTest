/**
 * File capri-update-controls.js
 *
 * This file syncs Customizer text editor control and Section background after you make set the front page as static
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/* global requestpost */
/* global wp */
/* global tinyMCE */
( function( $ ) {
	'use strict';
	wp.customize(
		'page_on_front', function( value ) {
			value.bind(
				function( newval ) {
					$.ajax(
						{
							url: requestpost.ajaxurl,
							type: 'post',
							data: {
								action: 'capri_ajax_call',
								pid: newval
							},

							success: function (result) {
								if (result !== '' && result !== 'undefined' ) {
									result     = JSON.parse( result );
									var id     = 'capri_page_editor';
									var editor = tinyMCE.get( id );

									editor.setContent( result.post_content );

									if (result.post_thumbnail !== '' && result.post_thumbnail !== 'undefined') {
										wp.customize.instance( requestpost.thumbnail_control ).set( result.post_thumbnail );
										wp.customize.control( requestpost.thumbnail_control ).container['0'].innerHTML = '<label for="capri_feature_thumbnail-button">' +
										'<span class="customize-control-title">' + requestpost.control_title_label + '</span>' +
										'</label>' +
										'<div class="attachment-media-view attachment-media-view-image landscape">' +
										'<div class="thumbnail thumbnail-image">' +
										'<img class="attachment-thumb" src="' + result.post_thumbnail + '" draggable="false" alt=""> ' +
										'</div>' +
										'<div class="actions">' +
										'<button type="button" class="button remove-button">' + requestpost.control_remove_label + '</button>' +
										'<button type="button" class="button upload-button control-focus" id="capri_feature_thumbnail-button">' + requestpost.control_change_label + '</button> ' +
										'<div style="clear:both"></div>' +
										'</div>' +
										'</div>';
									}
									wp.customize.instance( requestpost.editor_control ).previewer.refresh();
								}
							}
						}
					);
				}
			);
		}
	);
} )( jQuery );
