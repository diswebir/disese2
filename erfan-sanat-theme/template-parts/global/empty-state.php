<?php
/**
 * Reusable Empty State Component
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = $args['title'] ?? __( 'موردی متناسب با فیلتر انتخابی یافت نشد', 'erfan-sanat' );
$message = $args['message'] ?? __( 'می‌توانید فیلترهای جستجو را تغییر دهید یا جهت سفارش تولید سفارشی با واحد مهندسی فروش عرفان صنعت تماس بگیرید.', 'erfan-sanat' );
?>
<div class="es-empty-state" role="status">
	<div class="es-empty-icon">
		<?php echo erfan_sanat_icon( 'bulb' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<h3 class="es-empty-title"><?php echo esc_html( $title ); ?></h3>
	<p class="es-empty-desc"><?php echo esc_html( $message ); ?></p>
	<div class="es-empty-actions">
		<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="es-btn es-btn-primary">
			<?php esc_html_e( 'مشاهده همه محصولات', 'erfan-sanat' ); ?>
		</a>
		<a href="<?php echo esc_url( home_url( '/#consultation' ) ); ?>" class="es-btn es-btn-outline">
			<?php esc_html_e( 'دریافت مشاوره رایگان', 'erfan-sanat' ); ?>
		</a>
	</div>
</div>
