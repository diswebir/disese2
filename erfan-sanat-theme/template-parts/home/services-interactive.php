<?php
/**
 * Homepage Section 6: Interactive Urban Lighting Services
 *
 * Reproduces the Arena reference 5-service interactive showcase (`۱ / ۵`):
 * ۰۱ نورپردازی میدان
 * ۰۲ نورپردازی خیابان و بلوار
 * ۰۳ نورپردازی پل
 * ۰۴ نورپردازی المان‌های شهری
 * ۰۵ نورپردازی ساختمان
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = array(
	array(
		'num'   => '۰۱',
		'title' => 'نورپردازی میدان',
		'desc'  => 'خلق نقطه‌کانونی بصری در قلب شهر با المان‌ها و سازه‌های نوری باشکوه، خورشیدنماهای ۴۸ پره و درختان نوری هوشمند.',
		'image' => ES_THEME_URI . 'assets/images/light-sphere.jpg',
	),
	array(
		'num'   => '۰۲',
		'title' => 'نورپردازی خیابان و بلوار',
		'desc'  => 'طراحی کریدورهای نوری ایمن، زیبا و کم‌مصرف با لوسترهای شهری، المان‌های پایه چراغ و سقف‌های نوری ریسه‌ای.',
		'image' => ES_THEME_URI . 'assets/images/chandelier.jpg',
	),
	array(
		'num'   => '۰۳',
		'title' => 'نورپردازی پل',
		'desc'  => 'برجسته‌سازی سازه‌های شاخص شهری و پل‌های روگذر با وال‌واشرهای صنعتی DMX512 و پیکسل‌های ضدآب IP68.',
		'image' => ES_THEME_URI . 'assets/images/light-tunnel.jpg',
	),
	array(
		'num'   => '۰۴',
		'title' => 'نورپردازی المان‌های شهری',
		'desc'  => 'طراحی و ساخت سازه‌های حجمی تعاملی و هوشمند متناسب با هویت فرهنگی و شرایط اقلیمی هر شهر.',
		'image' => ES_THEME_URI . 'assets/images/light-element.jpg',
	),
	array(
		'num'   => '۰۵',
		'title' => 'نورپردازی ساختمان',
		'desc'  => 'نورپردازی نمای کلاسیک و مدرن ساختمان‌های اداری، تجاری و ابنیه تاریخی با جت‌لایت‌ها و وال‌واشرهای خطی.',
		'image' => ES_THEME_URI . 'assets/images/point-light.jpg',
	),
);
?>
<section id="services" class="es-section es-services-section">
	<div class="es-container">
		<div class="es-section-header">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'خدمات حرفه‌ای', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php esc_html_e( 'خدمات نورپردازی شهری', 'erfan-sanat' ); ?></h2>
				<p class="es-section-subtitle">
					<?php esc_html_e( 'از میدان تا پل؛ راهکارهایی جامع برای شهرداری‌ها، سازمان‌های عمرانی و پیمانکاران پروژه‌های شهری', 'erfan-sanat' ); ?>
				</p>
			</div>
			<div class="es-services-counter-badge" id="es-service-counter" aria-live="polite">
				۱ / ۵
			</div>
		</div>

		<div class="es-services-interactive-layout" data-es-services="true">
			<div class="es-services-tabs" role="tablist" aria-label="<?php esc_attr_e( 'خدمات نورپردازی شهری', 'erfan-sanat' ); ?>">
				<?php foreach ( $services as $idx => $srv ) : ?>
					<?php $is_active = ( 0 === $idx ); ?>
					<button
						type="button"
						role="tab"
						id="es-srv-tab-<?php echo (int) $idx; ?>"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="es-srv-panel-<?php echo (int) $idx; ?>"
						class="es-service-tab-btn <?php echo $is_active ? 'is-active' : ''; ?>"
						data-service-index="<?php echo (int) $idx; ?>"
						data-service-num="<?php echo esc_attr( erfan_sanat_persian_digits( $idx + 1 ) . ' / ۵' ); ?>"
					>
						<span class="es-service-tab-num"><?php echo esc_html( $srv['num'] ); ?></span>
						<div class="es-service-tab-text">
							<strong><?php echo esc_html( $srv['title'] ); ?></strong>
							<p><?php echo esc_html( $srv['desc'] ); ?></p>
						</div>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="es-services-preview-stage">
				<?php foreach ( $services as $idx => $srv ) : ?>
					<?php $is_active = ( 0 === $idx ); ?>
					<div
						role="tabpanel"
						id="es-srv-panel-<?php echo (int) $idx; ?>"
						aria-labelledby="es-srv-tab-<?php echo (int) $idx; ?>"
						class="es-service-preview-panel <?php echo $is_active ? 'is-active' : ''; ?>"
						<?php echo $is_active ? '' : 'hidden'; ?>
					>
						<img
							src="<?php echo esc_url( $srv['image'] ); ?>"
							alt="<?php echo esc_attr( $srv['title'] ); ?>"
							loading="lazy"
							width="800"
							height="600"
						/>
						<div class="es-service-preview-caption">
							<span class="es-pillar-num"><?php echo esc_html( $srv['num'] ); ?></span>
							<h3><?php echo esc_html( $srv['title'] ); ?></h3>
							<p><?php echo esc_html( $srv['desc'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
