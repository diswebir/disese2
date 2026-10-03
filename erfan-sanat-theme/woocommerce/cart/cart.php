<?php
/**
 * WooCommerce Cart Template (`woocommerce/cart/cart.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_cart' );
?>
<div class="es-wc-state-card">
	<?php if ( function_exists( 'WC' ) && WC()->cart && ! WC()->cart->is_empty() ) : ?>
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			<table class="es-specs-table es-cart-table shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
				<thead>
					<tr>
						<th class="product-name"><?php esc_html_e( 'محصول', 'erfan-sanat' ); ?></th>
						<th class="product-price"><?php esc_html_e( 'قیمت واحد', 'erfan-sanat' ); ?></th>
						<th class="product-quantity"><?php esc_html_e( 'تعداد', 'erfan-sanat' ); ?></th>
						<th class="product-subtotal"><?php esc_html_e( 'مجموع', 'erfan-sanat' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
						<?php
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<tr class="woocommerce-cart-form__cart-item">
								<td class="product-name">
									<?php
									if ( ! $product_permalink ) {
										echo wp_kses_post( $_product->get_name() );
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $_product->get_name() ) );
									}
									?>
								</td>
								<td class="product-price">
									<?php echo wp_kses_post( WC()->cart->get_product_price( $_product ) ); ?>
								</td>
								<td class="product-quantity">
									<?php echo esc_html( erfan_sanat_persian_digits( $cart_item['quantity'] ) ); ?>
								</td>
								<td class="product-subtotal">
									<?php echo wp_kses_post( WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) ); ?>
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
		<div class="cart-collaterals">
			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>
	<?php else : ?>
		<?php get_template_part( 'template-parts/global/empty-state' ); ?>
	<?php endif; ?>
</div>
<?php
do_action( 'woocommerce_after_cart' );
