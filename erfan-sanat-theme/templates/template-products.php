<?php
/**
 * Template Name: قالب کاتالوگ محصولات (Products)
 * Template Post Type: page
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged          = max( 1, absint( get_query_var( 'paged' ) ?: get_query_var( 'page' ) ) );
$products_query = new WP_Query(
	array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => max( 4, absint( es_opt( 'products_per_page', 12 ) ) ),
		'paged'          => $paged,
	)
);
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'تولیدات شرکت دانش‌بنیان عرفان صنعت اصفهان', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php the_title(); ?></h1>
	</div>
</section>

<section class="es-section">
	<div class="es-container">
		<div class="es-shop-layout">
			<?php get_template_part( 'template-parts/product/filter-sidebar' ); ?>
			<div class="es-shop-main">
				<?php if ( $products_query->have_posts() ) : ?>
					<div class="es-cards-grid es-grid-3">
						<?php
						while ( $products_query->have_posts() ) :
							$products_query->the_post();
							get_template_part( 'content-product' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php else : ?>
					<?php get_template_part( 'template-parts/global/empty-state' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/home/consultation-cta' );
get_footer();
