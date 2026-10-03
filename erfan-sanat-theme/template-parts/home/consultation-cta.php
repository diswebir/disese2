<?php
/**
 * Homepage Section 9: Consultation, Price Inquiry & Proforma Request Section
 *
 * Reproduces: "مشاوره و استعلام قیمت رایگان — روشنایی را به شهر خود دعوت کنید"
 * plus a secure nonce-protected project proforma request form.
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
$provinces     = erfan_sanat_get_iran_provinces();
$inquiry_state = isset( $_GET['es_inquiry'] ) ? sanitize_key( wp_unslash( $_GET['es_inquiry'] ) ) : '';
?>
<section id="consultation" class="es-section es-consultation-section">
	<div class="es-container">
		<div class="es-consultation-grid">
			<div class="es-consultation-info">
				<span class="es-section-eyebrow"><?php esc_html_e( 'مشاوره و استعلام قیمت رایگان', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php esc_html_e( 'روشنایی را به شهر خود دعوت کنید', 'erfan-sanat' ); ?></h2>
				<p class="es-section-subtitle">
					<?php esc_html_e( 'کارشناسان حرفه‌ای فروش پاسخگوی شما هستند؛ برای انتخاب بهترین المان نوری متناسب با پروژه‌تان، همین حالا تماس بگیرید. ارائه مشاوره رایگان، استعلام قیمت روز و راهنمایی کامل نصب و اجرا.', 'erfan-sanat' ); ?>
				</p>

				<div class="es-contact-cards-stack">
					<a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="es-contact-info-card es-contact-card-highlight">
						<span class="es-contact-card-icon"><?php echo erfan_sanat_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<span class="es-contact-card-label"><?php esc_html_e( 'تماس مستقیم با کارشناسان فروش (۱۰ خط ویژه)', 'erfan-sanat' ); ?></span>
							<strong class="es-contact-card-val" dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( $phone_display ) ); ?></strong>
						</div>
					</a>

					<a href="mailto:<?php echo esc_attr( $email ); ?>" class="es-contact-info-card">
						<span class="es-contact-card-icon"><?php echo erfan_sanat_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<span class="es-contact-card-label"><?php esc_html_e( 'ایمیل شرکت (پاسخگویی در سریع‌ترین زمان)', 'erfan-sanat' ); ?></span>
							<strong class="es-contact-card-val" dir="ltr"><?php echo esc_html( $email ); ?></strong>
						</div>
					</a>

					<div class="es-contact-info-card">
						<span class="es-contact-card-icon"><?php echo erfan_sanat_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<span class="es-contact-card-label"><?php esc_html_e( 'ساعات کاری کارخانه و دفتر مرکزی', 'erfan-sanat' ); ?></span>
							<strong class="es-contact-card-val"><?php echo esc_html( erfan_sanat_persian_digits( $hours ) ); ?></strong>
						</div>
					</div>

					<div class="es-contact-info-card">
						<span class="es-contact-card-icon"><?php echo erfan_sanat_icon( 'location' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<div>
							<span class="es-contact-card-label"><?php esc_html_e( 'نشانی کارخانه:', 'erfan-sanat' ); ?></span>
							<p class="es-contact-card-address">
								<?php echo esc_html( erfan_sanat_persian_digits( $address ) ); ?> | <?php esc_html_e( 'کدپستی:', 'erfan-sanat' ); ?> <?php echo esc_html( erfan_sanat_persian_digits( $postal ) ); ?>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="es-consultation-form-box">
				<h3><?php esc_html_e( 'درخواست پیش‌فاکتور رسمی و مشاوره فنی پروژه', 'erfan-sanat' ); ?></h3>
				<p><?php esc_html_e( 'ویژه شهرداری‌ها، دهیاری‌ها، سازمان‌های عمرانی و پیمانکاران پروژه‌های نورپردازی شهری.', 'erfan-sanat' ); ?></p>

				<?php if ( 'sent' === $inquiry_state ) : ?>
					<div class="es-alert es-alert-success" role="alert">
						<?php echo erfan_sanat_icon( 'check', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php esc_html_e( 'درخواست شما با موفقیت ثبت شد. کارشناسان فروش عرفان صنعت در اسرع وقت با شما تماس خواهند گرفت.', 'erfan-sanat' ); ?></span>
					</div>
				<?php elseif ( 'invalid' === $inquiry_state ) : ?>
					<div class="es-alert es-alert-error" role="alert">
						<span><?php esc_html_e( 'لطفاً نام و شماره تماس معتبر خود را وارد نمایید.', 'erfan-sanat' ); ?></span>
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-inquiry-form">
					<?php wp_nonce_field( 'erfan_sanat_consultation_submit', 'es_consultation_nonce' ); ?>
					<input type="hidden" name="es_action" value="submit_consultation" />
					<div class="screen-reader-text" aria-hidden="true">
						<label for="es_website_hp">Website</label>
						<input type="text" id="es_website_hp" name="es_website_hp" value="" tabindex="-1" autocomplete="off" />
					</div>

					<div class="es-form-row-2">
						<div class="es-form-group">
							<label for="es_full_name"><?php esc_html_e( 'نام و نام خانوادگی *', 'erfan-sanat' ); ?></label>
							<input type="text" id="es_full_name" name="es_full_name" required placeholder="<?php esc_attr_e( 'مثلاً: مهندس رضایی', 'erfan-sanat' ); ?>" />
						</div>
						<div class="es-form-group">
							<label for="es_phone"><?php esc_html_e( 'شماره تماس مستقیم *', 'erfan-sanat' ); ?></label>
							<input type="tel" id="es_phone" name="es_phone" required dir="ltr" placeholder="0913..." />
						</div>
					</div>

					<div class="es-form-row-2">
						<div class="es-form-group">
							<label for="es_organization"><?php esc_html_e( 'سازمان / شهرداری / شرکت', 'erfan-sanat' ); ?></label>
							<input type="text" id="es_organization" name="es_organization" placeholder="<?php esc_attr_e( 'شهرداری / شرکت عمرانی...', 'erfan-sanat' ); ?>" />
						</div>
						<div class="es-form-group">
							<label for="es_province"><?php esc_html_e( 'استان محل پروژه', 'erfan-sanat' ); ?></label>
							<select id="es_province" name="es_province">
								<?php foreach ( $provinces as $prov ) : ?>
									<option value="<?php echo esc_attr( $prov ); ?>"><?php echo esc_html( $prov ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="es-form-group">
						<label for="es_inquiry_type"><?php esc_html_e( 'نوع درخواست', 'erfan-sanat' ); ?></label>
						<select id="es_inquiry_type" name="es_inquiry_type">
							<option value="proforma"><?php esc_html_e( 'صدور پیش‌فاکتور رسمی جهت خرید سازمانی / مناقصه', 'erfan-sanat' ); ?></option>
							<option value="custom_design"><?php esc_html_e( 'طراحی و ساخت سفارشی المان / تونل نوری', 'erfan-sanat' ); ?></option>
							<option value="bulk_strings"><?php esc_html_e( 'خرید عمده ریسه‌های بلوطی، فندقی و سوزنی', 'erfan-sanat' ); ?></option>
							<option value="technical_support"><?php esc_html_e( 'مشاوره فنی، نصب و راه‌اندازی کنترلرها', 'erfan-sanat' ); ?></option>
						</select>
					</div>

					<div class="es-form-group">
						<label for="es_message"><?php esc_html_e( 'توضیحات پروژه (متراژ، تعداد یا مدل مدنظر)', 'erfan-sanat' ); ?></label>
						<textarea id="es_message" name="es_message" rows="3" placeholder="<?php esc_attr_e( 'ابعاد معبر، تعداد پایه چراغ یا مشخصات پروژه خود را بنویسید...', 'erfan-sanat' ); ?>"></textarea>
					</div>

					<button type="submit" class="es-btn es-btn-primary es-btn-block es-btn-lg">
						<span><?php esc_html_e( 'ثبت درخواست مشاوره و پیش‌فاکتور', 'erfan-sanat' ); ?></span>
						<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				</form>
			</div>
		</div>
	</div>
</section>
