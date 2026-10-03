<?php
/**
 * Product Archive Technical Filter Sidebar
 *
 * Filters products by:
 * - Order mode (`order_type`: online_cart, phone_inquiry, official_tender)
 * - Hierarchical `product_cat`
 * - Global attributes (`pa_voltage`, `pa_ip_rating`, `pa_control_protocol`)
 * - Municipality Proforma CTA card
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$action_url     = is_tax( 'product_cat' ) ? (string) get_term_link( get_queried_object() ) : home_url( '/shop/' );
$cur_order_type = isset( $_GET['order_type'] ) ? sanitize_key( wp_unslash( $_GET['order_type'] ) ) : '';
$cur_cat        = isset( $_GET['product_cat'] ) ? sanitize_key( wp_unslash( $_GET['product_cat'] ) ) : '';
$cur_voltage    = isset( $_GET['pa_voltage'] ) ? sanitize_key( wp_unslash( $_GET['pa_voltage'] ) ) : '';
$cur_ip         = isset( $_GET['pa_ip_rating'] ) ? sanitize_key( wp_unslash( $_GET['pa_ip_rating'] ) ) : '';
$cur_protocol   = isset( $_GET['pa_control_protocol'] ) ? sanitize_key( wp_unslash( $_GET['pa_control_protocol'] ) ) : '';
$cur_orderby    = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : '';

$attrs_blueprint = erfan_sanat_get_global_attributes_blueprint();
$cats_blueprint  = erfan_sanat_get_product_categories_blueprint();
?>
<aside class="es-shop-sidebar" aria-label="<?php esc_attr_e( 'فیلتر فنی محصولات', 'erfan-sanat' ); ?>">
	<form method="get" action="<?php echo esc_url( $action_url ); ?>" class="es-filter-card">
		<div class="es-filter-head">
			<h3><?php esc_html_e( 'فیلتر مهندسی محصولات', 'erfan-sanat' ); ?></h3>
			<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="es-reset-filters-link">
				<?php esc_html_e( 'حذف فیلترها', 'erfan-sanat' ); ?>
			</a>
		</div>

		<div class="es-filter-group">
			<label for="es-filter-orderby" class="es-filter-title"><?php esc_html_e( 'مرتب‌سازی بر اساس', 'erfan-sanat' ); ?></label>
			<select id="es-filter-orderby" name="orderby" class="es-filter-select">
				<option value="date" <?php selected( $cur_orderby, 'date' ); ?>><?php esc_html_e( 'جدیدترین محصولات', 'erfan-sanat' ); ?></option>
				<option value="price-asc" <?php selected( $cur_orderby, 'price-asc' ); ?>><?php esc_html_e( 'ارزان‌ترین به گران‌ترین', 'erfan-sanat' ); ?></option>
				<option value="price-desc" <?php selected( $cur_orderby, 'price-desc' ); ?>><?php esc_html_e( 'گران‌ترین به ارزان‌ترین', 'erfan-sanat' ); ?></option>
			</select>
		</div>

		<div class="es-filter-group">
			<span class="es-filter-title"><?php esc_html_e( 'وضعیت خرید و سفارش', 'erfan-sanat' ); ?></span>
			<div class="es-radio-stack">
				<label>
					<input type="radio" name="order_type" value="" <?php checked( '', $cur_order_type ); ?> />
					<span><?php esc_html_e( 'همه محصولات', 'erfan-sanat' ); ?></span>
				</label>
				<label>
					<input type="radio" name="order_type" value="online_cart" <?php checked( 'online_cart', $cur_order_type ); ?> />
					<span><?php esc_html_e( '🛒 قابل خرید آنلاین', 'erfan-sanat' ); ?></span>
				</label>
				<label>
					<input type="radio" name="order_type" value="phone_inquiry" <?php checked( 'phone_inquiry', $cur_order_type ); ?> />
					<span><?php esc_html_e( 'نیازمند استعلام تلفنی قیمت', 'erfan-sanat' ); ?></span>
				</label>
				<label>
					<input type="radio" name="order_type" value="official_tender" <?php checked( 'official_tender', $cur_order_type ); ?> />
					<span><?php esc_html_e( 'پروژه‌ای / مناقصه رسمی', 'erfan-sanat' ); ?></span>
				</label>
			</div>
		</div>

		<?php if ( ! is_tax( 'product_cat' ) ) : ?>
			<div class="es-filter-group">
				<label for="es-filter-cat" class="es-filter-title"><?php esc_html_e( 'دسته‌بندی تجهیزات', 'erfan-sanat' ); ?></label>
				<select id="es-filter-cat" name="product_cat" class="es-filter-select">
					<option value=""><?php esc_html_e( 'همه دسته‌بندی‌ها', 'erfan-sanat' ); ?></option>
					<?php foreach ( $cats_blueprint as $parent_slug => $parent_info ) : ?>
						<option value="<?php echo esc_attr( $parent_slug ); ?>" <?php selected( $cur_cat, $parent_slug ); ?>>
							<?php echo esc_html( $parent_info['name'] ); ?>
						</option>
						<?php foreach ( $parent_info['children'] as $child_slug => $child_name ) : ?>
							<option value="<?php echo esc_attr( $child_slug ); ?>" <?php selected( $cur_cat, $child_slug ); ?>>
								&nbsp;&nbsp;— <?php echo esc_html( $child_name ); ?>
							</option>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>

		<div class="es-filter-group">
			<label for="es-filter-voltage" class="es-filter-title"><?php esc_html_e( 'ولتاژ ورودی (Voltage)', 'erfan-sanat' ); ?></label>
			<select id="es-filter-voltage" name="pa_voltage" class="es-filter-select">
				<option value=""><?php esc_html_e( 'همه ولتاژها', 'erfan-sanat' ); ?></option>
				<?php foreach ( $attrs_blueprint['pa_voltage']['terms'] as $slug => $label ) : ?>
					<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $cur_voltage, $slug ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="es-filter-group">
			<label for="es-filter-ip" class="es-filter-title"><?php esc_html_e( 'درجه حفاظت (IP Rating)', 'erfan-sanat' ); ?></label>
			<select id="es-filter-ip" name="pa_ip_rating" class="es-filter-select">
				<option value=""><?php esc_html_e( 'همه درجات حفاظت', 'erfan-sanat' ); ?></option>
				<?php foreach ( $attrs_blueprint['pa_ip_rating']['terms'] as $slug => $label ) : ?>
					<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $cur_ip, $slug ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="es-filter-group">
			<label for="es-filter-protocol" class="es-filter-title"><?php esc_html_e( 'پروتکل کنترل هوشمند', 'erfan-sanat' ); ?></label>
			<select id="es-filter-protocol" name="pa_control_protocol" class="es-filter-select">
				<option value=""><?php esc_html_e( 'همه پروتکل‌ها', 'erfan-sanat' ); ?></option>
				<?php foreach ( $attrs_blueprint['pa_control_protocol']['terms'] as $slug => $label ) : ?>
					<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $cur_protocol, $slug ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="es-btn es-btn-primary es-btn-block">
			<?php esc_html_e( 'اعمال فیلترهای فنی', 'erfan-sanat' ); ?>
		</button>
	</form>

	<div class="es-municipality-promo-card">
		<span class="es-pill es-pill-gold"><?php esc_html_e( 'ویژه شهرداری‌ها و پیمانکاران', 'erfan-sanat' ); ?></span>
		<h4><?php esc_html_e( 'درخواست پیش‌فاکتور رسمی برای پروژه', 'erfan-sanat' ); ?></h4>
		<p><?php esc_html_e( 'با ثبت دقیق جزئیات پروژه (ارتفاع پایه، عرض معبر و کلاس نوری)، اقتصادی‌ترین و مهندسی‌شده‌ترین راهکار را دریافت نمایید.', 'erfan-sanat' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/#consultation' ) ); ?>" class="es-btn es-btn-outline es-btn-block">
			<?php esc_html_e( 'درخواست پیش‌فاکتور پروژه', 'erfan-sanat' ); ?>
		</a>
	</div>
</aside>
