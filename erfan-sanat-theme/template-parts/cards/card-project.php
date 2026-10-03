<?php
/**
 * Reusable Urban Lighting Project Card Component
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$index_num  = isset( $args['index'] ) ? sprintf( '%02d', absint( $args['index'] ) ) : '';
$img_url    = erfan_sanat_get_post_image_url( $project_id, 'project' );
$permalink  = (string) get_permalink( $project_id );
$title      = get_the_title( $project_id );
$client     = (string) get_post_meta( $project_id, '_es_project_client', true );
$comp_date  = (string) get_post_meta( $project_id, '_es_completion_date', true );
$pixels     = absint( get_post_meta( $project_id, '_es_total_pixel_count', true ) );
$cats       = get_the_terms( $project_id, 'project_cat' );
$locs       = get_the_terms( $project_id, 'project_location' );
$cat_name   = ( is_array( $cats ) && ! empty( $cats ) ) ? $cats[0]->name : __( 'نورپردازی شهری', 'erfan-sanat' );
$loc_name   = ( is_array( $locs ) && ! empty( $locs ) ) ? $locs[0]->name : __( 'اصفهان', 'erfan-sanat' );
?>
<article id="project-card-<?php echo esc_attr( (string) $project_id ); ?>" class="es-card es-project-card">
	<a href="<?php echo esc_url( $permalink ); ?>" class="es-card-media" aria-label="<?php echo esc_attr( $title ); ?>">
		<img
			src="<?php echo esc_url( $img_url ); ?>"
			alt="<?php echo esc_attr( $title ); ?>"
			loading="lazy"
			decoding="async"
			width="800"
			height="600"
		/>
		<div class="es-project-card-overlay">
			<span class="es-badge es-badge-location">
				<?php echo erfan_sanat_icon( 'location', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( $loc_name ); ?></span>
			</span>
			<?php if ( '' !== $index_num ) : ?>
				<span class="es-project-number"><?php echo esc_html( erfan_sanat_persian_digits( $index_num ) ); ?></span>
			<?php endif; ?>
		</div>
	</a>

	<div class="es-card-body">
		<div class="es-project-meta-row">
			<span class="es-project-cat-tag"><?php echo esc_html( $cat_name ); ?></span>
			<?php if ( '' !== $comp_date ) : ?>
				<span class="es-project-date">
					<?php echo erfan_sanat_icon( 'calendar', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( erfan_sanat_persian_digits( $comp_date ) ); ?></span>
				</span>
			<?php endif; ?>
		</div>

		<h3 class="es-card-title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h3>

		<p class="es-card-excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt( $project_id ), 20, '...' ) ); ?>
		</p>

		<div class="es-card-footer es-project-card-footer">
			<div class="es-project-specs-mini">
				<?php if ( $pixels > 0 ) : ?>
					<span><?php echo esc_html( erfan_sanat_persian_digits( number_format( $pixels ) ) . ' ' . __( 'پیکسل نوری', 'erfan-sanat' ) ); ?></span>
				<?php elseif ( '' !== $client ) : ?>
					<span><?php echo esc_html( $client ); ?></span>
				<?php endif; ?>
			</div>
			<a href="<?php echo esc_url( $permalink ); ?>" class="es-card-link">
				<span><?php esc_html_e( 'جزئیات فنی پروژه', 'erfan-sanat' ); ?></span>
				<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>
	</div>
</article>
