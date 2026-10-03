<?php
/**
 * WooCommerce Checkout Form Template (`woocommerce/checkout/form-checkout.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'wc_print_notices' ) ) {
	wc_print_notices();
}

do_action( 'woocommerce_before_checkout_form', $checkout ?? null );
?>
<div class="es-wc-state-card">
	<?php if ( isset( $checkout ) && is_object( $checkout ) && function_exists( 'wc_get_checkout_url' ) ) : ?>
		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
			<?php if ( $checkout->get_checkout_fields() ) : ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div class="col2-set" id="customer_details">
					<div class="col-1"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>
					<div class="col-2"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
				</div>
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<?php endif; ?>
			<h3 id="order_review_heading"><?php esc_html_e( 'سفارش شما', 'erfan-sanat' ); ?></h3>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		</form>
	<?php else : ?>
		<?php get_template_part( 'template-parts/home/consultation-cta' ); ?>
	<?php endif; ?>
</div>
<?php
do_action( 'woocommerce_after_checkout_form', $checkout ?? null );
