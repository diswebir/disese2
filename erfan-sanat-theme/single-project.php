<?php
/**
 * Single Urban Lighting Project Template (`single-project.php`)
 *
 * Displays complete project engineering case study, metadata panel,
 * before/after execution gallery, related projects, and consultation CTA.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$project_id = (int) get_the_ID();
	$img_url    = erfan_sanat_get_post_image_url( $project_id, 'project' );
	?>
	<article id="project-<?php the_ID(); ?>" <?php post_class( 'es-single-project' ); ?>>
		<header class="es-page-hero es-project-hero">
			<div class="es-container">
				<span class="es-section-eyebrow"><?php esc_html_e( 'گزارش فنی و اجرایی پروژه نورپردازی شهری', 'erfan-sanat' ); ?></span>
				<h1 class="es-page-title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="es-page-subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</header>

		<div class="es-container es-project-single-layout">
			<div class="es-project-main-col">
				<figure class="es-project-featured-banner">
					<img
						src="<?php echo esc_url( $img_url ); ?>"
						alt="<?php echo esc_attr( get_the_title() ); ?>"
						width="960"
						height="640"
					/>
				</figure>

				<div class="es-prose es-project-description">
					<?php the_content(); ?>
				</div>

				<?php get_template_part( 'template-parts/project/project-gallery', null, array( 'post_id' => $project_id ) ); ?>
			</div>

			<div class="es-project-side-col">
				<?php get_template_part( 'template-parts/project/project-meta-panel', null, array( 'post_id' => $project_id ) ); ?>
			</div>
		</div>
	</article>

	<?php
	$related_projects = new WP_Query(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => array( $project_id ),
			'no_found_rows'  => true,
		)
	);
	if ( $related_projects->have_posts() ) :
		?>
		<section class="es-section es-related-section">
			<div class="es-container">
				<h2 class="es-subsection-heading"><?php esc_html_e( 'سایر پروژه‌های مشابه اجراشده', 'erfan-sanat' ); ?></h2>
				<div class="es-cards-grid es-grid-3">
					<?php
					while ( $related_projects->have_posts() ) :
						$related_projects->the_post();
						get_template_part( 'template-parts/cards/card-project', null, array( 'post_id' => get_the_ID() ) );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;

	get_template_part( 'template-parts/home/consultation-cta' );
endwhile;

get_footer();
