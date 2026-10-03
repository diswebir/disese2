<?php
/**
 * Homepage Section 5: Popular Products Showcase + Dynamic WooCommerce Storefront Grid
 *
 * Reproduces the Arena reference 5 flagship product showcases
 * (درختان نوری هوشمند، خورشیدنما، لوستر فضای باز، ریسه‌های LED، پوینت لایت پیکسل)
 * plus live WooCommerce product cards and custom manufacturing CTA.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = erfan_sanat_get_page_url( 'shop' );

$flagship_families = array(
	array(
		'title'  => 'درختان نوری هوشمند',
		'models' => array( 'دلسا', 'آرتام', 'آتریسا', 'ایلومینا' ),
		'specs'  => array( '۱۶ میلیون رنگ', 'کنترل با اپلیکیشن', 'پیکسل RGB' ),
		'image'  => ES_THEME_URI . 'assets/images/light-tree.jpg',
		'url'    => erfan_sanat_get_term_url( 'light-trees', 'product_cat', $shop_url ),
		'badge'  => 'هوشمند NRF',
	),
	array(
		'title'  => 'خورشید‌نما',
		'models' => array( '۳۲ پره', '۴۸ پره' ),
		'specs'  => array( 'قطر تا ۳.۳ متری', 'پروتکل NRF', '+۲۳۰۰ پیکسل' ),
		'image'  => ES_THEME_URI . 'assets/images/sun-light.jpg',
		'url'    => erfan_sanat_get_term_url( 'square-elements', 'product_cat', $shop_url ),
		'badge'  => 'مجهز به ساعت نجومی',
	),
	array(
		'title'  => 'لوستر فضای باز',
		'models' => array( 'فروغ', 'شمسه' ),
		'specs'  => array( 'ارتفاع تا ۷ متر', 'ریسه سوزنی LED', 'IP67' ),
		'image'  => ES_THEME_URI . 'assets/images/chandelier.jpg',
		'url'    => erfan_sanat_get_term_url( 'urban-chandeliers', 'product_cat', $shop_url ),
		'badge'  => 'المان بلوار و میدان',
	),
	array(
		'title'  => 'ریسه‌های LED',
		'models' => array( 'فندقی', 'بلوطی', 'سوزنی', 'فلکسی' ),
		'specs'  => array( 'ضدضربه پلی‌کربنات', 'IP67', 'از ۱,۲۰۰,۰۰۰ تومان' ),
		'image'  => ES_THEME_URI . 'assets/images/string-lights.jpg',
		'url'    => erfan_sanat_get_term_url( 'decorative-light-strings', 'product_cat', $shop_url ),
		'badge'  => '🛒 قابل خرید آنلاین',
	),
	array(
		'title'  => 'پوینت لایت پیکسل',
		'models' => array( 'LED ۴ سانتی‌متری' ),
		'specs'  => array( 'فول‌کالر هوشمند', 'قاب نگهدارنده PLT', 'IP68' ),
		'image'  => ES_THEME_URI . 'assets/images/point-light.jpg',
		'url'    => erfan_sanat_get_term_url( 'pixel-point-lights', 'product_cat', $shop_url ),
		'badge'  => '🛒 قابل خرید آنلاین',
	),
);

$products_query = new WP_Query(
	array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'no_found_rows'  => true,
	)
);
?>
<section id="products" class="es-section es-products-section">
	<div class="es-container">
		<div class="es-section-header">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'محبوب‌ترین تولیدات شرکت', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php esc_html_e( 'برخی از محصولات عرفان صنعت', 'erfan-sanat' ); ?></h2>
				<p class="es-section-subtitle">
					<?php esc_html_e( 'با بهره‌گیری از به‌روزترین تجهیزات و کارشناسان متخصص، مجموعه‌ای بی‌نظیر از محصولات نورپردازی پیشرفته را عرضه می‌کنیم؛ روشنایی را به شهر خود دعوت کنید.', 'erfan-sanat' ); ?>
				</p>
			</div>
			<div class="es-smart-control-pill">
				<?php echo erfan_sanat_icon( 'wifi', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div>
					<strong><?php esc_html_e( 'کنترل هوشمند', 'erfan-sanat' ); ?></strong>
					<span><?php esc_html_e( 'WiFi و پروتکل NRF در تمامی محصولات', 'erfan-sanat' ); ?></span>
				</div>
			</div>
		</div>

		<div class="es-family-showcase-grid">
			<?php foreach ( $flagship_families as $fam ) : ?>
				<a href="<?php echo esc_url( $fam['url'] ); ?>" class="es-family-card">
					<div class="es-family-media">
						<img src="<?php echo esc_url( $fam['image'] ); ?>" alt="<?php echo esc_attr( $fam['title'] ); ?>" loading="lazy" width="640" height="480" />
						<?php if ( '' !== $fam['badge'] ) : ?>
							<span class="es-badge <?php echo str_contains( $fam['badge'], 'خرید' ) ? 'es-badge-online' : 'es-badge-inquiry'; ?>">
								<?php echo esc_html( $fam['badge'] ); ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="es-family-body">
						<h3 class="es-family-title"><?php echo esc_html( $fam['title'] ); ?></h3>
						<div class="es-family-models">
							<?php foreach ( $fam['models'] as $m ) : ?>
								<span class="es-model-chip"><?php echo esc_html( $m ); ?></span>
							<?php endforeach; ?>
						</div>
						<div class="es-family-specs">
							<?php foreach ( $fam['specs'] as $s ) : ?>
								<span class="es-spec-tag"><?php echo esc_html( $s ); ?></span>
							<?php endforeach; ?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<?php if ( $products_query->have_posts() ) : ?>
			<div class="es-storefront-preview">
				<div class="es-subsection-head-flex">
					<h3 class="es-subsection-heading"><?php esc_html_e( 'فروشگاه آنلاین و استعلام قیمت تجهیزات نورپردازی', 'erfan-sanat' ); ?></h3>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="es-btn es-btn-outline es-btn-sm">
						<span><?php esc_html_e( 'مشاهده همه محصولات فروشگاه', 'erfan-sanat' ); ?></span>
						<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
				<div class="es-cards-grid es-grid-3">
					<?php
					while ( $products_query->have_posts() ) :
						$products_query->the_post();
						get_template_part(
							'template-parts/cards/card-product',
							null,
							array( 'post_id' => get_the_ID() )
						);
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<?php get_template_part( 'template-parts/global/cta-banner' ); ?>
</section>
