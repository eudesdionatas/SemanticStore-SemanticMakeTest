<?php
/**
 * Woocommerce compatibility functions
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/**
 * Enqueue necessary files for woocommerce compatibility
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woocommerce_scripts() {
	wp_enqueue_style( 'capri-woocommerce-style', get_template_directory_uri() . '/inc/woocommerce/css/woocommerce.css', array(), CAPRI_VERSION );
	wp_enqueue_script( 'capri-woocommerce-functions', get_template_directory_uri() . '/inc/woocommerce/js/woocommerce.js', array(), CAPRI_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'capri_woocommerce_scripts', 20 );

/**
 * Declare WooCommerce support.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'capri_woocommerce_support' );

/**
 * Remove shop title
 *
 * @since   1.0.0
 * @access  public
 * @return bool
 */
function capri_hide_shop_page_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'capri_hide_shop_page_title', 10 );

/**
 * Remove breadcrumb
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Remove sidebar from woocommerce.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Remove the result count from WooCommerce
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/**
 * Remove the product rating display on product loops
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/**
 * Remove add to cart button on shop.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_remove_add_to_cart_buttons() {
	if ( is_product_category() || is_shop() ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'capri_remove_add_to_cart_buttons', 1 );

/**
 * Replace arrows form pagination with text (woocommerce).
 *
 * @param array $args Function arguments.
 *
 * @since   1.0.0
 * @access  public
 * @return mixed
 */
function capri_woocommerce_pagination( $args ) {
	$args['prev_text'] = esc_html__( 'Prev page', 'capri-lite' );
	$args['next_text'] = esc_html__( 'Next page', 'capri-lite' );

	return $args;
}
add_filter( 'woocommerce_pagination_args', 'capri_woocommerce_pagination' );

/**
 * Woocommerce Breadcrumb separator
 *
 * @param array $defaults Default values.
 *
 * @since   1.0.0
 * @access  public
 * @return mixed
 */
function capri_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = ' <span>/</span> ';

	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'capri_change_breadcrumb_delimiter' );

/**
 * Hook before shop item title.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_before_single_product_summary() {
	?>
	<span  class="featured-info">
	<?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'capri_before_single_product_summary' );

/**
 * Hook after shop item title.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_after_shop_loop_item_title() {
	?>
	</span><!-- product-summary-->
	<?php
}
add_action( 'woocommerce_after_shop_loop_item_title', 'capri_after_shop_loop_item_title' );

/**
 * Content before shop page.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woocommerce_before_main_content() {
	?>
	<div class="before-content-wrap">
	<?php
	if ( ! is_single() ) {
		capri_show_page_header( 'shop' );
	}
	if ( ! is_product() ) {
		capri_show_categories( 'woo' );
	}
	?>
	<div class="container woo-container">
	<div class="before-content-shop">
	<?php
}
add_action( 'woocommerce_before_main_content', 'capri_woocommerce_before_main_content', 10 );

/**
 * Content after shop page.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woocommerce_after_main_content() {
	?>
	</div><!-- .before-content-shop -->
	</div>
	</div><!-- before-content-wrap -->
	<?php
}
add_action( 'woocommerce_after_main_content', 'capri_woocommerce_after_main_content', 10 );


/**
 * Display WooCommerce categories in dropdown on shop page.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_show_categories( $type ) {
	$dropdown_categories = array();
	$text_to_display     = esc_html__( 'Product categories +', 'capri-lite' );

	if ( $type === 'woo' ) {
		$dropdown_categories = capri_get_woo_categories( false );
		if ( array_key_exists( 'none', $dropdown_categories ) ) {
			unset( $dropdown_categories['none'] );
		}
	}

	if ( $type === 'blog' ) {
		$wp_categories = get_categories();
		if ( ! empty( $wp_categories ) ) {
			foreach ( $wp_categories as $category ) {
				if ( ! empty( $category->term_id ) ) {
					$dropdown_categories[ $category->term_id ] = $category->name;
				}
			}
		}
		$text_to_display = esc_html__( 'Post categories +', 'capri-lite' );
	}

	if ( ! empty( $dropdown_categories ) ) {
	?>
		<div class="woo-cat-menu-toggle-wrap">
			<button class="woo-cat-menu-toggle">
				<?php echo esc_html( $text_to_display ); ?>
			</button>
			<ul class="woo-category-dropdown">
				<?php
				foreach ( $dropdown_categories as $key => $value ) {
					$link = get_category_link( $key );
					?>
					<li class="woo_cat_id_<?php echo esc_attr( $key ); ?>">
						<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $value ); ?></a>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php
	}
}

/**
 * Content before shop page.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woocommerce_before_shop_loop() {
	?>

	<div class="woo-shop-controls">
		<?php
		woocommerce_breadcrumb();

		if ( is_active_sidebar( 'sidebar-shop' ) ) {
			?>
			<span class="capri-sidebar-open"><i class="fa fa-filter" aria-hidden="true"></i></span>
			<?php
		}

		woocommerce_catalog_ordering();
		?>
	</div>

	<div class="woo-shop-content">
	<?php
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
			get_sidebar( 'shop' );
			?>
			<div class="before-content-shop">
	<?php
	}
}
add_action( 'woocommerce_before_shop_loop', 'capri_woocommerce_before_shop_loop', 10 );

/**
 * Content after shop page.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woocommerce_after_shop_loop() {
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
	?>
		</div>
		<?php
	}
	?>
	</div>
<?php
}
add_action( 'woocommerce_after_shop_loop', 'capri_woocommerce_after_shop_loop', 10 );

/**
 * Checkout page
 * Move the coupon fild and message info after the order table
 *
 * @since   1.0.0
 * @access  public
 */
function capri_coupon_after_order_table_js() {
	wc_enqueue_js(
		'
		$( $( "div.woocommerce-info, .checkout_coupon" ).detach() ).appendTo( "#capri-checkout-coupon" );
	'
	);
}
add_action( 'woocommerce_before_checkout_form', 'capri_coupon_after_order_table_js' );

/**
 * After order table hook.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_coupon_after_order_table() {
	echo '<div id="capri-checkout-coupon"></div><div style="clear:both"></div>';
}
add_action( 'woocommerce_checkout_order_review', 'capri_coupon_after_order_table' );


// remove default sorting dropdown
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// remove add to cart button
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 * Product Single -  Summary Box.
 *
 * @see capri_woo_before_product_title() - priority 5 - added
 * @see woocommerce_template_single_meta() - priority 10 - added
 * @see woocommerce_template_single_excerpt()
 * @see woocommerce_template_single_rating() - priority 40 - added
 * @see woocommerce_template_single_sharing()
 * @see capri_woo_after_product_info() - priority 100 - added
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 50 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 40 );
add_action( 'woocommerce_product_meta_end', 'capri_register_sharing_icons' );

/**
 * This function wrap product title in a div with class woo-product-title-wrapper
 * and opens container for product info
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woo_before_product_title() {
	?>
	<div class="woo-product-title-wrapper">
		<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
		<?php
		wc_get_template( 'single-product/price.php' );
		?>
	</div>
	<div class="woo-product-info-container">
	<?php
}
add_action( 'woocommerce_single_product_summary', 'capri_woo_before_product_title', 5 );

/**
 * This functions closes the div woo-product-info-container opened in capri_woo_before_product_title function
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woo_after_product_info() {
	?>
	</div> <!-- END woo-product-info-container -->
	<?php
}
add_action( 'woocommerce_single_product_summary', 'capri_woo_after_product_info', 100 );

/**
 * This function opens a div with class woo-product-details-wrapper before product image
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woo_before_product_image() {
	?>
	<div class="woo-product-details-wrapper">
	<?php
}
add_action( 'woocommerce_before_single_product_summary', 'capri_woo_before_product_image', 10 );

/**
 * This functions close the div opened in capri_woo_before_product_image function
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woo_product_summary() {
	?>
	</div><!-- .woo-product-details-wrapper -->
	<?php
}
add_action( 'woocommerce_after_single_product_summary', 'capri_woo_product_summary', 5 );

/**
 * Change review icon size
 *
 * @since   1.0.0
 * @access  public
 * @return int
 */
function capri_avatar_size() {
	return 105;
}
add_filter( 'woocommerce_review_gravatar_size', 'capri_avatar_size', 10 );

/**
 * Change date format
 *
 * @since   1.0.0
 * @access  public
 * @return string
 */
function capri_woo_date_format() {
	return 'n.d.Y';
}
add_filter( 'woocommerce_date_format', 'capri_woo_date_format' );


/**
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woo_related_products_number( $args ) {
	$args['posts_per_page'] = apply_filters( 'capri_single_product_related_items', 3 ); // 3 related products
	$args['columns']        = apply_filters( 'capri_single_product_related_columns', 3 ); // 3 columns
	return $args;
}
// Filter for up-sells products ( Add them in Edit product -> Linked Products -> Up-sells )
add_filter( 'woocommerce_upsell_display_args', 'capri_woo_related_products_number' );
// Filter for related products ( displayed by default )
add_filter( 'woocommerce_output_related_products_args', 'capri_woo_related_products_number' );

/**
 * Change number of products for woocommerce
 *
 * @since   1.0.0
 * @access  public
 */
function capri_new_woo_related_products_number() {
	return apply_filters( 'capri_single_product_related_items', 3 ); // 3 related products
}
add_filter( 'woocommerce_upsells_total', 'capri_new_woo_related_products_number' );


/**
 * Add placeholders in review form.
 *
 * @param array $comment_form Form options.
 *
 * @since   1.0.0
 * @access  public
 * @return mixed
 */
function capri_woo_comment_form_args( $comment_form ) {

	$commenter              = wp_get_current_commenter();
	$comment_form['fields'] = array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'capri-lite' ) . ' <span class="required">*</span></label> ' .
					'<input id="author" placeholder="' . apply_filters( 'capri_woo_author_field_placeholder', esc_html__( 'Name', 'capri-lite' ) ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'capri-lite' ) . ' <span class="required">*</span></label> ' .
					'<input id="email" placeholder="' . apply_filters( 'capri_woo_email_field_placeholder', esc_html__( 'Email Address', 'capri-lite' ) ) . '" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
	);

	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
		$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'capri-lite' ) . '</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'capri-lite' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'capri-lite' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'capri-lite' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'capri-lite' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'capri-lite' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'capri-lite' ) . '</option>
						</select></p>';
	}
	$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'capri-lite' ) . ' <span class="required">*</span></label><textarea placeholder="' . apply_filters( 'capri_woo_comment_field_placeholder', esc_html__( 'Written Review', 'capri-lite' ) ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

	$comment_form['title_reply'] = have_comments() ?
		sprintf(
			/* translators: %s is post title */
			apply_filters( 'capri_woo_title_reply', esc_html__( 'Add a review for: \'%s\'', 'capri-lite' ) ),
			get_the_title()
		) :
		sprintf(
			/* translators: %s is post title */
			esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'capri-lite' ),
			get_the_title()
		);

	return $comment_form;
}
add_filter( 'woocommerce_product_review_comment_form_args', 'capri_woo_comment_form_args' );

/**
 * Cart.
 *
 * @see woocommerce_cart_totals() - priority 10
 * @see woocommerce_button_proceed_to_checkout() - priority 20
 * @see woocommerce_cross_sell_display() - priority 30
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

/**
 * Cross sells filter
 *
 * @since   1.0.0
 * @access  public
 */
function capri_woo_cross_sells() {
	?>
	<hr class="before-interests">
	<?php
	woocommerce_cross_sell_display( 3, 3 );
	?>

	<?php
}

add_filter( 'woocommerce_cart_collaterals', 'capri_woo_cross_sells', 50 );


/**
 * Remove SKU on product pages
 *
 * @since   1.0.0
 * @access  public
 * @return bool
 */
function capri_remove_product_page_sku( $enabled ) {
	if ( ! is_admin() && is_product() ) {
		return false;
	}

	return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'capri_remove_product_page_sku' );


/**
 * Function to display header cart even on checkout or cart page.
 *
 * @since 1.0.0
 * @access public
 * @return bool
 */
function capri_always_show_live_cart() {
	return false;
}
add_filter( 'woocommerce_widget_cart_is_hidden', 'capri_always_show_live_cart', 40, 0 );


/**
 * Custom Add to Cart message
 *
 * @since 1.0.0
 * @access public
 */
function capri_woocommerce_add_to_cart_message( $input ) {
	$cart_redirect = get_option( 'woocommerce_cart_redirect_after_add' );

	// Check for Cart page url
	if ( function_exists( 'wc_get_page_id' ) ) {
		$cart_url = esc_url( get_permalink( wc_get_page_id( 'cart' ) ) );
	} else {
		$cart_url = esc_url( get_permalink( woocommerce_get_page_id( 'cart' ) ) );
	}

	// Check for Shop page url
	if ( function_exists( 'wc_get_page_id' ) ) {
		$shop_url = esc_url( get_permalink( wc_get_page_id( 'shop' ) ) );
	} else {
		$shop_url = esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
	}

	// Get product name from $input
	$input = explode( '&ldquo;', $input );
	$title = explode( '&rdquo;', $input[1] );
	$title = $title[0];

	if ( function_exists( 'wc_get_page_id' ) ) {

		if ( $cart_redirect === 'yes' ) {
			$message = sprintf( '<span><i class="fa fa-check" aria-hidden="true"></i><strong>%s</strong> %s</span><span><a href="%s" class="button">%s</a></span>', esc_html( $title ), esc_html__( 'has been added to your cart.', 'capri-lite' ), $shop_url, esc_html__( 'Continue Shopping', 'capri-lite' ) );
		} else {
			$message = sprintf( '<span><i class="fa fa-check" aria-hidden="true"></i><strong>%s</strong> %s</span><span><a href="%s" class="continue-shopping-link">%s</a><a href="%s" class="button">%s</a></span>', esc_html( $title ), esc_html__( 'has been added to your cart.', 'capri-lite' ), $shop_url, esc_html__( 'Continue Shopping', 'capri-lite' ), $cart_url, esc_html__( 'View Cart', 'capri-lite' ) );
		}
	} else {

		if ( $cart_redirect === 'yes' ) {
			$message = sprintf( '<span><i class="fa fa-check" aria-hidden="true"></i><strong>%s</strong> %s</span><span><a href="%s" class="button">%s</a></span>', esc_html( $title ), esc_html__( 'has been added to your cart.', 'capri-lite' ), $shop_url, esc_html__( 'Continue Shopping', 'capri-lite' ) );
		} else {
			$message = sprintf( '<span><i class="fa fa-check" aria-hidden="true"></i><strong>%s</strong> %s</span><span><a href="%s" class="continue-shopping-link">%s</a><a href="%s" class="button">%s</a></span>', esc_html( $title ), esc_html__( 'has been added to your cart.', 'capri-lite' ), $shop_url, esc_html__( 'Continue Shopping', 'capri-lite' ), $cart_url, esc_html__( 'View Cart', 'capri-lite' ) );
		}
	}
	return $message;
}

if ( function_exists( 'wc_deprecated_function' ) ) {
	add_filter( 'wc_add_to_cart_message_html', 'capri_woocommerce_add_to_cart_message' );
} else {
	add_filter( 'wc_add_to_cart_message', 'capri_woocommerce_add_to_cart_message' );
}


/**
 * Remove title on Cart and Checkout pages
 *
 * @since 1.0.0
 * @access public
 */
function capri_woocommerce_remove_title() {
	if ( ! is_shop() ) {
		return false;
	}
}
add_filter( 'woocommerce_show_page_title', 'capri_woocommerce_remove_title' );
