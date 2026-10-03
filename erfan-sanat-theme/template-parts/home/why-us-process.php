<?php
/**
 * Homepage Section 7: Why Erfan Sanat & 5-Step Collaboration Process
 *
 * Reproduces:
 * - چرا عرفان صنعت؟ / تعهد ما به کیفیت و دوام (4 cards)
 * - مسیر همکاری با ما؛ از ایده تا درخشش (5 steps)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$why_cards = array(
	array(
		'icon'  => 'award',
		'title' => 'گواهی ISO 9001:2015',
		'desc'  => 'مهر تأیید بین‌المللی بر سیستم مدیریت کیفیت در تمامی فرآیندهای سازمان',
	),
	array(
		'icon'  => 'droplet',
		'title' => 'استاندارد IP67 / IP68',
		'desc'  => 'مقاومت کامل در برابر آب، گرد و غبار؛ از باران‌های شمال تا کویر',
	),
	array(
		'icon'  => 'wifi',
		'title' => 'کنترل هوشمند',
		'desc'  => 'مدیریت رنگ و افکت‌های نوری از راه دور با WiFi و پروتکل NRF',
	),
	array(
		'icon'  => 'shield',
		'title' => '۲۴ ماه گارانتی + ۵ سال خدمات',
		'desc'  => 'گارانتی تعویض و خدمات پس از فروش؛ چون اعتماد شما بزرگ‌ترین سرمایه ماست',
	),
);

$process_steps = array(
	'۱' => 'بازدید و مشاوره رایگان',
	'۲' => 'طراحی اختصاصی',
	'۳' => 'تولید با متریال درجه‌یک',
	'۴' => 'نصب و اجرای حرفه‌ای',
	'۵' => 'تحویل و پشتیبانی دائم',
);
?>
<section class="es-section es-why-us-section">
	<div class="es-container">
		<div class="es-section-header es-text-center">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'چرا عرفان صنعت؟', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php esc_html_e( 'تعهد ما به کیفیت و دوام', 'erfan-sanat' ); ?></h2>
				<p class="es-section-subtitle">
					<?php esc_html_e( 'نورپردازی شهری سرمایه‌گذاری بلندمدت است؛ به همین دلیل هر محصول ما حاصل استانداردهای سخت‌گیرانه و تعهد به رضایت شماست.', 'erfan-sanat' ); ?>
				</p>
			</div>
		</div>

		<div class="es-why-grid">
			<?php foreach ( $why_cards as $card ) : ?>
				<div class="es-why-card">
					<div class="es-why-icon">
						<?php echo erfan_sanat_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<h3><?php echo esc_html( $card['title'] ); ?></h3>
					<p><?php echo esc_html( $card['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="es-process-banner">
			<div class="es-process-content">
				<h3><?php esc_html_e( 'مسیر همکاری با ما؛ از ایده تا درخشش', 'erfan-sanat' ); ?></h3>
				<ol class="es-process-steps">
					<?php foreach ( $process_steps as $step_num => $step_label ) : ?>
						<li class="es-process-step">
							<span class="es-step-badge"><?php echo esc_html( $step_num ); ?></span>
							<strong><?php echo esc_html( $step_label ); ?></strong>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
			<div class="es-process-media">
				<img
					src="<?php echo esc_url( ES_THEME_URI . 'assets/images/light-tunnel.jpg' ); ?>"
					alt="<?php esc_attr_e( 'مسیر همکاری با عرفان صنعت اصفهان', 'erfan-sanat' ); ?>"
					loading="lazy"
					width="640"
					height="420"
				/>
			</div>
		</div>
	</div>
</section>
