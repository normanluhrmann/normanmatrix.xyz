<?php
/**
 * @codingStandardsIgnoreFile
 */

namespace Raven\Modules\Posts\Carousel\Actions;

defined( 'ABSPATH' ) || die();

use Raven\Modules\Posts\Classes\Post_Base;

class Post_Classic extends Post_Base {

	protected function register_action_hooks() {
		add_action( 'elementor/element/raven-posts-carousel/section_sort_filter/after_section_end', [ $this, 'register_action_controls' ] );
	}

	public function register_action_controls( \Elementor\Widget_Base $widget ) {
		$this->skin = $widget->get_skin( 'classic' );

		$this->register_controls();
		$this->inject_controls();
	}

	protected function register_controls() {
		$this->register_container_controls();
		$this->register_image_controls();
		$this->register_icons_controls();
		$this->register_title_controls();
		$this->register_meta_controls();
		$this->register_excerpt_controls();
		$this->register_button_controls();
	}

	protected function inject_controls() {
		$this->skin->start_injection( [
			'at' => 'after',
			'of' => $this->skin->get_control_id( 'slides_scroll' ),
		] );

		$this->register_image_size_control();

		$this->register_settings_controls();

		$this->skin->end_injection();

		$this->skin->start_injection( [
			'at' => 'before',
			'of' => $this->skin->get_control_id( 'post_padding' ),
		] );

		$this->skin->add_responsive_control(
			'columns_height',
			[
				'label' => __( 'Height', 'raven' ),
				'type' => 'slider',
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .raven-post' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->skin->add_responsive_control(
			'columns_space_between',
			[
				'label' => __( 'Space Between', 'raven' ),
				'type' => 'slider',
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slick-list' => 'margin-left: calc( -{{SIZE}}{{UNIT}} / 2 ); margin-right: calc( -{{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .slick-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} / 2 ); padding-right: calc( ( {{SIZE}}{{UNIT}} / 2 ) + 2px );',
				],
			]
		);

		$this->skin->end_injection();
	}

	public function render_post( $instance ) {
		$this->skin = $instance;

		$show_image = $this->skin->get_instance_value( 'show_image' );

		$image_position = $this->skin->get_instance_value( 'post_image_position' );

		$hover_effect = $this->skin->get_instance_value( 'post_hover_effect' );

		$post_classes = [ 'raven-post' ];

		if ( 'yes' === $show_image && 'top' !== $image_position ) {
			$post_classes[] = 'raven-post-inline raven-post-inline-' . $image_position;
		}

		if ( ! empty( $hover_effect ) ) {
			$post_classes[] = 'elementor-animation-' . $hover_effect;
		}

		?>

		<div class="slick-item">
			<div class="raven-post-wrapper">
				<div class="<?php echo esc_attr( implode( ' ', $post_classes ) ); ?>">
					<?php $this->render_image(); ?>

					<div class="raven-post-content">
						<?php
						$this->render_ordered_content();
						$this->render_button();
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}


}
