<?php
/**
 * Erfan Sanat Enterprise WordPress Theme Bootstrap
 *
 * Keeps functions.php minimal: constants, theme setup, and modular includes.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ES_THEME_VERSION', '1.2.0' );
define( 'ES_THEME_SLUG', 'erfan-sanat-theme' );
define( 'ES_TEXT_DOMAIN', 'erfan-sanat' );
define( 'ES_OPTION_KEY', 'erfan_sanat_options' );
define( 'ES_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'ES_THEME_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Sets up theme defaults and registers support for WordPress features.
 */
function erfan_sanat_setup(): void {
	load_theme_textdomain( ES_TEXT_DOMAIN, ES_THEME_DIR . 'languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	add_image_size( 'es-card-thumb', 640, 480, true );
	add_image_size( 'es-project-wide', 960, 640, true );
	add_image_size( 'es-hero-banner', 1440, 820, true );

	register_nav_menus(
		array(
			'primary'   => __( 'فهرست اصلی هدر', 'erfan-sanat' ),
			'mobile'    => __( 'فهرست موبایل', 'erfan-sanat' ),
			'footer_1'  => __( 'فهرست فوتر - دسترسی سریع', 'erfan-sanat' ),
			'footer_2'  => __( 'فهرست فوتر - دسته‌بندی محصولات', 'erfan-sanat' ),
		)
	);
}
add_action( 'after_setup_theme', 'erfan_sanat_setup' );

$es_core_includes = array(
	'inc/options-schema.php',
	'inc/options.php',
	'inc/security.php',
	'inc/performance.php',
	'inc/enqueue.php',
	'inc/dynamic-css.php',
	'inc/template-helpers.php',
	'inc/post-types.php',
	'inc/taxonomies.php',
	'inc/woocommerce.php',
	'inc/seo.php',
	'inc/accessibility.php',
	'inc/admin/fields.php',
	'inc/admin/dashboard.php',
	'inc/admin/tools.php',
	'inc/admin/import-export.php',
);

foreach ( $es_core_includes as $es_include_file ) {
	$es_full_path = ES_THEME_DIR . $es_include_file;
	if ( file_exists( $es_full_path ) ) {
		require_once $es_full_path;
	}
}
