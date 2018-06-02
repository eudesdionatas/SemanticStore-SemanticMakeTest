<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since   1.0.0
 * @access  public
 * @param array $classes Classes for the body element.
 * @return array
 */
function capri_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'capri_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'capri_pingback_header' );

/**
 * Function to display all page headers.
 *
 * @since   1.0.0
 * @access  public
 * @param string $page_type Page type.
 */
function capri_show_page_header( $page_type ) {
	$append_to_class = 'shop-';
	switch ( $page_type ) {
		case 'shop':
			$category = get_queried_object();

			if ( isset( $category->term_id ) ) {

				$category_id = $category->term_id;
				$meta        = get_term_meta( $category_id );
				if ( ! empty( $meta['thumbnail_id'][0] ) ) {
					$image = wp_get_attachment_url( $meta['thumbnail_id'][0] );
				} else {
					$image = get_header_image();
				}
				$page_title = woocommerce_page_title( false );
			} else {
				$shop_page_id = get_option( 'woocommerce_shop_page_id' );
				$image        = wp_get_attachment_url( get_post_thumbnail_id( $shop_page_id ) );
				if ( empty( $image ) ) {
					$image = get_header_image();
				}
				$page_title = get_the_title( $shop_page_id );
			}
			break;

		case 'blog':
			$show_on_front   = get_option( 'show_on_front' );
			$page_for_posts  = get_option( 'page_for_posts' );
			$append_to_class = 'blog-';

			$redirect_url = home_url();
			if ( ! empty( $page_for_posts ) && $page_for_posts !== '0' && $show_on_front === 'page' ) {
				$redirect_url = get_page_link( $page_for_posts );
			}

			if ( ! empty( $page_for_posts ) && $page_for_posts !== '0' ) {
				$image = wp_get_attachment_url( get_post_thumbnail_id( $page_for_posts ) );
				if ( empty( $image ) ) {
					$image = get_header_image();
				}

				$page_title = get_theme_mod( 'capri_blog_title' );

				if ( empty( $page_title ) ) {
					$page_title = get_the_title( $page_for_posts );
				}
			} else {
				$image      = get_header_image();
				$page_title = get_theme_mod( 'capri_blog_title' );
			}
			break;

		case 'archive':
			$image      = get_header_image();
			$page_title = get_the_archive_title();
			;
			break;

		case 'search':
			$image      = get_header_image();
			$page_title =
				sprintf(
					/* translators: %s is Search query */
					esc_html__( 'Search Results for: %s', 'capri-lite' ),
					'<span>' . get_search_query() . '</span>'
				);
			break;
		case 'page':
			$pid             = get_the_ID();
			$append_to_class = '';
			$image           = '';
			if ( has_post_thumbnail() ) {
				$image = get_the_post_thumbnail_url( $pid, 'capri-header-size' );
			}
			$page_title = get_the_title();
			break;
	}// End switch().

	if ( ! empty( $image ) || ! empty( $page_title ) ) {
		?>
		<div class="<?php echo esc_attr( $append_to_class . 'entry-header' ); ?>" 
								<?php
								if ( ! empty( $image ) ) {
									echo 'style="background-image: url(' . esc_url( $image ) . '); background-size: cover;"';
								} else {
									echo 'style="background-color: rgba(80,84,96,0.5);"'; }
?>
>
			<?php
			if ( is_customize_preview() && $page_type !== 'page' ) {
			?>
				<div class="blog-title-css"></div>
				<?php
			}
			?>
			<div class="overlay"></div>
			<div class="container">
				<div class="<?php echo esc_attr( $append_to_class . 'page-title-wrap' ); ?>">
					<?php
					if ( ! empty( $page_title ) ) {
						if ( $page_type === 'page' ) {
							the_title( '<h1 class="entry-title">', '</h1>' );
						} else {
						?>
							<h1 class="<?php echo esc_attr( $append_to_class . 'page-title-inner' ); ?>"><?php echo wp_kses_post( $page_title ); ?></h1>
						<?php
						}
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
}

/**
 * Menu Fallback
 * =============
 * If this function is assigned to the wp_nav_menu's fallback_cb variable
 * and a menu has not been assigned to the theme location in the WordPress
 * menu manager the function with display nothing to a non-logged in user,
 * and will add a link to the WordPress menu manager if logged in as an admin.
 *
 * @since   1.0.0
 * @access  public
 * @param array $args passed from the wp_nav_menu function.
 */
function capri_fallback_menu( $args ) {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	$fb_output       = null;
	$container       = $args['container'];
	$container_id    = $args['container_id'];
	$container_class = $args['container_class'];
	$menu_id         = $args['menu_id'];
	$menu_class      = $args['menu_class'];
	if ( $container ) {
		$fb_output = '<' . esc_html( $container );
		if ( $container_id ) {
			$fb_output .= ' id="' . esc_attr( $container_id ) . '"';
		}
		if ( $container_class ) {
			$fb_output .= ' class="' . esc_attr( $container_class ) . '"';
		}
		$fb_output .= '>';
	}
	$fb_output .= '<ul';
	if ( $menu_id ) {
		$fb_output .= ' id="' . esc_attr( $menu_id ) . '"';
	}
	if ( $menu_class ) {
		$fb_output .= ' class="' . esc_attr( $menu_class ) . '"';
	}
	$fb_output .= '>';
	$fb_output .= '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'capri-lite' ) . '</a></li>';
	$fb_output .= '</ul>';
	if ( $container ) {
		$fb_output .= '</' . esc_html( $container ) . '>';
	}
	echo wp_kses_post( $fb_output );
}

/**
 * Change JetPack testimonials thumbnail size.
 *
 * @since   1.0.0
 * @access  public
 * @return string
 */
function capri_jetpack_testimonial_image_size() {
	return 'capri-jetpack-testimonial-thumbnail';
}
add_filter( 'jetpack_testimonial_thumbnail_size', 'capri_jetpack_testimonial_image_size' );
