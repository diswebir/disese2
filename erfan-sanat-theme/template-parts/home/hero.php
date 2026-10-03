<?php
/**
 * Homepage Section 1: Hero Section
 *
 * Reproduces the Arena reference Hero hierarchy:
 * - Knowledge-based company + ISO 9001 pill badges
 * - H1 headline: درخشان‌تر از همیشه، آینده‌ای روشن برای ایران می‌سازیم
 * - Subtitle & Dual CTAs
 * - 4 animated counter metrics (۲۵+ سال تجربه، ۸۵۰+ پروژه، ۲۸۹+ مشتری، ۹۰+ محصول)
 * - Scroll cue & URBAN LIGHTING — EST. ۲۰۰۰
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_badge    = (string) es_opt( 'hero_badge_text', 'شرکت دانش‌بنیان عرفان صنعت اصفهان' );
$iso_badge     = (string) es_opt( 'brand_iso_badge', 'گواهی ISO 9001' );
$hero_title    = (string) es_opt( 'hero_title', 'درخشان‌تر از همیشه، آینده‌ای روشن برای ایران می‌سازیم' );
$hero_subtitle = (string) es_opt( 'hero_subtitle', 'با بیش از دو دهه تجربه، پیشگام در طراحی، تولید و اجرای پروژه‌های روشنایی شهری و صنعتی؛ روشنایی‌بخش خیابان‌ها، پارک‌ها، میادین، ساختمان‌ها و صنایع کشور هستیم.' );
$hero_bg       = (string) es_opt( 'hero_bg_image', ES_THEME_URI . 'assets/images/hero.jpg' );
$stats         = es_opt( 'hero_stats_repeater', array() );
if ( ! is_array( $stats ) || empty( $stats ) ) {
	$stats = array(
		array( 'number' => '۲۵+', 'label' => 'سال تجربه درخشان' ),
		array( 'number' => '۸۵۰+', 'label' => 'پروژه تکمیل‌شده' ),
		array( 'number' => '۲۸۹+', 'label' => 'مشتری فعال' ),
		array( 'number' => '۹۰+', 'label' => 'محصول متنوع' ),
	);
}
?>
<section class="es-hero" aria-label="<?php esc_attr_e( 'معرفی عرفان صنعت اصفهان', 'erfan-sanat' ); ?>">
	<div class="es-hero-backdrop">
		<img
			src="<?php echo esc_url( $hero_bg ); ?>"
			alt="<?php esc_attr_e( 'نورپردازی شهری عرفان صنعت اصفهان', 'erfan-sanat' ); ?>"
			class="es-hero-bg-img"
			width="1440"
			height="820"
			fetchpriority="high"
		/>
		<div class="es-hero-gradient-overlay"></div>
	</div>

	<div class="es-container es-hero-container">
		<div class="es-hero-content">
			<div class="es-hero-badges">
				<span class="es-pill es-pill-gold">
					<?php echo erfan_sanat_icon( 'spark', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( $hero_badge ); ?></span>
				</span>
				<span class="es-pill es-pill-cyan">
					<?php echo erfan_sanat_icon( 'award', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( $iso_badge ); ?></span>
				</span>
			</div>

			<h1 class="es-hero-title">
				<?php echo esc_html( $hero_title ); ?>
			</h1>

			<p class="es-hero-subtitle">
				<?php echo esc_html( $hero_subtitle ); ?>
			</p>

			<div class="es-hero-actions">
				<a href="#projects" class="es-btn es-btn-primary es-btn-lg">
					<span><?php esc_html_e( 'مشاهده پروژه‌های نورپردازی', 'erfan-sanat' ); ?></span>
					<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
				<a href="#consultation" class="es-btn es-btn-glass es-btn-lg">
					<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'دریافت مشاوره رایگان', 'erfan-sanat' ); ?></span>
				</a>
			</div>

			<div class="es-hero-stats-grid">
				<?php foreach ( $stats as $stat ) : ?>
					<div class="es-hero-stat-card">
						<strong class="es-stat-number"><?php echo esc_html( erfan_sanat_persian_digits( $stat['number'] ?? '' ) ); ?></strong>
						<span class="es-stat-label"><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="es-hero-bottom-meta">
			<a href="#projects" class="es-scroll-cue">
				<span class="es-scroll-dot"></span>
				<span><?php esc_html_e( 'اسکرول', 'erfan-sanat' ); ?></span>
			</a>
			<span class="es-hero-est" dir="ltr">
				URBAN LIGHTING — EST. <?php echo esc_html( erfan_sanat_persian_digits( (string) es_opt( 'company_established_year', 2000 ) ) ); ?>
			</span>
		</div>
	</div>
</section>
