<?php
/**
 * Add form acceptance field.
 *
 * @package Raven
 * @since 1.0.0
 */

namespace Raven\Modules\Forms\Fields;

defined( 'ABSPATH' ) || die();

use Elementor\Plugin as Elementor;

/**
 * Acceptance Field.
 *
 * Initializing the acceptance field by extending field base abstract class.
 *
 * @since 1.0.0
 */
class Acceptance extends Field_Base {

	/**
	 * Get field type.
	 *
	 * Retrieve the field type.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Field type.
	 */
	public function get_type() {
		return 'acceptance';
	}

	/**
	 * Add render attribute.
	 *
	 * Add render attributes for each field based on the settings.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_field_render_attribute() {
		$attributes = [
			'type' => 'checkbox',
			'name' => 'fields[' . $this->get_id() . ']',
			'id' => 'form-field-' . $this->get_id(),
		];

		if ( 'true' === $this->get_required() ) {
			$attributes['required'] = 'required';
		}

		if ( 'true' === $this->field['checked_by_default'] ) {
			$attributes['checked'] = '1';
		}

		$this->widget->add_render_attribute( 'field-' . $this->get_id(), $attributes );
	}

	/**
	 * Render content.
	 *
	 * Render the field content.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_content() {
		?>
		<div class="raven-field-subgroup">
			<span class="raven-field-option">
				<input
					oninput="onInvalidRavenFormField(event)"
					oninvalid="onInvalidRavenFormField(event)"
					<?php echo $this->widget->get_render_attribute_string( 'field-' . $this->get_id() ); ?>>
				<label
					for="form-field-<?php echo $this->get_id(); ?>"
					class="raven-field-label">
					<?php echo $this->field['acceptance_text']; ?>
					</label>
			</span>
		</div>
		<?php
	}

	/**
	 * Update controls.
	 *
	 * Add controls in form fields.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object $widget Widget instance.
	 */
	public function update_controls( $widget ) {
		$control_data = Elementor::$instance->controls_manager->get_control_from_stack(
			$widget->get_unique_name(),
			'fields'
		);

		if ( is_wp_error( $control_data ) ) {
			return;
		}

		$field_controls = [
			'acceptance_text' => [
				'name' => 'acceptance_text',
				'label' => __( 'Acceptance Text', 'raven' ),
				'default' => __( 'I agree to terms.', 'raven' ),
				'type' => 'textarea',
				'condition' => [
					'type' => $this->get_type(),
				],
			],
			'checked_by_default' => [
				'name' => 'checked_by_default',
				'label' => __( 'Checked by Default', 'raven' ),
				'type' => 'switcher',
				'return_value' => 'true',
				'condition' => [
					'type' => $this->get_type(),
				],
			],
		];

		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
		$widget->update_control( 'fields', $control_data );
	}
}
