<?php
/**
 * input[type="hidden"] template
 */

$this->add_attribute( 'placeholder', $args['placeholder'] );
$this->add_attribute( 'value', $args['default'] );
$this->add_attribute( 'required', $this->get_required_val( $args ) );
$this->add_attribute( 'name', $args['name'] );
$this->add_attribute( 'type', 'date' );

?>
<input class="jet-form__field date-field"<?php $this->render_attributes_string(); ?>>