<?php
/**
 * WooCommerce My Account Template (`woocommerce/myaccount/my-account.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="es-wc-state-card es-myaccount-wrap">
	<?php do_action( 'woocommerce_account_navigation' ); ?>
	<div class="woocommerce-MyAccount-content">
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>
</div>
