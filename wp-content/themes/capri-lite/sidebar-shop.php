<?php
/**
 * Template for sidebar on shop page.
 * The sidebar containing the widget area for shop page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
	return;
}
?>
<div class="capri-sidebar">
	<span class="capri-sidebar-close"><i class="fa fa-times" aria-hidden="true"></i></span>
	<aside id="secondary" class="widget-area widget-area-shop">
		<?php dynamic_sidebar( 'sidebar-shop' ); ?>
	</aside><!-- #secondary -->
</div>
