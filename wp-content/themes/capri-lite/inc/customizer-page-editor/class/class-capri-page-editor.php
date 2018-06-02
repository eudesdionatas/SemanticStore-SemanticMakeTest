<?php
/**
 * Page editor control
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
/**
 * Class to create a custom tags control
 *
 * @author Themeisle
 * @package capri-pro
 */
class Capri_Page_Editor extends WP_Customize_Control {


	/**
	 * Flag to include sync scripts if needed
	 *
	 * @var bool|mixed
	 */
	private $needsync = false;

	/**
	 * Flag to do action admin_print_footer_scripts.
	 * This needs to be true only for one instance.
	 *
	 * @var bool|mixed
	 */
	private $include_admin_print_footer = false;

	/**
	 * Flag to load teeny.
	 *
	 * @var bool|mixed
	 */
	private $teeny = false;

	/**
	 * Capri_Page_Editor constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @param WP_Customize_Manager $manager Manager.
	 * @param string               $id Id.
	 * @param array                $args Constructor args.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( ! empty( $args['needsync'] ) ) {
			$this->needsync = $args['needsync'];
		}
		if ( ! empty( $args['include_admin_print_footer'] ) ) {
			$this->include_admin_print_footer = $args['include_admin_print_footer'];
		}
		if ( ! empty( $args['teeny'] ) ) {
			$this->teeny = $args['teeny'];
		}
	}

	/**
	 * Enqueue scripts
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function enqueue() {
		wp_enqueue_style( 'capri-text-editor-css', get_template_directory_uri() . '/inc/customizer-page-editor/css/customizer-page-editor.css', array(), '1.0.0' );
		wp_enqueue_script( 'capri-text-editor', get_template_directory_uri() . '/inc/customizer-page-editor/js/capri-text-editor.js', array( 'jquery' ), false, true );
		if ( $this->needsync === true ) {
			wp_enqueue_script( 'capri-controls-script', get_template_directory_uri() . '/inc/customizer-page-editor/js/capri-update-controls.js', array( 'jquery', 'customize-preview' ), '', true );
			wp_localize_script(
				'capri-controls-script', 'requestpost', array(
					'ajaxurl'              => esc_url( admin_url( 'admin-ajax.php' ) ),
					'thumbnail_control'    => 'capri_feature_thumbnail',
					'editor_control'       => 'capri_page_editor',
					'control_title_label'  => esc_html__( 'About background', 'capri-lite' ),
					'control_remove_label' => esc_html__( 'Remove', 'capri-lite' ),
					'control_change_label' => esc_html__( 'Change Image', 'capri-lite' ),
				)
			);
		}
	}


	/**
	 * Render the content on the theme customizer page
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_content() {
	?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
		<?php
		$settings        = array(
			'textarea_name' => $this->id,
			'teeny'         => $this->teeny,
		);
		$control_content = $this->value();
		$frontpage_id    = get_option( 'page_on_front' );
		$page_content    = '';
		if ( $this->needsync === true ) {
			if ( ! empty( $frontpage_id ) ) {
				$content_post = get_post( $frontpage_id );
				$page_content = $content_post->post_content;
				$page_content = apply_filters( 'capri_text', $page_content );
				$page_content = str_replace( ']]>', ']]&gt;', $page_content );
			}
		} else {
			$page_content = $this->value();
		}
		if ( $control_content !== $page_content ) {
			$control_content = $page_content;
		}
		wp_editor( $control_content, $this->id, $settings );
		if ( $this->include_admin_print_footer === true ) {
			do_action( 'admin_print_footer_scripts' );
		}
	}
}
