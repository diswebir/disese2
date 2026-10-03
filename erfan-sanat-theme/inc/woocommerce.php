<?php
/**
 * WooCommerce Integration & Custom Industrial Purchase / Inquiry Engine
 *
 * Supports:
 * - Three order modes: `online_cart`, `phone_inquiry`, `official_tender`
 * - `_es_is_purchasable_online` boolean enforcement
 * - `_es_custom_price_badge` replacement / badge display
 * - Product archive filtering by `product_cat`, `pa_voltage`, `pa_ip_rating`, `pa_control_protocol`, and order mode
 * - Template loader routing for `archive-product.php`, `single-product.php`, `taxonomy-product_cat.php`
 * - Native cart session fallback when WooCommerce plugin is not active
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieves normalized product purchase state and engineering metadata.
 *
 * @param int $product_id Product post ID.
 * @return array<string, mixed>
 */
function erfan_sanat_get_product_purchase_data( int $product_id ): array {
	$order_type_meta = (string) get_post_meta( $product_id, '_es_order_type', true );
	$default_mode    = (string) es_opt( 'wc_default_order_type', 'online_cart' );
	$order_type      = in_array( $order_type_meta, array( 'online_cart', 'phone_inquiry', 'official_tender' ), true )
		? $order_type_meta
		: $default_mode;

	$purchasable_raw = get_post_meta( $product_id, '_es_is_purchasable_online', true );
	$is_purchasable  = ( '' === $purchasable_raw )
		? ( 'online_cart' === $order_type )
		: ( '1' === (string) $purchasable_raw || true === $purchasable_raw );

	if ( 'online_cart' !== $order_type ) {
		$is_purchasable = false;
	}

	$regular_price = get_post_meta( $product_id, '_regular_price', true );
	if ( '' === $regular_price ) {
		$regular_price = get_post_meta( $product_id, '_price', true );
	}

	$custom_badge  = trim( (string) get_post_meta( $product_id, '_es_custom_price_badge', true ) );
	$inquiry_phone = trim( (string) get_post_meta( $product_id, '_es_inquiry_phone', true ) );
	if ( '' === $inquiry_phone ) {
		$inquiry_phone = (string) es_opt( 'wc_default_inquiry_phone', '031-91091011' );
	}

	$min_qty      = max( 1, absint( get_post_meta( $product_id, '_es_min_order_qty', true ) ?: 1 ) );
	$lead_time    = (string) ( get_post_meta( $product_id, '_es_production_lead_time', true ) ?: '۳ تا ۷ روز کاری' );
	$wattage      = get_post_meta( $product_id, '_es_wattage_rating', true );
	$chip_brand   = (string) ( get_post_meta( $product_id, '_es_chip_brand', true ) ?: 'Epistar Taiwan' );
	$datasheet    = erfan_sanat_resolve_media_url( get_post_meta( $product_id, '_es_technical_datasheet_pdf', true ) );
	$schematic    = erfan_sanat_resolve_media_url( get_post_meta( $product_id, '_es_wiring_schematic_img', true ) );
	$demo_video   = esc_url( (string) get_post_meta( $product_id, '_es_demo_video_url', true ) );

	// Compute display price HTML / label.
	if ( '' !== $custom_badge ) {
		$price_label = $custom_badge;
	} elseif ( $is_purchasable && is_numeric( $regular_price ) && (float) $regular_price > 0 ) {
		$price_label = erfan_sanat_format_toman( $regular_price );
	} elseif ( 'official_tender' === $order_type ) {
		$price_label = __( 'استعلام مناقصه و پیش‌فاکتور رسمی', 'erfan-sanat' );
	} else {
		$price_label = __( 'تماس جهت استعلام قیمت روز', 'erfan-sanat' );
	}

	return array(
		'product_id'     => $product_id,
		'order_type'     => $order_type,
		'is_purchasable' => $is_purchasable,
		'regular_price'  => $regular_price,
		'custom_badge'   => $custom_badge,
		'price_label'    => $price_label,
		'inquiry_phone'  => $inquiry_phone,
		'min_qty'        => $min_qty,
		'lead_time'      => $lead_time,
		'wattage'        => $wattage,
		'chip_brand'     => $chip_brand,
		'datasheet_url'  => $datasheet ?: esc_url( (string) es_opt( 'products_catalog_pdf_url', ES_THEME_URI . 'assets/images/sample-datasheet.pdf' ) ),
		'schematic_url'  => $schematic ?: esc_url( ES_THEME_URI . 'assets/images/wiring-schematic.jpg' ),
		'demo_video_url' => $demo_video,
	);
}

/**
 * Retrieves assigned global product attributes (`pa_*`) for a product.
 *
 * @param int $product_id Product post ID.
 * @return array<string, array{label: string, values: array<int, string>, slugs: array<int, string>}>
 */
function erfan_sanat_get_product_attributes_summary( int $product_id ): array {
	$blueprint = erfan_sanat_get_global_attributes_blueprint();
	$summary   = array();

	foreach ( $blueprint as $tax_name => $attr_info ) {
		if ( ! taxonomy_exists( $tax_name ) ) {
			continue;
		}
		$terms = get_the_terms( $product_id, $tax_name );
		if ( is_array( $terms ) && ! empty( $terms ) ) {
			$names = array();
			$slugs = array();
			foreach ( $terms as $term ) {
				$names[] = $term->name;
				$slugs[] = $term->slug;
			}
			$summary[ $tax_name ] = array(
				'label'  => $attr_info['label'],
				'values' => $names,
				'slugs'  => $slugs,
			);
		}
	}

	return $summary;
}

/**
 * Filters WooCommerce `woocommerce_is_purchasable` based on `_es_is_purchasable_online` and `_es_order_type`.
 *
 * @param bool       $purchasable Current purchasable status.
 * @param WC_Product $product     WooCommerce product object.
 * @return bool
 */
function erfan_sanat_wc_filter_is_purchasable( bool $purchasable, $product ): bool {
	if ( ! is_object( $product ) || ! method_exists( $product, 'get_id' ) ) {
		return $purchasable;
	}
	$data = erfan_sanat_get_product_purchase_data( (int) $product->get_id() );
	if ( ! $data['is_purchasable'] ) {
		return false;
	}
	return $purchasable;
}
add_filter( 'woocommerce_is_purchasable', 'erfan_sanat_wc_filter_is_purchasable', 20, 2 );

/**
 * Filters WooCommerce price HTML when a custom price badge or inquiry mode is configured.
 *
 * @param string     $price_html Default price HTML.
 * @param WC_Product $product    WooCommerce product instance.
 * @return string
 */
function erfan_sanat_wc_filter_price_html( string $price_html, $product ): string {
	if ( ! is_object( $product ) || ! method_exists( $product, 'get_id' ) ) {
		return $price_html;
	}
	$data = erfan_sanat_get_product_purchase_data( (int) $product->get_id() );
	if ( '' !== $data['custom_badge'] || ! $data['is_purchasable'] ) {
		return '<span class="es-price-badge">' . esc_html( $data['price_label'] ) . '</span>';
	}
	if ( '' === trim( wp_strip_all_tags( $price_html ) ) ) {
		return '<span class="es-price-amount">' . esc_html( $data['price_label'] ) . '</span>';
	}
	return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'erfan_sanat_wc_filter_price_html', 20, 2 );

/**
 * Filters WooCommerce minimum quantity input value according to `_es_min_order_qty`.
 *
 * @param array<string, mixed> $args    Quantity input args.
 * @param WC_Product           $product Product object.
 * @return array<string, mixed>
 */
function erfan_sanat_wc_quantity_input_args( array $args, $product ): array {
	if ( is_object( $product ) && method_exists( $product, 'get_id' ) ) {
		$min = max( 1, absint( get_post_meta( (int) $product->get_id(), '_es_min_order_qty', true ) ?: 1 ) );
		if ( $min > 1 ) {
			$args['min_value'] = $min;
			if ( empty( $args['input_value'] ) || (int) $args['input_value'] < $min ) {
				$args['input_value'] = $min;
			}
		}
	}
	return $args;
}
add_filter( 'woocommerce_quantity_input_args', 'erfan_sanat_wc_quantity_input_args', 20, 2 );

/**
 * Applies GET filter parameters (`product_cat`, `pa_voltage`, `pa_ip_rating`, `pa_control_protocol`, `order_type`, `orderby`)
 * to product archive queries.
 *
 * @param WP_Query $query Main WP_Query object.
 */
function erfan_sanat_filter_product_archive_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_post_type_archive( 'product' ) && ! $query->is_tax( 'product_cat' ) ) {
		return;
	}

	$tax_query  = (array) $query->get( 'tax_query' );
	$meta_query = (array) $query->get( 'meta_query' );

	// Filter by product_cat slug if passed via GET on main shop archive.
	$cat_slug = isset( $_GET['product_cat'] ) ? sanitize_key( wp_unslash( $_GET['product_cat'] ) ) : '';
	if ( '' !== $cat_slug && ! $query->is_tax( 'product_cat' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $cat_slug,
		);
	}

	// Filter by global product attributes (`pa_*`).
	$filterable_attrs = array(
		'pa_voltage',
		'pa_ip_rating',
		'pa_control_protocol',
		'pa_light_color',
		'pa_beam_angle',
		'pa_body_material',
	);
	foreach ( $filterable_attrs as $attr_tax ) {
		$param = isset( $_GET[ $attr_tax ] ) ? sanitize_key( wp_unslash( $_GET[ $attr_tax ] ) ) : '';
		if ( '' !== $param && taxonomy_exists( $attr_tax ) ) {
			$tax_query[] = array(
				'taxonomy' => $attr_tax,
				'field'    => 'slug',
				'terms'    => $param,
			);
		}
	}

	// Filter by custom purchase mode (`order_type`: online_cart, phone_inquiry, official_tender).
	$order_mode = isset( $_GET['order_type'] ) ? sanitize_key( wp_unslash( $_GET['order_type'] ) ) : '';
	if ( in_array( $order_mode, array( 'online_cart', 'phone_inquiry', 'official_tender' ), true ) ) {
		$meta_query[] = array(
			'key'   => '_es_order_type',
			'value' => $order_mode,
		);
	}

	// Sorting (`orderby`: price-asc, price-desc, date).
	$orderby = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : '';
	if ( 'price' === $orderby || 'price-asc' === $orderby ) {
		$query->set( 'meta_key', '_regular_price' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
	} elseif ( 'price-desc' === $orderby ) {
		$query->set( 'meta_key', '_regular_price' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'DESC' );
	}

	if ( ! empty( $tax_query ) ) {
		$query->set( 'tax_query', array_values( array_filter( $tax_query ) ) );
	}
	if ( ! empty( $meta_query ) ) {
		$query->set( 'meta_query', array_values( array_filter( $meta_query ) ) );
	}
}
add_action( 'pre_get_posts', 'erfan_sanat_filter_product_archive_query', 20 );

/**
 * Ensures WordPress template hierarchy resolves `archive-product.php`, `single-product.php`,
 * and `taxonomy-product_cat.php` even if WooCommerce plugin is not active.
 *
 * @param string $template Resolved template path.
 * @return string
 */
function erfan_sanat_locate_product_templates( string $template ): string {
	if ( is_singular( 'product' ) ) {
		$custom = locate_template( array( 'single-product.php', 'woocommerce/single-product.php' ) );
		if ( $custom ) {
			return $custom;
		}
	}
	if ( is_tax( 'product_cat' ) ) {
		$custom = locate_template( array( 'taxonomy-product_cat.php', 'woocommerce/taxonomy-product_cat.php', 'archive-product.php' ) );
		if ( $custom ) {
			return $custom;
		}
	}
	if ( is_post_type_archive( 'product' ) ) {
		$custom = locate_template( array( 'archive-product.php', 'woocommerce/archive-product.php' ) );
		if ( $custom ) {
			return $custom;
		}
	}
	return $template;
}
add_filter( 'template_include', 'erfan_sanat_locate_product_templates', 20 );

/**
 * Returns the current cart items count (from WooCommerce if active, or native cookie cart).
 *
 * @return int
 */
function erfan_sanat_get_cart_count(): int {
	if ( function_exists( 'WC' ) && isset( WC()->cart ) && is_object( WC()->cart ) ) {
		return absint( WC()->cart->get_cart_contents_count() );
	}
	$items = erfan_sanat_get_native_cart_items();
	$total = 0;
	foreach ( $items as $qty ) {
		$total += absint( $qty );
	}
	return $total;
}

/**
 * Retrieves native fallback cart items `{product_id => quantity}` from cookie/request.
 *
 * @return array<int, int>
 */
function erfan_sanat_get_native_cart_items(): array {
	static $runtime_cart = null;
	if ( null !== $runtime_cart ) {
		return $runtime_cart;
	}
	$runtime_cart = array();
	if ( ! empty( $_COOKIE['es_cart_items'] ) ) {
		$decoded = json_decode( wp_unslash( (string) $_COOKIE['es_cart_items'] ), true );
		if ( is_array( $decoded ) ) {
			foreach ( $decoded as $pid => $qty ) {
				$pid = absint( $pid );
				$qty = absint( $qty );
				if ( $pid > 0 && $qty > 0 ) {
					$runtime_cart[ $pid ] = $qty;
				}
			}
		}
	}
	return $runtime_cart;
}

/**
 * Handles native `add-to-cart` requests when WooCommerce is not handling them or on custom forms.
 */
function erfan_sanat_handle_add_to_cart_request(): void {
	if ( class_exists( 'WooCommerce' ) ) {
		return;
	}

	$add_id = isset( $_REQUEST['add-to-cart'] ) ? absint( $_REQUEST['add-to-cart'] ) : 0;
	if ( $add_id <= 0 ) {
		return;
	}

	$product = get_post( $add_id );
	if ( ! $product || 'product' !== $product->post_type ) {
		return;
	}

	$purchase_data = erfan_sanat_get_product_purchase_data( $add_id );
	if ( ! $purchase_data['is_purchasable'] ) {
		return;
	}

	$qty   = isset( $_REQUEST['quantity'] ) ? max( $purchase_data['min_qty'], absint( $_REQUEST['quantity'] ) ) : $purchase_data['min_qty'];
	$items = erfan_sanat_get_native_cart_items();
	$items[ $add_id ] = ( $items[ $add_id ] ?? 0 ) + $qty;

	if ( ! headers_sent() ) {
		setcookie( 'es_cart_items', (string) wp_json_encode( $items ), time() + DAY_IN_SECONDS * 7, COOKIEPATH ?: '/' );
	}
	$_COOKIE['es_cart_items'] = (string) wp_json_encode( $items );
}
add_action( 'init', 'erfan_sanat_handle_add_to_cart_request', 20 );
