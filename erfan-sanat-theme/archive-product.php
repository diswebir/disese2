<?php
/**
 * WooCommerce Product Archive / Shop Template (`archive-product.php`)
 *
 * Reproduces the Erfan Sanat industrial lighting storefront with quick category access,
 * PDF catalog download, technical attribute filter sidebar, and proforma request section.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$archive_title = is_tax( 'product_cat' )
	? single_term_title( '', false )
	: (string) es_opt( 'products_archive_title', 'فروشگاه تجهیزات نورپردازی شهری و محصولات دانش‌بنیان' );

$catalog_pdf = (string) es_opt( 'products_catalog_pdf_url', ES_THEME_URI . 'assets/images/sample-datasheet.pdf' );
?>
<section class="es-page-hero es-shop-hero">
	<div class="es-container">
		<div class="es-shop-hero-flex">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'تولیدات دانش‌بنیان با ۲۴ ماه گارانتی', 'erfan-sanat' ); ?></span>
				<h1 class="es-page-title"><?php echo esc_html( $archive_title ); ?></h1>
				<p class="es-page-subtitle">
					<?php esc_html_e( 'امکان خرید آنلاین برای کالاهای استاندارد فراهم است؛ همچنین برای محصولات پروژه‌ای جهت تضمین دقت فنی، می‌توانید از سیستم استعلام قیمت، مشاوره و صدور پیش‌فاکتور رسمی استفاده نمایید.', 'erfan-sanat' ); ?>
				</p>
			</div>
			<div class="es-shop-hero-actions">
				<a href="<?php echo esc_url( $catalog_pdf ); ?>" class="es-btn es-btn-primary" download>
					<?php echo erfan_sanat_icon( 'download', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'دریافت کاتالوگ جامع (PDF)', 'erfan-sanat' ); ?></span>
				</a>
				<a href="#consultation" class="es-btn es-btn-outline">
					<span><?php esc_html_e( 'مشاوره انتخاب محصول', 'erfan-sanat' ); ?></span>
				</a>
			</div>
		</div>
	</div>
</section>

<section class="es-section es-shop-catalog-section">
	<div class="es-container">
		<div class="es-shop-layout">
			<?php get_template_part( 'template-parts/product/filter-sidebar' ); ?>

			<div class="es-shop-main">
				<?php if ( have_posts() ) : ?>
					<div class="es-cards-grid es-grid-3">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'content-product' );
						endwhile;
						?>
					</div>
					<?php get_template_part( 'template-parts/global/pagination' ); ?>
				<?php else : ?>
					<?php
					get_template_part(
						'template-parts/global/empty-state',
						null,
						array(
							'title'   => __( 'محصولی با این مشخصات فنی یافت نشد', 'erfan-sanat' ),
							'message' => __( 'فیلترهای انتخابی را تغییر دهید یا جهت تولید سفارشی با مشخصات اختصاصی پروژه با کارشناسان فروش تماس بگیرید.', 'erfan-sanat' ),
						)
					);
					?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/home/consultation-cta' );
get_footer();
