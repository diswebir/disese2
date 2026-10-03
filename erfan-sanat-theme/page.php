<?php
/**
 * Standard Page & Storefront Cart/Checkout/Account State Template (`page.php`)
 *
 * Automatically routes core slugs (`contact`, `about`, `projects`, `products`, `blog`, `cart`, `checkout`)
 * to their rich layouts even when no custom page template is manually assigned.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$queried_id   = get_queried_object_id();
$queried_slug = $queried_id ? (string) get_post_field( 'post_name', $queried_id ) : '';
$decoded_slug = rawurldecode( $queried_slug );

if ( in_array( $decoded_slug, array( 'about', 'about-us', 'درباره-ما' ), true ) ) {
	get_template_part( 'templates/template-about' );
	return;
}

if ( in_array( $decoded_slug, array( 'contact', 'contact-us', 'تماس-با-ما' ), true ) ) {
	get_template_part( 'templates/template-contact' );
	return;
}

if ( in_array( $decoded_slug, array( 'projects', 'project', 'پروژه-ها' ), true ) ) {
	get_template_part( 'templates/template-projects' );
	return;
}

if ( in_array( $decoded_slug, array( 'products', 'shop', 'فروشگاه' ), true ) && ! class_exists( 'WooCommerce' ) ) {
	get_template_part( 'templates/template-products' );
	return;
}

if ( in_array( $decoded_slug, array( 'blog', 'وبلاگ' ), true ) ) {
	get_template_part( 'templates/template-blog' );
	return;
}

get_header();

while ( have_posts() ) :
	the_post();
	$slug         = (string) get_post_field( 'post_name', get_the_ID() );
	$decoded_post = rawurldecode( $slug );
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

	<?php if ( in_array( $decoded_post, array( 'about', 'about-us', 'درباره-ما' ), true ) ) : ?>
		<?php get_template_part( 'template-parts/home/about-section' ); ?>
		<?php get_template_part( 'template-parts/home/why-us-process' ); ?>
		<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>
	<?php endif; ?>
	<?php
endwhile;

get_footer();
