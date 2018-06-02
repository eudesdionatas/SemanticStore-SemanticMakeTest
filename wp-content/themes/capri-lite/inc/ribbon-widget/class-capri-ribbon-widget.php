<?php
/**
 * Ribbon section from footer
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/*
 * Ribbon widget
 */
if ( ! class_exists( 'Capri_Ribbon_Widget' ) ) {

	/**
	 * Class Capri_Ribbon_Widget
	 *
	 * @author Themeisle
	 * @package capri-pro
	 */
	class Capri_Ribbon_Widget extends WP_Widget {

		/**
		 * Capri_Ribbon_Widget constructor.
		 *
		 * @since   1.0.0
		 * @access  public
		 */
		public function __construct() {
			parent::__construct(
				'capri_ribbon-widget',
				esc_html__( 'Capri - Ribbon', 'capri-lite' ), array(
					'customize_selective_refresh' => true,
				)
			);
			add_action( 'admin_enqueue_scripts', array( $this, 'widget_scripts' ) );
		}

		/**
		 * Enqueue scripts
		 *
		 * @since   1.0.0
		 * @access  public
		 */
		public function widget_scripts( $hook ) {
			if ( $hook !== 'widgets.php' ) {
				return;
			}
			wp_enqueue_media();
			wp_enqueue_script( 'capri-widget-media-script', get_template_directory_uri() . '/inc/ribbon-widget/js/widget-media.js', false, '1.1', true );
		}

		/**
		 * Widget display.
		 *
		 * @since   1.0.0
		 * @access  public
		 */
		public function widget( $args, $instance ) {
			if ( ! empty( $args['before_widget'] ) ) {
				echo wp_kses_post( $args['before_widget'] );
			}

			$widget_title = ! empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) : '';
			$widget_text  = ! empty( $instance['text'] ) ? apply_filters( 'capri_translate_single_string', $instance['text'], 'Ribbon Widget' ) : '';
			$button_label = ! empty( $instance['button_text'] ) ? apply_filters( 'capri_translate_single_string', $instance['button_text'], 'Ribbon Widget' ) : '';
			$button_link  = ! empty( $instance['button_link'] ) ? apply_filters( 'capri_translate_single_string', $instance['button_link'], 'Ribbon Widget' ) : '';
			$image_url    = ! empty( $instance['image_uri'] ) ? apply_filters( 'capri_translate_single_string', $instance['image_uri'], 'Ribbon Widget' ) : '';

			?>
			<div class="ribbon-wrap">
				<div class="ribbon-wrap-inner"<?php echo ! empty( $image_url ) ? ' style="background-image: url(' . esc_url( $image_url ) . ')' : ''; ?>">
					<div class="ribbon-overlay"></div>
					<div class="container">
							<div class="ribbon-content">
								<div class="ribbon-content-inner">
									<?php
									if ( ! empty( $widget_title ) ) {
									?>
										<div class="ribbon-title"><?php echo wp_kses_post( $widget_title ); ?></div>
										<?php
									}
									if ( ! empty( $widget_text ) ) {
									?>
										<div class="ribbon-content-wrap"><?php echo wp_kses_post( $widget_text ); ?></div>
										<?php
									}
									if ( ! empty( $button_label ) && ! empty( $button_link ) ) {
									?>
										<a href="<?php echo esc_url( $button_link ); ?>" class="ribbon-button-link">
											<span class="ribbon-button"><?php echo esc_html( $button_label ); ?></span>
										</a>
										<?php
									}
									?>
								</div>
							</div>
					</div><!-- .container -->
				</div><!-- .ribbon-wrap-inner -->
			</div><!-- .ribbon-wrap -->
			<?php
			if ( ! empty( $args['after_widget'] ) ) {
				echo wp_kses_post( $args['after_widget'] );
			}
		}

		/**
		 * Update
		 *
		 * @since   1.0.0
		 * @access  public
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                        = $old_instance;
			$instance['text']                = wp_kses_post( $new_instance['text'] );
			$instance['title']               = wp_kses_post( $new_instance['title'] );
			$instance['button_text']         = sanitize_text_field( $new_instance['button_text'] );
			$instance['button_link']         = esc_url_raw( $new_instance['button_link'] );
			$instance['image_uri']           = esc_url_raw( $new_instance['image_uri'] );
			$instance['custom_media_id']     = sanitize_text_field( $new_instance['custom_media_id'] );
			$instance['image_in_customizer'] = esc_url_raw( $new_instance['image_in_customizer'] );
			$this->capri_ribbon_register( $instance, 'Ribbon Widget' );
			return $instance;
		}

		/**
		 * Widget form
		 *
		 * @since   1.0.0
		 * @access  public
		 */
		public function form( $instance ) {

			echo '<p>';
				echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'capri-lite' ) . '</label><br/>';
				echo '<input type="text" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" value="';
			if ( ! empty( $instance['title'] ) ) {
				echo esc_attr( $instance['title'] );
			}
				echo '" class="widefat">';
			echo '</p>';
			echo '<p>';
				echo '<label for="' . esc_attr( $this->get_field_id( 'text' ) ) . '">' . esc_html__( 'Text', 'capri-lite' ) . '</label><br/>';
				echo '<textarea class="widefat" rows="3" cols="20" name="' . esc_attr( $this->get_field_name( 'text' ) ) . '" id="' . esc_attr( $this->get_field_id( 'text' ) ) . '">';
			if ( ! empty( $instance['text'] ) ) {
				echo htmlspecialchars_decode( $instance['text'] );
			}
				echo '</textarea>';
			echo '</p>';
			echo '<p>';
				echo '<label for="' . esc_attr( $this->get_field_id( 'button_text' ) ) . '">' . esc_html__( 'Button text', 'capri-lite' ) . '</label><br/>';
				echo '<input type="text" name="' . esc_attr( $this->get_field_name( 'button_text' ) ) . '" id="' . esc_attr( $this->get_field_id( 'button_text' ) ) . '" value="';
			if ( ! empty( $instance['button_text'] ) ) {
				echo esc_attr( $instance['button_text'] );
			}
				echo '" class="widefat">';
			echo '</p>';
			echo '<p>';
				echo '<label for="' . esc_attr( $this->get_field_id( 'first-line' ) ) . '">' . esc_html__( 'Button link', 'capri-lite' ) . '</label><br/>';
				echo '<input type="text" name="' . esc_attr( $this->get_field_name( 'button_link' ) ) . '" id="' . esc_attr( $this->get_field_id( 'button_link' ) ) . '" value="';
			if ( ! empty( $instance['button_link'] ) ) {
				echo esc_attr( $instance['button_link'] );
			}
				echo '" class="widefat">';
			echo '</p>';
			echo '<p>';
				echo '<label for="' . esc_attr( $this->get_field_id( 'image_uri' ) ) . '">' . esc_html__( 'Image', 'capri-lite' ) . '</label><br/>';
				$image_in_customizer = '';
				$display             = 'none';
			if ( ! empty( $instance['image_in_customizer'] ) && ! empty( $instance['image_uri'] ) ) {
				$image_in_customizer = esc_url( $instance['image_in_customizer'] );
				$display             = 'inline-block';
			} else {
				if ( ! empty( $instance['image_uri'] ) ) {
					$image_in_customizer = esc_url( $instance['image_uri'] );
					$display             = 'inline-block';
				}
			}
				$capri_pro_image_in_customizer = $this->get_field_name( 'image_in_customizer' );

				echo '<input type="hidden" class="custom_media_display_in_customizer" name="';
			if ( ! empty( $capri_pro_image_in_customizer ) ) {
				echo esc_html( $capri_pro_image_in_customizer );
			}
				echo '" value="';
			if ( ! empty( $instance['image_in_customizer'] ) ) {
				echo esc_attr( $instance['image_in_customizer'] );
			}
				echo '">';
				echo '<img class="custom_media_image" src="' . esc_url( $image_in_customizer ) . '" style="margin:0;padding:0;max-width:100px;float:left;display:' . esc_attr( $display ) . '" alt="' . esc_html__( 'Uploaded image', 'capri-lite' ) . '"/><br/>';

				echo '<input type="text" class="widefat custom_media_url" name="' . esc_attr( $this->get_field_name( 'image_uri' ) ) . '" id="' . esc_attr( $this->get_field_id( 'image_uri' ) ) . '" value="';
			if ( ! empty( $instance['image_uri'] ) ) {
				echo esc_url( $instance['image_uri'] );
			}
				echo '" style="margin-top:5px;">';

				echo '<input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="' . esc_attr( $this->get_field_name( 'image_uri' ) ) . '" value="' . esc_attr__( 'Upload Image', 'capri-lite' ) . '" style="margin-top:5px;">';
			echo '</p>';

			echo '<input class="custom_media_id" id="' . esc_attr( $this->get_field_id( 'custom_media_id' ) ) . '" name="' . esc_attr( $this->get_field_name( 'custom_media_id' ) ) . '" type="hidden" value="';
			if ( ! empty( $instance['custom_media_id'] ) ) {
				echo esc_attr( $instance['custom_media_id'] );
			}
			echo '"/>';
		}

		/**
		 * Register ribbon strings for pll
		 *
		 * @since 1.1.0
		 * @access public
		 */
		function capri_ribbon_register( $instance, $name ) {
			if ( empty( $instance ) || ! function_exists( 'pll_register_string' ) ) {
				return;
			}
			foreach ( $instance as $field_name => $field_value ) {
				$f_n = function_exists( 'ucfirst' ) ? ucfirst( esc_html( $field_name ) ) : esc_html( $field_name );
				pll_register_string( $f_n, $field_value, $name );
			}
		}
	}
}// End if().
