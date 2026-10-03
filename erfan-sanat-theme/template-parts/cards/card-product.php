<?php
/**
 * Reusable Product Card Component
 *
 * Respects `_es_is_purchasable_online`, `_es_order_type`, `_es_custom_price_badge`,
 * and displays global engineering attributes (`pa_*`).
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id    = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$purchase_data = erfan_sanat_get_product_purchase_data( $product_id );
$attrs_summary = erfan_sanat_get_product_attributes_summary( $product_id );
$img_url       = erfan_sanat_get_post_image_url( $product_id, 'product' );
$permalink     = (string) get_permalink( $product_id );
$title         = get_the_title( $product_id );
$terms         = get_the_terms( $product_id, 'product_cat' );
$primary_cat   = ( is_array( $terms ) && ! empty( $terms ) ) ? reset( $terms ) : null;
?>
<article id="product-card-<?php echo esc_attr( (string) $product_id ); ?>" class="es-card es-product-card" data-order-type="<?php echo esc_attr( $purchase_data['order_type'] ); ?>">
	<a href="<?php echo esc_url( $permalink ); ?>" class="es-card-media" aria-label="<?php echo esc_attr( $title ); ?>">
		<img
			src="<?php echo esc_url( $img_url ); ?>"
			alt="<?php echo esc_attr( $title ); ?>"
			loading="lazy"
			decoding="async"
			width="640"
			height="480"
		/>
		<div class="es-card-badges-top">
			<?php if ( $purchase_data['is_purchasable'] ) : ?>
				<span class="es-badge es-badge-online">
					<?php esc_html_e( '🛒 قابل خرید آنلاین', 'erfan-sanat' ); ?>
				</span>
			<?php elseif ( 'official_tender' === $purchase_data['order_type'] ) : ?>
				<span class="es-badge es-badge-tender">
					<?php esc_html_e( 'پروژه‌ای / مناقصه رسمی', 'erfan-sanat' ); ?>
				</span>
			<?php else : ?>
				<span class="es-badge es-badge-inquiry">
					<?php esc_html_e( 'استعلام قیمت روز', 'erfan-sanat' ); ?>
				</span>
			<?php endif; ?>
		</div>
	</a>

	<div class="es-card-body">
		<?php if ( $primary_cat instanceof WP_Term ) : ?>
			<div class="es-card-category">
				<a href="<?php echo esc_url( (string) get_term_link( $primary_cat ) ); ?>">
					<?php echo esc_html( $primary_cat->name ); ?>
				</a>
			</div>
		<?php endif; ?>

		<h3 class="es-card-title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h3>

		<?php if ( es_opt( 'products_show_tech_badges', true ) ) : ?>
			<div class="es-tech-pills">
				<?php
				$pill_count = 0;
				foreach ( array( 'pa_ip_rating', 'pa_voltage', 'pa_control_protocol', 'pa_light_color' ) as $tax_k ) :
					if ( ! empty( $attrs_summary[ $tax_k ]['values'][0] ) && $pill_count < 3 ) :
						++$pill_count;
						?>
						<span class="es-tech-pill"><?php echo esc_html( $attrs_summary[ $tax_k ]['values'][0] ); ?></span>
						<?php
					endif;
				endforeach;
				if ( 0 === $pill_count && ! empty( $purchase_data['chip_brand'] ) ) :
					?>
					<span class="es-tech-pill"><?php echo esc_html( $purchase_data['chip_brand'] ); ?></span>
					<span class="es-tech-pill">IP67</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="es-card-footer">
			<div class="es-card-price-wrap">
				<span class="es-card-price-val">
					<?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['price_label'] ) ); ?>
				</span>
			</div>

			<div class="es-card-cta">
				<?php if ( $purchase_data['is_purchasable'] ) : ?>
					<a href="<?php echo esc_url( $permalink ); ?>" class="es-btn es-btn-sm es-btn-primary">
						<?php esc_html_e( 'خرید آنلاین', 'erfan-sanat' ); ?>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( $permalink ); ?>" class="es-btn es-btn-sm es-btn-outline">
						<?php esc_html_e( 'مشخصات و استعلام', 'erfan-sanat' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>
