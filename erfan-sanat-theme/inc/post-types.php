<?php
/**
 * Custom Post Types, Rewrite Rules & Content Metadata Architecture
 *
 * Registers:
 * - `project` CPT (/project/%postname%/, archive /projects/)
 * - `product` CPT fallback when WooCommerce is not active (/product/%postname%/, archive /shop/ & /products/)
 * - Custom meta boxes and sanitized save handlers for Products, Projects, and Technical Blog Posts.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the `project` Custom Post Type and `product` fallback if WooCommerce is inactive.
 */
function erfan_sanat_register_post_types(): void {
	$project_labels = array(
		'name'               => __( 'پروژه‌های نورپردازی', 'erfan-sanat' ),
		'singular_name'      => __( 'پروژه نورپردازی', 'erfan-sanat' ),
		'menu_name'          => __( 'پروژه‌های شهری', 'erfan-sanat' ),
		'add_new'            => __( 'افزودن پروژه جدید', 'erfan-sanat' ),
		'add_new_item'       => __( 'افزودن پروژه نورپردازی جدید', 'erfan-sanat' ),
		'edit_item'          => __( 'ویرایش پروژه', 'erfan-sanat' ),
		'new_item'           => __( 'پروژه جدید', 'erfan-sanat' ),
		'view_item'          => __( 'مشاهده پروژه', 'erfan-sanat' ),
		'search_items'       => __( 'جستجوی پروژه‌ها', 'erfan-sanat' ),
		'not_found'          => __( 'پروژه‌ای یافت نشد.', 'erfan-sanat' ),
		'not_found_in_trash' => __( 'پروژه‌ای در زباله‌دان یافت نشد.', 'erfan-sanat' ),
		'all_items'          => __( 'همه پروژه‌ها', 'erfan-sanat' ),
	);

	register_post_type(
		'project',
		array(
			'labels'             => $project_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'query_var'          => true,
			'menu_icon'          => 'dashicons-building',
			'capability_type'    => 'post',
			'has_archive'        => 'projects',
			'hierarchical'       => false,
			'menu_position'      => 21,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
			'rewrite'            => array(
				'slug'       => 'project',
				'with_front' => false,
			),
		)
	);

	// Register `product` post type if WooCommerce plugin is not currently active.
	if ( ! class_exists( 'WooCommerce' ) && ! post_type_exists( 'product' ) ) {
		$product_labels = array(
			'name'               => __( 'محصولات نورپردازی', 'erfan-sanat' ),
			'singular_name'      => __( 'محصول', 'erfan-sanat' ),
			'menu_name'          => __( 'محصولات (فروشگاه)', 'erfan-sanat' ),
			'add_new'            => __( 'افزودن محصول', 'erfan-sanat' ),
			'add_new_item'       => __( 'افزودن محصول نورپردازی جدید', 'erfan-sanat' ),
			'edit_item'          => __( 'ویرایش محصول', 'erfan-sanat' ),
			'view_item'          => __( 'مشاهده محصول', 'erfan-sanat' ),
			'all_items'          => __( 'همه محصولات', 'erfan-sanat' ),
			'search_items'       => __( 'جستجوی محصولات', 'erfan-sanat' ),
			'not_found'          => __( 'محصولی یافت نشد.', 'erfan-sanat' ),
		);

		register_post_type(
			'product',
			array(
				'labels'             => $product_labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => true,
				'query_var'          => true,
				'menu_icon'          => 'dashicons-lightbulb',
				'capability_type'    => 'post',
				'has_archive'        => 'shop',
				'hierarchical'       => false,
				'menu_position'      => 20,
				'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
				'rewrite'            => array(
					'slug'       => 'product',
					'with_front' => false,
				),
			)
		);
	}
}
add_action( 'init', 'erfan_sanat_register_post_types', 5 );

/**
 * Registers custom rewrite rules for `/products/`, `/shop/`, and `/blog/` routes.
 */
function erfan_sanat_register_rewrite_rules(): void {
	// Support both `/shop/` and `/products/` as product archive routes.
	add_rewrite_rule( '^products/?$', 'index.php?post_type=product', 'top' );
	add_rewrite_rule( '^products/page/([0-9]{1,})/?$', 'index.php?post_type=product&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^shop/?$', 'index.php?post_type=product', 'top' );
	add_rewrite_rule( '^shop/page/([0-9]{1,})/?$', 'index.php?post_type=product&paged=$matches[1]', 'top' );

	// Support `/projects/` archive, pagination, and `/projects/%postname%/` alias.
	add_rewrite_rule( '^projects/?$', 'index.php?post_type=project', 'top' );
	add_rewrite_rule( '^projects/page/([0-9]{1,})/?$', 'index.php?post_type=project&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^projects/([^/]+)/?$', 'index.php?project=$matches[1]&post_type=project&name=$matches[1]', 'top' );

	// Support `/project-city/%term%/` alias alongside `/project-location/%term%/`.
	add_rewrite_rule( '^project-city/([^/]+)/?$', 'index.php?project_location=$matches[1]', 'top' );

	// Support `/blog/%postname%/` single post permalink and `/blog/` archive.
	add_rewrite_rule( '^blog/page/([0-9]{1,})/?$', 'index.php?post_type=post&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^blog/([^/]+)/?$', 'index.php?name=$matches[1]&post_type=post', 'top' );
}
add_action( 'init', 'erfan_sanat_register_rewrite_rules', 15 );

/**
 * Returns the canonical schema of custom meta fields for Products, Projects, and Blog Posts.
 *
 * @return array<string, array<string, array<string, mixed>>>
 */
function erfan_sanat_get_post_meta_schema(): array {
	return array(
		'product' => array(
			'_es_is_purchasable_online' => array(
				'type'    => 'boolean',
				'label'   => __( 'قابل خرید آنلاین (افزودن مستقیم به سبد خرید)', 'erfan-sanat' ),
				'default' => true,
			),
			'_es_order_type' => array(
				'type'    => 'select',
				'label'   => __( 'مدل ثبت سفارش و فروش محصول', 'erfan-sanat' ),
				'default' => 'online_cart',
				'options' => array(
					'online_cart'     => __( 'خرید آنلاین (Online Cart)', 'erfan-sanat' ),
					'phone_inquiry'   => __( 'استعلام تلفنی قیمت (Phone Inquiry)', 'erfan-sanat' ),
					'official_tender' => __( 'مناقصه رسمی و پیش‌فاکتور سازمانی (Official Tender)', 'erfan-sanat' ),
				),
			),
			'_es_inquiry_phone' => array(
				'type'    => 'text',
				'label'   => __( 'شماره تماس اختصاصی استعلام این محصول', 'erfan-sanat' ),
				'default' => '031-91091011',
			),
			'_es_custom_price_badge' => array(
				'type'    => 'text',
				'label'   => __( 'برچسب جایگزین قیمت (در صورت استعلامی بودن)', 'erfan-sanat' ),
				'default' => '',
			),
			'_es_min_order_qty' => array(
				'type'    => 'number',
				'label'   => __( 'حداقل تعداد سفارش (عدد / متر)', 'erfan-sanat' ),
				'default' => 1,
			),
			'_es_production_lead_time' => array(
				'type'    => 'text',
				'label'   => __( 'زمان آماده‌سازی و تحویل (Lead Time)', 'erfan-sanat' ),
				'default' => '۳ تا ۷ روز کاری',
			),
			'_es_wattage_rating' => array(
				'type'    => 'number',
				'label'   => __( 'توان مصرفی (وات)', 'erfan-sanat' ),
				'default' => 12,
			),
			'_es_chip_brand' => array(
				'type'    => 'text',
				'label'   => __( 'برند چیپ ال‌ای‌دی (Chip Brand)', 'erfan-sanat' ),
				'default' => 'Epistar Taiwan',
			),
			'_es_technical_datasheet_pdf' => array(
				'type'    => 'media',
				'label'   => __( 'فایل دیتاشیت فنی (PDF)', 'erfan-sanat' ),
				'default' => '',
			),
			'_es_wiring_schematic_img' => array(
				'type'    => 'media',
				'label'   => __( 'تصویر نقشه سیم‌کشی و سربندی (Schematic)', 'erfan-sanat' ),
				'default' => '',
			),
			'_es_demo_video_url' => array(
				'type'    => 'url',
				'label'   => __( 'لینک ویدیو تست افکت نوری محصول', 'erfan-sanat' ),
				'default' => '',
			),
		),
		'project' => array(
			'_es_project_client' => array(
				'type'    => 'text',
				'label'   => __( 'کارفرمای پروژه (شهرداری / سازمان)', 'erfan-sanat' ),
				'default' => 'شهرداری و سازمان زیباسازی',
			),
			'_es_completion_date' => array(
				'type'    => 'date_or_text',
				'label'   => __( 'تاریخ تکمیل و بهره‌برداری پروژه', 'erfan-sanat' ),
				'default' => '۱۴۰۴/۰۶/۱۵',
			),
			'_es_total_pixel_count' => array(
				'type'    => 'number',
				'label'   => __( 'تعداد کل پیکسل‌ها / نقاط نوری', 'erfan-sanat' ),
				'default' => 4800,
			),
			'_es_total_power_kw' => array(
				'type'    => 'number',
				'label'   => __( 'مجموع توان مصرفی پروژه (کیلووات)', 'erfan-sanat' ),
				'default' => 3.5,
			),
			'_es_before_after_gallery' => array(
				'type'    => 'gallery',
				'label'   => __( 'گالری تصاویر قبل و بعد / مراحل اجرای پروژه', 'erfan-sanat' ),
				'default' => array(),
			),
			'_es_project_drone_video' => array(
				'type'    => 'media',
				'label'   => __( 'ویدیو هوایی هلی‌شات پروژه (Drone Video)', 'erfan-sanat' ),
				'default' => '',
			),
			'_es_project_map_coords' => array(
				'type'    => 'text',
				'label'   => __( 'مختصات جغرافیایی محل اجرا (Lat, Lng)', 'erfan-sanat' ),
				'default' => '32.6539, 51.6660',
			),
		),
		'post' => array(
			'_es_reading_time_min' => array(
				'type'    => 'number',
				'label'   => __( 'زمان تقریبی مطالعه (دقیقه)', 'erfan-sanat' ),
				'default' => 6,
			),
			'_es_technical_reviewer' => array(
				'type'    => 'text',
				'label'   => __( 'بازبین فنی مقاله (واحد مهندسی)', 'erfan-sanat' ),
				'default' => 'واحد تحقیق و توسعه (R&D) عرفان صنعت اصفهان',
			),
			'_es_software_project_file' => array(
				'type'    => 'media',
				'label'   => __( 'فایل ضمیمه مهندسی / پروژه نرم‌افزاری کنترلر', 'erfan-sanat' ),
				'default' => '',
			),
			'_es_faq_schema_repeater' => array(
				'type'    => 'repeater',
				'label'   => __( 'سوالات متداول فنی مقاله (FAQ Schema)', 'erfan-sanat' ),
				'default' => array(),
			),
		),
	);
}

/**
 * Registers custom meta boxes for `product`, `project`, and `post`.
 */
function erfan_sanat_register_meta_boxes(): void {
	add_meta_box(
		'es_product_engineering_meta',
		__( 'مشخصات فنی، نحوه فروش و اسناد مهندسی (عرفان صنعت)', 'erfan-sanat' ),
		'erfan_sanat_render_product_meta_box',
		'product',
		'normal',
		'high'
	);

	add_meta_box(
		'es_project_engineering_meta',
		__( 'شناسنامه فنی و اطلاعات اجرایی پروژه نورپردازی', 'erfan-sanat' ),
		'erfan_sanat_render_project_meta_box',
		'project',
		'normal',
		'high'
	);

	add_meta_box(
		'es_post_technical_meta',
		__( 'متادیتای تخصصی مقاله و سوالات متداول (FAQ Schema)', 'erfan-sanat' ),
		'erfan_sanat_render_post_meta_box',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'erfan_sanat_register_meta_boxes' );

/**
 * Renders the Product Engineering & Purchase Mode meta box.
 *
 * @param WP_Post $post Current product post object.
 */
function erfan_sanat_render_product_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'erfan_sanat_save_post_meta', 'erfan_sanat_meta_nonce' );
	$schema = erfan_sanat_get_post_meta_schema()['product'];
	$price  = get_post_meta( $post->ID, '_regular_price', true );
	?>
	<div class="es-admin-metabox-grid">
		<div class="es-meta-field">
			<label for="_regular_price"><strong><?php esc_html_e( 'قیمت پایه محصول (تومان)', 'erfan-sanat' ); ?></strong></label>
			<input type="number" id="_regular_price" name="_regular_price" value="<?php echo esc_attr( (string) $price ); ?>" class="regular-text" min="0" step="1000" />
		</div>
		<?php foreach ( $schema as $meta_key => $cfg ) : ?>
			<?php
			$saved = get_post_meta( $post->ID, $meta_key, true );
			$val   = ( '' !== $saved && false !== $saved ) ? $saved : $cfg['default'];
			?>
			<div class="es-meta-field">
				<label for="<?php echo esc_attr( $meta_key ); ?>"><strong><?php echo esc_html( $cfg['label'] ); ?></strong></label>
				<?php if ( 'boolean' === $cfg['type'] ) : ?>
					<label class="es-toggle-label">
						<input type="checkbox" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>" value="1" <?php checked( ! empty( $val ) ); ?> />
						<span><?php esc_html_e( 'فعال', 'erfan-sanat' ); ?></span>
					</label>
				<?php elseif ( 'select' === $cfg['type'] ) : ?>
					<select id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>">
						<?php foreach ( $cfg['options'] as $opt_val => $opt_label ) : ?>
							<option value="<?php echo esc_attr( $opt_val ); ?>" <?php selected( (string) $val, (string) $opt_val ); ?>>
								<?php echo esc_html( $opt_label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php elseif ( 'number' === $cfg['type'] ) : ?>
					<input type="number" step="any" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>" value="<?php echo esc_attr( (string) $val ); ?>" class="regular-text" />
				<?php else : ?>
					<input type="text" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>" value="<?php echo esc_attr( (string) $val ); ?>" class="large-text" />
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Renders the Project Engineering meta box.
 *
 * @param WP_Post $post Current project post object.
 */
function erfan_sanat_render_project_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'erfan_sanat_save_post_meta', 'erfan_sanat_meta_nonce' );
	$schema = erfan_sanat_get_post_meta_schema()['project'];
	?>
	<div class="es-admin-metabox-grid">
		<?php foreach ( $schema as $meta_key => $cfg ) : ?>
			<?php
			$saved = get_post_meta( $post->ID, $meta_key, true );
			$val   = ( '' !== $saved && false !== $saved ) ? $saved : $cfg['default'];
			if ( is_array( $val ) ) {
				$val = implode( ',', $val );
			}
			?>
			<div class="es-meta-field">
				<label for="<?php echo esc_attr( $meta_key ); ?>"><strong><?php echo esc_html( $cfg['label'] ); ?></strong></label>
				<?php if ( 'number' === $cfg['type'] ) : ?>
					<input type="number" step="any" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>" value="<?php echo esc_attr( (string) $val ); ?>" class="regular-text" />
				<?php else : ?>
					<input type="text" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>" value="<?php echo esc_attr( (string) $val ); ?>" class="large-text" />
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Renders the Technical Blog Post meta box with FAQ Schema Repeater.
 *
 * @param WP_Post $post Current blog post object.
 */
function erfan_sanat_render_post_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'erfan_sanat_save_post_meta', 'erfan_sanat_meta_nonce' );
	$reading_time = get_post_meta( $post->ID, '_es_reading_time_min', true );
	$reviewer     = get_post_meta( $post->ID, '_es_technical_reviewer', true );
	$project_file = get_post_meta( $post->ID, '_es_software_project_file', true );
	$faqs         = get_post_meta( $post->ID, '_es_faq_schema_repeater', true );
	if ( ! is_array( $faqs ) ) {
		$faqs = array();
	}
	?>
	<div class="es-admin-metabox-grid">
		<div class="es-meta-field">
			<label for="_es_reading_time_min"><strong><?php esc_html_e( 'زمان مطالعه (دقیقه)', 'erfan-sanat' ); ?></strong></label>
			<input type="number" id="_es_reading_time_min" name="_es_reading_time_min" value="<?php echo esc_attr( (string) ( $reading_time ?: 6 ) ); ?>" min="1" max="120" />
		</div>
		<div class="es-meta-field">
			<label for="_es_technical_reviewer"><strong><?php esc_html_e( 'بازبین فنی مقاله', 'erfan-sanat' ); ?></strong></label>
			<input type="text" id="_es_technical_reviewer" name="_es_technical_reviewer" value="<?php echo esc_attr( (string) ( $reviewer ?: 'واحد تحقیق و توسعه (R&D) عرفان صنعت اصفهان' ) ); ?>" class="large-text" />
		</div>
		<div class="es-meta-field">
			<label for="_es_software_project_file"><strong><?php esc_html_e( 'فایل ضمیمه پروژه نرم‌افزاری / نقشه (URL یا ID رسانه)', 'erfan-sanat' ); ?></strong></label>
			<input type="text" id="_es_software_project_file" name="_es_software_project_file" value="<?php echo esc_attr( (string) $project_file ); ?>" class="large-text" />
		</div>
		<div class="es-meta-field es-meta-full">
			<label><strong><?php esc_html_e( 'سوالات متداول فنی مقاله (FAQ Schema Repeater)', 'erfan-sanat' ); ?></strong></label>
			<div class="es-faq-repeater-wrap" id="es-post-faq-repeater">
				<?php foreach ( $faqs as $idx => $faq_item ) : ?>
					<div class="es-repeater-item">
						<input type="text" name="_es_faq_schema_repeater[<?php echo (int) $idx; ?>][question]" value="<?php echo esc_attr( $faq_item['question'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'عنوان سوال فنی...', 'erfan-sanat' ); ?>" class="large-text" />
						<textarea name="_es_faq_schema_repeater[<?php echo (int) $idx; ?>][answer]" rows="2" placeholder="<?php esc_attr_e( 'پاسخ دقیق مهندسی...', 'erfan-sanat' ); ?>" class="large-text"><?php echo esc_textarea( $faq_item['answer'] ?? '' ); ?></textarea>
					</div>
				<?php endforeach; ?>
				<div class="es-repeater-item">
					<input type="text" name="_es_faq_schema_repeater[<?php echo count( $faqs ); ?>][question]" value="" placeholder="<?php esc_attr_e( 'افزودن سوال جدید...', 'erfan-sanat' ); ?>" class="large-text" />
					<textarea name="_es_faq_schema_repeater[<?php echo count( $faqs ); ?>][answer]" rows="2" placeholder="<?php esc_attr_e( 'پاسخ سوال جدید...', 'erfan-sanat' ); ?>" class="large-text"></textarea>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Sanitizes and saves custom metadata for `product`, `project`, and `post`.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function erfan_sanat_save_post_meta( int $post_id, WP_Post $post ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	$nonce = isset( $_POST['erfan_sanat_meta_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['erfan_sanat_meta_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'erfan_sanat_save_post_meta' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$all_schemas = erfan_sanat_get_post_meta_schema();
	$post_type   = $post->post_type;

	if ( 'product' === $post_type && isset( $_POST['_regular_price'] ) ) {
		$raw_price = sanitize_text_field( wp_unslash( $_POST['_regular_price'] ) );
		$num_price = is_numeric( $raw_price ) ? max( 0, (float) $raw_price ) : '';
		update_post_meta( $post_id, '_regular_price', $num_price );
		update_post_meta( $post_id, '_price', $num_price );
	}

	if ( ! isset( $all_schemas[ $post_type ] ) ) {
		return;
	}

	foreach ( $all_schemas[ $post_type ] as $meta_key => $cfg ) {
		$type = $cfg['type'] ?? 'text';

		if ( 'boolean' === $type ) {
			$is_checked = isset( $_POST[ $meta_key ] ) && erfan_sanat_sanitize_bool( wp_unslash( $_POST[ $meta_key ] ) );
			update_post_meta( $post_id, $meta_key, $is_checked ? '1' : '0' );
			continue;
		}

		if ( ! array_key_exists( $meta_key, $_POST ) ) {
			continue;
		}

		$raw = wp_unslash( $_POST[ $meta_key ] );

		switch ( $type ) {
			case 'select':
				$val     = sanitize_key( (string) $raw );
				$allowed = isset( $cfg['options'] ) ? array_keys( $cfg['options'] ) : array();
				if ( ! in_array( $val, $allowed, true ) ) {
					$val = $cfg['default'];
				}
				update_post_meta( $post_id, $meta_key, $val );
				break;

			case 'number':
				$num = is_numeric( $raw ) ? (float) $raw : (float) $cfg['default'];
				update_post_meta( $post_id, $meta_key, $num );
				break;

			case 'url':
				update_post_meta( $post_id, $meta_key, esc_url_raw( (string) $raw ) );
				break;

			case 'media':
				if ( is_numeric( $raw ) ) {
					update_post_meta( $post_id, $meta_key, absint( $raw ) );
				} else {
					update_post_meta( $post_id, $meta_key, esc_url_raw( (string) $raw ) );
				}
				break;

			case 'gallery':
				update_post_meta( $post_id, $meta_key, erfan_sanat_sanitize_gallery( $raw ) );
				break;

			case 'repeater':
				$clean_faqs = array();
				if ( is_array( $raw ) ) {
					foreach ( $raw as $row ) {
						if ( ! is_array( $row ) ) {
							continue;
						}
						$q = isset( $row['question'] ) ? sanitize_text_field( (string) $row['question'] ) : '';
						$a = isset( $row['answer'] ) ? sanitize_textarea_field( (string) $row['answer'] ) : '';
						if ( '' !== $q && '' !== $a ) {
							$clean_faqs[] = array(
								'question' => $q,
								'answer'   => $a,
							);
						}
					}
				}
				update_post_meta( $post_id, $meta_key, $clean_faqs );
				break;

			case 'date_or_text':
			case 'text':
			default:
				update_post_meta( $post_id, $meta_key, sanitize_text_field( (string) $raw ) );
				break;
		}
	}
}
add_action( 'save_post', 'erfan_sanat_save_post_meta', 10, 2 );
