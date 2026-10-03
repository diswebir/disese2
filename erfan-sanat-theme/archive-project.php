<?php
/**
 * Urban Lighting Projects Archive Template (`archive-project.php`)
 *
 * Supports filtering by `project_cat` and `project_location`.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$archive_url  = get_post_type_archive_link( 'project' ) ?: home_url( '/projects/' );
$project_cats = get_terms( array( 'taxonomy' => 'project_cat', 'hide_empty' => false ) );
$project_locs = get_terms( array( 'taxonomy' => 'project_location', 'hide_empty' => false ) );
$active_cat   = is_tax( 'project_cat' ) ? get_queried_object()->slug : ( isset( $_GET['project_cat'] ) ? sanitize_key( wp_unslash( $_GET['project_cat'] ) ) : '' );
$active_loc   = is_tax( 'project_location' ) ? get_queried_object()->slug : ( isset( $_GET['project_location'] ) ? sanitize_key( wp_unslash( $_GET['project_location'] ) ) : '' );

$heading_title = is_tax()
	? single_term_title( '', false )
	: (string) es_opt( 'projects_archive_title', 'پروژه‌های نورپردازی شهری' );
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'نمونه‌کارهای اجرایی در سراسر ایران', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title"><?php echo esc_html( $heading_title ); ?></h1>
		<p class="es-page-subtitle">
			<?php echo esc_html( (string) es_opt( 'projects_archive_subtitle', 'نمونه پروژه‌های نورپردازی حرفه‌ای شهری؛ هر پروژه، روایتی از هنر، مهندسی و نور است که هویت بصری شهر را برای همیشه دگرگون می‌کند.' ) ); ?>
		</p>

		<?php if ( is_array( $project_cats ) && ! empty( $project_cats ) ) : ?>
			<div class="es-filter-pills-bar" role="navigation" aria-label="<?php esc_attr_e( 'فیلتر نوع پروژه', 'erfan-sanat' ); ?>">
				<a href="<?php echo esc_url( $archive_url ); ?>" class="es-filter-pill <?php echo ( '' === $active_cat && '' === $active_loc ) ? 'is-active' : ''; ?>">
					<?php esc_html_e( 'همه پروژه‌ها', 'erfan-sanat' ); ?>
				</a>
				<?php foreach ( $project_cats as $pcat ) : ?>
					<a href="<?php echo esc_url( (string) get_term_link( $pcat ) ); ?>" class="es-filter-pill <?php echo ( $active_cat === $pcat->slug ) ? 'is-active' : ''; ?>">
						<?php echo esc_html( $pcat->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( is_array( $project_locs ) && ! empty( $project_locs ) ) : ?>
			<div class="es-filter-pills-bar es-location-pills-bar" role="navigation" aria-label="<?php esc_attr_e( 'فیلتر شهر محل اجرا', 'erfan-sanat' ); ?>">
				<span class="es-pills-label"><?php esc_html_e( 'فیلتر بر اساس شهر:', 'erfan-sanat' ); ?></span>
				<?php foreach ( $project_locs as $ploc ) : ?>
					<a href="<?php echo esc_url( (string) get_term_link( $ploc ) ); ?>" class="es-tech-pill <?php echo ( $active_loc === $ploc->slug ) ? 'is-active' : ''; ?>">
						<?php echo esc_html( $ploc->name ); ?>
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
				$idx = 1;
				while ( have_posts() ) :
					the_post();
					get_template_part(
						'template-parts/cards/card-project',
						null,
						array(
							'post_id' => get_the_ID(),
							'index'   => $idx++,
						)
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
					'title'   => __( 'پروژه‌ای در این دسته‌بندی یافت نشد', 'erfan-sanat' ),
					'message' => __( 'برای مشاهده سایر نمونه‌کارهای اجرایی عرفان صنعت اصفهان، فیلتر را پاک کنید.', 'erfan-sanat' ),
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/global/cta-banner' );
get_footer();
