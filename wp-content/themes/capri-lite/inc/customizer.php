<?php
/**
 * Capri Pro Theme Customizer.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * Creates a panel for front page sections.
 * Creates controls for blog title and blog description.
 *
 * @since   1.0.0
 * @modified 1.1.14
 * @access  public
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function capri_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'header_image_data' )->transport = 'postMessage';

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;
	$custom_logo       = $wp_customize->get_control( 'custom_logo' );
	if ( ! empty( $custom_logo ) ) {
		$wp_customize->get_control( 'custom_logo' )->priority = 5;
	}

	$wp_customize->add_panel(
		'capri_frontpage_sections', array(
			'priority'    => 30,
			'title'       => esc_html__( 'Frontpage Sections', 'capri-lite' ),
			'description' => esc_html__( 'Drag and drop panels to change sections order.', 'capri-lite' ),
		)
	);

	$wp_customize->add_setting(
		'capri_blog_title', array(
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'capri_blog_title', array(
			'label'    => esc_html__( 'Blog Title', 'capri-lite' ),
			'section'  => 'header_image',
			'priority' => 5,
		)
	);

	/**
	 * Footer options
	 */
	$wp_customize->add_panel(
		'capri_footer_panel', array(
			'priority' => 90,
			'title'    => esc_html__( 'Footer', 'capri-lite' ),
		)
	);

	$wp_customize->add_section(
		'capri_footer_copyright_section', array(
			'title'    => esc_html__( 'Copyright', 'capri-lite' ),
			'panel'    => 'capri_footer_panel',
			'priority' => apply_filters( 'capri_section_priority', 10, 'capri_big_title' ),
		)
	);

	$wp_customize->add_setting(
		'capri_footer_copyright', array(
			'default'           => sprintf(
				/* translators: %1$s: Theme link, %2$s: WordPress link */
				apply_filters( 'capri_filter_copyright', esc_html__( '%1$s | Powered by %2$s', 'capri-lite' ) ),
				/* translators: %s is Theme link */
				sprintf( '<a href="https://themeisle.com/themes/capri-pro" rel="nofollow" target="_blank">%s</a>', esc_html__( 'CAPRI', 'capri-lite' ) ),
				/* translators: %s is WordPress name*/
				sprintf( '<a href="http://wordpress.org/" rel="nofollow" target="_blank">%s</a>', esc_html__( 'WordPress', 'capri-lite' ) )
			),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'capri_footer_copyright', array(
			'label'    => esc_html__( 'Copyright', 'capri-lite' ),
			'section'  => 'capri_footer_copyright_section',
			'priority' => 1,
		)
	);

	$capri_footer_1 = $wp_customize->get_section( 'sidebar-widgets-capri-footer-widget-area' );
	$capri_footer_2 = $wp_customize->get_section( 'sidebar-widgets-capri-footer-widget-area-2' );
	$capri_footer_3 = $wp_customize->get_section( 'sidebar-widgets-capri-footer-widget-area-3' );

	if ( capri_check_if_wp_greater_than_4_7() ) {
		if ( ! empty( $capri_footer_1 ) ) {
			$capri_footer_1->panel = 'capri_footer_panel';
		}
		if ( ! empty( $capri_footer_2 ) ) {
			$capri_footer_2->panel = 'capri_footer_panel';
		}
		if ( ! empty( $capri_footer_3 ) ) {
			$capri_footer_3->panel = 'capri_footer_panel';
		}
	}
}
add_action( 'customize_register', 'capri_customize_register' );

/**
 * Function to check if WordPress is greater or equal to 4.7
 */
function capri_check_if_wp_greater_than_4_7() {
	$wp_version_nr = get_bloginfo( 'version' );
	if ( function_exists( 'version_compare' ) ) {
		if ( version_compare( $wp_version_nr, '4.7', '>=' ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Add selective refresh for general controls.
 *
 * @since   1.0.0
 * @access  public
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function capri_register_general_partials( $wp_customize ) {

	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'header_site_title', array(
			'selector'        => '.site-title a',
			'settings'        => array( 'blogname' ),
			'render_callback' => 'capri_site_title_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'document_title', array(
			'selector'        => 'head > title',
			'settings'        => array( 'blogname' ),
			'render_callback' => 'wp_get_document_title',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'header_site_description', array(
			'selector'        => '.site-description',
			'settings'        => array( 'blogdescription' ),
			'render_callback' => 'capri_site_description_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'capri_blog_title', array(
			'selector'        => '.blog-page-title-inner',
			'settings'        => 'capri_blog_title',
			'render_callback' => 'capri_blog_title_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'header_image', array(
			'selector'        => '.blog-title-css',
			'settings'        => 'header_image',
			'render_callback' => 'capri_blog_image_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'capri_footer_copyright', array(
			'selector'        => '.footer-copyright',
			'settings'        => 'capri_footer_copyright',
			'render_callback' => 'capri_footer_copyright_render_callback',
		)
	);

}
add_action( 'customize_register', 'capri_register_general_partials' );


/**
 * Sanitize checkbox output.
 *
 * @since 1.1.14
 */
function capri_sanitize_checkbox( $input ) {
	return ( isset( $input ) && true === (bool) $input ? true : false );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_customize_preview_js() {
	wp_enqueue_script( 'capri-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'capri_customize_preview_js' );


/**
 * Get WooCommerce products categories.
 *
 * @since   1.0.0
 * @access  public
 * @param bool $placeholder Choose whether or not to display "Select category".
 * @return array Returns an array with WooCommerce categories.
 */
function capri_get_woo_categories( $placeholder = true ) {
	$capri_prod_categories_array = $placeholder === true ? array(
		'-' => esc_html__( 'Select category', 'capri-lite' ),
	) : array();
	if ( ! class_exists( 'WooCommerce' ) ) {
		return $capri_prod_categories_array;
	}

	$capri_prod_categories = get_categories(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => 0,
			'title_li'   => '',
		)
	);
	if ( ! empty( $capri_prod_categories ) ) {
		foreach ( $capri_prod_categories as $capri_prod_cat ) {
			if ( ! empty( $capri_prod_cat->term_id ) && ! empty( $capri_prod_cat->name ) ) {
				$capri_prod_categories_array[ $capri_prod_cat->term_id ] = $capri_prod_cat->name;
			}
		}
	}
	$capri_prod_categories_array['none'] = esc_html__( 'None', 'capri-lite' );

	return $capri_prod_categories_array;
}

/**
 * Check if WooCommerce is installed.
 * Callback function for shop controls.
 *
 * @since   1.0.0
 * @access  public
 * @return bool
 */
function capri_check_woo() {
	return class_exists( 'WooCommerce' );
}


/**
 * Display featured products on front page.
 *
 * @since   1.0.0
 * @access  public
 * @param string $control_name Customizer control name.
 * @param bool   $is_callback Check if this function is called from selective refresh.
 * @return mixed
 */
function capri_display_products( $control_name, $is_callback = false, $count = false ) {
	$nb_of_products = 0;
	if ( class_exists( 'WooCommerce' ) ) {

		$capri_products_category = get_theme_mod( $control_name );
		if ( is_array( $capri_products_category ) && in_array( 'none', $capri_products_category ) ) {
			return $nb_of_products;
		}

		if ( $control_name === 'capri_featured_products_category' ) {
			$filter_name = 'capri_featured_products';
		} else {
			$filter_name = 'capri_special_offers';
		}
		$settings = array(
			'post_type'      => 'product',
			'posts_per_page' => apply_filters( $filter_name . '_number', 3 ),
			'meta_query'     => array(
				array(
					'key' => '_thumbnail_id',
				),
			),
		);
		if ( ! empty( $capri_products_category ) && $capri_products_category !== '-' ) {
			$settings['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => apply_filters( $filter_name . '_category', ! empty( $capri_products_category ) ? $capri_products_category : '' ),
				),
			);
		}
		$loop = new WP_Query( $settings );

		if ( $loop->have_posts() ) {

			if ( $is_callback !== true ) { ?>
					<div class="featured-items-wrap">
					<?php
			}
			while ( $loop->have_posts() ) {
				$loop->the_post();
				$nb_of_products++;
				if ( $count === false ) {
					$product_id = get_the_ID();
					$product    = new WC_Product( $product_id );

					if ( function_exists( 'wc_get_price_including_tax' ) ) {
						$price = wc_price( wc_get_price_including_tax( $product ) );
					} else {
						$price = wc_price( $product->get_price_including_tax( 1, $product->get_price() ) );
					}

					?>

					<div class="col-xs-12 col-sm-12 col-md-4 featured-item">
						<div class="featured-item-inner">
							<div class="featured-image">
								<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'capri-featured-products-image' ); ?>
								</a>
							</div>
							<div class="featured-info">
								<div class="featured-name-wrap">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="featured-name"><?php the_title(); ?></a>
								</div>
								<?php
								if ( ! empty( $price ) ) {
								?>
										<div class="featured-price-wrap">
											<p class="featured-price"><?php echo wp_kses_post( $price ); ?></p>
										</div>
										<?php
								}
								?>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>

					<?php
				}// End if().
			}// End while().
			if ( $is_callback !== true ) {
			?>
				</div>
				<?php
			}
			wp_reset_postdata();

		} else {
			if ( current_user_can( 'edit_posts' ) && $count === false ) {
			?>
				<p class="text-center">
					<?php
					$admin_new_post_link = esc_url( admin_url() ) . 'post-new.php?post_type=product';
					printf(
						/* translators: %1$s: is Link to new products */
						esc_html__( 'There are no products to display. Click %1$s to add new products!', 'capri-lite' ),
						/* translators: %1$s is Url to new products , %2$s is New products text */
						sprintf(
							'<a href="%1$s" target=_blank"><b>%2$s</b></a>',
							esc_url( $admin_new_post_link ),
							esc_html__( 'here', 'capri-lite' )
						)
					);
					?>
				</p>
				<?php
			}
		}// End if().
	}// End if().

	return $nb_of_products;
}

/**
 * Render callback function for sections title.
 *
 * @param Object $input To get control name.
 *
 * @since   1.0.0
 * @access  public
 * @return string Theme mod value.
 */
function capri_section_title_render_callback( $input ) {
	$control_name = $input->settings[0];
	$default      = current_user_can( 'edit_posts' ) ? esc_html__( 'Edit this section title in Customizer', 'capri-lite' ) : false;
	return get_theme_mod( $control_name, $default );
}

/**
 * Render callback function for featured products and special offers sections.
 *
 * @since   1.0.0
 * @access  public
 * @param Object $input To get control name.
 */
function capri_products_sections_render_callback( $input ) {

	switch ( $input->settings[0] ) {
		case 'capri_featured_products_shortcode':
			$type = 'capri_featured_products';
			break;
		case 'capri_featured_products_category':
			$type = 'capri_featured_products';
			break;
		case 'capri_special_offers_shortcode':
			$type = 'capri_special_offers';
			break;
		case 'capri_special_offers_category':
			$type = 'capri_special_offers';
			break;
	}

	if ( ! empty( $type ) ) {
		$control_name    = $type . '_shortcode';
		$capri_shortcode = get_theme_mod( $control_name );
		if ( ! empty( $capri_shortcode ) ) {
			echo do_shortcode( $capri_shortcode );
		} else {
			$control_name = $type . '_category';
			capri_display_products( $control_name, true );
		}
	}
}

/**
 * Callback for blog title selective refresh
 *
 * @since   1.0.0
 * @access  public
 * @return string Page title.
 */
function capri_blog_title_render_callback() {
	$page_for_posts = get_option( 'page_for_posts' );
	$page_title     = get_theme_mod( 'capri_blog_title' );
	if ( empty( $page_title ) ) {
		if ( ! empty( $page_for_posts ) && ( $page_for_posts !== 0 ) ) {
			$page_title = get_the_title( $page_for_posts );
		} else {
			$page_title = '';
		}
	}
	return $page_title;
}

/**
 * Callback for blog image selective refresh
 *
 * @since   1.0.0
 * @access  public
 */
function capri_blog_image_render_callback() {

	$header_image = get_header_image();
	if ( empty( $header_image ) ) {
		$page_for_posts = get_option( 'page_for_posts' );
		$header_image   = wp_get_attachment_url( get_post_thumbnail_id( $page_for_posts ) );
	}
	?>
	<style class="capri-blog-title-css">
		.shop-entry-header {
			background-image: url(<?php echo ! empty( $header_image ) ? esc_url( $header_image ) : 'none'; ?>) !important;
		}
	</style>
	<?php
}

/**
 * Render callback for site title
 *
 * @since   1.0.0
 * @access  public
 * @return string Site title.
 */
function capri_site_title_render_callback() {
	return get_bloginfo( 'name', 'display' );
}

/**
 * Render callback for site description
 *
 * @since   1.0.0
 * @access  public
 * @return string Site description.
 */
function capri_site_description_render_callback() {
	return get_bloginfo( 'description', 'display' );
}

/**
 * Render callback function for footer copyright
 *
 * @since   1.0.0
 * @access  public
 * @return string Footer copyright.
 */
function capri_footer_copyright_render_callback() {
	/* translators: %1$s: Theme link, %2$s: WordPress link */
	return wp_kses_post( get_theme_mod( 'capri_footer_copyright' ) );
}
