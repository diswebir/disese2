<?php
/**
 * Single Post / Technical Article Template (`single.php`)
 *
 * Routes `project` to `single-project.php` and `product` to `single-product.php`,
 * and renders full technical article layout with `_es_reading_time_min`,
 * `_es_technical_reviewer`, `_es_software_project_file`, and `_es_faq_schema_repeater`.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_singular( 'project' ) ) {
	get_template_part( 'single-project' );
	return;
}

if ( is_singular( 'product' ) ) {
	get_template_part( 'single-product' );
	return;
}

get_header();

while ( have_posts() ) :
	the_post();
	$post_id = (int) get_the_ID();
	$img_url = erfan_sanat_get_post_image_url( $post_id, 'post' );
	$cats    = get_the_category( $post_id );
	$tags    = get_the_tags( $post_id );
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'es-single-article' ); ?>>
		<header class="es-page-hero es-article-hero">
			<div class="es-container">
				<?php if ( ! empty( $cats ) ) : ?>
					<div class="es-hero-badges">
						<?php foreach ( $cats as $c ) : ?>
							<a href="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>" class="es-pill es-pill-gold">
								<?php echo esc_html( $c->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<h1 class="es-page-title"><?php the_title(); ?></h1>

				<?php get_template_part( 'template-parts/blog/article-meta', null, array( 'post_id' => $post_id ) ); ?>
			</div>
		</header>

		<div class="es-container es-article-layout">
			<div class="es-article-main">
				<figure class="es-article-featured-media">
					<img
						src="<?php echo esc_url( $img_url ); ?>"
						alt="<?php echo esc_attr( get_the_title() ); ?>"
						width="960"
						height="540"
					/>
				</figure>

				<div class="es-prose es-article-content">
					<?php the_content(); ?>
				</div>

				<?php get_template_part( 'template-parts/blog/faq-accordion', null, array( 'post_id' => $post_id ) ); ?>

				<?php if ( is_array( $tags ) && ! empty( $tags ) ) : ?>
					<footer class="es-article-tags-footer">
						<strong><?php esc_html_e( 'کلیدواژه‌های تخصصی:', 'erfan-sanat' ); ?></strong>
						<div class="es-tech-pills">
							<?php foreach ( $tags as $t ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $t->term_id ) ); ?>" class="es-tech-pill">
									#<?php echo esc_html( $t->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</footer>
				<?php endif; ?>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>

			<aside class="es-article-sidebar" aria-label="<?php esc_attr_e( 'ستون کناری مقاله', 'erfan-sanat' ); ?>">
				<div class="es-sidebar-widget">
					<h3><?php esc_html_e( 'نیاز به مشاوره فنی دارید؟', 'erfan-sanat' ); ?></h3>
					<p><?php esc_html_e( 'واحد مهندسی و تحقیق و توسعه عرفان صنعت آماده پاسخگویی به سوالات فنی شما درباره سربندی، کنترلرهای DMX/SPI و محاسبه افت ولتاژ است.', 'erfan-sanat' ); ?></p>
					<a href="tel:<?php echo esc_attr( (string) es_opt( 'contact_phone_tel_link', '03191091011' ) ); ?>" class="es-btn es-btn-primary es-btn-block">
						<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span dir="ltr"><?php echo esc_html( erfan_sanat_persian_digits( (string) es_opt( 'contact_phone_main', '۰۳۱-۹۱۰۹۱۰۱۱' ) ) ); ?></span>
					</a>
				</div>
			</aside>
		</div>
	</article>

	<?php
	$related_posts = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	if ( $related_posts->have_posts() ) :
		?>
		<section class="es-section es-related-section">
			<div class="es-container">
				<h2 class="es-subsection-heading"><?php esc_html_e( 'مقالات فنی مرتبط', 'erfan-sanat' ); ?></h2>
				<div class="es-cards-grid es-grid-3">
					<?php
					while ( $related_posts->have_posts() ) :
						$related_posts->the_post();
						get_template_part( 'template-parts/cards/card-post', null, array( 'post_id' => get_the_ID() ) );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_footer();
