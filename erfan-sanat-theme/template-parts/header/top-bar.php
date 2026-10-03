<?php
/**
 * Top Bar Component (ISO 9001 badge, working hours, direct 10-line phone)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! es_opt( 'header_show_topbar', true ) ) {
	return;
}

$phone_display = (string) es_opt( 'contact_phone_main', '۰۳۱-۹۱۰۹۱۰۱۱' );
$phone_tel     = (string) es_opt( 'contact_phone_tel_link', '03191091011' );
$working_hours = (string) es_opt( 'contact_working_hours', '۷ صبح تا ۴:۳۰ بعدازظهر (شنبه تا پنجشنبه)' );
$iso_badge     = (string) es_opt( 'brand_iso_badge', 'گواهی ISO 9001:2015' );
?>
<div class="es-topbar">
	<div class="es-container es-topbar-inner">
		<div class="es-topbar-right">
			<span class="es-topbar-badge">
				<?php echo erfan_sanat_icon( 'shield', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( (string) es_opt( 'company_legal_name', 'شرکت دانش‌بنیان عرفان صنعت اصفهان' ) ); ?></span>
			</span>
			<span class="es-topbar-divider" aria-hidden="true">|</span>
			<span class="es-topbar-iso">
				<?php echo erfan_sanat_icon( 'award', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( $iso_badge ); ?></span>
			</span>
		</div>
		<div class="es-topbar-left">
			<span class="es-topbar-hours">
				<?php echo erfan_sanat_icon( 'clock', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( erfan_sanat_persian_digits( $working_hours ) ); ?></span>
			</span>
			<a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="es-topbar-phone">
				<?php echo erfan_sanat_icon( 'phone', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( $phone_display ) ); ?></span>
				<span class="es-topbar-lines"><?php esc_html_e( '۱۰ خط ویژه', 'erfan-sanat' ); ?></span>
			</a>
		</div>
	</div>
</div>
