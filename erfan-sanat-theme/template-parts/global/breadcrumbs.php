<?php
/**
 * Semantic Breadcrumbs Component
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_front_page() || ! es_opt( 'seo_enable_breadcrumbs', true ) ) {
	return;
}

$crumbs = erfan_sanat_get_breadcrumbs();
if ( empty( $crumbs ) ) {
	return;
}
?>
<nav class="es-breadcrumbs" aria-label="<?php esc_attr_e( 'مسیر راهنما', 'erfan-sanat' ); ?>">
	<div class="es-container">
		<ol class="es-breadcrumb-list">
			<?php foreach ( $crumbs as $idx => $crumb ) : ?>
				<?php $is_last = ( $idx === count( $crumbs ) - 1 ); ?>
				<li class="es-breadcrumb-item <?php echo $is_last ? 'is-current' : ''; ?>">
					<?php if ( ! $is_last && ! empty( $crumb['url'] ) ) : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>"><?php echo esc_html( $crumb['label'] ); ?></a>
						<span class="es-breadcrumb-sep" aria-hidden="true">/</span>
					<?php else : ?>
						<span aria-current="page"><?php echo esc_html( $crumb['label'] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</nav>
