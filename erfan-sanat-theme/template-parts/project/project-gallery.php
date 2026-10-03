<?php
/**
 * Single Project Before/After & Execution Gallery Component
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$gallery    = get_post_meta( $project_id, '_es_before_after_gallery', true );
if ( is_string( $gallery ) && '' !== $gallery ) {
	$gallery = array_filter( array_map( 'trim', explode( ',', $gallery ) ) );
}
if ( ! is_array( $gallery ) || empty( $gallery ) ) {
	$gallery = array(
		ES_THEME_URI . 'assets/images/light-tunnel.jpg',
		ES_THEME_URI . 'assets/images/light-sphere.jpg',
		ES_THEME_URI . 'assets/images/light-element.jpg',
	);
}
?>
<section class="es-project-gallery-section" aria-label="<?php esc_attr_e( 'گالری تصاویر اجرای پروژه', 'erfan-sanat' ); ?>">
	<h3><?php esc_html_e( 'گالری تصاویر مراحل ساخت، نصب و نمای شب پروژه', 'erfan-sanat' ); ?></h3>
	<div class="es-project-gallery-grid">
		<?php foreach ( $gallery as $idx => $item ) : ?>
			<?php
			$img_url = erfan_sanat_resolve_media_url( $item );
			if ( '' === $img_url ) {
				continue;
			}
			?>
			<figure class="es-gallery-figure">
				<img
					src="<?php echo esc_url( $img_url ); ?>"
					alt="<?php echo esc_attr( get_the_title( $project_id ) . ' - ' . ( $idx + 1 ) ); ?>"
					loading="lazy"
					width="800"
					height="600"
				/>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
