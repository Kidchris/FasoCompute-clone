<?php
/**
 * Gutenify Template Kit: Block Patterns
 *
 * @since Gutenify Template Kit 1.0
 */

 /**
  * Get patterns content.
  *
  * @param string $file_name Filename.
  * @return string
  */
function gutenify_template_kit_get_pattern_content( $file_name ) {
	ob_start();
	include get_theme_file_path( '/inc/patterns/' . $file_name . '.php' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Registers block patterns and categories.
 *
 * @since Gutenify Template Kit 1.0
 *
 * @return void
 */
function gutenify_template_kit_register_block_patterns() {

	$patterns = array(
		'footer-default' => array(
			'title'      => __( 'Default footer', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-footers' ),
			'blockTypes' => array( 'core/template-part/footer' ),
		),
		'header-default' => array(
			'title'      => __( 'Default header', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-headers' ),
			'blockTypes' => array( 'core/template-part/header' ),
		),
		'post-listing' => array(
			'title'    => __( 'Post Listing', 'gutenify-template-kit' ),
			'inserter' => false,
			'categories' => array( 'gutenify-template-kit-query' ),
		),
		'hidden-404' => array(
			'title'    => __( '404 content', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-pages' ),
		),
		'page-cover-title' => array(
			'title'    => __( 'Page Cover Title', 'gutenify-template-kit' ),
			'categories' => array( 'featured' ),
		),
		'featured-section-1' => array(
			'title'    => __( 'Featured Section 1', 'gutenify-template-kit' ),
			'categories' => array( 'featured' ),
		),
		'hero-section-1' => array(
			'title'    => __( 'Hero Section 1', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-hero' ),
		),
		'hero-section-2' => array(
			'title'    => __( 'Hero Section 2', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-hero' ),
		),
		'hero-section-3' => array(
			'title'    => __( 'Hero Section 3', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-hero' ),
		),
		'media-text-1' => array(
			'title'    => __( 'Media Text 1', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-media-text' ),
		),
		'cta-1' => array(
			'title'    => __( 'CTA 1', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-cta' ),
		),
		'features-section-1' => array(
			'title'    => __( 'Features Section 1', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-services' ),
		),
		'services-section-1' => array(
			'title'    => __( 'Services Section 1', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-services' ),
		),
		'title-section-1' => array(
			'title'    => __( 'Services Section 1', 'gutenify-template-kit' ),
			'categories' => array( 'gutenify-template-kit-titles' ),
		),
	);

	$block_pattern_categories = array(
		'featured'                 => array( 'label' => __( 'Featured', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-footers' => array( 'label' => __( 'Footers', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-headers' => array( 'label' => __( 'Headers', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-query'   => array( 'label' => __( 'Query', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-pages'   => array( 'label' => __( 'Pages', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-hero'   => array( 'label' => __( 'Hero Sections', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-media-text'   => array( 'label' => __( 'Media Text', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-cta'   => array( 'label' => __( 'CTA', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-services'   => array( 'label' => __( 'Services', 'gutenify-template-kit' ) ),
		'gutenify-template-kit-titles'   => array( 'label' => __( 'Titles', 'gutenify-template-kit' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since Gutenify Template Kit 1.0
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'gutenify_template_kit_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	/**
	 * Filters the theme block patterns.
	 *
	 * @since Gutenify Template Kit 1.0
	 *
	 * @param array $block_patterns List of block patterns by name.
	 */
	$patterns = apply_filters( 'gutenify_template_kit_block_patterns', $patterns );

	foreach ( $patterns as $block_pattern => $pattern ) {
		$pattern['content'] = gutenify_template_kit_get_pattern_content( $block_pattern );
		register_block_pattern(
			'gutenify-template-kit/' . $block_pattern,
			$pattern
		);
	}
}
add_action( 'init', 'gutenify_template_kit_register_block_patterns', 9 );
