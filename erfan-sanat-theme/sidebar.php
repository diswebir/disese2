<?php
/**
 * Sidebar Template (`sidebar.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside id="secondary" class="es-article-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'ستون کناری', 'erfan-sanat' ); ?>">
	<div class="es-sidebar-widget">
		<h3><?php esc_html_e( 'مشاوره مهندسی و فروش', 'erfan-sanat' ); ?></h3>
		<p><?php esc_html_e( 'واحد مهندسی و تحقیق و توسعه عرفان صنعت آماده پاسخگویی به سوالات فنی و صدور پیش‌فاکتور رسمی است.', 'erfan-sanat' ); ?></p>
		<a href="tel:<?php echo esc_attr( (string) es_opt( 'contact_phone_tel_link', '03191091011' ) ); ?>" class="es-btn es-btn-primary es-btn-block">
			<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( (string) es_opt( 'contact_phone_main', '۰۳۱-۹۱۰۹۱۰۱۱' ) ) ); ?></span>
		</a>
	</div>
</aside>
