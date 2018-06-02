<?php
/**
 * Functions file.
 * Capri Pro functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-lite
 */

define( 'CAPRI_PHP_INCLUDE', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'CAPRI_VERSION', '1.1.21' );

if ( ! function_exists( 'capri_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	function capri_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Capri Pro, use a find and replace
		 * to change 'capri-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'capri-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Add support for selective refresh.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
         * Set default thumbnail size.
         */
		set_post_thumbnail_size( 720, 330, true );

		/*
		 * Image size used for products thumbnails.
		 */
		add_image_size( 'capri-featured-products-image', 500, 500, true );

		/*
         * Image size used for categories section on front page.
         */
		add_image_size( 'capri-frontpage-categories', 615, 580, true );

		/*
		 * Image size used for testimonials section on About page
		 */
		add_image_size( 'capri-jetpack-testimonial-thumbnail', 265, 265, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'capri-lite' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'capri_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for custom logo
		add_theme_support(
			'custom-logo', array(
				'height'     => 300,
				'width'      => 600,
				'flex-width' => true,
			)
		);

		// Add theme support for custom header
		$defaults = array(
			'flex-height' => true,
			'flex-width'  => true,
		);
		add_theme_support( 'custom-header', $defaults );

	}
endif;
add_action( 'after_setup_theme', 'capri_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @since   1.0.0
 * @access  public
 */
function capri_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'capri_content_width', 640 );
}
add_action( 'after_setup_theme', 'capri_content_width', 0 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since   1.0.0
 * @access  public
 */
function capri_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'capri-lite' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebars(
		3, array(
			'name'          =>
				/* translators: %d is Footer id */
				esc_html__( 'Footer %d', 'capri-lite' ),
			'id'            => 'capri-footer-widget-area',
			'class'         => 'col-sm-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar Shop', 'capri-lite' ),
				'id'            => 'sidebar-shop',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Ribbon area', 'capri-lite' ),
			'id'            => 'ribbon-area',
			'class'         => 'ribbon-area',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_widget( 'capri_ribbon_widget' );

}
add_action( 'widgets_init', 'capri_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since   1.0.0
 * @access  public
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function capri_excerpt_more() {
	$link =
		/* translators: %1$s : Permalink, %2$s : Continue reading text */
		sprintf(
			' <span class="more-link-wrap"><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'capri-lite' ), array(
						'span' => array(
							'class' => array( '' ),
						),
					)
				), get_the_title( get_the_ID() )
			)
		);
	return '&hellip; ' . $link;
}
add_filter( 'excerpt_more', 'capri_excerpt_more' );

/**
 * Register Fonts
 *
 * @since   1.0.0
 * @access  public
 * @return string Link to google font.
 */
function capri_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Bitter and Arimo, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'capri-lite' );
	$arimo  = _x( 'on', 'Arimo font: on or off', 'capri-lite' );

	if ( 'off' !== $bitter || 'off' !== $arimo ) {
		$font_families = array();

		if ( 'off' !== $bitter ) {
			$font_families[] = 'Bitter:400';
		}

		if ( 'off' !== $arimo ) {
			$font_families[] = 'Arimo:400,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_scripts() {

	wp_enqueue_style( 'capri-fonts', capri_fonts_url(), array(), null );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), '3.3.6', 'all' );

	wp_enqueue_style( 'capri-style', get_stylesheet_uri(), array(), CAPRI_VERSION );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.5.0' );

	wp_enqueue_script( 'capri-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), CAPRI_VERSION, true );

	wp_localize_script(
		'capri-navigation', 'capriScreenReaderText', array(
			'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'capri-lite' ) . '</span>',
			'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'capri-lite' ) . '</span>',
		)
	);

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'capri-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'capri-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'capri_scripts' );

/**
 * Implement the Custom Header feature.
 */
require CAPRI_PHP_INCLUDE . 'custom-header.php';

/**
 * Custom template tags for this theme.
 */
require CAPRI_PHP_INCLUDE . 'template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require CAPRI_PHP_INCLUDE . 'extras.php';

/**
 * Customizer additions.
 */
require CAPRI_PHP_INCLUDE . 'customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require CAPRI_PHP_INCLUDE . 'jetpack.php';

/**
 * Woocommerce integration functions.
 */
require CAPRI_PHP_INCLUDE . 'woocommerce/functions.php';

/**
 * Add Placehoder in comment Form Fields (Name, Email, Website)
 *
 * @since   1.0.0
 * @access  public
 */
function capri_comment_placeholders( $fields ) {
	$fields['author'] = str_replace(
		'<input',
		'<input placeholder="' . esc_attr__( 'Name', 'capri-lite' ) . '"',
		$fields['author']
	);
	$fields['email']  = str_replace(
		'<input',
		'<input placeholder="' . esc_attr__( 'Email', 'capri-lite' ) . '"',
		$fields['email']
	);
	$fields['url']    = str_replace(
		'<input',
		'<input placeholder="' . esc_attr__( 'Website', 'capri-lite' ) . '"',
		$fields['url']
	);
	return $fields;
}
add_filter( 'comment_form_default_fields', 'capri_comment_placeholders' );


/**
 * Add Placehoder in comment Form Field (Comment)
 *
 * @since   1.0.0
 * @access  public
 */
function capri_textarea_placeholder( $fields ) {
	$fields['comment_field'] = str_replace(
		'<textarea',
		'<textarea placeholder="' . esc_html__( 'Comment', 'capri-lite' ) . '"',
		$fields['comment_field']
	);
	return $fields;
}
add_filter( 'comment_form_defaults', 'capri_textarea_placeholder' );

/**
 * Add inline style to the theme.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_inline_style() {

	$custom_css = '';

	if ( class_exists( 'WooCommerce' ) ) {
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		$image        = wp_get_attachment_url( get_post_thumbnail_id( $shop_page_id ) );
		if ( ! empty( $image ) ) {
			$custom_css .= '.post-type-archive-product .customize-partial-edit-shortcut-header_image{
				display: none;
			}';
		}
	}

	$page_for_posts = get_option( 'page_for_posts' );
	if ( ! empty( $page_for_posts ) && $page_for_posts !== '0' ) {
		$image = wp_get_attachment_url( get_post_thumbnail_id( $page_for_posts ) );
		if ( ! empty( $image ) ) {
			$custom_css .= '.blog .customize-partial-edit-shortcut-header_image{
				display: none;
			}';
		}
	}

	$capri_big_title_shortcode = get_theme_mod( 'capri_big_title_shortcode' );

	if ( empty( $capri_big_title_shortcode ) ) {
		$capri_big_title_image = get_theme_mod( 'capri_big_title_image', get_template_directory_uri() . '/assets/img/header_background.jpg' );
		if ( ! empty( $capri_big_title_image ) ) {
			$capri_big_title_image = esc_url( $capri_big_title_image );
		} else {
			$frontpage_id = get_option( 'page_on_front' );
			if ( ! empty( $frontpage_id ) ) {
				$capri_big_title_image = wp_get_attachment_url( get_post_thumbnail_id( $frontpage_id ) );
			}
		}

		if ( ! empty( $capri_big_title_image ) ) {
			$custom_css .= '
                .big-title-wrap{
                        background-image: url(' . esc_url( $capri_big_title_image ) . ');
                }';
		}
		if ( is_admin_bar_showing() ) {
			$custom_css .= '
				.transparent-background{
					margin-top:32px;
				}';
		}
	}

	wp_add_inline_style( 'capri-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'capri_inline_style' );

/**
 * Define Allowed Files to be included.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_filter_features( $array ) {
	return array_merge(
		$array, array(

			'/customizer-pro/customizer-theme-info',

			'/features/feature-big-title-section',
			'/sections/capri-big-title-section',

			'/features/feature-featured-products-section',
			'/sections/capri-featured-products-section',

			'/features/feature-categories-section',
			'/sections/capri-categories-section',

			'/features/feature-special-offers-section',
			'/sections/capri-special-offers-section',

			'/features/feature-about-section',
			'/sections/capri-about-section',

			'/features/feature-pro-manager',

			'/ribbon-widget/class-capri-ribbon-widget',

			'/features/sharing-icons/feature-sharing-icons',
		)
	);
}
add_filter( 'capri_filter_features', 'capri_filter_features' );

/**
 * Include features files.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_include_features() {
	$capri_inc_dir      = rtrim( CAPRI_PHP_INCLUDE, '/' );
	$capri_allowed_phps = array();
	$capri_allowed_phps = apply_filters( 'capri_filter_features', $capri_allowed_phps );

	foreach ( $capri_allowed_phps as $file ) {
		$capri_file_to_include = $capri_inc_dir . $file . '.php';
		if ( file_exists( $capri_file_to_include ) ) {
			include_once( $capri_file_to_include );
		}
	}
}
add_action( 'after_setup_theme', 'capri_include_features' );


/**
 * Filter the front page template so it's bypassed entirely if the user selects
 * to display blog posts on their homepage instead of a static page.
 *
 * @since   1.0.0
 * @modified 1.1.14
 * @access  public
 */
function capri_filter_front_page_template( $template ) {
	$capri_old_fp = get_theme_mod( 'capri_old_fp' );
	if ( ! $capri_old_fp ) {
		return is_home() ? '' : $template;
	}
	return '';
}
add_filter( 'frontpage_template', 'capri_filter_front_page_template' );


/**
 * Filter to translate strings
 *
 * @since 1.1.0
 * @access public
 */
function capri_translate_single_string( $original_value, $domain ) {
	if ( is_customize_preview() ) {
		$wpml_translation = $original_value;
	} else {
		$wpml_translation = apply_filters( 'wpml_translate_single_string', $original_value, $domain, $original_value );
		if ( $wpml_translation === $original_value && function_exists( 'pll__' ) ) {
			return pll__( $original_value );
		}
	}
	return $wpml_translation;
}
add_filter( 'capri_translate_single_string', 'capri_translate_single_string', 10, 2 );

if ( file_exists( get_template_directory() . '/class-tgm-plugin-activation.php' ) ) {
	/* tgm-plugin-activation */
	require_once get_template_directory() . '/class-tgm-plugin-activation.php';

	/**
	 * TGM required plugins
	 */
	function capri_register_required_plugins() {

		$plugins = array(
			array(
				'name'     => 'Orbit Fox',
				'slug'     => 'themeisle-companion',
				'required' => false,
			),
		);

		$config = array(
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'capri_register_required_plugins' );
}
