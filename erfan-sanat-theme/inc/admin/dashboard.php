<?php
/**
 * Native WordPress Admin Dashboard & Settings Engine
 *
 * Provides the top-level "تنظیمات عرفان صنعت" administration panel with
 * 17 schema-driven tabs, section reset, full reset, and security checks.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the top-level Erfan Sanat settings page and submenus.
 */
function erfan_sanat_register_admin_menu(): void {
	add_menu_page(
		__( 'تنظیمات پوسته عرفان صنعت اصفهان', 'erfan-sanat' ),
		__( 'عرفان صنعت', 'erfan-sanat' ),
		'manage_options',
		'erfan-sanat-settings',
		'erfan_sanat_render_admin_dashboard',
		'dashicons-lightbulb',
		59
	);

	add_submenu_page(
		'erfan-sanat-settings',
		__( 'تنظیمات جامع پوسته', 'erfan-sanat' ),
		__( 'تنظیمات پوسته', 'erfan-sanat' ),
		'manage_options',
		'erfan-sanat-settings',
		'erfan_sanat_render_admin_dashboard'
	);

	add_submenu_page(
		'erfan-sanat-settings',
		__( 'ابزارهای سیستم و داده نمونه', 'erfan-sanat' ),
		__( 'ابزارها و داده نمونه', 'erfan-sanat' ),
		'manage_options',
		'erfan-sanat-tools',
		'erfan_sanat_render_tools_page'
	);

	add_submenu_page(
		'erfan-sanat-settings',
		__( 'درون‌ریزی و برون‌بری تنظیمات', 'erfan-sanat' ),
		__( 'درون‌ریزی / برون‌بری', 'erfan-sanat' ),
		'manage_options',
		'erfan-sanat-import-export',
		'erfan_sanat_render_import_export_page'
	);
}
add_action( 'admin_menu', 'erfan_sanat_register_admin_menu' );

/**
 * Handles saving and resetting theme options via POST with strict nonce and capability checks.
 */
function erfan_sanat_handle_admin_settings_actions(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	if ( empty( $_POST['es_admin_action'] ) ) {
		return;
	}

	$action = sanitize_key( wp_unslash( $_POST['es_admin_action'] ) );
	if ( ! in_array( $action, array( 'save_options', 'reset_tab', 'reset_all' ), true ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__( 'شما مجوز دسترسی برای تغییر تنظیمات پوسته را ندارید.', 'erfan-sanat' ),
			esc_html__( 'عدم دسترسی', 'erfan-sanat' ),
			array( 'response' => 403 )
		);
	}

	$nonce = isset( $_POST['erfan_sanat_settings_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['erfan_sanat_settings_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'erfan_sanat_save_settings_action' ) ) {
		wp_die(
			esc_html__( 'خطای امنیتی: توکن امنیتی (Nonce) معتبر نیست.', 'erfan-sanat' ),
			esc_html__( 'خطای امنیتی', 'erfan-sanat' ),
			array( 'response' => 403 )
		);
	}

	$tabs       = erfan_sanat_get_options_tabs();
	$active_tab = isset( $_POST['es_active_tab'] ) ? sanitize_key( wp_unslash( $_POST['es_active_tab'] ) ) : 'general';
	if ( ! isset( $tabs[ $active_tab ] ) ) {
		$active_tab = 'general';
	}

	$status = 'saved';
	if ( 'save_options' === $action ) {
		$incoming = isset( $_POST[ ES_OPTION_KEY ] ) && is_array( $_POST[ ES_OPTION_KEY ] )
			? wp_unslash( $_POST[ ES_OPTION_KEY ] )
			: array();
		erfan_sanat_save_options( $incoming, $active_tab );
		$status = 'saved';
	} elseif ( 'reset_tab' === $action ) {
		erfan_sanat_reset_options( $active_tab );
		$status = 'tab_reset';
	} elseif ( 'reset_all' === $action ) {
		erfan_sanat_reset_options( 'all' );
		$status = 'all_reset';
	}

	$redirect_url = add_query_arg(
		array(
			'page'      => 'erfan-sanat-settings',
			'tab'       => $active_tab,
			'es_status' => $status,
		),
		admin_url( 'admin.php' )
	);
	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'admin_init', 'erfan_sanat_handle_admin_settings_actions' );

/**
 * Renders the main tabbed Theme Settings Dashboard.
 */
function erfan_sanat_render_admin_dashboard(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'دسترسی غیرمجاز.', 'erfan-sanat' ) );
	}

	$tabs       = erfan_sanat_get_options_tabs();
	$schema     = erfan_sanat_get_options_schema();
	$options    = es_opt();
	$active_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'general';
	if ( ! isset( $tabs[ $active_tab ] ) ) {
		$active_tab = 'general';
	}
	$status = isset( $_GET['es_status'] ) ? sanitize_key( wp_unslash( $_GET['es_status'] ) ) : '';
	?>
	<div class="wrap es-admin-wrap" dir="rtl">
		<header class="es-admin-header">
			<div class="es-admin-brand">
				<span class="es-admin-badge">ES</span>
				<div>
					<h1><?php esc_html_e( 'پنل مدیریت پوسته سازمانی عرفان صنعت اصفهان', 'erfan-sanat' ); ?></h1>
					<p><?php esc_html_e( 'مدیریت یکپارچه هویت بصری، فروشگاه تجهیزات نورپردازی، پروژه‌های شهری و سئو فنی', 'erfan-sanat' ); ?> — <code>v<?php echo esc_html( ES_THEME_VERSION ); ?></code></p>
				</div>
			</div>
			<div class="es-admin-quick-links">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button" target="_blank" rel="noopener">
					<?php esc_html_e( 'مشاهده وب‌سایت زنده', 'erfan-sanat' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=erfan-sanat-tools' ) ); ?>" class="button">
					<?php esc_html_e( 'ابزارها و داده نمونه', 'erfan-sanat' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=erfan-sanat-import-export' ) ); ?>" class="button">
					<?php esc_html_e( 'پشتیبان‌گیری JSON', 'erfan-sanat' ); ?>
				</a>
			</div>
		</header>

		<?php if ( 'saved' === $status ) : ?>
			<div class="notice notice-success is-dismissible es-admin-notice">
				<p><strong><?php esc_html_e( 'تنظیمات با موفقیت در دیتابیس ذخیره و کش سیستم بروزرسانی شد.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php elseif ( 'tab_reset' === $status ) : ?>
			<div class="notice notice-warning is-dismissible es-admin-notice">
				<p><strong><?php esc_html_e( 'تنظیمات این بخش به مقادیر پیش‌فرض بازنشانی شد.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php elseif ( 'all_reset' === $status ) : ?>
			<div class="notice notice-warning is-dismissible es-admin-notice">
				<p><strong><?php esc_html_e( 'تمامی تنظیمات پوسته به مقادیر پیش‌فرض کارخانه بازنشانی شد.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php endif; ?>

		<div class="es-admin-layout">
			<nav class="es-admin-tabs-nav" aria-label="<?php esc_attr_e( 'تب‌های تنظیمات پوسته', 'erfan-sanat' ); ?>">
				<ul>
					<?php foreach ( $tabs as $tab_key => $tab_meta ) : ?>
						<?php
						$tab_url   = add_query_arg(
							array(
								'page' => 'erfan-sanat-settings',
								'tab'  => $tab_key,
							),
							admin_url( 'admin.php' )
						);
						$is_active = ( $tab_key === $active_tab );
						?>
						<li>
							<a href="<?php echo esc_url( $tab_url ); ?>" class="es-tab-link <?php echo $is_active ? 'is-active' : ''; ?>">
								<span class="dashicons <?php echo esc_attr( $tab_meta['icon'] ?? 'dashicons-admin-generic' ); ?>"></span>
								<span><?php echo esc_html( $tab_meta['title'] ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<div class="es-admin-content-panel">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=erfan-sanat-settings&tab=' . $active_tab ) ); ?>" class="es-settings-form">
					<?php wp_nonce_field( 'erfan_sanat_save_settings_action', 'erfan_sanat_settings_nonce' ); ?>
					<input type="hidden" name="es_active_tab" value="<?php echo esc_attr( $active_tab ); ?>" />

					<div class="es-panel-section-head">
						<div>
							<h2><?php echo esc_html( $tabs[ $active_tab ]['title'] ); ?></h2>
							<p><?php echo esc_html( $tabs[ $active_tab ]['desc'] ?? '' ); ?></p>
						</div>
						<div class="es-panel-actions-top">
							<button type="submit" name="es_admin_action" value="save_options" class="button button-primary button-large">
								<?php esc_html_e( 'ذخیره تنظیمات', 'erfan-sanat' ); ?>
							</button>
						</div>
					</div>

					<div class="es-fields-list">
						<?php
						foreach ( $schema as $field_key => $field_cfg ) {
							if ( ( $field_cfg['tab'] ?? 'general' ) !== $active_tab ) {
								continue;
							}
							$current_val = $options[ $field_key ] ?? ( $field_cfg['default'] ?? '' );
							erfan_sanat_render_schema_field( $field_key, $field_cfg, $current_val );
						}
						?>
					</div>

					<footer class="es-panel-footer">
						<div class="es-panel-footer-primary">
							<button type="submit" name="es_admin_action" value="save_options" class="button button-primary button-large">
								<?php esc_html_e( 'ذخیره تغییرات این بخش', 'erfan-sanat' ); ?>
							</button>
							<button type="submit" name="es_admin_action" value="reset_tab" class="button es-reset-tab-btn">
								<?php esc_html_e( 'بازنشانی این بخش به پیش‌فرض', 'erfan-sanat' ); ?>
							</button>
						</div>
						<div class="es-panel-footer-danger">
							<button type="submit" name="es_admin_action" value="reset_all" class="button button-link-delete es-reset-all-btn">
								<?php esc_html_e( 'بازنشانی کل تنظیمات پوسته', 'erfan-sanat' ); ?>
							</button>
						</div>
					</footer>
				</form>
			</div>
		</div>
	</div>
	<?php
}
