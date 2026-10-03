<?php
/**
 * Template Name: قالب آرشیو پروژه‌های نورپردازی (Projects)
 * Template Post Type: page
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged          = max( 1, absint( get_query_var( 'paged' ) ?: get_query_var( 'page' ) ) );
$projects_query = new WP_Query(
	array(
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => max( 3, absint( es_opt( 'projects_per_page', 9 ) ) ),
		'paged'          => $paged,
	)
);
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'نمونه‌کارهای برتر', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php the_title(); ?></h1>
		<p class="es-page-subtitle">
			<?php echo esc_html( (string) es_opt( 'projects_archive_subtitle', '' ) ); ?>
		</p>
	</div>
</section>

<section class="es-section">
	<div class="es-container">
		<?php if ( $projects_query->have_posts() ) : ?>
			<div class="es-cards-grid es-grid-3">
				<?php
				$idx = 1;
				while ( $projects_query->have_posts() ) :
					$projects_query->the_post();
					get_template_part(
						'template-parts/cards/card-project',
						null,
						array(
							'post_id' => get_the_ID(),
							'index'   => $idx++,
						)
					);
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/global/empty-state' ); ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/global/cta-banner' );
get_footer();
