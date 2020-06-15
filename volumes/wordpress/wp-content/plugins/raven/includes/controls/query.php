<?php
/**
 * Adds query control. This control will fetch different type of data e.g post, author, term, taxonomy based on query param.
 *
 * @package Raven
 * @since 1.9.4
 */

namespace Raven\Controls;

use Elementor\Control_Select2;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Query extends Control_Select2 {

	public function get_type() {
		return 'raven_query';
	}

	/**
	 *  Control default settings.
	 *
	 * @since 1.9.4
	 *
	 * @return array
	 */
	protected function get_default_settings() {
		return array_merge( parent::get_default_settings(), [
			'query' => [
				'source' => 'post', // post, author, term, taxonomy.
				'post_type' => 'post',
				'post_type_control' => 'query_post_type', // Mention control whose value is a post_type.
				'numberposts' => 30,
				'no_found_rows' => true,
				'orderby' => 'title',
			],
		] );
	}

	/**
	 * Get query results.
	 *
	 * @since 1.9.4
	 * @access public
	 *
	 * @param array $data Ajax params.
	 *
	 * @return array
	 */
	public static function get_query_results( $data ) {
		switch ( $data['source'] ) {
			case 'post':
				$results = self::get_posts( $data );
				break;
			case 'term':
				$results = self::get_terms( $data );
				break;
			case 'author':
				$results = self::get_authors( $data );
				break;
		}

		return [
			'results' => $results,
		];
	}

	/**
	 * Get posts.
	 *
	 * @since 1.9.4
	 * @access public
	 * @static
	 *
	 * @param array $data Query.
	 *
	 * @return array
	 */
	private static function get_posts( $args ) {
		if ( ! empty( $args['editor_post_id'] ) ) {
			$exclude         = empty( $args['exclude'] ) ? [] : $args['exclude'];
			$exclude[]       = $args['editor_post_id'];
			$args['exclude'] = $exclude;
		}

		$args = wp_parse_args( $args, [
			'post_type' => '',
			'include' => [],
			'exclude' => [],
			'numberposts' => 10,
		] );

		$posts = get_posts( $args );

		$posts = array_reduce( $posts, function ( $value, $post ) {
			$value[] = [
				'id' => $post->ID,
				'text' => $post->post_title,
			];

			return $value;
		}, [] );

		return $posts;
	}

	/**
	 * Get authors.
	 *
	 * @since 1.9.5
	 * @access private
	 *
	 * @param array $args Arguments.
	 * @return array
	 */
	private static function get_authors( $args ) {
		$args = wp_parse_args( $args, [
			'include' => [],
			'exclude' => [],
			'number' => 10,
		] );

		$query_params = [
			'who' => 'authors',
			'has_published_posts' => true,
			'fields' => [
				'ID',
				'display_name',
			],
			'number'  => $args['number'],
			'include' => $args['include'],
			'exclude' => $args['exclude'],
		];

		$user_query = new \WP_User_Query( $query_params );

		$results = [];

		foreach ( $user_query->get_results() as $author ) {
			$results[] = [
				'id' => $author->ID,
				'text' => $author->display_name,
			];
		}

		return $results;
	}

	/**
	 * Get terms.
	 *
	 * @since 1.9.5
	 * @access private
	 *
	 * @param array $args Arguments.
	 * @return array
	 */
	private static function get_terms( $args ) {
		$args = wp_parse_args( $args, [
			'taxonomy' => '',
			'include' => [],
			'exclude' => [],
			'number' => 10,
		] );

		$terms = get_terms(
			[
				'taxonomy' => $args['taxonomy'],
				'hide_empty' => false,
				'include' => $args['include'],
				'exclude' => $args['exclude'],
				'number' => $args['number'],
			]
		);

		if ( is_wp_error( $terms ) ) {
			return [];
		}

		$results = [];

		foreach ( $terms as $term ) {
			$results[] = [
				'id' => $term->term_id,
				'text' => self::get_term_name_with_parents( $term ),
			];
		}

		return $results;
	}

	/**
	 * Get term name with parents.
	 *
	 * @since 1.9.5
	 *
	 * @param \WP_Term $term
	 * @param int $max
	 *
	 * @return string
	 */
	private static function get_term_name_with_parents( \WP_Term $term, $max = 3 ) {
		if ( 0 === $term->parent ) {
			return $term->name;
		}

		$separator = is_rtl() ? ' < ' : ' > ';
		$test_term = $term;

		$names = [];

		while ( $test_term->parent > 0 ) {
			$test_term = get_term( $test_term->parent );

			if ( ! $test_term ) {
				break;
			}

			$names[] = $test_term->name;
		}

		$names = array_reverse( $names );

		if ( count( $names ) < ( $max ) ) {
			return implode( $separator, $names ) . $separator . $term->name;
		}

		$name_string = '';

		for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
			$name_string .= $names[ $i ] . $separator;
		}

		return $name_string . '...' . $separator . $term->name;
	}
}
