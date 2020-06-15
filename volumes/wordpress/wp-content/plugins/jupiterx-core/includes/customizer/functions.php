<?php
/**
 * The Jupiter Customizer component.
 *
 * @package JupiterX_Core\Customizer
 */

/**
 * Load Kirki library.
 *
 * @since 1.0.0
 */
function jupiterx_customizer_kirki() {
	jupiterx_core()->load_files( [ 'customizer/vendors/kirki/kirki' ] );
}

add_action( 'jupiterx_init', 'jupiterx_load_customizer_dependencies', 5 );
/**
 * Load Customzier.
 *
 * @since 1.9.0
 *
 * @return void
 */
function jupiterx_load_customizer_dependencies() {
	jupiterx_core()->load_files( [ 'customizer/api/customizer' ] );
	jupiterx_core()->load_files( [ 'customizer/api/init' ] );
}

if ( ! function_exists( 'jupiterx_core_customizer_include' ) ) {
	add_action( 'init', 'jupiterx_core_customizer_include', 15 );
	/**
	 * Include customizer setting file.
	 *
	 * With loading customizer on init, we have access to custom post types and custom taxonomies.
	 *
	 * @since 1.9.0
	 *
	 * @return void
	 */
	function jupiterx_core_customizer_include() {
		/**
		 * Hook after registering theme customizer settings.
		 *
		 * @since 1.3.0
		 */
		do_action( 'jupiterx_before_customizer_register' );

		/**
		 * Load customizer settings.
		 */
		require_once jupiterx_core()->plugin_dir() . 'includes/customizer/settings/settings.php';

		/**
		 * Hook after registering theme customizer settings.
		 *
		 * @since 1.3.0
		 */
		do_action( 'jupiterx_after_customizer_register' );
	}
}

if ( version_compare( JUPITERX_VERSION, '1.17.1', '>' ) ) {
	add_action(
		'wp_ajax_jupiterx_core_customizer_preview_redirect_url',
		'jupiterx_core_customizer_preview_redirect_url'
	);
}

if ( ! function_exists( 'jupiterx_core_customizer_preview_redirect_url' ) ) {
	/**
	 * Get Customizer redirect URL.
	 *
	 * @since 1.16.0
	 *
	 * @return void
	 */
	function jupiterx_core_customizer_preview_redirect_url() {
		check_ajax_referer( 'jupiterx_core_get_customizer_preview_redirect_url' );

		$section = wp_unslash( filter_input( INPUT_POST, 'section' ) );
		$options = wp_unslash( json_decode( filter_input( INPUT_POST, 'options' ), true ) );

		if ( empty( $section ) ) {
			wp_send_json_error();
		}

		if ( ! is_array( $options ) ) {
			$options = [];
		}

		$url = jupiterx_core_get_customizer_preview_redirect_url( $section, $options );

		if ( empty( $url ) ) {
			wp_send_json_error();
		}

		wp_send_json_success( [ 'redirectUrl' => $url ] );
	}
}

/**
 * Ignore phpmd erros.
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.ExitExpression)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
if ( ! function_exists( 'jupiterx_core_customizer_preview_redirect' ) ) {
	if ( version_compare( JUPITERX_VERSION, '1.17.1', '<=' ) ) {
		add_action( 'template_redirect', 'jupiterx_core_customizer_preview_redirect' );
	}
	/**
	 * Redircet to desired template while selecting a pop-up.
	 *
	 * @since 1.9.0
	 *
	 * @param string $section Customizer Section.
	 *
	 * @return void
	 *
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 */
	function jupiterx_core_customizer_preview_redirect( $section = '' ) {
		$section = jupiterx_get( 'jupiterx' );

		switch ( $section ) {
			case 'jupiterx_post_single':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'blog_single' );
				if ( ! is_singular( 'post' ) && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			case 'jupiterx_portfolio_single':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'portfolio_single' );
				if ( ! is_singular( 'portfolio' ) && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			case 'jupiterx_search':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'search' );
				if ( ! is_search() && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			case 'jupiterx_404':
				$template = get_theme_mod( 'jupiterx_404_template' );
				if ( ! empty( $template ) ) {
					wp_safe_redirect( get_permalink( intval( $template ) ) );
					exit;
				}

				global $wp_query;

				$wp_query->set_404();
				status_header( 404 );

				break;

			case 'jupiterx_maintenance':
				$template = get_theme_mod( 'jupiterx_maintenance_template' );
				if ( ! empty( $template ) ) {
					wp_safe_redirect( get_permalink( intval( $template ) ) );
					exit;
				}
				break;

			case 'jupiterx_blog_archive':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'blog_archive' );
				if ( ! is_post_type_archive( 'post' ) && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			case 'jupiterx_portfolio_archive':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'portfolio_archive' );
				if ( $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			case 'jupiterx_checkout_cart':
				if ( class_exists( 'WooCommerce' ) ) {
					$url = get_permalink( wc_get_page_id( 'cart' ) );
					if ( ! is_cart() && ! is_checkout() && $url ) {
						wp_safe_redirect( $url );
						exit;
					}
				}
				break;

			case 'jupiterx_product_archive':
				if ( class_exists( 'WooCommerce' ) ) {
					$url = JupiterX_Customizer_Utils::get_preview_url( 'product_archive' );
					if ( ! is_product_category() && $url ) {
						wp_safe_redirect( $url );
						exit;
					}
				}
				break;

			case 'jupiterx_product_page':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'product_single' );
				if ( ! is_singular( 'product' ) && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			case 'jupiterx_product_list':
				if ( class_exists( 'WooCommerce' ) ) {
					$url = get_permalink( wc_get_page_id( 'shop' ) );
					if ( ! is_shop() && $url ) {
						wp_safe_redirect( $url );
						exit;
					}
				}
				break;

			case 'jupiterx_page_single':
				$url = JupiterX_Customizer_Utils::get_preview_url( 'single_page' );
				if ( ! is_singular( 'page' ) && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;

			default:
				$post_type = jupiterx_get( 'post_type' );

				if ( $post_type && jupiterx_get( 'single' ) ) {
					$url = JupiterX_Customizer_Utils::get_permalink( JupiterX_Customizer_Utils::get_random_post( $post_type ) );
				} elseif ( $post_type && jupiterx_get( 'archive' ) ) {
					$url = get_post_type_archive_link( $post_type );
				}

				if ( isset( $url ) && $url ) {
					wp_safe_redirect( $url );
					exit;
				}
				break;
		}
	}
}

if ( ! function_exists( 'jupiterx_core_maintenance_page_redirect' ) ) {
	add_action( 'template_redirect', 'jupiterx_core_maintenance_page_redirect' );
	/**
	 * Redirect maintenance pages to specific page template.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 *
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	function jupiterx_core_maintenance_page_redirect() {
		// Current viewing page ID.
		$post_id = get_queried_object_id();

		// Is maintenance enabled?
		$is_enabled = get_theme_mod( 'jupiterx_maintenance', false );

		// The page where redirect ended up.
		$page_template = intval( get_theme_mod( 'jupiterx_maintenance_template' ) );

		// Disable when logged in or viewing the current template.
		if ( is_user_logged_in() || $page_template === $post_id ) {
			return;
		}

		// Maintenance is enabled, page template is not empty and the page status is published.
		if ( $is_enabled && ! empty( $page_template ) && 'publish' === get_post_status( $page_template ) ) {
			wp_safe_redirect( get_permalink( $page_template ) );
			exit;
		}
	}
}

if ( ! function_exists( 'jupiterx_core_404_page_redirect' ) ) {
	add_action( 'template_redirect', 'jupiterx_core_404_page_redirect' );
	/**
	 * Redirect 404 pages to specific page template.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 *
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	function jupiterx_core_404_page_redirect() {
		// The page where redirect ended up.
		$page_template = intval( get_theme_mod( 'jupiterx_404_template' ) );

		// Legitimate non existing page, page template is not empty and the page status must be published.
		if ( is_404() && ! empty( $page_template ) && 'publish' === get_post_status( $page_template ) ) {
			wp_safe_redirect( get_permalink( $page_template ), 301 );
		} elseif ( ! empty( $page_template ) && get_the_ID() === $page_template ) {
			status_header( 404 );
		}
	}
}

/**
 * Ignore phpmd erros.
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.ExitExpression)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
if ( ! function_exists( 'jupiterx_core_get_customizer_preview_redirect_url' ) ) {
	/**
	 * Calculate redirect URL for customizer preview.
	 *
	 * @since 1.16.0
	 *
	 * @param string $section Section open in customizer preview.
	 * @param array  $options Options changed in customizer preview.
	 *
	 * @return string
	 */
	function jupiterx_core_get_customizer_preview_redirect_url( $section = '', $options = [] ) {
		switch ( $section ) {
			case 'jupiterx_post_single':
				return JupiterX_Customizer_Utils::get_preview_url( 'blog_single' );

			case 'jupiterx_portfolio_single':
				return JupiterX_Customizer_Utils::get_preview_url( 'portfolio_single' );

			case 'jupiterx_search':
				return JupiterX_Customizer_Utils::get_preview_url( 'search' );

			case 'jupiterx_404':
				$template = get_theme_mod( 'jupiterx_404_template' );
				if ( ! empty( $template ) ) {
					return get_permalink( intval( $template ) );
				}

				break;

			case 'jupiterx_maintenance':
				$template = get_theme_mod( 'jupiterx_maintenance_template' );
				if ( ! empty( $template ) ) {
					return get_permalink( intval( $template ) );
				}
				break;

			case 'jupiterx_blog_archive':
				return JupiterX_Customizer_Utils::get_preview_url( 'blog_archive' );

			case 'jupiterx_portfolio_archive':
				return JupiterX_Customizer_Utils::get_preview_url( 'portfolio_archive' );

			case 'jupiterx_checkout_cart':
				if ( class_exists( 'WooCommerce' ) ) {
					return get_permalink( wc_get_page_id( 'cart' ) );
				}
				break;

			case 'jupiterx_product_archive':
				if ( class_exists( 'WooCommerce' ) ) {
					return JupiterX_Customizer_Utils::get_preview_url( 'product_archive' );
				}
				break;

			case 'jupiterx_product_page':
				return JupiterX_Customizer_Utils::get_preview_url( 'product_single' );

			case 'jupiterx_product_list':
				if ( class_exists( 'WooCommerce' ) ) {
					return get_permalink( wc_get_page_id( 'shop' ) );
				}
				break;

			case 'jupiterx_page_single':
				return JupiterX_Customizer_Utils::get_preview_url( 'single_page' );

			case 'jupiterx_title_bar_settings':
				return jupiterx_core_customizer_exceptions_control_redirect_url(
					'jupiterx_title_bar_exceptions',
					$options
				);

			case 'jupiterx_sidebar_settings':
				return jupiterx_core_customizer_exceptions_control_redirect_url(
					'jupiterx_sidebar_exceptions',
					$options
				);

			default:
				$post_type = ! empty( $options['post_type'] ) ? $options['post_type'] : '';

				if ( $post_type && ! empty( $options['single'] ) ) {
					$url = JupiterX_Customizer_Utils::get_permalink( JupiterX_Customizer_Utils::get_random_post( $post_type ) );
				} elseif ( $post_type && ! empty( $options['archive'] ) ) {
					$url = get_post_type_archive_link( $post_type );
				}

				return $url;
		}
	}
}

/**
 * Ignore phpmd erros.
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.ExitExpression)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
if ( ! function_exists( 'jupiterx_core_customizer_exceptions_control_redirect_url' ) ) {
	/**
	 * Redirect Jupiter X Custom Exception Control changes to relevant page.
	 *
	 * @since 1.16.0
	 *
	 * @param string $exception Exception section.
	 * @param array  $options   Options changed within Exception control.
	 *
	 * @return mixed
	 */
	function jupiterx_core_customizer_exceptions_control_redirect_url( $exception, $options ) {
		$exception_changed = '';
		$exceptions        = [];

		if ( ! empty( $options[ $exception ] ) && is_array( $options[ $exception ] ) ) {
			$exceptions = $options[ $exception ];
		}

		if ( empty( $options ) || ! is_array( $options ) ) {
			return null;
		}

		$option_keys  = array_keys( $options );
		$option_id    = array_shift( $option_keys );
		$option_value = $options[ $option_id ];

		foreach ( $exceptions as $e_key => $e_value ) {
			if ( 0 === strpos( $option_id, $exception . '_' . $e_key ) ) {
				$exception_changed = $e_key;
				break;
			}
		}

		if ( $exception === $option_id ) {
			$exception_changed = $option_value;
			$exception_changed = empty( $exception_changed ) ? '' : json_decode( $exception_changed, true );

			if ( is_array( $exception_changed ) ) {
				$exception_changed = array_pop( $exception_changed );
			}
		}

		if ( empty( $exception_changed ) ) {
			jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_post_single' );

			return null;
		}

		$custom_post_types = array_keys( jupiterx_get_post_types( 'label' ) );

		if ( in_array( $exception_changed, $custom_post_types, true ) ) {
			$url = JupiterX_Customizer_Utils::get_permalink(
				JupiterX_Customizer_Utils::get_random_post( $exception_changed )
			);

			if ( ! is_singular( $exception_changed ) && $url ) {
				return $url;
			}
		}

		$custom_post_types_archives = array_keys( jupiterx_get_post_types_archives() );

		if ( in_array( $exception_changed, $custom_post_types_archives, true ) ) {
			$url = get_post_type_archive_link( str_replace( 'archive__', '', $exception_changed ) );

			if ( ! is_post_type_archive( $exception_changed ) && $url ) {
				return $url;
			}
		}

		switch ( $exception_changed ) {
			case 'page':
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_page_single' );
			case 'post':
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_post_single' );
			case 'search':
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_search' );
			case 'product':
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_product_list' );
			case 'archive':
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_blog_archive' );
			case 'portfolio':
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_portfolio_single' );
			default:
				return jupiterx_core_get_customizer_preview_redirect_url( 'jupiterx_404' );
		}
	}
}
