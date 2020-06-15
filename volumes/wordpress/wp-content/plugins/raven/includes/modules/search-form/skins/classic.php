<?php
namespace Raven\Modules\Search_Form\Skins;

defined( 'ABSPATH' ) || die();

use Elementor\Plugin as Elementor;

class Classic extends \Elementor\Skin_Base {

	public function get_id() {
		return 'classic';
	}

	public function get_title() {
		return __( 'Classic', 'raven' );
	}

	protected function _register_controls_actions() {
		add_action( 'elementor/element/raven-search-form/section_content/after_section_end', [ $this, 'register_controls' ], 10 );
	}

	public function register_controls() {
		$this->register_input_controls();
		$this->register_icon_controls();
	}

	public function register_input_controls() {
		$this->start_controls_section(
			'section_input',
			[
				'label' => __( 'Input', 'raven' ),
				'tab' => 'style',
			]
		);

		$this->add_responsive_control(
			'input_width',
			[
				'label' => __( 'Width', 'raven' ),
				'type' => 'slider',
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-inner' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			'typography',
			[
				'name' => 'input_typography',
				'scheme' => '3',
				'selector' => '{{WRAPPER}} .raven-search-form-input',
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label' => __( 'Padding', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-input, {{WRAPPER}} .raven-search-form-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_align',
			[
				'label' => __( 'Alignment', 'raven' ),
				'type' => 'choose',
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'raven' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'raven' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'raven' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->start_controls_tabs( 'tabs_input' );

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => __( 'Normal', 'raven' ),
			]
		);

		$this->add_control(
			'input_color',
			[
				'label' => __( 'Text Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-input' => 'color: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'input_background_color',
			[
				'label' => __( 'Background Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_heading',
			[
				'label' => __( 'Border', 'raven' ),
				'type' => 'heading',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'condition' => [
					$this->get_control_id( 'input_border_border!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			'border',
			[
				'name' => 'input_border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-search-form-inner',
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' => __( 'Border Radius', 'raven' ),
				'type' => 'dimensions',
				'size_s' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			'box-shadow',
			[
				'name' => 'input_box_shadow',
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .raven-search-form-inner',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label' => __( 'Focus', 'raven' ),
			]
		);

		$this->add_control(
			'focus_input_color',
			[
				'label' => __( 'Text Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-focus .raven-search-form-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'focus_input_background_color',
			[
				'label' => __( 'Background Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-focus .raven-search-form-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'focus_input_border_heading',
			[
				'label' => __( 'Border', 'raven' ),
				'type' => 'heading',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'focus_input_border_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'condition' => [
					$this->get_control_id( 'focus_input_border_border!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-focus .raven-search-form-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			'border',
			[
				'name' => 'focus_input_border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-search-form-focus .raven-search-form-inner',
			]
		);

		$this->add_control(
			'focus_input_border_radius',
			[
				'label' => __( 'Border Radius', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-focus .raven-search-form-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			'box-shadow',
			[
				'name' => 'focus_input_box_shadow',
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .raven-search-form-focus .raven-search-form-inner',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function register_icon_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'raven' ),
				'tab' => 'style',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'raven' ),
				'type' => 'slider',
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .raven-search-form-button > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'allowed_dimensions' => 'horizontal',
				'placeholder' => [
					'top' => 'auto',
					'right' => '',
					'bottom' => 'auto',
					'left' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => __( 'Normal', 'raven' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .raven-search-form-button > svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_color',
			[
				'label' => __( 'Background Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_heading',
			[
				'label' => __( 'Border', 'raven' ),
				'type' => 'heading',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'condition' => [
					$this->get_control_id( 'icon_border_border!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			'border',
			[
				'name' => 'icon_border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-search-form-button',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'raven' ),
			]
		);

		$this->add_control(
			'hover_icon_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .raven-search-form-button:hover > svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_icon_background_color',
			[
				'label' => __( 'Background Color', 'raven' ),
				'type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_icon_border_heading',
			[
				'label' => __( 'Border', 'raven' ),
				'type' => 'heading',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hover_icon_border_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'condition' => [
					$this->get_control_id( 'hover_icon_border_border!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			'border',
			[
				'name' => 'hover_icon_border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-search-form-button:hover',
			]
		);

		$this->add_control(
			'hover_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-search-form-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render() {
		$icon     = $this->parent->get_settings( 'icon' );
		$icon_new = $this->parent->get_settings( 'icon_new' );

		$migration_allowed = Elementor::$instance->icons_manager->is_migration_allowed();
		$is_new            = empty( $icon ) && $migration_allowed;

		?>
		<form class="raven-search-form raven-search-form-classic" method="get" action="<?php echo esc_url( get_bloginfo( 'url' ) ); ?>" role="search">
			<div class="raven-search-form-container">
				<div class="raven-search-form-inner">
					<input class="raven-search-form-input" type="search" name="s" placeholder="<?php echo $this->parent->get_settings( 'placeholder' ); ?>" />
					<?php
					if ( ! empty( $icon ) || ! empty( $icon_new['value'] ) ) :
						if ( $is_new || ! empty( $icon_new['value'] ) ) :
							if ( 'svg' === $icon_new['library'] ) {
								?>
								<button class="raven-search-form-button raven-search-form-button-svg">
									<?php Elementor::$instance->icons_manager->render_icon( $icon_new ); ?>
								</button>
								<?php
							} else {
								Elementor::$instance->icons_manager->render_icon( $icon_new, [ 'class' => 'raven-search-form-button' ], 'button' );
							}
						else :
							?>
							<button class="raven-search-form-button <?php echo esc_attr( $icon ); ?>"></button>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</form>
		<?php
	}
}
