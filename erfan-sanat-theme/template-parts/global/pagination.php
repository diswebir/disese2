<?php
/**
 * Accessible Archive Pagination Component
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$links = paginate_links(
	array(
		'prev_text' => '&rarr; ' . __( 'قبلی', 'erfan-sanat' ),
		'next_text' => __( 'بعدی', 'erfan-sanat' ) . ' &larr;',
		'type'      => 'array',
	)
);

if ( empty( $links ) || ! is_array( $links ) ) {
	return;
}
?>
<nav class="es-pagination" aria-label="<?php esc_attr_e( 'صفحه‌بندی محتوا', 'erfan-sanat' ); ?>">
	<ul class="es-pagination-list">
		<?php foreach ( $links as $link_html ) : ?>
			<li class="es-pagination-item">
				<?php echo wp_kses_post( erfan_sanat_persian_digits( $link_html ) ); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
