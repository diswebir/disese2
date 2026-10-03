<?php
/**
 * Theme Settings JSON Import / Export Engine
 *
 * Allows exporting the single `erfan_sanat_options` array as JSON and importing
 * from JSON file or raw JSON payload with full schema sanitization.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles JSON Export and Import requests on `admin_init`.
 */
function erfan_sanat_handle_import_export_actions(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	if ( empty( $_POST['es_ie_action'] ) ) {
		return;
	}

	$action = sanitize_key( wp_unslash( $_POST['es_ie_action'] ) );
	if ( ! in_array( $action, array( 'export_json', 'import_json' ), true ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'دسترسی غیرمجاز.', 'erfan-sanat' ), '', array( 'response' => 403 ) );
	}

	$nonce = isset( $_POST['erfan_sanat_ie_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['erfan_sanat_ie_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'erfan_sanat_import_export_action' ) ) {
		wp_die( esc_html__( 'خطای امنیتی: توکن نامعتبر است.', 'erfan-sanat' ), '', array( 'response' => 403 ) );
	}

	if ( 'export_json' === $action ) {
		$export_payload = array(
			'theme'       => ES_THEME_SLUG,
			'version'     => ES_THEME_VERSION,
			'exported_at' => gmdate( 'c' ),
			'options'     => es_opt(),
		);

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="erfan-sanat-options-' . gmdate( 'Y-m-d' ) . '.json"' );
		echo wp_json_encode( $export_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		exit;
	}

	if ( 'import_json' === $action ) {
		$decoded = null;

		if ( ! empty( $_FILES['es_import_file']['tmp_name'] ) ) {
			$validated = erfan_sanat_validate_json_upload( $_FILES['es_import_file'] );
			if ( is_wp_error( $validated ) ) {
				wp_safe_redirect( add_query_arg( array( 'page' => 'erfan-sanat-import-export', 'ie_status' => 'invalid_json' ), admin_url( 'admin.php' ) ) );
				exit;
			}
			$decoded = $validated;
		} elseif ( ! empty( $_POST['es_import_raw_json'] ) ) {
			$raw_json = trim( (string) wp_unslash( $_POST['es_import_raw_json'] ) );
			$parsed   = json_decode( $raw_json, true );
			if ( JSON_ERROR_NONE === json_last_error() && is_array( $parsed ) ) {
				$decoded = $parsed;
			}
		}

		if ( ! is_array( $decoded ) ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'erfan-sanat-import-export', 'ie_status' => 'invalid_json' ), admin_url( 'admin.php' ) ) );
			exit;
		}

		$options_to_import = isset( $decoded['options'] ) && is_array( $decoded['options'] ) ? $decoded['options'] : $decoded;
		erfan_sanat_save_options( $options_to_import, null );

		wp_safe_redirect( add_query_arg( array( 'page' => 'erfan-sanat-import-export', 'ie_status' => 'imported' ), admin_url( 'admin.php' ) ) );
		exit;
	}
}
add_action( 'admin_init', 'erfan_sanat_handle_import_export_actions' );

/**
 * Renders the Import / Export admin page.
 */
function erfan_sanat_render_import_export_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'دسترسی غیرمجاز.', 'erfan-sanat' ) );
	}

	$ie_status      = isset( $_GET['ie_status'] ) ? sanitize_key( wp_unslash( $_GET['ie_status'] ) ) : '';
	$export_preview = wp_json_encode(
		array(
			'theme'   => ES_THEME_SLUG,
			'version' => ES_THEME_VERSION,
			'options' => es_opt(),
		),
		JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
	);
	?>
	<div class="wrap es-admin-wrap" dir="rtl">
		<h1><?php esc_html_e( 'درون‌ریزی و برون‌بری تنظیمات پوسته (JSON)', 'erfan-sanat' ); ?></h1>

		<?php if ( 'imported' === $ie_status ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'فایل تنظیمات JSON با موفقیت اعتبارسنجی، پاک‌سازی و درون‌ریزی شد.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php elseif ( 'invalid_json' === $ie_status ) : ?>
			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'خطا: داده یا فایل JSON واردشده معتبر نیست.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php endif; ?>

		<div class="es-admin-cards-two-col">
			<div class="es-admin-card">
				<h2><?php esc_html_e( 'برون‌بری تنظیمات فعلی (Export JSON)', 'erfan-sanat' ); ?></h2>
				<p><?php esc_html_e( 'می‌توانید یک نسخه پشتیبان کامل از تمامی تنظیمات پوسته را در قالب فایل استاندارد JSON دانلود یا کپی نمایید.', 'erfan-sanat' ); ?></p>
				<textarea readonly rows="10" class="large-text code" dir="ltr"><?php echo esc_textarea( (string) $export_preview ); ?></textarea>
				<form method="post">
					<?php wp_nonce_field( 'erfan_sanat_import_export_action', 'erfan_sanat_ie_nonce' ); ?>
					<input type="hidden" name="es_ie_action" value="export_json" />
					<p>
						<button type="submit" class="button button-primary">
							<?php esc_html_e( 'دانلود فایل پشتیبان JSON', 'erfan-sanat' ); ?>
						</button>
					</p>
				</form>
			</div>

			<div class="es-admin-card">
				<h2><?php esc_html_e( 'درون‌ریزی تنظیمات (Import JSON)', 'erfan-sanat' ); ?></h2>
				<p><?php esc_html_e( 'فایل JSON پشتیبان را بارگذاری کنید یا محتوای JSON را در کادر زیر قرار دهید. تمامی فیلدها پیش از ذخیره بر اساس اسکیما پاک‌سازی می‌شوند.', 'erfan-sanat' ); ?></p>
				<form method="post" enctype="multipart/form-data">
					<?php wp_nonce_field( 'erfan_sanat_import_export_action', 'erfan_sanat_ie_nonce' ); ?>
					<input type="hidden" name="es_ie_action" value="import_json" />
					<p>
						<label for="es_import_file"><strong><?php esc_html_e( 'انتخاب فایل JSON:', 'erfan-sanat' ); ?></strong></label><br />
						<input type="file" id="es_import_file" name="es_import_file" accept=".json,application/json" />
					</p>
					<p>
						<label for="es_import_raw_json"><strong><?php esc_html_e( 'یا جای‌گذاری مستقیم کد JSON:', 'erfan-sanat' ); ?></strong></label>
						<textarea id="es_import_raw_json" name="es_import_raw_json" rows="7" class="large-text code" dir="ltr" placeholder='{"options": {...}}'></textarea>
					</p>
					<p>
						<button type="submit" class="button button-primary">
							<?php esc_html_e( 'اعتبارسنجی و درون‌ریزی تنظیمات', 'erfan-sanat' ); ?>
						</button>
					</p>
				</form>
			</div>
		</div>
	</div>
	<?php
}
