<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Jet_Listing_Item_Document extends Elementor\Core\Base\Document {

	public function get_name() {
		return jet_engine()->listings->get_id();
	}

	public static function get_title() {
		return __( 'Listing Item', 'jet-engine' );
	}

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['admin_tab_group'] = '';

		return $properties;
	}

	protected function _register_controls() {

		parent::_register_controls();

		$this->start_controls_section(
			'jet_listing_settings',
			array(
				'label' => __( 'Listing Settings', 'jet-engine' ),
				'tab' => Elementor\Controls_Manager::TAB_SETTINGS,
			)
		);

		$this->add_control(
			'reload_notice',
			array(
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw'  => __( '<b>Please note:</b> You need to reload page after applying new source, changing post type or taxonomy. New meta fields and options for dynamic fields will be applied only after reloading.', 'jet-engine' ),
			)
		);

		$this->add_control(
			'listing_source',
			array(
				'label'   => esc_html__( 'Listing source:', 'jet-engine' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'posts',
				'options' => array(
					'posts'    => esc_html__( 'Posts', 'jet-engine' ),
					'terms'    => esc_html__( 'Terms', 'jet-engine' ),
					'users'    => esc_html__( 'Users', 'jet-engine' ),
					'repeater' => esc_html__( 'Repeater Field', 'jet-engine' ),
				),
			)
		);

		$this->add_control(
			'listing_post_type',
			array(
				'label'   => esc_html__( 'From post type:', 'jet-engine' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'options' => jet_engine()->listings->get_post_types_for_options(),
				'condition' => array(
					'listing_source' => array( 'posts', 'repeater' ),
				),
			)
		);

		$this->add_control(
			'listing_tax',
			array(
				'label'   => esc_html__( 'From taxonomy:', 'jet-engine' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'right',
				'options' => jet_engine()->listings->get_taxonomies_for_options(),
				'condition' => array(
					'listing_source' => 'terms',
				),
			)
		);

		$this->add_control(
			'repeater_source',
			array(
				'label'   => esc_html__( 'Repeater source:', 'jet-engine' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => 'jet_engine',
				'options' => array(
					'jet_engine' => __( 'JetEngine', 'jet-engine' ),
					'acf'        => __( 'ACF', 'jet-engine' ),
				),
				'condition' => array(
					'listing_source' => 'repeater',
				),
			)
		);

		$this->add_control(
			'repeater_field',
			array(
				'label'       => esc_html__( 'Repeater field:', 'jet-engine' ),
				'type'        => Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'condition'   => array(
					'listing_source' => 'repeater',
				),
			)
		);

		$this->add_control(
			'preview_width',
			array(
				'label'      => esc_html__( 'Preview Width', 'jet-engine' ),
				'type'       => Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 300,
						'max' => 1200,
					),
				),
				'selectors'  => array(
					'.jet-listing-item.single-jet-engine .elementor' => 'width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
				),
			)
		);

		$this->add_control(
			'listing_link',
			array(
				'label'        => esc_html__( 'Make listing item clickable', 'jet-engine' ),
				'type'         => Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-engine' ),
				'label_off'    => esc_html__( 'No', 'jet-engine' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$meta_fields = $this->get_meta_fields_for_post_type();

		$this->add_control(
			'listing_link_source',
			array(
				'label'     => __( 'Link source', 'jet-engine' ),
				'type'      => Elementor\Controls_Manager::SELECT,
				'default'   => '_permalink',
				'groups'    => $meta_fields,
				'condition' => array(
					'listing_link' => 'yes',
				),
			)
		);

		if ( jet_engine()->options_pages ) {

			$options_pages_select = jet_engine()->options_pages->get_options_for_select( 'plain' );

			if ( ! empty( $options_pages_select ) ) {
				$this->add_control(
					'listing_link_option',
					array(
						'label'     => __( 'Option', 'jet-engine' ),
						'type'      => Elementor\Controls_Manager::SELECT,
						'default'   => '',
						'groups'    => $options_pages_select,
						'condition' => array(
							'listing_link'        => 'yes',
							'listing_link_source' => 'options_page',
						),
					)
				);
			}

		}

		$this->add_control(
			'listing_link_open_in_new',
			array(
				'label'        => esc_html__( 'Open in new window', 'jet-engine' ),
				'type'         => Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-engine' ),
				'label_off'    => esc_html__( 'No', 'jet-engine' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'listing_link' => 'yes',
					'listing_link_source!' => 'open_map_listing_popup',
				),
			)
		);

		$this->add_control(
			'listing_link_rel_attr',
			array(
				'label'   => __( 'Add "rel" attr', 'jet-engine' ),
				'type'    => Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''           => __( 'No', 'jet-engine' ),
					'alternate'  => __( 'Alternate', 'jet-engine' ),
					'author'     => __( 'Author', 'jet-engine' ),
					'bookmark'   => __( 'Bookmark', 'jet-engine' ),
					'external'   => __( 'External', 'jet-engine' ),
					'help'       => __( 'Help', 'jet-engine' ),
					'license'    => __( 'License', 'jet-engine' ),
					'next'       => __( 'Next', 'jet-engine' ),
					'nofollow'   => __( 'Nofollow', 'jet-engine' ),
					'noreferrer' => __( 'Noreferrer', 'jet-engine' ),
					'noopener'   => __( 'Noopener', 'jet-engine' ),
					'prev'       => __( 'Prev', 'jet-engine' ),
					'search'     => __( 'Search', 'jet-engine' ),
					'tag'        => __( 'Tag', 'jet-engine' ),
				),
				'condition' => array(
					'listing_link' => 'yes',
					'listing_link_source!' => 'open_map_listing_popup',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Get meta fields for post type
	 *
	 * @return array
	 */
	public function get_meta_fields_for_post_type() {

		$default = array(
			'label'   => __( 'General', 'jet-engine' ),
			'options' => array(
				'_permalink' => __( 'Permalink', 'jet-engine' ),
			),
		);

		$result      = array();
		$meta_fields = array();

		if ( jet_engine()->options_pages ) {
			$default['options']['options_page'] = __( 'Options', 'jet-engine' );
		}

		if ( jet_engine()->modules->is_module_active( 'maps-listings' ) ) {
			$default['options']['open_map_listing_popup'] = __( 'Open Map Listing Popup', 'jet-engine' );
		}

		if ( jet_engine()->meta_boxes ) {
			$meta_fields = jet_engine()->meta_boxes->get_fields_for_select( 'plain' );
		}

		return apply_filters(
			'jet-engine/listings/dynamic-link/fields',
			array_merge( array( $default ), $meta_fields )
		);

	}

	public function get_preview_as_query_args() {

		$preview_id      = (int) $this->get_settings( 'preview_id' );
		$source          = $this->get_settings( 'listing_source' );
		$post_type       = $this->get_settings( 'listing_post_type' );
		$tax             = $this->get_settings( 'listing_tax' );
		$repeater_source = $this->get_settings( 'repeater_source' );
		$repeater_field  = $this->get_settings( 'repeater_field' );
		$args            = false;

		jet_engine()->listings->data->set_listing( jet_engine()->listings->get_new_doc( array(
			'listing_source'    => $source,
			'listing_post_type' => $post_type,
			'listing_tax'       => $tax,
			'repeater_source'   => $repeater_source,
			'repeater_field'    => $repeater_field,
		) ) );

		switch ( $source ) {

			case 'posts':
			case 'repeater':

				$post = get_posts( array(
					'post_type'        => $post_type,
					'numberposts'      => 1,
					'orderby'          => 'date',
					'order'            => 'DESC',
					'suppress_filters' => false,
				) );

				if ( ! empty( $post ) ) {

					jet_engine()->listings->data->set_current_object( $post[0] );

					$args = array(
						'post_type' => $post_type,
						'p'         => $post[0]->ID,
					);

				}

				break;

			case 'terms':

				$terms = get_terms( array(
					'taxonomy'   => $tax,
					'hide_empty' => false,
				) );

				if ( ! empty( $terms ) ) {

					jet_engine()->listings->data->set_current_object( $terms[0] );

					$args = array(
						'tax_query' => array(
							array(
								'taxonomy' => $tax,
								'field'    => 'slug',
								'terms'    => $terms[0]->slug,
							),
						),
					);

				}

				break;

			case 'users':

				jet_engine()->listings->data->set_current_object( wp_get_current_user() );

				break;

			default:

				do_action( 'jet-engine/listings/document/get-preview/' . $source, $this );

				break;

		}

		return $args;
	}

	public function get_elements_raw_data( $data = null, $with_html_content = false ) {

		jet_engine()->elementor_views->switch_to_preview_query();

		$editor_data = parent::get_elements_raw_data( $data, $with_html_content );

		jet_engine()->elementor_views->restore_current_query();

		return $editor_data;
	}

	public function render_element( $data ) {

		jet_engine()->elementor_views->switch_to_preview_query();

		$render_html = parent::render_element( $data );

		jet_engine()->elementor_views->restore_current_query();

		return $render_html;
	}

	public function get_elements_data( $status = 'publish' ) {

		if ( ! isset( $_GET[ jet_engine()->post_type->slug() ] ) || ! isset( $_GET['preview'] ) ) {
			return parent::get_elements_data( $status );
		}

		jet_engine()->elementor_views->switch_to_preview_query();

		$elements = parent::get_elements_data( $status );

		jet_engine()->elementor_views->restore_current_query();

		return $elements;
	}

}
