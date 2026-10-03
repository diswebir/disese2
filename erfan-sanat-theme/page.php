<?php
/**
 * Standard Page & Storefront Cart/Checkout/Account State Template (`page.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$slug = get_post_field( 'post_name', get_the_ID() );
	?>
	<section class="es-page-hero">
		<div class="es-container">
			<span class="es-section-eyebrow"><?php echo esc_html( (string) es_opt( 'company_legal_name', 'شرکت دانش‌بنیان عرفان صنعت اصفهان' ) ); ?></span>
			<h1 class="es-page-title"><?php the_title(); ?></h1>
		</div>
	</section>

	<section class="es-section">
		<div class="es-container">
			<?php if ( 'cart' === $slug && ! class_exists( 'WooCommerce' ) ) : ?>
				<?php
				$cart_items = erfan_sanat_get_native_cart_items();
				?>
				<div class="es-wc-state-card">
					<?php if ( empty( $cart_items ) ) : ?>
						<?php
						get_template_part(
							'template-parts/global/empty-state',
							null,
							array(
								'title'   => __( 'سبد خرید شما در حال حاضر خالی است', 'erfan-sanat' ),
								'message' => __( 'می‌توانید محصولات قابل خرید آنلاین را از فروشگاه انتخاب و به سبد خرید اضافه نمایید.', 'erfan-sanat' ),
							)
						);
						?>
					<?php else : ?>
						<table class="es-specs-table es-cart-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'محصول', 'erfan-sanat' ); ?></th>
									<th><?php esc_html_e( 'تعداد', 'erfan-sanat' ); ?></th>
									<th><?php esc_html_e( 'قیمت واحد', 'erfan-sanat' ); ?></th>
									<th><?php esc_html_e( 'مجموع', 'erfan-sanat' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$grand_total = 0;
								foreach ( $cart_items as $pid => $qty ) :
									$pdata    = erfan_sanat_get_product_purchase_data( (int) $pid );
									$unit_val = is_numeric( $pdata['regular_price'] ) ? (float) $pdata['regular_price'] : 0;
									$sub      = $unit_val * $qty;
									$grand_total += $sub;
									?>
									<tr>
										<td><a href="<?php echo esc_url( (string) get_permalink( $pid ) ); ?>"><?php echo esc_html( get_the_title( $pid ) ); ?></a></td>
										<td><?php echo esc_html( erfan_sanat_persian_digits( $qty ) ); ?></td>
										<td><?php echo esc_html( erfan_sanat_format_toman( $unit_val ) ); ?></td>
										<td><strong><?php echo esc_html( erfan_sanat_format_toman( $sub ) ); ?></strong></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div class="es-cart-summary-bar">
							<strong><?php esc_html_e( 'جمع کل سفارش:', 'erfan-sanat' ); ?> <?php echo esc_html( erfan_sanat_format_toman( $grand_total ) ); ?></strong>
							<a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>" class="es-btn es-btn-primary">
								<?php esc_html_e( 'ادامه جهت تسویه حساب و صدور فاکتور', 'erfan-sanat' ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php elseif ( 'checkout' === $slug && ! class_exists( 'WooCommerce' ) ) : ?>
				<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>
			<?php else : ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'es-entry-content-card' ); ?>>
					<div class="es-prose">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endif; ?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
