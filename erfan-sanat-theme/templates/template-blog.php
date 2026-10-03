<?php
/**
 * Template Name: قالب وبلاگ و مقالات فنی (Blog)
 * Template Post Type: page
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged      = max( 1, absint( get_query_var( 'paged' ) ?: get_query_var( 'page' ) ) );
$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
	)
);
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'مجله علمی و آموزش‌های فنی', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php the_title(); ?></h1>
	</div>
</section>

<section class="es-section">
	<div class="es-container">
		<?php if ( $blog_query->have_posts() ) : ?>
			<div class="es-cards-grid es-grid-3">
				<?php
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					get_template_part( 'template-parts/cards/card-post', null, array( 'post_id' => get_the_ID() ) );
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
get_footer();
