<?php
/**
 * Security Hardening, Nonce Verification, Input Sanitization & Inquiry Handling
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sends defensive HTTP security headers on frontend and admin requests.
 */
function erfan_sanat_send_security_headers(): void {
	if ( headers_sent() || ! es_opt( 'adv_security_headers', true ) ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
add_action( 'send_headers', 'erfan_sanat_send_security_headers' );

/**
 * Removes WordPress version disclosure from head and feeds when configured.
 *
 * @return string
 */
function erfan_sanat_remove_version_generator(): string {
	if ( es_opt( 'adv_hide_wp_version', true ) ) {
		return '';
	}
	return get_bloginfo( 'version' );
}
add_filter( 'the_generator', 'erfan_sanat_remove_version_generator' );

/**
 * Validates uploaded JSON files for settings import to prevent unsafe uploads.
 *
 * @param array<string, mixed> $file $_FILES entry.
 * @return array<string, mixed>|WP_Error
 */
function erfan_sanat_validate_json_upload( array $file ) {
	if ( empty( $file['tmp_name'] ) || ! isset( $file['error'] ) || UPLOAD_ERR_OK !== (int) $file['error'] ) {
		return new WP_Error( 'es_upload_error', __( 'فایل معتبر جهت بارگذاری انتخاب نشده است.', 'erfan-sanat' ) );
	}

	$filename = isset( $file['name'] ) ? sanitize_file_name( (string) $file['name'] ) : '';
	if ( ! str_ends_with( strtolower( $filename ), '.json' ) ) {
		return new WP_Error( 'es_invalid_ext', __( 'فقط فایل‌های با پسوند .json مجاز هستند.', 'erfan-sanat' ) );
	}

	$max_size = 512 * 1024; // 512 KB max for settings JSON.
	if ( isset( $file['size'] ) && (int) $file['size'] > $max_size ) {
		return new WP_Error( 'es_file_too_large', __( 'حجم فایل تنظیمات بیش از حد مجاز است.', 'erfan-sanat' ) );
	}

	$raw_content = file_get_contents( (string) $file['tmp_name'] );
	if ( false === $raw_content || '' === trim( $raw_content ) ) {
		return new WP_Error( 'es_empty_file', __( 'فایل بارگذاری‌شده خالی است.', 'erfan-sanat' ) );
	}

	$decoded = json_decode( $raw_content, true );
	if ( JSON_ERROR_NONE !== json_last_error() || ! is_array( $decoded ) ) {
		return new WP_Error( 'es_invalid_json', __( 'ساختار فایل JSON معتبر نیست.', 'erfan-sanat' ) );
	}

	return $decoded;
}

/**
 * Handles frontend Project Consultation & Proforma Inquiry submissions securely.
 */
function erfan_sanat_handle_consultation_submission(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	if ( empty( $_POST['es_action'] ) || 'submit_consultation' !== $_POST['es_action'] ) {
		return;
	}

	$nonce = isset( $_POST['es_consultation_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['es_consultation_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'erfan_sanat_consultation_submit' ) ) {
		wp_die(
			esc_html__( 'خطای امنیتی: توکن فرم نامعتبر یا منقضی شده است.', 'erfan-sanat' ),
			esc_html__( 'خطای امنیتی', 'erfan-sanat' ),
			array( 'response' => 403 )
		);
	}

	// Honeypot check against automated spam.
	if ( ! empty( $_POST['es_website_hp'] ) ) {
		wp_safe_redirect( add_query_arg( 'es_inquiry', 'sent', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$full_name    = isset( $_POST['es_full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['es_full_name'] ) ) : '';
	$phone        = isset( $_POST['es_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['es_phone'] ) ) : '';
	$organization = isset( $_POST['es_organization'] ) ? sanitize_text_field( wp_unslash( $_POST['es_organization'] ) ) : '';
	$province     = isset( $_POST['es_province'] ) ? sanitize_text_field( wp_unslash( $_POST['es_province'] ) ) : '';
	$inquiry_type = isset( $_POST['es_inquiry_type'] ) ? sanitize_key( wp_unslash( $_POST['es_inquiry_type'] ) ) : 'consultation';
	$product_id   = isset( $_POST['es_product_id'] ) ? absint( $_POST['es_product_id'] ) : 0;
	$message      = isset( $_POST['es_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['es_message'] ) ) : '';

	if ( '' === $full_name || '' === $phone ) {
		$redirect_err = add_query_arg( 'es_inquiry', 'invalid', wp_get_referer() ?: home_url( '/' ) );
		wp_safe_redirect( $redirect_err );
		exit;
	}

	$inquiries = get_option( 'erfan_sanat_inquiries_log', array() );
	if ( ! is_array( $inquiries ) ) {
		$inquiries = array();
	}

	array_unshift(
		$inquiries,
		array(
			'name'         => $full_name,
			'phone'        => $phone,
			'organization' => $organization,
			'province'     => $province,
			'type'         => $inquiry_type,
			'product_id'   => $product_id,
			'message'      => $message,
			'created_at'   => current_time( 'mysql' ),
		)
	);

	// Keep the latest 100 inquiries.
	$inquiries = array_slice( $inquiries, 0, 100 );
	update_option( 'erfan_sanat_inquiries_log', $inquiries, false );

	$redirect_ok = add_query_arg( 'es_inquiry', 'sent', wp_get_referer() ?: home_url( '/' ) );
	wp_safe_redirect( $redirect_ok );
	exit;
}
add_action( 'template_redirect', 'erfan_sanat_handle_consultation_submission' );
