<?php
/**
 * Add form Redirect action.
 *
 * @package Raven
 * @since 1.0.0
 */

namespace Raven\Modules\Forms\Actions;

defined( 'ABSPATH' ) || die();

/**
 * MailChimp Action.
 *
 * Initializing the Redirect action by extending action base.
 *
 * @since 1.0.0
 */
class Redirect extends Action_Base {

	/**
	 * Update controls.
	 *
	 * Add Redirect section.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param object $widget Widget instance.
	 */
	public function update_controls( $widget ) {

		$widget->start_controls_section(
			'section_redirect',
			[
				'label' => __( 'Redirect', 'raven' ),
				'condition' => [
					'actions' => 'redirect',
				],
			]
		);

		$widget->add_control(
			'redirect_to',
			[
				'label' => __( 'Redirect To', 'raven' ),
				'type' => 'text',
				'placeholder' => site_url() . '/thank-you',
				'label_block' => true,
				'render_type' => 'ui',
			]
		);

		$widget->end_controls_section();

	}

	/**
	 * Run action.
	 *
	 * Add redirect URL to the response.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param object $ajax_handler Ajax handler instance.
	 */
	public static function run( $ajax_handler ) {
		$url = $ajax_handler->form['settings']['redirect_to'];

		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			$admin_error = __( 'Redirect Action: The "Redirect To" value is not a valid URL.', 'raven' );
		}

		if ( empty( $admin_error ) ) {
			return $ajax_handler->add_response( 'redirect_to', $url );
		}

		$ajax_handler->add_response( 'admin_errors', $admin_error );
	}
}
