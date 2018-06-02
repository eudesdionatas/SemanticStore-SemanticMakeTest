<?php
/**
 * No posts template.
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'capri-lite' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
		?>
			<p>
				<?php
				printf(
					/* translators: $s is link to new post */
					esc_html__( 'Ready to publish your first post? %s.', 'capri-lite' ),
					/* translators: %1$s is url to new post, %2$s is link label */
					sprintf(
						'<a href="%1$s">%2$s</a>',
						esc_url( admin_url( 'post-new.php' ) ),
						esc_html__( 'Get started here', 'capri-lite' )
					)
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'capri-lite' ); ?></p>
			<?php
			get_search_form();

		else :
		?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'capri-lite' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
