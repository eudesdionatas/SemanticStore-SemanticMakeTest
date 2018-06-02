<?php
/**
 * Post template.
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content' ); ?>>
	<header class="entry-header">
		<?php

		if ( has_post_thumbnail() ) :
		?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="thumbnail-wrap">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</a>
		<?php endif; ?>

		<div class="entry-header-title-wrap 
		<?php
		if ( ! has_post_thumbnail() ) {
			echo 'without-featured-image';}
?>
">

			<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
			?>
				<div class="entry-meta">
					<?php capri_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
			endif;
			?>

		</div>

	</header><!-- .entry-header -->
	<div class="entry-content<?php echo ! is_single() ? ' entry-content-blog' : ''; ?>">
		<?php
		$capri_more = strpos( $post->post_content, '<!--more' );

		if ( $capri_more || is_single() ) {
			the_content(
				sprintf(
					/* translators: %s: Name of current post. */
					esc_html__( 'Continue reading %s', 'capri-lite' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);
		} else {
			the_excerpt();
		}

		if ( is_single() ) {
			capri_entry_footer();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'capri-lite' ),
					'after'  => '</div>',
				)
			);

		}
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
