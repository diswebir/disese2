<?php
/**
 * Homepage Section 8: Latest Technical Articles & Knowledge Base
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $blog_query->have_posts() ) {
	return;
}
?>
<section id="blog" class="es-section es-blog-section">
	<div class="es-container">
		<div class="es-section-header">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'مجله علمی و فنی', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php echo esc_html( (string) es_opt( 'blog_archive_title', 'وبلاگ و مقالات تخصصی نورپردازی' ) ); ?></h2>
				<p class="es-section-subtitle">
					<?php esc_html_e( 'مقالات آموزشی کنترلرهای پیکسلی، استانداردهای درجه حفاظت IP67/IP68، محاسبه افت ولتاژ و اخبار شرکت دانش‌بنیان عرفان صنعت.', 'erfan-sanat' ); ?>
				</p>
			</div>
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="es-btn es-btn-outline">
				<span><?php esc_html_e( 'مشاهده همه مقالات', 'erfan-sanat' ); ?></span>
				<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>

		<div class="es-cards-grid es-grid-3">
			<?php
			while ( $blog_query->have_posts() ) :
				$blog_query->the_post();
				get_template_part(
					'template-parts/cards/card-post',
					null,
					array( 'post_id' => get_the_ID() )
				);
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
