<?php
/**
 * Sidebar template.
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<div class="capri-sidebar">
	<span class="capri-sidebar-close"><i class="fa fa-times" aria-hidden="true"></i></span>
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- #secondary -->
</div>
