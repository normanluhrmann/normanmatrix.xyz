<?php
/**
 * @codingStandardsIgnoreFile
 */

namespace Raven\Modules\Posts\Post\Actions;

defined( 'ABSPATH' ) || die();

use Raven\Modules\Posts\Classes\Post_Base;

class Post_Cover extends Post_Base {

	protected function register_action_hooks() {
		add_action( 'elementor/element/raven-posts/section_sort_filter/after_section_end', [ $this, 'register_action_controls' ] );
	}

	public function register_action_controls( \Elementor\Widget_Base $widget ) {
		$this->skin = $widget->get_skin( 'cover' );

		$this->register_controls();
		$this->inject_controls();
		$this->update_controls();
	}

	protected function register_controls() {
		$this->register_container_controls();
		$this->register_image_controls();
		$this->register_overlay_controls();
		$this->register_icons_controls();
		$this->register_title_controls();
		$this->register_meta_controls();
		$this->register_excerpt_controls();
		$this->register_button_controls();
	}

	protected function register_container_controls() {
		$this->skin->start_controls_section(
			'section_container',
			[
				'label' => __( 'Container', 'raven' ),
				'tab' => 'style',
			]
		);

		$this->skin->add_responsive_control(
			'post_padding',
			[
				'label' => __( 'Padding', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .raven-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->skin->add_control(
			'post_align',
			[
				'label' => __( 'Alignment', 'raven' ),
				'type' => 'choose',
				'label_block' => false,
				'default' => '',
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
				'selectors' => [
					'{{WRAPPER}} .raven-post-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->skin->start_controls_tabs( 'tabs_container' );

		$this->skin->start_controls_tab(
			'tab_container_normal',
			[
				'label' => __( 'Normal', 'raven' ),
			]
		);

		$this->skin->add_group_control(
			'raven-background',
			[
				'name' => 'post_background',
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'label' => __( 'Background Color Type', 'raven' ),
					],
					'color' => [
						'label' => __( 'Background Color', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-post',
			]
		);

		$this->skin->add_control(
			'post_border_heading',
			[
				'label' => __( 'Border', 'raven' ),
				'type' => 'heading',
				'separator' => 'before',
			]
		);

		$this->skin->add_control(
			'post_border_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'condition' => [
					$this->skin->get_control_id( 'post_border_border!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->skin->add_group_control(
			'border',
			[
				'name' => 'post_border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-post',
			]
		);

		$this->skin->add_control(
			'post_border_radius',
			[
				'label' => __( 'Border Radius', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->skin->add_group_control(
			'box-shadow',
			[
				'name' => 'post_box_shadow',
				'selector' => '{{WRAPPER}} .raven-post',
			]
		);

		$this->skin->end_controls_tab();

		$this->skin->start_controls_tab(
			'tab_container_hover',
			[
				'label' => __( 'Hover', 'raven' ),
			]
		);

		$this->skin->add_group_control(
			'raven-background',
			[
				'name' => 'hover_post_background',
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'label' => __( 'Background Color Type', 'raven' ),
					],
					'color' => [
						'label' => __( 'Background Color', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-post:hover',
			]
		);

		$this->skin->add_control(
			'hover_post_border_heading',
			[
				'label' => __( 'Border', 'raven' ),
				'type' => 'heading',
				'separator' => 'before',
			]
		);

		$this->skin->add_control(
			'hover_post_border_color',
			[
				'label' => __( 'Color', 'raven' ),
				'type' => 'color',
				'condition' => [
					$this->skin->get_control_id( 'hover_post_border_border!' ) => '',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->skin->add_group_control(
			'border',
			[
				'name' => 'hover_post_border',
				'placeholder' => '1px',
				'exclude' => [ 'color' ],
				'fields_options' => [
					'width' => [
						'label' => __( 'Border Width', 'raven' ),
					],
				],
				'selector' => '{{WRAPPER}} .raven-post:hover',
			]
		);

		$this->skin->add_control(
			'hover_post_border_radius',
			[
				'label' => __( 'Border Radius', 'raven' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->skin->add_group_control(
			'box-shadow',
			[
				'name' => 'hover_post_box_shadow',
				'selector' => '{{WRAPPER}} .raven-post:hover',
			]
		);

		$this->skin->end_controls_tab();

		$this->skin->end_controls_tabs();

		$this->skin->end_controls_section();
	}

	protected function register_image_controls() {
		$this->skin->start_controls_section(
			'section_image',
			[
				'label' => __( 'Featured Image', 'raven' ),
				'tab' => 'style',
				'condition' => [
					$this->skin->get_control_id( 'show_image' ) => 'yes',
				],
			]
		);

		$this->skin->add_control(
			'post_image_background_position',
			[
				'label' => __( 'Background Position', 'raven' ),
				'type' => 'select',
				'default' => 'center center',
				'options' => [
					'center center' => __( 'Center Center', 'raven' ),
					'center left' => __( 'Center Left', 'raven' ),
					'center right' => __( 'Center Right', 'raven' ),
					'top center' => __( 'Top Center', 'raven' ),
					'top left' => __( 'Top Left', 'raven' ),
					'top right' => __( 'Top Right', 'raven' ),
					'bottom center' => __( 'Bottom Center', 'raven' ),
					'bottom left' => __( 'Bottom Left', 'raven' ),
					'bottom right' => __( 'Bottom Right', 'raven' ),
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => '_skin',
							'operator' => '===',
							'value' => $this->skin->get_id(),
						],
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'query_post_type',
									'operator' => '===',
									'value' => 'post',
								],
								[
									'name' => $this->skin->get_control_id( 'layout' ),
									'operator' => '!==',
									'value' => 'masonry',
								],
								[
									'name' => '_skin',
									'operator' => '===',
									'value' => 'classic',
								],
							],
						]
					],
				],
				'selectors' => [
					'{{WRAPPER}} .raven-image-fit img' => '-o-object-position: {{VALUE}}; object-position: {{VALUE}};',
				],
			]
		);

		$this->skin->add_control(
			'post_image_background_size',
			[
				'label' => __( 'Background Size', 'raven' ),
				'type' => 'select',
				'default' => 'cover',
				'options' => [
					'auto' => __( 'Auto', 'raven' ),
					'cover' => __( 'Cover', 'raven' ),
					'contain' => __( 'Contain', 'raven' ),
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => '_skin',
							'operator' => '===',
							'value' => $this->skin->get_id(),
						],
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'query_post_type',
									'operator' => '===',
									'value' => 'post',
								],
								[
									'name' => $this->skin->get_control_id( 'layout' ),
									'operator' => '!==',
									'value' => 'masonry',
								],
								[
									'name' => '_skin',
									'operator' => '===',
									'value' => 'classic',
								],
							],
						]
					],
				],
				'selectors' => [
					'{{WRAPPER}} .raven-image-fit img' => '-o-object-fit: {{VALUE}}; object-fit: {{VALUE}};',
				],
			]
		);

		$this->skin->add_control(
			'post_image_hover_effect',
			[
				'label' => __( 'Hover Effect', 'raven' ),
				'type' => 'select',
				'default' => '',
				'options' => [
					'' => __( 'None', 'raven' ),
					'slide-right' => __( 'Slide Right', 'raven' ),
					'slide-down' => __( 'Slide Down', 'raven' ),
					'scale-down' => __( 'Scale Down', 'raven' ),
					'scale-up' => __( 'Scale Up', 'raven' ),
					'blur' => __( 'Blur', 'raven' ),
					'grayscale-reverse' => __( 'Grayscale to Color', 'raven' ),
					'grayscale' => __( 'Color to Grayscale', 'raven' ),
				],
				'prefix_class' => 'raven-hover-',
			]
		);

		$this->skin->start_controls_tabs( 'tabs_post_image' );

		$this->skin->start_controls_tab(
			'tab_post_image_normal',
			[
				'label' => __( 'Normal', 'raven' ),
			]
		);

		$this->skin->add_responsive_control(
			'post_image_opacity',
			[
				'label' => __( 'Opacity', 'raven' ),
				'type' => 'slider',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => '1',
				],
				'tablet_default' => [
					'size' => '1',
				],
				'mobile_default' => [
					'size' => '1',
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->skin->end_controls_tab();

		$this->skin->start_controls_tab(
			'tab_post_image_hover',
			[
				'label' => __( 'Hover', 'raven' ),
			]
		);

		$this->skin->add_responsive_control(
			'hover_post_image_opacity',
			[
				'label' => __( 'Opacity', 'raven' ),
				'type' => 'slider',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post-image:hover img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .raven-post-inside:hover .raven-post-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->skin->end_controls_tab();

		$this->skin->end_controls_tabs();

		$this->skin->end_controls_section();
	}

	protected function inject_controls() {
		$this->skin->start_injection( [
			'at' => 'before',
			'of' => 'query_posts_per_page',
		] );

		$this->register_image_size_control();

		$this->skin->end_injection();

		$this->skin->start_injection( [
			'at' => 'after',
			'of' => 'query_posts_per_page',
		] );

		$this->register_settings_controls();

		$this->skin->end_injection();

		$this->skin->start_injection( [
			'at' => 'before',
			'of' => $this->skin->get_control_id( 'post_padding' ),
		] );

		$this->skin->add_responsive_control(
			'columns_spacing',
			[
				'label' => __( 'Column Spacing', 'raven' ),
				'type' => 'slider',
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'device_args' => [
					'desktop' => [
						'selectors' => [
							'{{WRAPPER}} .raven-grid, {{WRAPPER}} .raven-masonry' => 'margin-left: calc( -{{SIZE}}{{UNIT}} / 2 ); margin-right: calc( -{{SIZE}}{{UNIT}} / 2 );',
							'{{WRAPPER}} .raven-grid-item, {{WRAPPER}} .raven-masonry-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} / 2 ); padding-right: calc( {{SIZE}}{{UNIT}} / 2 );',
							'{{WRAPPER}} .raven-grid.raven-grid-1, {{WRAPPER}} .raven-masonry.raven-masonry-1' => 'margin-left: 0; margin-right: 0;',
							'{{WRAPPER}} .raven-grid.raven-grid-1 .raven-grid-item, {{WRAPPER}} .raven-masonry.raven-masonry-1 .raven-masonry-item' => 'padding-left: 0; padding-right: 0;',
						],
					],
					'tablet' => [
						'selectors' => [
							'{{WRAPPER}} .raven-grid, {{WRAPPER}} .raven-masonry' => 'margin-left: calc( -{{SIZE}}{{UNIT}} / 2 ); margin-right: calc( -{{SIZE}}{{UNIT}} / 2 );',
							'{{WRAPPER}} .raven-grid-item, {{WRAPPER}} .raven-masonry-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} / 2 ); padding-right: calc( {{SIZE}}{{UNIT}} / 2 );',
							'{{WRAPPER}} .raven-grid.raven-grid-tablet-1, {{WRAPPER}} .raven-masonry.raven-masonry-tablet-1' => 'margin-left: 0; margin-right: 0;',
							'{{WRAPPER}} .raven-grid.raven-grid-tablet-1 .raven-grid-item, {{WRAPPER}} .raven-masonry.raven-masonry-tablet-1 .raven-masonry-item' => 'padding-left: 0; padding-right: 0;',
						],
					],
					'mobile' => [
						'selectors' => [
							'{{WRAPPER}} .raven-grid, {{WRAPPER}} .raven-masonry' => 'margin-left: calc( -{{SIZE}}{{UNIT}} / 2 ); margin-right: calc( -{{SIZE}}{{UNIT}} / 2 );',
							'{{WRAPPER}} .raven-grid-item, {{WRAPPER}} .raven-masonry-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} / 2 ); padding-right: calc( {{SIZE}}{{UNIT}} / 2 );',
							'{{WRAPPER}} .raven-grid.raven-grid-mobile-1, {{WRAPPER}} .raven-masonry.raven-masonry-mobile-1' => 'margin-left: 0; margin-right: 0;',
							'{{WRAPPER}} .raven-grid.raven-grid-mobile-1 .raven-grid-item, {{WRAPPER}} .raven-masonry.raven-masonry-mobile-1 .raven-masonry-item' => 'padding-left: 0; padding-right: 0;',
						],
					],
				]
			]
		);

		$this->skin->add_responsive_control(
			'rows_spacing',
			[
				'label' => __( 'Row Spacing', 'raven' ),
				'type' => 'slider',
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->skin->end_injection();
	}

	protected function update_controls() {
		$this->skin->update_control(
			'show_image',
			[
				'default' => 'yes',
			]
		);

		$this->skin->update_responsive_control(
			'post_image_height',
			[
				'condition' => [
					'_skin' => $this->skin->get_id(),
					$this->skin->get_control_id( 'layout!' ) => 'masonry',
				],
			]
		);
	}

	public function render_post( $instance ) {
		$this->skin = $instance;

		$layout       = $this->skin->get_instance_value( 'layout' );
		$show_image   = $this->skin->get_instance_value( 'show_image' );
		$hover_effect = $this->skin->get_instance_value( 'post_hover_effect' );
		$content      = ! $this->has_overlay() || 'cover' !== $this->skin->get_id();

		$item_classes = [
			'masonry' === $layout ? 'raven-masonry-item' : 'raven-grid-item',
			'raven-post-item',
		];

		$item_classes = array_merge( $item_classes, get_post_class() );

		$post_classes = [ 'raven-post' ];

		if ( 'yes' === $show_image ) {
			$post_classes[] = 'raven-post-inside';
		}

		if ( ! empty( $hover_effect ) ) {
			$post_classes[] = 'elementor-animation-' . $hover_effect;
		}

		?>
		<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">
			<div class="<?php echo esc_attr( implode( ' ', $post_classes ) ); ?>">
				<?php
				$this->render_image();

				$this->get_render_overlay();

				if ( $content ) {
					?>
					<div class="raven-post-content">
						<?php
						$this->render_ordered_content();
						$this->render_button();
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	protected function render_image() {
		if ( ! $this->skin->get_instance_value( 'show_image' ) ) {
			return;
		}

		$settings = [
			'image_size' => $this->skin->get_instance_value( 'post_image_size_size' ),
			'image' => [
				'id' => get_post_thumbnail_id(),
			],
			'image_custom_dimension' => $this->skin->get_instance_value( 'post_image_size_custom_dimension' ),
		];

		$image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings );

		if ( empty( $image_html ) ) {
			return;
		}

		$classes = [
			'raven-post-image',
			'raven-image-fit'
		];

		$html_tag = $this->disabled_overlay() ? 'a' : 'div';

		?>
		<div class="raven-post-image-wrap">
			<?php
			printf(
				'<%1$s class="%2$s" %3$s><span class="raven-post-image-overlay">%6$s</span>%4$s %5$s</%1$s>',
				$html_tag,
				implode( ' ', $classes ),
				( 'a' === $html_tag ) ? 'href="' . get_permalink() . '"' : '',
				( isset( $fit_image ) ) ? $fit_image : '',
				$image_html,
				$this->get_render_overlay()
			);
			?>
		</div>
		<?php
	}
}
