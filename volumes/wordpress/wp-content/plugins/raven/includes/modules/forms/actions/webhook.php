<?php
/**
 * Form Webhook action.
 *
 * @package Raven
 * @since 1.3.0
 */

namespace Raven\Modules\Forms\Actions;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

/**
 * Webhook Action.
 *
 * Initializing the Webhook action by extending action base.
 *
 * @since 1.3.0
 */
class Webhook extends Action_Base {
	/**
	 * Exclude form fields in the webhook.
	 *
	 * @access private
	 *
	 * @var array
	 */
	private static $exclude_fields = [ 'recaptcha', 'recaptcha_v3' ];

	/**
	 * Update controls.
	 *
	 * Webhook setting section.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @param object $widget Widget instance.
	 */
	public function update_controls( $widget ) {

		$widget->start_controls_section(
			'section_webhook',
			[
				'label' => __( 'Webhook', 'raven' ),
				'condition' => [
					'actions' => 'webhook',
				],
			]
		);

		$widget->add_control(
			'webhook_url',
			[
				'label' => __( 'Webhook URL', 'raven' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'http://webhook-endpoint.com',
				'description' => __( 'Enter the webhook URL where you want to send your Form data after submit e.g. ', 'raven' ) . sprintf( '<a href="%s" target="_blank">%s</a>.', 'https://zapier.com/apps/webhook/integrations', __( 'Integrate with Zapier Webhook', 'raven' ) ),
			]
		);

		$widget->end_controls_section();

	}

	/**
	 * Run action.
	 *
	 * Send form data to webhook URL.
	 *
	 * @since 1.3.0
	 * @access public
	 * @static
	 *
	 * @param object $ajax_handler Ajax handler instance.
	 *
	 * @return void
	 */
	public static function run( $ajax_handler ) {
		$settings = $ajax_handler->form['settings'];

		if ( empty( $settings['webhook_url'] ) ) {
			return;
		}

		$body = self::get_form_data( $ajax_handler, $settings );

		$args = [
			'body' => $body,
		];

		$response = wp_remote_post( $settings['webhook_url'], $args );

		if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			$ajax_handler->add_response( 'admin_errors', __( 'Webhook Action: Webhook Error.', 'raven' ) );
		}
	}

	/**
	 * Get form fields data.
	 *
	 * @since 1.3.0
	 * @access private
	 * @static
	 *
	 * @param object $ajax_handler Ajax handler instance.
	 * @param array  $settings Form settings.
	 *
	 * @return array
	 */
	private static function get_form_data( $ajax_handler, $settings ) {
		$fields = [];

		foreach ( $settings['fields'] as $field ) {
			if ( \in_array( $field['type'], self::$exclude_fields, true ) ) {
				continue;
			}

			$field_value = $ajax_handler->record['fields'][ $field['_id'] ];

			if ( 'acceptance' === $field['type'] ) {
				$field_value = empty( $field_value ) ? __( 'No', 'raven' ) : __( 'Yes', 'raven' );
			}

			if ( empty( $field['label'] ) ) {
				$fields[ __( 'No Label', 'raven' ) . ' ' . $field['_id'] ] = $field_value;
			} else {
				$fields[ $field['label'] ] = $field_value;
			}
		}

		return $fields;
	}
}
