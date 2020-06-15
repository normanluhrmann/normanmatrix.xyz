<?php
/**
 * Textarea template
 */

$this->add_attribute( 'placeholder', $args['placeholder'] );
$this->add_attribute( 'required', $this->get_required_val( $args ) );
$this->add_attribute( 'name', $args['name'] );

if ( ! empty( $args['minlength'] ) ) {
	$this->add_attribute( 'minlength', $args['minlength'] );
}

if ( ! empty( $args['maxlength'] ) ) {
	$this->add_attribute( 'maxlength', $args['maxlength'] );
}

?>
<textarea class="jet-form__field textarea-field"<?php $this->render_attributes_string(); ?>><?php
	echo $args['default'];
?></textarea>