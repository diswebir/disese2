<?php
/**
 * Asset Enqueue Management
 *
 * Strictly loads local assets only. Applies local Persian Vazirmatn font
 * across both Frontend and the entire WordPress Admin Panel.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues frontend styles and Vanilla JS scripts.
 */
function erfan_sanat_enqueue_frontend_assets(): void {
	if ( is_admin() ) {
		return;
	}

	$css_ver = file_exists( ES_THEME_DIR . 'assets/css/theme.css' )
		? ES_THEME_VERSION . '.' . (string) filemtime( ES_THEME_DIR . 'assets/css/theme.css' )
		: ES_THEME_VERSION;

	wp_enqueue_style(
		'erfan-sanat-theme',
		ES_THEME_URI . 'assets/css/theme.css',
		array(),
		$css_ver
	);

	wp_add_inline_style( 'erfan-sanat-theme', erfan_sanat_get_dynamic_css() );

	$script_args = array(
		'in_footer' => true,
	);
	if ( es_opt( 'perf_defer_theme_js', true ) ) {
		$script_args['strategy'] = 'defer';
	}

	$js_ver = file_exists( ES_THEME_DIR . 'assets/js/theme.js' )
		? ES_THEME_VERSION . '.' . (string) filemtime( ES_THEME_DIR . 'assets/js/theme.js' )
		: ES_THEME_VERSION;

	wp_enqueue_script(
		'erfan-sanat-theme',
		ES_THEME_URI . 'assets/js/theme.js',
		array(),
		$js_ver,
		$script_args
	);

	wp_localize_script(
		'erfan-sanat-theme',
		'erfanSanatConfig',
		array(
			'ajaxUrl'       => esc_url( admin_url( 'admin-ajax.php' ) ),
			'homeUrl'       => esc_url( home_url( '/' ) ),
			'nonce'         => wp_create_nonce( 'erfan_sanat_frontend_nonce' ),
			'isRtl'         => is_rtl(),
			'persianDigits' => (bool) es_opt( 'enable_persian_digits', true ),
			'i18n'          => array(
				'copied'      => __( 'کد در حافظه کپی شد', 'erfan-sanat' ),
				'sending'     => __( 'در حال ارسال درخواست...', 'erfan-sanat' ),
				'sentSuccess' => __( 'درخواست شما با موفقیت ثبت شد. کارشناسان فروش به‌زودی با شما تماس می‌گیرند.', 'erfan-sanat' ),
				'sentError'   => __( 'خطایی در ثبت درخواست رخ داد. لطفاً مجدداً تلاش کنید.', 'erfan-sanat' ),
				'close'       => __( 'بستن', 'erfan-sanat' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'erfan_sanat_enqueue_frontend_assets' );

/**
 * Preloads local Vazirmatn WOFF2 primary font files on frontend and admin.
 */
function erfan_sanat_preload_local_fonts(): void {
	$regular_font = esc_url( ES_THEME_URI . 'assets/fonts/Vazirmatn-Regular.woff2' );
	$bold_font    = esc_url( ES_THEME_URI . 'assets/fonts/Vazirmatn-Bold.woff2' );
	echo '<link rel="preload" href="' . $regular_font . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
	echo '<link rel="preload" href="' . $bold_font . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
}
add_action( 'wp_head', 'erfan_sanat_preload_local_fonts', 2 );
add_action( 'admin_head', 'erfan_sanat_preload_local_fonts', 2 );

/**
 * Enqueues admin styles across the entire WordPress Admin Panel (so Persian Vazirmatn
 * typography applies everywhere in wp-admin) and loads admin JS/media on theme & CPT screens.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function erfan_sanat_enqueue_admin_assets( $hook_suffix = '' ): void {
	$hook_suffix = (string) $hook_suffix;
	$admin_css_ver = file_exists( ES_THEME_DIR . 'assets/css/admin.css' )
		? ES_THEME_VERSION . '.' . (string) filemtime( ES_THEME_DIR . 'assets/css/admin.css' )
		: ES_THEME_VERSION;

	// Always load admin.css across wp-admin so Persian Vazirmatn typography and RTL polish apply everywhere.
	wp_enqueue_style(
		'erfan-sanat-admin',
		ES_THEME_URI . 'assets/css/admin.css',
		array(),
		$admin_css_ver
	);

	$screen       = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	$is_theme_opt = str_contains( $hook_suffix, 'erfan-sanat' );
	$is_cpt_edit  = $screen && in_array( $screen->post_type, array( 'product', 'project', 'post', 'page' ), true );

	if ( ! $is_theme_opt && ! $is_cpt_edit ) {
		return;
	}

	wp_enqueue_media();

	$admin_js_ver = file_exists( ES_THEME_DIR . 'assets/js/admin.js' )
		? ES_THEME_VERSION . '.' . (string) filemtime( ES_THEME_DIR . 'assets/js/admin.js' )
		: ES_THEME_VERSION;

	wp_enqueue_script(
		'erfan-sanat-admin',
		ES_THEME_URI . 'assets/js/admin.js',
		array(),
		$admin_js_ver,
		true
	);

	wp_localize_script(
		'erfan-sanat-admin',
		'erfanSanatAdmin',
		array(
			'ajaxUrl'       => esc_url( admin_url( 'admin-ajax.php' ) ),
			'nonce'         => wp_create_nonce( 'erfan_sanat_admin_nonce' ),
			'confirmReset'  => __( 'آیا از بازنشانی تنظیمات به مقادیر پیش‌فرض اطمینان دارید؟', 'erfan-sanat' ),
			'mediaTitle'    => __( 'انتخاب فایل یا تصویر از رسانه', 'erfan-sanat' ),
			'mediaButton'   => __( 'انتخاب و ثبت', 'erfan-sanat' ),
			'removeRowText' => __( 'حذف ردیف', 'erfan-sanat' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'erfan_sanat_enqueue_admin_assets' );
