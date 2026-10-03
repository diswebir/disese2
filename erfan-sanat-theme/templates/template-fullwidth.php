<?php
/**
 * Template Name: قالب تمام‌عرض سازمانی (Fullwidth)
 * Template Post Type: page
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="es-page-hero">
		<div class="es-container">
			<span class="es-section-eyebrow"><?php echo esc_html( (string) es_opt( 'company_legal_name', 'شرکت دانش‌بنیان عرفان صنعت اصفهان' ) ); ?></span>
			<h1 class="es-page-title"><?php the_title(); ?></h1>
		</div>
	</section>

	<section class="es-section">
		<div class="es-container">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'es-entry-content-card es-fullwidth-card' ); ?>>
				<div class="es-prose">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
	</section>

	<?php get_template_part( 'template-parts/home/about-section' ); ?>
	<?php get_template_part( 'template-parts/home/why-us-process' ); ?>
	<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>
	<?php
endwhile;

get_footer();
