<?php
/**
 * Core setup, site hooks and filters.
 *
 * @package cerium
 */

namespace Chance_Digital\Cerium\Core;

/**
 * Set up theme defaults and register supported WordPress features.
 */
function setup() {
	$n = function( $function ) {
		$function = __NAMESPACE__ . "\\$function";
		if ( function_exists( $function ) ) {
			return $function;
		}
	};

	add_action( 'after_setup_theme',         $n( 'i18n' ) );
	add_action( 'after_setup_theme',         $n( 'theme_setup' ) );
	add_action( 'wp_enqueue_scripts',        $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts',        $n( 'styles' ) );
	add_action( 'wp_head',                   $n( 'js_detection' ), 0 );
	add_action( 'widgets_init',              $n( 'widgets' ) );

	add_filter( 'script_loader_tag', $n( 'script_loader_tag' ), 10, 2 );
	//add_filter( 'acf/fields/google_map/api', $n( 'acf_map_api' ) );
}

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @return void
 */
function js_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

/**
 * Add async/defer attributes to enqueued scripts that have the specified script_execution flag.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return string
 */
function script_loader_tag( $tag, $handle ) {
	$script_execution = wp_scripts()->get_data( $handle, 'script_execution' );
	if ( ! $script_execution ) {
		return $tag;
	}
	if ( 'async' !== $script_execution && 'defer' !== $script_execution ) {
		return $tag;
	}
	// Abort adding async/defer for scripts that have this script as a dependency. _doing_it_wrong()?
	foreach ( wp_scripts()->registered as $script ) {
		if ( in_array( $handle, $script->deps, true ) ) {
			return $tag;
		}
	}
	// Add the attribute if it hasn't already been added.
	if ( ! preg_match( ":\s$script_execution(=|>|\s):", $tag ) ) {
		$tag = preg_replace( ':(?=></script>):', " $script_execution", $tag, 1 );
	}
	return $tag;
}

/**
 * Makes Theme available for translation.
 *
 * Translations can be added to the /languages directory.
 * If you're building a theme based on "cerium", change the
 * filename of '/languages/cerium.pot' to the name of your project.
 *
 * @return void
 */
function i18n() {
	load_theme_textdomain( 'cerium', CERIUM_PATH . '/languages' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return void
 */
function theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]
	);
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Additional theme support for woocommerce 3.0.+
	// Uncomment as needed.
	//add_theme_support( 'wc-product-gallery-zoom' );
	//add_theme_support( 'wc-product-gallery-lightbox' );
	//add_theme_support( 'wc-product-gallery-slider' );

	// Add featured image sizes.
	// Sizes are optimized and cropped for landscape aspect ratio and
	// optimized for HiDPI displays on 'small' and 'medium' screen sizes.
	add_image_size( 'featured-small', 640, 9999 );
	add_image_size( 'featured-medium', 1280, 9999 );
	add_image_size( 'featured-large', 1440, 9999 );
	add_image_size( 'featured-xlarge', 1920, 9999 );

	// Load editor stylesheet.
	add_editor_style( CERIUM_TEMPLATE_URL . '/dist/css/editor.min.css' );

	// Register nav menus.
	register_nav_menus(
		[
			'main-navigation'      => __( 'Main Navigation', 'cerium' ),
			'secondary-navigation' => __( 'Secondary Navigation', 'cerium' ),
			'footer-navigation'    => __( 'Footer Navigation', 'cerium' ),
			'social'               => __( 'Social Navigation', 'cerium' ),
		]
	);
}

/**
 * Enqueue scripts for front-end.
 *
 * Inspired by https://github.com/10up/theme-scaffold/blob/master/includes/core.php
 *
 * @return void
 */
function scripts() {

	// Deregister the jquery version bundled with WordPress.
	wp_deregister_script( 'jquery' );

	// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', [], '3.2.1', false );

	// Deregister the jquery-migrate version bundled with WordPress.
	wp_deregister_script( 'jquery-migrate' );

	// CDN hosted jQuery migrate for compatibility with jQuery 3.x.
	wp_register_script( 'jquery-migrate', '//code.jquery.com/jquery-migrate-3.0.1.min.js', [ 'jquery' ], '3.0.1', false );
	wp_enqueue_script( 'jquery-migrate' );

	// Frontend JS.
	wp_register_script( 'frontend', CERIUM_TEMPLATE_URL . '/dist/js/frontend.min.js', [], CERIUM_VERSION, true );
	wp_localize_script(
		'frontend', 'csAjax', [
			'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
		]
	);
	wp_enqueue_script( 'frontend' );

	// Add the comment-reply library on pages where it is necessary.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {

	wp_enqueue_style( 'frontend', CERIUM_TEMPLATE_URL . '/dist/css/frontend.min.css', [], CERIUM_VERSION );
}

/**
 * Register widget areas.
 *
 * @return void
 */
function widgets() {

	register_sidebar(
		[
			'name'          => 'Main sidebar',
			'id'            => 'main-sidebar',
			'before_widget' => '<div class="sidebar__wrapper">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="sidebar__heading">',
			'after_title'   => '</h3>',
		]
	);
}

/**
 * Return API key for use in ACF filter.
 *
 * @param  string $api Google Maps API key.
 * @return array       API array with key added.
 */
function acf_map_api( $api ) {
	$api['key'] = 'API_KEY_GOES_HERE';

	return $api;
}

// Add ACF options page if ACF is enabled.
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		[
			'page_title' => __( 'Theme Settings', 'cerium' ),
			'menu_title' => __( 'Theme Settings', 'cerium' ),
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		]
	);
}
