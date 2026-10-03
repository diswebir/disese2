<?php
/**
 * Site Footer Component
 *
 * Reproduces the Arena reference & Erfan Sanat corporate footer with
 * ISO 9001 / IP67-IP68 trust badges, quick links, product categories, and contact details.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone_display = (string) es_opt( 'contact_phone_main', '۰۳۱ - ۹۱۰۹۱۰۱۱' );
$phone_tel     = (string) es_opt( 'contact_phone_tel_link', '03191091011' );
$email         = (string) es_opt( 'contact_email', 'info@erfansanat.com' );
$hours         = (string) es_opt( 'contact_working_hours', '۷ صبح تا ۴:۳۰ بعدازظهر شنبه تا پنجشنبه' );
$address       = (string) es_opt( 'contact_address', 'اصفهان، شهرستان خمینی‌شهر، شهرک صنعتی برق و الکترونیک، بلوار الکترونیک، پلاک ۱۱۹' );
$postal        = (string) es_opt( 'contact_postal_code', '۸۴۱۸۱۴۸۶۷۸' );
$copyright     = (string) es_opt( 'footer_copyright_text', 'تمامی حقوق این وب‌سایت متعلق به شرکت دانش‌بنیان عرفان صنعت اصفهان می‌باشد.' );
$about_html    = (string) es_opt( 'footer_about_editor', '' );
?>
<footer id="colophon" class="es-site-footer" role="contentinfo">
	<?php if ( es_opt( 'footer_show_trust_badges', true ) ) : ?>
		<div class="es-footer-trust-bar">
			<div class="es-container es-trust-grid">
				<div class="es-trust-item">
					<span class="es-trust-icon"><?php echo erfan_sanat_icon( 'award' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<strong><?php esc_html_e( 'گواهینامه ISO 9001:2015', 'erfan-sanat' ); ?></strong>
						<span><?php esc_html_e( 'سیستم مدیریت کیفیت بین‌المللی', 'erfan-sanat' ); ?></span>
					</div>
				</div>
				<div class="es-trust-item">
					<span class="es-trust-icon"><?php echo erfan_sanat_icon( 'droplet' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<strong><?php esc_html_e( 'استاندارد حفاظت IP67 / IP68', 'erfan-sanat' ); ?></strong>
						<span><?php esc_html_e( 'آب‌بندی اولتراسونیک و رزین صنعتی', 'erfan-sanat' ); ?></span>
					</div>
				</div>
				<div class="es-trust-item">
					<span class="es-trust-icon"><?php echo erfan_sanat_icon( 'wifi' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<strong><?php esc_html_e( 'کنترل هوشمند WiFi و NRF', 'erfan-sanat' ); ?></strong>
						<span><?php esc_html_e( 'مدیریت افکت‌ها با اپلیکیشن موبایل', 'erfan-sanat' ); ?></span>
					</div>
				</div>
				<div class="es-trust-item">
					<span class="es-trust-icon"><?php echo erfan_sanat_icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<strong><?php esc_html_e( '۲۴ ماه گارانتی + ۵ سال خدمات', 'erfan-sanat' ); ?></strong>
						<span><?php esc_html_e( 'پشتیبانی مستقیم کارخانه تولیدی', 'erfan-sanat' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="es-container es-footer-main">
		<div class="es-footer-col es-footer-col-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-brand-link">
				<span class="es-brand-mark"><?php echo esc_html( (string) es_opt( 'brand_badge_text', 'ES' ) ); ?></span>
				<span class="es-brand-text">
					<strong class="es-brand-title"><?php esc_html_e( 'عرفان صنعت اصفهان', 'erfan-sanat' ); ?></strong>
					<small class="es-brand-subtitle"><?php esc_html_e( 'شرکت دانش‌بنیان نورپردازی شهری', 'erfan-sanat' ); ?></small>
				</span>
			</a>
			<div class="es-footer-about-text">
				<?php echo wp_kses_post( $about_html ); ?>
			</div>
			<div class="es-footer-socials">
				<?php
				$socials = array(
					'social_whatsapp'  => __( 'واتساپ', 'erfan-sanat' ),
					'social_telegram'  => __( 'تلگرام', 'erfan-sanat' ),
					'social_aparat'    => __( 'آپارات', 'erfan-sanat' ),
					'social_instagram' => __( 'اینستاگرام', 'erfan-sanat' ),
					'social_eitaa'     => __( 'ایتا', 'erfan-sanat' ),
				);
				foreach ( $socials as $opt_k => $label ) :
					$s_url = (string) es_opt( $opt_k, '' );
					if ( '' !== $s_url ) :
						?>
						<a href="<?php echo esc_url( $s_url ); ?>" class="es-social-pill" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( $label ); ?>
						</a>
						<?php
					endif;
				endforeach;
				?>
			</div>
		</div>

		<div class="es-footer-col">
			<h3 class="es-footer-heading"><?php esc_html_e( 'دسترسی سریع', 'erfan-sanat' ); ?></h3>
			<ul class="es-footer-links">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'صفحه اصلی', 'erfan-sanat' ); ?></a></li>
				<li><a href="<?php echo esc_url( erfan_sanat_get_page_url( 'shop' ) ); ?>"><?php esc_html_e( 'فروشگاه تجهیزات نورپردازی', 'erfan-sanat' ); ?></a></li>
				<li><a href="<?php echo esc_url( erfan_sanat_get_page_url( 'projects' ) ); ?>"><?php esc_html_e( 'پروژه‌های نورپردازی شهری', 'erfan-sanat' ); ?></a></li>
				<li><a href="<?php echo esc_url( erfan_sanat_get_page_url( 'blog' ) ); ?>"><?php esc_html_e( 'مقالات فنی و آموزش کنترلرها', 'erfan-sanat' ); ?></a></li>
				<li><a href="<?php echo esc_url( erfan_sanat_get_page_url( 'about' ) ); ?>"><?php esc_html_e( 'درباره شرکت دانش‌بنیان', 'erfan-sanat' ); ?></a></li>
				<li><a href="<?php echo esc_url( erfan_sanat_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'تماس با ما و استعلام قیمت', 'erfan-sanat' ); ?></a></li>
			</ul>
		</div>

		<div class="es-footer-col">
			<h3 class="es-footer-heading"><?php esc_html_e( 'گروه‌های کالایی', 'erfan-sanat' ); ?></h3>
			<ul class="es-footer-links">
				<?php
				$cat_blueprints = erfan_sanat_get_product_categories_blueprint();
				foreach ( $cat_blueprints as $cat_slug => $cat_info ) :
					$term_obj = taxonomy_exists( 'product_cat' ) ? get_term_by( 'slug', $cat_slug, 'product_cat' ) : false;
					$link_url = ( $term_obj && ! is_wp_error( $term_obj ) ) ? get_term_link( $term_obj ) : home_url( '/product-category/' . $cat_slug . '/' );
					?>
					<li>
						<a href="<?php echo esc_url( (string) $link_url ); ?>">
							<?php echo esc_html( $cat_info['name'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="es-footer-col es-footer-col-contact">
			<h3 class="es-footer-heading"><?php esc_html_e( 'ارتباط با کارخانه و فروش', 'erfan-sanat' ); ?></h3>
			<ul class="es-footer-contact-list">
				<li>
					<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<span><?php esc_html_e( 'تلفن کارشناسان فروش (۱۰ خط ویژه):', 'erfan-sanat' ); ?></span>
						<a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="es-footer-phone" dir="ltr">
							<?php echo esc_html( erfan_sanat_persian_digits( $phone_display ) ); ?>
						</a>
					</div>
				</li>
				<li>
					<?php echo erfan_sanat_icon( 'mail', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<span><?php esc_html_e( 'پست الکترونیکی:', 'erfan-sanat' ); ?></span>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" dir="ltr"><?php echo esc_html( $email ); ?></a>
					</div>
				</li>
				<li>
					<?php echo erfan_sanat_icon( 'clock', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<span><?php esc_html_e( 'ساعات کاری:', 'erfan-sanat' ); ?></span>
						<strong><?php echo esc_html( erfan_sanat_persian_digits( $hours ) ); ?></strong>
					</div>
				</li>
				<li>
					<?php echo erfan_sanat_icon( 'location', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div>
						<span><?php esc_html_e( 'نشانی:', 'erfan-sanat' ); ?></span>
						<p><?php echo esc_html( erfan_sanat_persian_digits( $address ) ); ?> | <?php esc_html_e( 'کدپستی:', 'erfan-sanat' ); ?> <?php echo esc_html( erfan_sanat_persian_digits( $postal ) ); ?></p>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="es-footer-bottom">
		<div class="es-container es-footer-bottom-inner">
			<p><?php echo esc_html( erfan_sanat_persian_digits( $copyright ) ); ?></p>
			<p class="es-footer-est">URBAN LIGHTING — EST. <?php echo esc_html( erfan_sanat_persian_digits( (string) es_opt( 'company_established_year', 2000 ) ) ); ?></p>
		</div>
	</div>
</footer>
