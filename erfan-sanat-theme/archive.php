<?php
/**
 * Generic Archive Template (`archive.php`)
 *
 * Routes `project` archives/taxonomies to `archive-project.php` and
 * `product` archives/taxonomies to `archive-product.php`, otherwise renders blog archive.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_post_type_archive( 'project' ) || is_tax( array( 'project_cat', 'project_location' ) ) ) {
	get_template_part( 'archive-project' );
	return;
}

if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) {
	get_template_part( 'archive-product' );
	return;
}

get_header();
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'آرشیو مقالات و دانشنامه فنی', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="es-page-subtitle">', '</div>' ); ?>
	</div>
</section>

<section class="es-section">
	<div class="es-container">
		<?php if ( have_posts() ) : ?>
			<div class="es-cards-grid es-grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/cards/card-post', null, array( 'post_id' => get_the_ID() ) );
				endwhile;
				?>
			</div>
			<?php get_template_part( 'template-parts/global/pagination' ); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/global/empty-state' ); ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
