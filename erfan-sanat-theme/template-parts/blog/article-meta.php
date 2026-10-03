<?php
/**
 * Technical Blog Article Engineering Meta Bar
 *
 * Displays `_es_reading_time_min`, `_es_technical_reviewer`, and `_es_software_project_file`.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id      = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$reading_time = max( 1, absint( get_post_meta( $post_id, '_es_reading_time_min', true ) ?: 6 ) );
$reviewer     = (string) ( get_post_meta( $post_id, '_es_technical_reviewer', true ) ?: 'واحد تحقیق و توسعه (R&D) عرفان صنعت اصفهان' );
$file_url     = erfan_sanat_resolve_media_url( get_post_meta( $post_id, '_es_software_project_file', true ) );
?>
<div class="es-article-engineering-bar">
	<div class="es-article-meta-items">
		<span class="es-meta-chip">
			<?php echo erfan_sanat_icon( 'calendar', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span><?php echo esc_html( erfan_sanat_persian_digits( get_the_date( 'Y/m/d', $post_id ) ) ); ?></span>
		</span>

		<span class="es-meta-chip">
			<?php echo erfan_sanat_icon( 'clock', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span>
				<?php
				printf(
					/* translators: %s: reading time in minutes */
					esc_html__( 'زمان مطالعه: %s دقیقه', 'erfan-sanat' ),
					esc_html( erfan_sanat_persian_digits( $reading_time ) )
				);
				?>
			</span>
		</span>

		<span class="es-meta-chip es-meta-reviewer">
			<?php echo erfan_sanat_icon( 'shield', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span><?php esc_html_e( 'بازبین فنی:', 'erfan-sanat' ); ?> <strong><?php echo esc_html( $reviewer ); ?></strong></span>
		</span>
	</div>

	<?php if ( '' !== $file_url ) : ?>
		<a href="<?php echo esc_url( $file_url ); ?>" class="es-btn es-btn-sm es-btn-primary" download>
			<?php echo erfan_sanat_icon( 'download', 'es-icon-xs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span><?php esc_html_e( 'دانلود فایل پروژه / ضمیمه فنی', 'erfan-sanat' ); ?></span>
		</a>
	<?php endif; ?>
</div>
