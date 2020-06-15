<?php
/**
 * Add Jupiter settings for Footer > Styles > Widgets Text popup to the WordPress Customizer.
 *
 * @package JupiterX\Framework\Admin\Customizer
 *
 * @since   1.0.0
 */

$section = 'jupiterx_footer_widgets_text';

// Typography.
JupiterX_Customizer::add_field( [
	'type'       => 'jupiterx-typography',
	'settings'   => 'jupiterx_footer_widgets_text_typography',
	'section'    => $section,
	'responsive' => true,
	'css_var'    => 'footer-widgets-text',
	'transport'  => 'postMessage',
	'exclude'    => [ 'letter_spacing', 'text_transform' ],
	'output'     => [
		[
			'element' => '.jupiterx-footer-widgets .jupiterx-widget-content, .jupiterx-footer-widgets .jupiterx-widget-content p',
		],
	],
] );
