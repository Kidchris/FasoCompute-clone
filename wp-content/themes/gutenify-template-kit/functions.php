<?php
/**
 * Gutenify Template Kit functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Gutenify_Template_Kit
 */

if ( ! defined( 'GUTENIFY_TEMPLATE_KIT_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'GUTENIFY_TEMPLATE_KIT_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'gutenify_template_kit_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gutenify_template_kit_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Gutenify Template Kit, use a find and replace
		 * to change 'gutenify-template-kit' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gutenify-template-kit', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'align-wide' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		// add_editor_style( 'style.css' );

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 192,
				'width'       => 192,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Experimental support for adding blocks inside nav menus
		add_theme_support( 'block-nav-menus' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Register nav menus.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'gutenify-template-kit' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'gutenify_template_kit_setup' );

/**
 * Theme default options.
 *
 * @return array
 */
function gutenify_template_kit_default_options() {
	return array(
		'site_primary_color'     => '#2196f3',
		'global_primary_font'    => 'lato-helvetica',
	);
}

/**
 * Add Google webfonts
 *
 * @return $fonts_url
 */

function gutenify_template_kit_fonts_url() {
	$font_families = ['family=Gilda+Display', 'family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900', 'family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900', 'family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900', 'family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900', 'family=Inter:wght@100;400;700', 'family=Jost'];
	if ( class_exists( 'WP_Theme_JSON_Resolver_Gutenberg' ) ) {
		$theme_data = WP_Theme_JSON_Resolver_Gutenberg::get_merged_data()->get_settings();
		if ( empty( $theme_data ) || empty( $theme_data['typography'] ) || empty( $theme_data['typography']['fontFamilies'] ) ) {
			return '';
		}

		if ( ! empty( $theme_data['typography']['fontFamilies']['custom'] ) ) {
			foreach( $theme_data['typography']['fontFamilies']['custom'] as $font ) {
				if ( ! empty( $font['google'] ) ) {
					$font_families[] = $font['google'];
				}
			}

		// NOTE: This should be removed once Gutenberg 12.1 lands stably in all environments
		} else if ( ! empty( $theme_data['typography']['fontFamilies']['user'] ) ) {
			foreach( $theme_data['typography']['fontFamilies']['user'] as $font ) {
				if ( ! empty( $font['google'] ) ) {
					$font_families[] = $font['google'];
				}
			}
		// End Gutenberg < 12.1 compatibility patch

		} else {
			if ( ! empty( $theme_data['typography']['fontFamilies']['theme'] ) ) {
				foreach( $theme_data['typography']['fontFamilies']['theme'] as $font ) {
					if ( ! empty( $font['google'] ) ) {
						$font_families[] = $font['google'];
					}
				}
			}
		}
	}

	if ( empty( $font_families ) ) {
		return '';
	}

	// Make a single request for the theme or user fonts.
	return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $font_families ) ) . '&display=swap' );
}

/**
 * Google font info
 *
 * @param mixed $font_name Font name.
 * @return array
 */
function gutenify_template_kit_google_font_info( $font_name = false ) {
	$font_info = array(
		'lato-helvetica' => array(
			'url'    => 'https://fonts.googleapis.com/css?family=Lato:400,700,300',
			'family' => '"lato", Helvetica, sans-serif',
		),
		'gilda-display' => array(
			'url'    => 'https://fonts.googleapis.com/css2?family=Gilda+Display&display=swap',
			'family' => 'Gilda Display',
		),
		'nunito-sans' => array(
			'url'    => 'https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap',
			'family' => 'Nunito Sans',
		),
		'roboto' => array(
			'url'    => 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap',
			'family' => 'Roboto',
		),
		'poppins' => array(
			'url'    => 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
			'family' => 'Poppins',
		),
	);
	if ( ! $font_name ) {
		return $font_info;
	}

	return ! empty( $font_info[ $font_name ] ) ? $font_info[ $font_name ] : false;
}

/**
 * Enqueue scripts and styles.
 */
function gutenify_template_kit_scripts() {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Register theme stylesheet.
	$theme_version = wp_get_theme()->get( 'Version' );



	// FontAwesome.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/all' . $min . '.css', array(), '5.15.3', 'all' );
	wp_enqueue_style( 'gutenify-animate', get_template_directory_uri() . '/css/animate.css', array(), filemtime( get_theme_file_path( '/css/animate.css' ) ), 'all' );
	wp_enqueue_style( 'gutenify-template-kit-fonts', gutenify_template_kit_fonts_url(), array(), null );

	$deps = array( 'font-awesome', 'gutenify-animate' );
	global $wp_styles;
	if ( in_array( 'wc-blocks-vendors-style', $wp_styles->queue ) ) {
		$deps[] = 'wc-blocks-vendors-style';
	}

	wp_enqueue_style( 'gutenify-template-kit-style', get_stylesheet_uri(), $deps, date( 'Ymd-Gis', filemtime( get_theme_file_path( 'style.css' ) ) ) );
	wp_style_add_data( 'gutenify-template-kit-style', 'rtl', 'replace' );

	$deps = array( 'jquery' );
	wp_enqueue_script( 'gutenify-template-kit-animate', get_template_directory_uri() . '/js/animate' . $min . '.js', $deps, date( 'Ymd-Gis', filemtime( get_theme_file_path( 'style.css' ) ) ) );

}
add_action( 'wp_enqueue_scripts', 'gutenify_template_kit_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function gutenify_template_kit_admin_scripts() {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Register theme stylesheet.
	$theme_version = wp_get_theme()->get( 'Version' );

	$deps = array();

	// FontAwesome.
	wp_enqueue_style( 'gutenify-template-kit-admin-style', get_stylesheet_directory_uri() . '/css/admin-style.css', $deps, date( 'Ymd-Gis', filemtime( get_theme_file_path( 'style.css' ) ) ) );

}
add_action( 'admin_enqueue_scripts', 'gutenify_template_kit_admin_scripts' );

/**
 *
 * Enqueue scripts and styles.
 */
function gutenify_template_kit_editor_styles() {
	// Enqueue editor styles.
	add_editor_style(
		array(
			gutenify_template_kit_fonts_url(),
		)
	);
}
add_action( 'admin_init', 'gutenify_template_kit_editor_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Load TGM file.
 */
require_once get_template_directory() . '/inc/tgm/plugin-activation.php';

/**
 * Load core file.
 */
require_once get_template_directory() . '/inc/core/bootstrap.php';
