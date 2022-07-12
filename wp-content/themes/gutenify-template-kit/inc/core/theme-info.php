<?php
/**
 * Add theme page
 */
function gutenify_template_kit_menu() {
	add_theme_page( esc_html__( 'Gutenify Template Kit', 'gutenify-template-kit' ), esc_html__( 'Gutenify Theme', 'gutenify-template-kit' ), 'edit_theme_options', 'gutenify-template-kit-info', 'gutenify_template_kit_theme_page_display' );
}
add_action( 'admin_menu', 'gutenify_template_kit_menu' );

/**
 * Display About page
 */
function gutenify_template_kit_theme_page_display() {
	$theme = wp_get_theme();

	if ( is_child_theme() ) {
		$theme = wp_get_theme()->parent();
	}

	include_once 'templates/theme-info.php';
}
