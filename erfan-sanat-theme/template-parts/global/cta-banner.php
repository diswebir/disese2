<?php
/**
 * Reusable Engineering Consultation CTA Banner
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone_display = (string) es_opt( 'contact_phone_main', '۰۳۱-۹۱۰۹۱۰۱۱' );
$phone_tel     = (string) es_opt( 'contact_phone_tel_link', '03191091011' );
?>
<section class="es-cta-strip" aria-label="<?php esc_attr_e( 'سفارش اختصاصی و مشاوره فنی', 'erfan-sanat' ); ?>">
	<div class="es-container">
		<div class="es-cta-strip-box">
			<div class="es-cta-strip-content">
				<span class="es-section-eyebrow"><?php esc_html_e( 'طراحی و ساخت سفارشی', 'erfan-sanat' ); ?></span>
				<h3><?php esc_html_e( 'طراحی و ساخت سفارشی مطابق طرح اختصاصی شما', 'erfan-sanat' ); ?></h3>
				<p><?php esc_html_e( 'اگر طرح خاصی برای میدان، پل، تونل نوری یا بلوار شهر خود در ذهن دارید، تیم مهندسی عرفان صنعت آن را از ایده تا اجرای نهایی پیاده‌سازی می‌کند.', 'erfan-sanat' ); ?></p>
			</div>
			<div class="es-cta-strip-actions">
				<a href="<?php echo esc_url( home_url( '/#consultation' ) ); ?>" class="es-btn es-btn-primary">
					<span><?php esc_html_e( 'شروع سفارش اختصاصی', 'erfan-sanat' ); ?></span>
					<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
				<a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="es-btn es-btn-outline">
					<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( $phone_display ) ); ?></span>
				</a>
			</div>
		</div>
	</div>
</section>
