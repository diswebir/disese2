<?php
/**
 * Single Product Purchase / Inquiry / Official Tender Box
 *
 * Implements the three Erfan Sanat ordering modes:
 * 1. `online_cart` (when `_es_is_purchasable_online` is true) -> Quantity + Add to Cart
 * 2. `phone_inquiry` -> Direct sales engineer call CTA + configured `_es_inquiry_phone`
 * 3. `official_tender` -> Municipality/Contractor tender & proforma invoice CTA
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id    = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$purchase_data = erfan_sanat_get_product_purchase_data( $product_id );
$warranty_text = (string) es_opt( 'wc_warranty_badge_text', '۲۴ ماه گارانتی تعویض + ۵ سال خدمات پس از فروش' );
$tender_label  = (string) es_opt( 'wc_tender_cta_label', 'درخواست پیش‌فاکتور رسمی و شرایط مناقصه' );
$tel_clean     = preg_replace( '/[^0-9+]/', '', $purchase_data['inquiry_phone'] );
?>
<div class="es-product-purchase-card" data-order-mode="<?php echo esc_attr( $purchase_data['order_type'] ); ?>">
	<div class="es-purchase-warranty-strip">
		<?php echo erfan_sanat_icon( 'shield', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<span><?php echo esc_html( $warranty_text ); ?></span>
	</div>

	<div class="es-purchase-price-header">
		<span class="es-purchase-price-caption"><?php esc_html_e( 'وضعیت قیمت و فروش:', 'erfan-sanat' ); ?></span>
		<strong class="es-purchase-price-main">
			<?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['price_label'] ) ); ?>
		</strong>
	</div>

	<ul class="es-purchase-logistics-meta">
		<li>
			<span><?php esc_html_e( 'حداقل تعداد سفارش:', 'erfan-sanat' ); ?></span>
			<strong><?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['min_qty'] ) . ' ' . __( 'عدد / واحد', 'erfan-sanat' ) ); ?></strong>
		</li>
		<li>
			<span><?php esc_html_e( 'زمان تحویل و آماده‌سازی:', 'erfan-sanat' ); ?></span>
			<strong><?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['lead_time'] ) ); ?></strong>
		</li>
		<?php if ( ! empty( $purchase_data['chip_brand'] ) ) : ?>
			<li>
				<span><?php esc_html_e( 'برند چیپ ال‌ای‌دی:', 'erfan-sanat' ); ?></span>
				<strong><?php echo esc_html( $purchase_data['chip_brand'] ); ?></strong>
			</li>
		<?php endif; ?>
	</ul>

	<?php if ( $purchase_data['is_purchasable'] && 'online_cart' === $purchase_data['order_type'] ) : ?>
		<form class="es-cart-form cart" method="post" enctype="multipart/form-data">
			<div class="es-qty-cart-row">
				<div class="es-qty-control">
					<label for="es-qty-<?php echo esc_attr( (string) $product_id ); ?>" class="screen-reader-text">
						<?php esc_html_e( 'تعداد سفارش', 'erfan-sanat' ); ?>
					</label>
					<button type="button" class="es-qty-btn" data-qty-step="-1" aria-label="<?php esc_attr_e( 'کاهش تعداد', 'erfan-sanat' ); ?>">-</button>
					<input
						type="number"
						id="es-qty-<?php echo esc_attr( (string) $product_id ); ?>"
						name="quantity"
						value="<?php echo esc_attr( (string) $purchase_data['min_qty'] ); ?>"
						min="<?php echo esc_attr( (string) $purchase_data['min_qty'] ); ?>"
						step="1"
						class="es-qty-input"
					/>
					<button type="button" class="es-qty-btn" data-qty-step="1" aria-label="<?php esc_attr_e( 'افزایش تعداد', 'erfan-sanat' ); ?>">+</button>
				</div>

				<button type="submit" name="add-to-cart" value="<?php echo esc_attr( (string) $product_id ); ?>" class="es-btn es-btn-primary es-btn-lg es-add-to-cart-btn">
					<?php echo erfan_sanat_icon( 'cart', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'افزودن به سبد خرید', 'erfan-sanat' ); ?></span>
				</button>
			</div>
		</form>
		<p class="es-bulk-note">
			<?php esc_html_e( 'در صورت نیاز به خرید عمده یا متراژ سفارشی، با واحد فروش کارخانه تماس بگیرید:', 'erfan-sanat' ); ?>
			<a href="tel:<?php echo esc_attr( (string) $tel_clean ); ?>" dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['inquiry_phone'] ) ); ?></a>
		</p>

	<?php elseif ( 'official_tender' === $purchase_data['order_type'] ) : ?>
		<div class="es-tender-cta-box">
			<p class="es-tender-notice">
				<?php esc_html_e( 'این محصول سازه‌ای / پروژه‌ای بوده و بر اساس ابعاد معبر، ارتفاع پایه و الزامات مناقصه شهرداری‌ها تولید و قیمت‌گذاری می‌شود.', 'erfan-sanat' ); ?>
			</p>
			<a href="#product-inquiry-form" class="es-btn es-btn-primary es-btn-block es-btn-lg">
				<span><?php echo esc_html( $tender_label ); ?></span>
				<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
			<a href="tel:<?php echo esc_attr( (string) $tel_clean ); ?>" class="es-btn es-btn-outline es-btn-block">
				<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'تماس با واحد مناقصات:', 'erfan-sanat' ); ?> <strong dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['inquiry_phone'] ) ); ?></strong></span>
			</a>
		</div>

	<?php else : ?>
		<div class="es-phone-inquiry-box">
			<p class="es-inquiry-notice">
				<?php esc_html_e( 'جهت دریافت قیمت روز کارخانه، مشاوره فنی رایگان و صدور پیش‌فاکتور رسمی با کارشناسان فروش تماس بگیرید.', 'erfan-sanat' ); ?>
			</p>
			<a href="tel:<?php echo esc_attr( (string) $tel_clean ); ?>" class="es-btn es-btn-primary es-btn-block es-btn-lg">
				<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'استعلام تلفنی قیمت:', 'erfan-sanat' ); ?> <strong dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['inquiry_phone'] ) ); ?></strong></span>
			</a>
			<a href="#product-inquiry-form" class="es-btn es-btn-outline es-btn-block">
				<span><?php esc_html_e( 'ثبت آنلاین درخواست پیش‌فاکتور', 'erfan-sanat' ); ?></span>
			</a>
		</div>
	<?php endif; ?>

	<div class="es-product-docs-bar">
		<?php if ( ! empty( $purchase_data['datasheet_url'] ) ) : ?>
			<a href="<?php echo esc_url( $purchase_data['datasheet_url'] ); ?>" class="es-doc-btn" download>
				<?php echo erfan_sanat_icon( 'download', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'دانلود دیتاشیت فنی (PDF)', 'erfan-sanat' ); ?></span>
			</a>
		<?php endif; ?>
		<a href="#product-specs-section" class="es-doc-btn">
			<?php echo erfan_sanat_icon( 'spark', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span><?php esc_html_e( 'مشاهده نقشه سیم‌کشی و جدول مشخصات', 'erfan-sanat' ); ?></span>
		</a>
	</div>
</div>
