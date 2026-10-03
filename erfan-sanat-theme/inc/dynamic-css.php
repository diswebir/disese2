<?php
/**
 * Runtime Dynamic CSS Custom Properties Generator
 *
 * Generates all required CSS variables from `es_opt()` at runtime.
 * Never writes generated CSS into physical files.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds the runtime CSS custom properties string.
 *
 * Required variables:
 * --es-primary, --es-secondary, --es-accent, --es-background,
 * --es-surface, --es-text, --es-muted, --es-border,
 * --es-radius, --es-container, --es-font-body, --es-font-heading
 *
 * @return string
 */
function erfan_sanat_get_dynamic_css(): string {
	$primary     = sanitize_hex_color( (string) es_opt( 'color_primary', '#f59e0b' ) ) ?: '#f59e0b';
	$secondary   = sanitize_hex_color( (string) es_opt( 'color_secondary', '#0ea5e9' ) ) ?: '#0ea5e9';
	$accent      = sanitize_hex_color( (string) es_opt( 'color_accent', '#fbbf24' ) ) ?: '#fbbf24';
	$background  = sanitize_hex_color( (string) es_opt( 'color_background', '#090d16' ) ) ?: '#090d16';
	$surface     = sanitize_hex_color( (string) es_opt( 'color_surface', '#111827' ) ) ?: '#111827';
	$text        = sanitize_hex_color( (string) es_opt( 'color_text', '#f8fafc' ) ) ?: '#f8fafc';
	$muted       = sanitize_hex_color( (string) es_opt( 'color_muted', '#94a3b8' ) ) ?: '#94a3b8';
	$border      = sanitize_hex_color( (string) es_opt( 'color_border', '#1e293b' ) ) ?: '#1e293b';
	$radius      = max( 4, min( 32, absint( es_opt( 'ui_border_radius', 16 ) ) ) );
	$container   = max( 1140, min( 1560, absint( es_opt( 'ui_container_width', 1320 ) ) ) );
	$base_size   = max( 14, min( 20, absint( es_opt( 'font_base_size', 16 ) ) ) );
	$font_body   = sanitize_text_field( (string) es_opt( 'font_body', 'Vazirmatn' ) );
	$font_head   = sanitize_text_field( (string) es_opt( 'font_heading', 'Vazirmatn' ) );
	$font_uri    = esc_url( ES_THEME_URI . 'assets/fonts/' );

	$body_stack = "'" . esc_attr( $font_body ) . "', 'Tahoma', sans-serif";
	$head_stack = "'" . esc_attr( $font_head ) . "', 'Tahoma', sans-serif";

	$css  = "@font-face{font-family:'Vazirmatn';src:url('{$font_uri}Vazirmatn-Regular.woff2') format('woff2');font-weight:400;font-style:normal;font-display:swap;}";
	$css .= "@font-face{font-family:'Vazirmatn';src:url('{$font_uri}Vazirmatn-Medium.woff2') format('woff2');font-weight:500;font-style:normal;font-display:swap;}";
	$css .= "@font-face{font-family:'Vazirmatn';src:url('{$font_uri}Vazirmatn-SemiBold.woff2') format('woff2');font-weight:600;font-style:normal;font-display:swap;}";
	$css .= "@font-face{font-family:'Vazirmatn';src:url('{$font_uri}Vazirmatn-Bold.woff2') format('woff2');font-weight:700;font-style:normal;font-display:swap;}";
	$css .= "@font-face{font-family:'Vazirmatn';src:url('{$font_uri}Vazirmatn-ExtraBold.woff2') format('woff2');font-weight:800;font-style:normal;font-display:swap;}";

	$css .= ':root{';
	$css .= "--es-primary:{$primary};";
	$css .= "--es-secondary:{$secondary};";
	$css .= "--es-accent:{$accent};";
	$css .= "--es-background:{$background};";
	$css .= "--es-surface:{$surface};";
	$css .= "--es-text:{$text};";
	$css .= "--es-muted:{$muted};";
	$css .= "--es-border:{$border};";
	$css .= "--es-radius:{$radius}px;";
	$css .= "--es-container:{$container}px;";
	$css .= "--es-font-body:{$body_stack};";
	$css .= "--es-font-heading:{$head_stack};";
	$css .= "--es-font-size-base:{$base_size}px;";
	$css .= '}';

	return $css;
}
