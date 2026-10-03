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
if ( ! is_array( $sales_team ) || count( $sales_team ) < 6 ) {
	$sales_team = array(
		array( 'name' => 'مهندس محمدعلی قربانی', 'role' => 'مدیر فروش و پروژه‌های شهری', 'phone' => '09137976915' ),
		array( 'name' => 'مهندس علی حیدری', 'role' => 'سرپرست فروش و مشاوره فنی', 'phone' => '09130559026' ),
		array( 'name' => 'مهندس فرزین داستانیان', 'role' => 'کارشناس فروش المان‌های نوری', 'phone' => '09130559025' ),
		array( 'name' => 'مهندس مرتضی کامرانی', 'role' => 'پشتیبانی فنی و کنترلرهای هوشمند', 'phone' => '09139330097' ),
		array( 'name' => 'مهندس مصطفی ابراهیم‌زاده', 'role' => 'کارشناس فروش پروژه‌های شهرداری', 'phone' => '09130559027' ),
		array( 'name' => 'مهندس رسول حبیبی', 'role' => 'کارشناس فروش ریسه‌ها و وال‌واشر', 'phone' => '09130559028' ),
		array( 'name' => 'سرکار خانم حبیب‌الهی', 'role' => 'کارشناس فروش و صدور پیش‌فاکتور', 'phone' => '031-91091011' ),
		array( 'name' => 'سرکار خانم قربانی', 'role' => 'امور قراردادها و پیگیری سفارشات', 'phone' => '031-91091011' ),
	);
}

$contact_faqs = array(
	array(
		'q' => 'نحوه دریافت پیش‌فاکتور رسمی برای شهرداری‌ها و دهیاری‌ها چگونه است؟',
		'a' => 'کافی است از طریق فرم زیر یا تماس مستقیم با شماره ۰۳۱-۹۱۰۹۱۰۱۱ مشخصات پروژه یا فهرست اقلام مورد نیاز را اعلام فرمایید تا پیش‌فاکتور رسمی ممهور همراه با شناسنامه فنی و کد کالا (GS1 / ایران‌کد) در کمتر از ۲ ساعت صادر گردد.',
	),
	array(
		'q' => 'آیا امکان طراحی و تولید المان نوری اختصاصی متناسب با هویت فرهنگی هر شهر وجود دارد؟',
		'a' => 'بله، واحد طراحی صنعتی و سازه عرفان صنعت اصفهان بر اساس طرح پیشنهادی شهرداری یا طراحی سه‌بعدی اختصاصی، سازه‌های نوری بومی و مناسبتی را با ۲۴ ماه گارانتی تولید و اجرا می‌کند.',
	),
	array(
		'q' => 'شرایط گارانتی و خدمات پس از فروش محصولات عرفان صنعت چیست؟',
		'a' => 'تمامی تولیدات شرکت دارای ۱۲ تا ۲۴ ماه گارانتی تعویض واقعی و ۵ سال خدمات پس از فروش و تامین قطعات مستقیم از کارخانه اصفهان هستند.',
	),
);
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'ارتباط مستقیم با کارخانه و واحد فروش', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php esc_html_e( 'تماس با شرکت دانش‌بنیان عرفان صنعت اصفهان', 'erfan-sanat' ); ?></h1>
		<p class="es-page-subtitle">
			<?php esc_html_e( 'راه‌های ارتباط مستقیم با کارشناسان فروش، استعلام قیمت روز، دریافت پیش‌فاکتور رسمی مناقصات و پشتیبانی فنی کنترلرها.', 'erfan-sanat' ); ?>
		</p>
	</div>
</section>

<section class="es-section es-sales-team-section">
	<div class="es-container">
		<div class="es-section-header">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'پاسخگوی تمام سوالات شما هستیم', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php esc_html_e( 'کارشناسان حرفه‌ای فروش و پشتیبانی فنی', 'erfan-sanat' ); ?></h2>
				<p class="es-section-subtitle">
					<?php esc_html_e( 'شنبه تا پنجشنبه از ساعت ۷:۰۰ صبح الی ۱۶:۳۰ بعدازظهر آماده ارائه مشاوره تخصصی رایگان به شما هستیم.', 'erfan-sanat' ); ?>
				</p>
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

<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>

<section class="es-section">
	<div class="es-container">
		<div class="es-faq-section">
			<h3 class="es-faq-heading"><?php esc_html_e( 'سوالات متداول خرید، پیش‌فاکتور و همکاری با شهرداری‌ها', 'erfan-sanat' ); ?></h3>
			<div class="es-faq-accordion">
				<?php foreach ( $contact_faqs as $idx => $faq ) : ?>
					<details class="es-faq-item" <?php echo 0 === $idx ? 'open' : ''; ?>>
						<summary class="es-faq-question">
							<span><?php echo esc_html( $faq['q'] ); ?></span>
							<span class="es-faq-chevron" aria-hidden="true">+</span>
						</summary>
						<div class="es-faq-answer">
							<p><?php echo esc_html( $faq['a'] ); ?></p>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
