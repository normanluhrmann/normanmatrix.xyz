<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Jet_Engine_User_Field_Tag extends Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'jet-user-custom-field';
	}

	public function get_title() {
		return __( 'User Field', 'jet-engine' );
	}

	public function get_group() {
		return Jet_Engine_Dynamic_Tags_Module::JET_GROUP;
	}

	public function get_categories() {
		return array(
			Jet_Engine_Dynamic_Tags_Module::TEXT_CATEGORY,
			Jet_Engine_Dynamic_Tags_Module::NUMBER_CATEGORY,
			Jet_Engine_Dynamic_Tags_Module::URL_CATEGORY,
			Jet_Engine_Dynamic_Tags_Module::POST_META_CATEGORY,
			Jet_Engine_Dynamic_Tags_Module::COLOR_CATEGORY
		);
	}

	public function is_settings_required() {
		return true;
	}

	protected function _register_controls() {

		$this->add_control(
			'user_field',
			array(
				'label'  => __( 'Field', 'jet-engine' ),
				'type'   => Elementor\Controls_Manager::SELECT,
				'groups' => $this->get_user_fields(),
			)
		);

		$this->add_control(
			'user_context',
			array(
				'label'   => __( 'Context', 'jet-engine' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'current_user',
				'options' => array(
					'current_user' => __( 'Current User', 'jet-engine' ),
					'queried_user' => __( 'Queried User', 'jet-engine' ),
				),
			)
		);

	}

	public function render() {

		$user_field = $this->get_settings( 'user_field' );
		$context    = $this->get_settings( 'user_context' );

		if ( ! $context ) {
			$context = 'current_user';
		}

		if ( empty( $user_field ) ) {
			return;
		}

		$default_fields = $this->default_user_fields();
		$value          = false;

		if ( 'current_user' === $context ) {
			$user_object = jet_engine()->listings->data->get_current_user_object();
		} else {
			$user_object = jet_engine()->listings->data->get_queried_user_object();
		}

		if ( ! $user_object ) {
			return;
		}

		if ( isset( $default_fields[ $user_field ] ) ) {
			$value = jet_engine()->listings->data->get_prop( $user_field, $user_object );
		} elseif ( $user_object ) {
			$value = get_user_meta( $user_object->ID, $user_field, true );
		}

		echo $value;

	}

	public function default_user_fields() {
		return array(
			'ID'              => __( 'ID', 'jet-engine' ),
			'user_login'      => __( 'Login', 'jet-engine' ),
			'user_nicename'   => __( 'Nickname', 'jet-engine' ),
			'user_email'      => __( 'E-mail', 'jet-engine' ),
			'user_url'        => __( 'URL', 'jet-engine' ),
			'user_registered' => __( 'Registration Date', 'jet-engine' ),
			'display_name'    => __( 'Display Name', 'jet-engine' ),
		);
	}

	private function get_user_fields() {

		$default = array(
			'label'   => __( 'User Properties', 'jet-engine' ),
			'options' => $this->default_user_fields(),
		);

		if ( jet_engine()->meta_boxes ) {
			return array_merge(
				array( $default ),
				jet_engine()->meta_boxes->get_fields_for_select( 'plain', 'elementor', 'user' )
			);
		} else {
			return array( $default );
		}

	}
}
