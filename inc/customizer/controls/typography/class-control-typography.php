<?php
/**
 * Customizer Control: subetuwebwp-typography.
 *
 * @package     subetuwebWP WordPress theme
 * @subpackage  Controls
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typography control
 */
class subetuwebWP_Customizer_Typography_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'subetuwebwp-typography';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		// Don't call is The Event Calendar active to avoid conflict
		if ( ! class_exists( 'Tribe__Events__Main' ) || ! class_exists( 'LearnPress' ) || ! defined( 'TUTOR_VERSION' ) || ! defined( 'LEARNDASH_VERSION' ) ) {
			wp_enqueue_script( 'subetuwebwp-select2', subetuwebWP_INC_DIR_URI . 'customizer/controls/select2.min.js', array( 'jquery' ), false, true );
			wp_enqueue_style( 'select2', subetuwebWP_INC_DIR_URI . 'customizer/controls/select2.min.css', null );
			wp_enqueue_script( 'subetuwebwp-typography-js', subetuwebWP_INC_DIR_URI . 'customizer/assets/min/js/typography.min.js', array( 'jquery', 'subetuwebwp-select2' ), false, true );
			wp_localize_script( 'subetuwebwp-select2', 'subetuweb_wp_fonts_list', $this->fonts_list() );

		}
		wp_enqueue_style( 'subetuwebwp-typography', subetuwebWP_INC_DIR_URI . 'customizer/assets/min/css/typography.min.css', null );
	}


	/**
	 * Fonts List.
	 *
	 * @access public
	 */
	public function fonts_list() {
		ob_start();
		?>
		<?php
				// Add custom fonts from child themes
				if ( function_exists( 'subetuweb_add_custom_fonts' ) ) {
					$fonts = subetuweb_add_custom_fonts();
					if ( $fonts && is_array( $fonts ) ) { ?>
						<optgroup label="<?php esc_attr_e( 'Custom Fonts', 'subetuwebwp' ); ?>">
							<?php foreach ( $fonts as $font ) { ?>
								<option value="<?php echo esc_attr( $font ); ?>"><?php echo esc_html( $font ); ?></option>
							<?php } ?>
						</optgroup>
					<?php }
				}

				// Get Standard font options
				if ( $std_fonts = subetuwebwp_standard_fonts() ) { ?>
					<optgroup label="<?php esc_attr_e( 'Standard Fonts', 'subetuwebwp' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $std_fonts as $font ) { ?>
							<option value="<?php echo esc_attr( $font ); ?>"><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php }

				// Google font options
				if ( $google_fonts = subetuwebwp_google_fonts_array() ) { ?>
					<optgroup label="<?php esc_attr_e( 'Google Fonts', 'subetuwebwp' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $google_fonts as $font ) { ?>
							<option value="<?php echo esc_attr( $font ); ?>"><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
		<?php

		$content = str_replace( [ "\n", "\r", "\t" ], '', ob_get_clean());

		return [
			'content' => $content
		];
	}


	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		$this_val = $this->value(); ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<select class="subetuwebwp-typography-select" <?php $this->link(); ?> data-value="<?php echo $this_val ?>">
				<option value="" <?php if ( ! $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Default', 'subetuwebwp' ); ?></option>
			</select>

		</label>

		<?php
	}
}
