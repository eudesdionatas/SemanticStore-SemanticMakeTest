<?php
/**
 * Header template.
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'capri-lite' ); ?></a>
		<?php
		$transparent_background = false;
		if ( is_front_page() && ! is_home() ) {
			$transparent_background = true;
		}
		?>
		<header id="masthead" class="site-header <?php echo $transparent_background ? 'transparent-header' : ''; ?>">
			<div class="header-wrap">
				<div class="container header-container">
					<div class="site-header-main">
						<div class="site-header-inner-main">
							<div class="site-branding">
								<?php
								if ( function_exists( 'the_custom_logo' ) ) {
									the_custom_logo();
								}

								if ( is_front_page() && is_home() ) :
								?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
								?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;

								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) :
								?>
									<p class="site-description"><?php echo wp_kses_post( $description ); ?></p>
									<?php
								endif;
								?>
							</div><!-- .site-branding -->

							<div class="menu-toggle-container">
								<button id="menu-toggle" class="menu-toggle"><i class="fa fa-bars"></i></button>
							</div>
						</div><!-- .site-header-inner-main -->

						<div id="site-header-menu" class="site-header-menu">

							<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'capri-lite' ); ?>">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_class'     => 'primary-menu',
										'fallback_cb'    => 'capri_fallback_menu',
									)
								);
									?>
							</nav><!-- .main-navigation -->

							<?php
							if ( class_exists( 'WooCommerce' ) ) {
							?>
								<div class="header-shopping-cart">
									<?php
									/* This happens because WC()->cart->get_cart_url() function is deprecated */
									if ( function_exists( 'wc_get_cart_url' ) ) {
										$cart_url = wc_get_cart_url();
									} elseif ( function_exists( 'WC' ) ) {
										$cart_url = WC()->cart->get_cart_url();
									}

									if ( ! empty( $cart_url ) ) {
										$cart_items = trim( WC()->cart->get_cart_contents_count() );
										?>
										<div class="navbar-cart-inner">
											<a href="<?php echo esc_url( $cart_url ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'capri-lite' ); ?>">
												<i class="fa fa-shopping-cart fa-6"></i><span><?php echo esc_html__( 'Your Cart', 'capri-lite' ) . ' (' . $cart_items . ')'; ?></span>
											</a>
										</div>
										<div class="header-shopping-cart-products">
											<?php the_widget( 'WC_Widget_Cart' ); ?>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>

						</div><!-- .site-header-menu -->

					</div><!-- .site-header-main -->
				</div>

			</div>
		</header><!-- .site-header -->

		<div id="content" class="site-content">
