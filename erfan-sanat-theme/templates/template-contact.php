<?php
/**
 * Template Name: قالب تماس با ما و کارشناسان فروش (Contact)
 * Template Post Type: page
 *
 * Reproduces the Erfan Sanat contact page with direct sales engineers directory,
 * factory contact cards, FAQ accordion, and project consultation form.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$sales_team = es_opt( 'contact_sales_team_repeater', array() );
if ( ! is_array( $sales_team ) || empty( $sales_team ) ) {
	$sales_team = array(
		array( 'name' => 'مهندس محمدعلی قربانی', 'role' => 'مدیر فروش', 'phone' => '09137976915' ),
		array( 'name' => 'مهندس علی حیدری', 'role' => 'سرپرست فروش', 'phone' => '09130559026' ),
		array( 'name' => 'مهندس فرزین داستانیان', 'role' => 'کارشناس فروش پروژه‌های شهری', 'phone' => '09130559025' ),
		array( 'name' => 'مهندس مرتضی کامرانی', 'role' => 'پشتیبانی فنی و فروش', 'phone' => '09139330097' ),
	);
}
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'ارتباط مستقیم با کارخانه و واحد فروش', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php the_title(); ?></h1>
		<p class="es-page-subtitle">
			<?php esc_html_e( 'راه‌های ارتباط، استعلام قیمت روز و ثبت سفارش در شرکت دانش‌بنیان عرفان صنعت اصفهان.', 'erfan-sanat' ); ?>
		</p>
	</div>
</section>

<section class="es-section es-sales-team-section">
	<div class="es-container">
		<div class="es-section-header">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'پاسخگوی تمام سوالات شما هستیم', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php esc_html_e( 'کارشناسان حرفه‌ای فروش و پشتیبانی فنی', 'erfan-sanat' ); ?></h2>
			</div>
		</div>

		<div class="es-sales-team-grid">
			<?php foreach ( $sales_team as $member ) : ?>
				<?php
				$m_name  = $member['name'] ?? '';
				$m_role  = $member['role'] ?? '';
				$m_phone = $member['phone'] ?? '';
				$m_tel   = preg_replace( '/[^0-9+]/', '', $m_phone );
				?>
				<div class="es-sales-card">
					<div class="es-sales-avatar" aria-hidden="true">ES</div>
					<h3><?php echo esc_html( $m_name ); ?></h3>
					<span class="es-sales-role"><?php echo esc_html( $m_role ); ?></span>
					<?php if ( '' !== $m_phone ) : ?>
						<a href="tel:<?php echo esc_attr( (string) $m_tel ); ?>" class="es-btn es-btn-outline es-btn-sm" dir="ltr">
							<?php echo erfan_sanat_icon( 'phone', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php echo esc_html( erfan_sanat_persian_digits( $m_phone ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/home/consultation-cta' );
get_footer();
