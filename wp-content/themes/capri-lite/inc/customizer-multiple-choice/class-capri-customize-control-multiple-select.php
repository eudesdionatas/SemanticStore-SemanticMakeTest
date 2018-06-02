<?php
/**
 * Customize control multiple choice.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Class Customize_Control_Multiple_Select
 *
 * @author Themeisle
 * @package capri-pro
 */
class Capri_Customize_Control_Multiple_Select extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @var string
	 */
	public $type = 'multiple-select';

	/**
	 * Enqueue necessary script
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function enqueue() {
		wp_enqueue_script( 'capri-customizer-repeater-script', get_template_directory_uri() . '/inc/customizer-multiple-choice/js/customizer_multiple_choice.js', array( 'jquery' ), '1.0.1', true );
	}


	/**
	 * Displays the multiple select on the customize screen.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select class="capri-multiple-select" <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<?php
				foreach ( $this->choices as $value => $label ) {
					$selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
					echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . esc_html( $label ) . '</option>';
				}
				?>
			</select>
		</label>
	<?php
	}
}

if ( ! function_exists( 'capri_sanitize_multiple_select' ) ) {
	/**
	 * Sanitization function for multiple select control.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @param array $input Multiple select input.
	 * @return string
	 */
	function capri_sanitize_multiple_select( $input ) {

		if ( ! empty( $input ) ) {
			$woo_categories = capri_get_woo_categories();
			foreach ( $input as $selected_cat ) {
				if ( ! array_key_exists( $selected_cat, $woo_categories ) ) {
					return array( 'none' );
				}
			}
		}
		return $input;
	}
}
