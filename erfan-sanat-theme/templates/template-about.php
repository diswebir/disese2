<?php
/**
 * Template Name: قالب درباره ما و گواهینامه‌ها (About)
 * Template Post Type: page
 *
 * Reproduces the Erfan Sanat About Us experience with corporate history since 1378 (2000),
 * 4 trust pillars, interactive Story/Values/Goals/Vision tabs, ISO 9001:2015 certification,
 * catalog download, and 5-step process.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$catalog_pdf = (string) es_opt( 'products_catalog_pdf_url', ES_THEME_URI . 'assets/images/sample-datasheet.pdf' );
?>
<section class="es-page-hero es-about-page-hero">
	<div class="es-container">
		<div class="es-hero-badges">
			<span class="es-pill es-pill-gold">
				<?php echo erfan_sanat_icon( 'spark', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'تأسیس ۱۳۷۸ — بیش از ربع قرن تجربه مستمر', 'erfan-sanat' ); ?></span>
			</span>
			<span class="es-pill es-pill-cyan">
				<?php echo erfan_sanat_icon( 'award', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'دارای گواهینامه بین‌المللی ISO 9001:2015', 'erfan-sanat' ); ?></span>
			</span>
		</div>
		<h1 class="es-page-title"><?php esc_html_e( 'درباره شرکت دانش‌بنیان عرفان صنعت اصفهان', 'erfan-sanat' ); ?></h1>
		<p class="es-page-subtitle">
			<?php esc_html_e( 'پیشگام در طراحی، مهندسی و تولید تجهیزات نورپردازی شهری، المان‌های حجمی هوشمند، تونل‌های نوری و کنترلرهای پیکسلی در سراسر ایران.', 'erfan-sanat' ); ?>
		</p>
	</div>
</section>

<?php get_template_part( 'template-parts/home/about-section' ); ?>

<section class="es-section es-about-vision-section">
	<div class="es-container">
		<div class="es-product-specs-section" data-es-specs-tabs>
			<div class="es-specs-tabs-bar" role="tablist" aria-label="<?php esc_attr_e( 'چشم‌انداز و ارزش‌های سازمانی', 'erfan-sanat' ); ?>">
				<button type="button" class="es-specs-tab is-active" role="tab" aria-selected="true" data-spec-tab="story">
					<?php esc_html_e( 'داستان و تاریخچه ما', 'erfan-sanat' ); ?>
				</button>
				<button type="button" class="es-specs-tab" role="tab" aria-selected="false" data-spec-tab="values">
					<?php esc_html_e( 'ارزش‌های بنیادین', 'erfan-sanat' ); ?>
				</button>
				<button type="button" class="es-specs-tab" role="tab" aria-selected="false" data-spec-tab="goals">
					<?php esc_html_e( 'اهداف مهندسی و بومی‌سازی', 'erfan-sanat' ); ?>
				</button>
				<button type="button" class="es-specs-tab" role="tab" aria-selected="false" data-spec-tab="iso">
					<?php esc_html_e( 'گواهینامه ISO 9001:2015 و کاتالوگ', 'erfan-sanat' ); ?>
				</button>
			</div>

			<div class="es-specs-tab-panel is-active" role="tabpanel" data-spec-panel="story">
				<div class="es-specs-table-card es-prose">
					<h3><?php esc_html_e( 'از کارگاه تخصصی الکترونیک در سال ۱۳۷۸ تا قطب دانش‌بنیان نورپردازی شهری کشور', 'erfan-sanat' ); ?></h3>
					<p><?php esc_html_e( 'شرکت دانش‌بنیان عرفان صنعت اصفهان فعالیت رسمی خود را از سال ۱۳۷۸ (۲۰۰۰ میلادی) با تمرکز بر طراحی و ساخت سیستم‌های الکترونیکی و روشنایی صنعتی آغاز نمود. امروز با استقرار در شهرک صنعتی برق و الکترونیک خمینی‌شهر اصفهان و بهره‌مندی از بیش از ۱۰۰ نیروی متخصص، بیش از ۸۵۰ پروژه موفق نورپردازی شهری را در همکاری با شهرداری‌ها و سازمان‌های زیباسازی سراسر کشور به انجام رسانده است.', 'erfan-sanat' ); ?></p>
					<p><?php esc_html_e( 'تمامی مراحل طراحی سازه، قالب‌سازی پلی‌کربنات آنتی‌یووی، مونتاژ بردهای الکترونیکی SMD، جوش اولتراسونیک، تزریق رزین IP67/IP68 و برنامه‌نویسی کنترلرهای هوشمند WiFi و NRF در داخل کارخانه عرفان صنعت انجام می‌شود.', 'erfan-sanat' ); ?></p>
				</div>
			</div>

			<div class="es-specs-tab-panel" role="tabpanel" data-spec-panel="values" hidden>
				<div class="es-specs-table-card es-prose">
					<h3><?php esc_html_e( 'ارزش‌های سازمانی عرفان صنعت اصفهان', 'erfan-sanat' ); ?></h3>
					<ul>
						<li><strong><?php esc_html_e( 'کیفیت بدون مصالحه:', 'erfan-sanat' ); ?></strong> <?php esc_html_e( 'استفاده از چیپ‌های اورجینال Epistar و Cree، کابل‌های تمام مس و حباب‌های پلی‌کربنات نشکن مقاوم در برابر تابش خورشید.', 'erfan-sanat' ); ?></li>
						<li><strong><?php esc_html_e( 'تعهد واقعی به گارانتی:', 'erfan-sanat' ); ?></strong> <?php esc_html_e( 'ارائه ۲۴ ماه گارانتی تعویض بی‌قیدوشرط و ۵ سال خدمات پس از فروش مستقیم کارخانه.', 'erfan-sanat' ); ?></li>
						<li><strong><?php esc_html_e( 'ایمنی شهروندان:', 'erfan-sanat' ); ?></strong> <?php esc_html_e( 'طراحی المان‌ها و تونل‌های نوری با ولتاژ ایمن ۱۲ و ۲۴ ولت DC و سازه‌های مقاوم در برابر تندباد.', 'erfan-sanat' ); ?></li>
					</ul>
				</div>
			</div>

			<div class="es-specs-tab-panel" role="tabpanel" data-spec-panel="goals" hidden>
				<div class="es-specs-table-card es-prose">
					<h3><?php esc_html_e( 'خودکفایی فناوری و رقابت با تراز اول جهانی', 'erfan-sanat' ); ?></h3>
					<p><?php esc_html_e( 'واحد تحقیق و توسعه (R&D) عرفان صنعت اصفهان با بومی‌سازی پروتکل همگام‌سازی بی‌سیم NRF تا برد ۲۰۰ متر و اپلیکیشن اختصاصی مدیریت انیمیشن‌های نوری، نیاز شهرداری‌های کشور به واردات تجهیزات خارجی را به‌طور کامل مرتفع ساخته است.', 'erfan-sanat' ); ?></p>
				</div>
			</div>

			<div class="es-specs-tab-panel" role="tabpanel" data-spec-panel="iso" hidden>
				<div class="es-specs-table-card es-prose">
					<h3><?php esc_html_e( 'استاندارد مدیریت کیفیت ISO 9001:2015 و دریافت مستندات رسمی', 'erfan-sanat' ); ?></h3>
					<p><?php esc_html_e( 'تمامی فرآیندهای طراحی، تامین قطعات، کنترل کیفیت خط تولید (QC) و خدمات پس از فروش شرکت دانش‌بنیان عرفان صنعت اصفهان تحت پوشش استاندارد بین‌المللی ISO 9001:2015 قرار دارد.', 'erfan-sanat' ); ?></p>
					<p>
						<a href="<?php echo esc_url( $catalog_pdf ); ?>" class="es-btn es-btn-primary" download>
							<?php echo erfan_sanat_icon( 'download', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php esc_html_e( 'دانلود کاتالوگ جامع و رزومه رسمی شرکت (PDF)', 'erfan-sanat' ); ?></span>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/home/why-us-process' ); ?>
<?php get_template_part( 'template-parts/home/city-marquee' ); ?>
<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>

<?php
get_footer();
