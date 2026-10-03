<?php
/**
 * Reusable Technical Blog Article Card Component
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id      = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$img_url      = erfan_sanat_get_post_image_url( $post_id, 'post' );
$permalink    = (string) get_permalink( $post_id );
$title        = get_the_title( $post_id );
$reading_time = max( 1, absint( get_post_meta( $post_id, '_es_reading_time_min', true ) ?: 6 ) );
$cats         = get_the_category( $post_id );
$cat_name     = ! empty( $cats ) ? $cats[0]->name : __( 'مجله علمی', 'erfan-sanat' );
?>
<article id="post-card-<?php echo esc_attr( (string) $post_id ); ?>" class="es-card es-post-card">
	<a href="<?php echo esc_url( $permalink ); ?>" class="es-card-media" aria-label="<?php echo esc_attr( $title ); ?>">
		<img
			src="<?php echo esc_url( $img_url ); ?>"
			alt="<?php echo esc_attr( $title ); ?>"
			loading="lazy"
			decoding="async"
			width="640"
			height="480"
		/>
		<span class="es-badge es-badge-cat"><?php echo esc_html( $cat_name ); ?></span>
	</a>

	<div class="es-card-body">
		<div class="es-post-meta-bar">
			<span>
				<?php echo erfan_sanat_icon( 'calendar', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo esc_html( erfan_sanat_persian_digits( get_the_date( 'Y/m/d', $post_id ) ) ); ?>
			</span>
			<?php if ( es_opt( 'blog_show_reading_time', true ) ) : ?>
				<span>
					<?php echo erfan_sanat_icon( 'clock', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php
					printf(
						/* translators: %s: reading time in minutes */
						esc_html__( '%s دقیقه مطالعه', 'erfan-sanat' ),
						esc_html( erfan_sanat_persian_digits( $reading_time ) )
					);
					?>
				</span>
			<?php endif; ?>
		</div>

		<h3 class="es-card-title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
		</h3>

		<p class="es-card-excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt( $post_id ), 22, '...' ) ); ?>
		</p>

		<div class="es-card-footer">
			<a href="<?php echo esc_url( $permalink ); ?>" class="es-card-link">
				<span><?php esc_html_e( 'مطالعه مقاله فنی', 'erfan-sanat' ); ?></span>
				<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>
	</div>
</article>
