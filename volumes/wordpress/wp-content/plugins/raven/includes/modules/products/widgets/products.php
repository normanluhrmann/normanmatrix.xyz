<?php
namespace Raven\Modules\Products\Widgets;

defined( 'ABSPATH' ) || die();

use Raven\Utils;
use Raven\Base\Base_Widget;
use Raven\Modules\Products\Skins;

class Products extends Base_Widget {

	protected $_has_template_content = false;

	public $query = null;

	public function get_name() {
		return 'raven-wc-products';
	}

	public function get_title() {
		return __( 'Products', 'raven' );
	}

	public function get_icon() {
		return 'raven-element-icon raven-element-icon-products';
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'raven-pagination' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Classic( $this ) );
	}

	protected function _register_controls() {
		$this->register_content_controls();
		$this->register_settings_controls();
		$this->register_sort_filter_controls();
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'raven' ),
			]
		);

		$this->add_group_control(
			'raven-posts',
			[
				'name' => 'query',
				'post_type' => 'product',
				'exclude' => [ 'authors' ],
			]
		);

		$this->end_controls_section();

		$this->update_control(
			'_skin',
			[
				'frontend_available' => 'true',
			]
		);
	}

	protected function register_settings_controls() {
		$this->start_controls_section(
			'section_settings',
			[
				'label' => __( 'Settings', 'raven' ),
			]
		);

		$this->end_controls_section();
	}

	protected function register_sort_filter_controls() {
		$this->start_controls_section(
			'section_sort_filter',
			[
				'label' => __( 'Sort & Filter', 'raven' ),
			]
		);

		$this->add_control(
			'query_orderby',
			[
				'label' => __( 'Order By', 'raven' ),
				'type' => 'select',
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'raven' ),
					'title' => __( 'Title', 'raven' ),
					'menu_order' => __( 'Menu Order', 'raven' ),
					'random' => __( 'Random', 'raven' ),
				],
			]
		);

		$this->add_control(
			'query_order',
			[
				'label' => __( 'Order', 'raven' ),
				'type' => 'select',
				'default' => 'DESC',
				'options' => [
					'ASC' => __( 'ASC', 'raven' ),
					'DESC' => __( 'DESC', 'raven' ),
				],
			]
		);

		$this->add_control(
			'query_offset',
			[
				'label' => __( 'Offset', 'raven' ),
				'description' => __( 'Use this setting to skip over posts (e.g. \'4\' to skip over 4 posts).', 'raven' ),
				'type' => 'number',
				'default' => 0,
				'min' => 0,
				'max' => 100,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'query_excludes',
			[
				'label' => __( 'Excludes', 'raven' ),
				'type' => 'select2',
				'multiple' => true,
				'label_block' => true,
				'default' => [ 'current_post' ],
				'options' => [
					'current_post' => __( 'Current Product', 'raven' ),
					'manual_selection' => __( 'Manual Selection', 'raven' ),
				],
			]
		);

		$this->add_control(
			'query_excludes_ids',
			[
				'label' => __( 'Search & Select', 'raven' ),
				'type' => 'raven_query',
				'options' => [],
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'query_excludes' => 'manual_selection',
				],
				'query' => [
					'source' => 'post',
					'post_type' => 'product',
					'numberposts' => 30,
					'no_found_rows' => true,
					'orderby' => 'title',
				],
			]
		);

		$this->add_control(
			'query_filter_by',
			[
				'label' => __( 'Filter By', 'raven' ),
				'type' => 'select',
				'default' => '',
				'options' => [
					'' => __( 'None', 'raven' ),
					'featured' => __( 'Featured', 'raven' ),
					'sale' => __( 'Sale', 'raven' ),
				],
			]
		);

		$this->end_controls_section();
	}

	public function query_posts() {
		$settings = $this->get_settings_for_display();

		$skin = $this->get_current_skin();

		$query_args = Utils::get_query_args( $settings );

		$order_args = WC()->query->get_catalog_ordering_args( $settings['query_orderby'], $settings['query_order'] );

		$query_args['orderby'] = $order_args['orderby'];

		$query_args['order'] = $order_args['order'];

		$query_args['tax_query'][] = [ // phpcs:ignore
			[
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			],
		];

		if ( 'yes' === $settings[ $skin->get_id() . '_show_all_products' ] ) {
			$query_args['posts_per_page'] = -1;
		} else {
			$query_args['posts_per_page'] = intval( $settings[ $skin->get_id() . '_columns' ] ) * intval( $settings[ $skin->get_id() . '_rows' ] );
		}

		if ( ! empty( $order_args['meta_key'] ) ) {
			$query_args['meta_key'] = $order_args['meta_key']; // phpcs:ignore
		}

		if ( 'sale' === $settings['query_filter_by'] ) {
			$query_args['post__in'] = array_merge( [ 0 ], wc_get_product_ids_on_sale() );
		}

		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
			$query_args = $this->get_wc_visibility_parse_query( $query_args );
		} else {
			$query_args = $this->get_wc_legacy_visibility_parse_query( $query_args );
		}

		$this->query = new \WP_Query( $query_args );
	}

	public function ajax_get_render_products() {
		$skin = $this->get_current_skin();

		if ( ! $skin ) {
			return;
		}

		$skin->set_parent( $this );

		$this->query_posts();

		$queried_products = $skin->render_products( false );

		$queried_products['currentPage'] = max( 1, $this->query->get( 'paged', 1 ) );

		$queried_products['totalPages'] = max( 1, $this->query->max_num_pages );

		return $queried_products;
	}

	private function get_wc_visibility_parse_query( $query_args ) {
		$settings = $this->get_settings();

		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		if ( 'featured' === $settings['query_filter_by'] ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'product_visibility',
				'field' => 'term_taxonomy_id',
				'terms' => $product_visibility_term_ids['featured'],
			];
		}

		return $query_args;
	}

	private function get_wc_legacy_visibility_parse_query( $query_args ) {
		$settings = $this->get_settings();

		$query_args['meta_query'] = [ // phpcs:ignore
			[
				'key' => '_visibility',
				'value' => [ 'catalog', 'visible' ],
				'compare' => 'IN',
			],
		];

		if ( 'featured' === $settings['query_filter_by'] ) {
			$query_args['meta_query'][] = [
				'key' => '_featured',
				'value' => 'yes',
			];
		}

		return $query_args;
	}

	protected function render() {}
}
