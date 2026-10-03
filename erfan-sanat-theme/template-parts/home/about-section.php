<?php
/**
 * Homepage Section 4: About Knowledge-Based Company Section
 *
 * Reproduces: "درباره شرکت دانش‌بنیان — بیش از ۲۵ سال تجربه، حاصلِ کارِ مفیدِ بی‌وقفه"
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_title = (string) es_opt( 'home_about_title', 'بیش از ۲۵ سال تجربه، حاصلِ کارِ مفیدِ بی‌وقفه' );
?>
<section id="about" class="es-section es-about-section">
	<div class="es-container">
		<div class="es-about-grid">
			<div class="es-about-content">
				<span class="es-section-eyebrow"><?php esc_html_e( 'درباره شرکت دانش‌بنیان', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php echo esc_html( $about_title ); ?></h2>

				<p class="es-about-lead">
					<strong><?php esc_html_e( 'شرکت دانش‌بنیان عرفان صنعت اصفهان', 'erfan-sanat' ); ?></strong>
					<?php esc_html_e( 'در زمینه نورپردازی شهری، با سابقه‌ای درخشان و متخصصانی مجرب، طیف وسیعی از خدمات را به شهرداری‌ها، سازمان‌های عمرانی و پیمانکاران پروژه‌های شهری ارائه می‌دهد. ستاره‌ای درخشان در آسمان صنعت روشنایی ایران که با تکیه بر دانش فنی و برترین تکنولوژی‌ها، به دنبال خلق فضایی ایمن، زیبا و پایدار برای زندگی و کار شماست؛ برای ما نور، نمادی از امید، پیشرفت و زندگی است.', 'erfan-sanat' ); ?>
				</p>

				<ul class="es-check-list">
					<li>
						<span class="es-check-icon"><?php echo erfan_sanat_icon( 'check', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php esc_html_e( 'طراحی، تولید و اجرای پروژه‌های روشنایی شهری و صنعتی', 'erfan-sanat' ); ?></span>
					</li>
					<li>
						<span class="es-check-icon"><?php echo erfan_sanat_icon( 'check', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php esc_html_e( 'دارای گواهینامه بین‌المللی ISO 9001:2015', 'erfan-sanat' ); ?></span>
					</li>
					<li>
						<span class="es-check-icon"><?php echo erfan_sanat_icon( 'check', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php esc_html_e( '۲۴ ماه گارانتی تعویض + ۵ سال خدمات پس از فروش', 'erfan-sanat' ); ?></span>
					</li>
				</ul>

				<div class="es-about-actions">
					<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="es-btn es-btn-primary">
						<span><?php esc_html_e( 'کسب اطلاعات بیشتر', 'erfan-sanat' ); ?></span>
						<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<div class="es-iso-inline-badge">
						<?php echo erfan_sanat_icon( 'award' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div>
							<strong>ISO 9001:2015</strong>
							<span><?php esc_html_e( 'مدیریت کیفیت بین‌المللی', 'erfan-sanat' ); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="es-about-visual">
				<div class="es-about-image-frame">
					<img
						src="<?php echo esc_url( ES_THEME_URI . 'assets/images/light-element.jpg' ); ?>"
						alt="<?php esc_attr_e( 'المان نوری عرفان صنعت اصفهان', 'erfan-sanat' ); ?>"
						loading="lazy"
						width="800"
						height="600"
					/>
					<div class="es-about-image-caption">
						<?php esc_html_e( 'المان‌های نوری اختصاصی عرفان صنعت', 'erfan-sanat' ); ?>
					</div>
				</div>

				<div class="es-about-counters">
					<div class="es-counter-box">
						<strong class="es-counter-val" data-count="850">۸۵۰+</strong>
						<span><?php esc_html_e( 'پروژه تکمیل‌شده', 'erfan-sanat' ); ?></span>
					</div>
					<div class="es-counter-box">
						<strong class="es-counter-val" data-count="100">۱۰۰+</strong>
						<span><?php esc_html_e( 'نیروی متخصص', 'erfan-sanat' ); ?></span>
					</div>
					<div class="es-counter-box">
						<strong class="es-counter-val" data-count="289">۲۸۹+</strong>
						<span><?php esc_html_e( 'مشتری فعال', 'erfan-sanat' ); ?></span>
					</div>
					<div class="es-counter-box">
						<strong class="es-counter-val" data-count="90">۹۰+</strong>
						<span><?php esc_html_e( 'محصول متنوع', 'erfan-sanat' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
