<?php
/**
 * input[type="hidden"] template
 */

$this->add_attribute( 'placeholder', $args['placeholder'] );
$this->add_attribute( 'value', $args['default'] );
$this->add_attribute( 'required', $this->get_required_val( $args ) );
$this->add_attribute( 'min', $args['min'] );
$this->add_attribute( 'max', $args['max'] );
$this->add_attribute( 'step', $args['step'] );
$this->add_attribute( 'name', $args['name'] );

?>
<input type="number" class="jet-form__field text-field"<?php $this->render_attributes_string(); ?>>