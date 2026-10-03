<?php
/**
 * WooCommerce Product Loop Item (`content-product.php`)
 *
 * Delegates to the reusable `template-parts/cards/card-product.php`.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part(
	'template-parts/cards/card-product',
	null,
	array( 'post_id' => get_the_ID() )
);
