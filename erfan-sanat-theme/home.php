<?php
/**
 * Blog Posts Index Template (`home.php`)
 *
 * Displays the Technical Knowledge Base & Blog archive with category filters.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$blog_title = (string) es_opt( 'blog_archive_title', 'پایگاه دانش و مقالات تخصصی نورپردازی شهری' );
$categories = get_categories( array( 'hide_empty' => false ) );
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'مجله علمی و فنی عرفان صنعت', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php echo esc_html( $blog_title ); ?></h1>
		<p class="es-page-subtitle">
			<?php esc_html_e( 'مقالات آموزشی کنترلرهای پیکسلی WS2811 و DMX512، استانداردهای درجه حفاظت IP67/IP68، راهنمای محاسبه افت ولتاژ و آخرین اخبار شرکت دانش‌بنیان عرفان صنعت اصفهان.', 'erfan-sanat' ); ?>
		</p>

		<?php if ( ! empty( $categories ) ) : ?>
			<div class="es-filter-pills-bar" role="navigation" aria-label="<?php esc_attr_e( 'دسته‌بندی مقالات', 'erfan-sanat' ); ?>">
				<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="es-filter-pill <?php echo is_home() ? 'is-active' : ''; ?>">
					<?php esc_html_e( 'همه مقالات', 'erfan-sanat' ); ?>
				</a>
				<?php foreach ( $categories as $cat ) : ?>
					<?php if ( 'uncategorized' === $cat->slug ) { continue; } ?>
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="es-filter-pill <?php echo is_category( $cat->term_id ) ? 'is-active' : ''; ?>">
						<?php echo esc_html( $cat->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="es-section">
	<div class="es-container">
		<?php if ( have_posts() ) : ?>
			<div class="es-cards-grid es-grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part(
						'template-parts/cards/card-post',
						null,
						array( 'post_id' => get_the_ID() )
					);
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
					'title'   => __( 'هنوز مقاله‌ای در این بخش منتشر نشده است', 'erfan-sanat' ),
					'message' => __( 'به‌زودی مقالات تخصصی جدید توسط واحد تحقیق و توسعه عرفان صنعت منتشر خواهد شد.', 'erfan-sanat' ),
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
