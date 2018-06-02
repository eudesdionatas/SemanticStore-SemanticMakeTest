<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

if ( ! function_exists( 'capri_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	function capri_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

			$posted_on = sprintf(
				'<a href="' . esc_url( get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ), get_post_time( 'j' ) ) ) . '" rel="bookmark">' . $time_string . '</a>'
			);

			echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'capri_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories and tags.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	function capri_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'capri-lite' ) );

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'capri-lite' ) );

			if ( $tags_list || ( $categories_list && capri_categorized_blog() ) ) {

				echo '<div class="single-cat-links">';
				if ( $categories_list && capri_categorized_blog() ) {
					/* translators: %1$s is categories list */
					printf( '<span class="cat-links">' . esc_html__( 'posted under: %1$s', 'capri-lite' ) . '</span>', $categories_list ); // WPCS: XSS OK.
				}

				if ( $tags_list ) {
					/* translators: %1$s is tags list */
					printf( '<span class="tags-links">' . esc_html__( 'tagged: %1$s', 'capri-lite' ) . '</span>', $tags_list ); // WPCS: XSS OK.
				}
				echo '</div>';
			}
		}
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @since   1.0.0
 * @access  public
 * @return bool
 */
function capri_categorized_blog() {
	$all_the_cool_cats = get_transient( 'capri_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'capri_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so capri_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so capri_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in capri_categorized_blog.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'capri_categories' );
}
add_action( 'edit_category', 'capri_category_transient_flusher' );
add_action( 'save_post', 'capri_category_transient_flusher' );


/**
 * Print the attached image with a link to the next attached image.
 *
 * @since 1.0.0
 * @access  public
 */
function capri_the_attached_image() {

	/**
	 * Filter the image attachment size to use.
	 *
	 * @since themotion 1.0
	 *
	 * @param array $size {
	 *
	 * @type int The attachment height in pixels.
	 * @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'themotion_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
     * Grab the IDs of all the image attachments in a gallery so we can get the URL
     * of the next adjacent image in a gallery, or the first image (if we're
     * looking at the last image in a gallery), or, in a gallery of one, just the
     * link to that image file.
     */
	$attachment_ids = get_posts(
		array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => - 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		)
	);

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}
		// get the URL of the next image attachment...
		if ( isset( $next_id ) ) {
			$next_attachment_url = get_attachment_link( $next_id );
		} // End if().
		else {
			$next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
		}
	}

	/* translators: %1$s is Next attachment url, %2$s is title attribute, %3$s is attachment */
	printf(
		'<a href="%1$s" title="%2$s" class="thumbnail-wrap" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute(
			array(
				'echo' => false,
			)
		),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
