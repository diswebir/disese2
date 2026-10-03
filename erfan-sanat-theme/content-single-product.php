<?php
/**
 * WooCommerce Single Product Content (`content-single-product.php`)
 *
 * Renders the product gallery, custom purchase/inquiry/tender box,
 * technical attributes table, wiring schematic, and product inquiry form.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id    = (int) get_the_ID();
$img_url       = erfan_sanat_get_post_image_url( $product_id, 'product' );
$purchase_data = erfan_sanat_get_product_purchase_data( $product_id );
$attrs_summary = erfan_sanat_get_product_attributes_summary( $product_id );
$terms         = get_the_terms( $product_id, 'product_cat' );
$added_to_cart = isset( $_REQUEST['add-to-cart'] ) && absint( $_REQUEST['add-to-cart'] ) === $product_id;
?>
<article id="product-<?php the_ID(); ?>" <?php post_class( 'es-single-product-article' ); ?>>
	<div class="es-container">
		<?php if ( $added_to_cart ) : ?>
			<div class="es-alert es-alert-success" role="alert">
				<?php echo erfan_sanat_icon( 'check', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span>
					<?php esc_html_e( 'محصول با موفقیت به سبد خرید شما اضافه شد.', 'erfan-sanat' ); ?>
					<a href="<?php echo esc_url( home_url( '/cart/' ) ); ?>" class="es-alert-link"><?php esc_html_e( 'مشاهده سبد خرید', 'erfan-sanat' ); ?></a>
				</span>
			</div>
		<?php endif; ?>

		<div class="es-product-top-grid">
			<div class="es-product-gallery-col">
				<div class="es-product-main-figure">
					<img
						src="<?php echo esc_url( $img_url ); ?>"
						alt="<?php echo esc_attr( get_the_title() ); ?>"
						id="es-main-product-img"
						width="800"
						height="600"
					/>
					<span class="es-badge es-badge-warranty">
						<?php esc_html_e( '۲۴ ماه گارانتی', 'erfan-sanat' ); ?>
					</span>
				</div>

				<div class="es-product-thumbs-row">
					<button type="button" class="es-product-thumb is-active" data-full-src="<?php echo esc_url( $img_url ); ?>">
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="120" height="90" />
					</button>
					<button type="button" class="es-product-thumb" data-full-src="<?php echo esc_url( $purchase_data['schematic_url'] ); ?>">
						<img src="<?php echo esc_url( $purchase_data['schematic_url'] ); ?>" alt="<?php esc_attr_e( 'نقشه فنی و سیم‌کشی', 'erfan-sanat' ); ?>" width="120" height="90" />
					</button>
				</div>
			</div>

			<div class="es-product-summary-col">
				<?php if ( is_array( $terms ) && ! empty( $terms ) ) : ?>
					<div class="es-product-cats-row">
						<?php foreach ( $terms as $t ) : ?>
							<a href="<?php echo esc_url( (string) get_term_link( $t ) ); ?>" class="es-pill es-pill-gold">
								<?php echo esc_html( $t->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<h1 class="es-product-single-title"><?php the_title(); ?></h1>

				<?php if ( has_excerpt() ) : ?>
					<div class="es-product-short-desc">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $attrs_summary ) ) : ?>
					<div class="es-quick-specs-box">
						<h4><?php esc_html_e( 'مشخصات کلیدی محصول:', 'erfan-sanat' ); ?></h4>
						<ul class="es-quick-specs-list">
							<?php foreach ( $attrs_summary as $attr_row ) : ?>
								<li>
									<span><?php echo esc_html( $attr_row['label'] ); ?>:</span>
									<strong><?php echo esc_html( implode( ' ، ', $attr_row['values'] ) ); ?></strong>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php get_template_part( 'template-parts/product/purchase-box', null, array( 'post_id' => $product_id ) ); ?>
			</div>
		</div>

		<?php get_template_part( 'template-parts/product/technical-specs', null, array( 'post_id' => $product_id ) ); ?>

		<section class="es-product-description-section">
			<h2><?php esc_html_e( 'بررسی تخصصی و توضیحات فنی محصول', 'erfan-sanat' ); ?></h2>
			<div class="es-prose">
				<?php the_content(); ?>
			</div>
		</section>

		<div id="product-inquiry-form">
			<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>
		</div>
	</div>
</article>
