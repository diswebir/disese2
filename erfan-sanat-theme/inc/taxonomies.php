<?php
/**
 * Custom Taxonomies & Global Product Attributes Registration
 *
 * Registers:
 * - `project_cat` (/project-category/)
 * - `project_location` (/project-location/)
 * - `product_cat` (/product-category/)
 * - Global product attributes: `pa_voltage`, `pa_ip_rating`, `pa_control_protocol`,
 *   `pa_light_color`, `pa_beam_angle`, `pa_body_material`
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers all custom taxonomies and global product attribute taxonomies.
 */
function erfan_sanat_register_taxonomies(): void {
	// 1. Project Category (`project_cat`)
	register_taxonomy(
		'project_cat',
		array( 'project' ),
		array(
			'labels'            => array(
				'name'          => __( 'دسته‌بندی پروژه‌ها', 'erfan-sanat' ),
				'singular_name' => __( 'دسته پروژه', 'erfan-sanat' ),
				'search_items'  => __( 'جستجوی دسته‌های پروژه', 'erfan-sanat' ),
				'all_items'     => __( 'همه دسته‌های پروژه', 'erfan-sanat' ),
				'edit_item'     => __( 'ویرایش دسته پروژه', 'erfan-sanat' ),
				'add_new_item'  => __( 'افزودن دسته پروژه جدید', 'erfan-sanat' ),
				'menu_name'     => __( 'دسته‌بندی پروژه‌ها', 'erfan-sanat' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'         => 'project-category',
				'with_front'   => false,
				'hierarchical' => true,
			),
		)
	);

	// 2. Project Location (`project_location`)
	register_taxonomy(
		'project_location',
		array( 'project' ),
		array(
			'labels'            => array(
				'name'          => __( 'شهر و محل اجرای پروژه', 'erfan-sanat' ),
				'singular_name' => __( 'محل اجرا', 'erfan-sanat' ),
				'search_items'  => __( 'جستجوی شهرها', 'erfan-sanat' ),
				'all_items'     => __( 'همه شهرهای محل اجرا', 'erfan-sanat' ),
				'edit_item'     => __( 'ویرایش شهر محل اجرا', 'erfan-sanat' ),
				'add_new_item'  => __( 'افزودن شهر جدید', 'erfan-sanat' ),
				'menu_name'     => __( 'شهرهای محل اجرا', 'erfan-sanat' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'project-location',
				'with_front' => false,
			),
		)
	);

	// 3. Product Category (`product_cat`) if not already registered by WooCommerce
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		register_taxonomy(
			'product_cat',
			array( 'product' ),
			array(
				'labels'            => array(
					'name'          => __( 'دسته‌بندی محصولات', 'erfan-sanat' ),
					'singular_name' => __( 'دسته محصول', 'erfan-sanat' ),
					'search_items'  => __( 'جستجوی دسته‌های محصول', 'erfan-sanat' ),
					'all_items'     => __( 'همه دسته‌های محصول', 'erfan-sanat' ),
					'edit_item'     => __( 'ویرایش دسته محصول', 'erfan-sanat' ),
					'add_new_item'  => __( 'افزودن دسته محصول', 'erfan-sanat' ),
					'menu_name'     => __( 'دسته‌بندی محصولات', 'erfan-sanat' ),
				),
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'         => 'product-category',
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
	}

	// 4. Global Product Attributes (`pa_*`)
	$global_attributes = erfan_sanat_get_global_attributes_blueprint();
	foreach ( $global_attributes as $tax_name => $attr_data ) {
		if ( ! taxonomy_exists( $tax_name ) ) {
			register_taxonomy(
				$tax_name,
				array( 'product' ),
				array(
					'labels'            => array(
						'name'          => $attr_data['label'],
						'singular_name' => $attr_data['label'],
					),
					'hierarchical'      => false,
					'public'            => true,
					'show_ui'           => true,
					'show_admin_column' => false,
					'show_in_nav_menus' => false,
					'show_in_rest'      => true,
					'rewrite'           => array(
						'slug'       => str_replace( 'pa_', 'attribute-', $tax_name ),
						'with_front' => false,
					),
				)
			);
		}
	}
}
add_action( 'init', 'erfan_sanat_register_taxonomies', 6 );

/**
 * Returns the blueprint of global product attributes and their required terms.
 *
 * @return array<string, array<string, mixed>>
 */
function erfan_sanat_get_global_attributes_blueprint(): array {
	return array(
		'pa_voltage' => array(
			'label' => __( 'ولتاژ ورودی', 'erfan-sanat' ),
			'terms' => array(
				'12v-dc'  => '۱۲ ولت DC',
				'24v-dc'  => '۲۴ ولت DC',
				'220v-ac' => '۲۲۰ ولت AC (برق مستقیم شهری)',
			),
		),
		'pa_ip_rating' => array(
			'label' => __( 'درجه حفاظت (IP)', 'erfan-sanat' ),
			'terms' => array(
				'ip65' => 'IP65 (ضد گردوغبار و پاشش آب)',
				'ip67' => 'IP67 (مقاوم در برابر غوطه‌وری موقت)',
				'ip68' => 'IP68 (آب‌بندی کامل صنعتی و غوطه‌وری مداوم)',
			),
		),
		'pa_control_protocol' => array(
			'label' => __( 'پروتکل کنترل هوشمند', 'erfan-sanat' ),
			'terms' => array(
				'dmx512'      => 'پروتکل صنعتی DMX512',
				'spi-ws2811'  => 'دیجیتال آدرس‌پذیر SPI (WS2811 / NRF)',
				'spi-ucs1903' => 'دیجیتال آدرس‌پذیر SPI (UCS1903)',
				'analog-mono' => 'تک‌رنگ / آنالوگ ثابت',
			),
		),
		'pa_light_color' => array(
			'label' => __( 'طیف و رنگ نور', 'erfan-sanat' ),
			'terms' => array(
				'full-color-rgb'  => 'فول‌کالر هوشمند (۱۶ میلیون رنگ RGB)',
				'rgbw'            => 'چهاررنگ ترکیبی (RGBW)',
				'sun-amber'       => 'آفتابی گرم / کهربایی',
				'warm-white-3000k' => 'سفید گرم (3000K)',
				'cool-white-6000k' => 'سفید مهتابی (6000K)',
			),
		),
		'pa_beam_angle' => array(
			'label' => __( 'زاویه تابش لنز', 'erfan-sanat' ),
			'terms' => array(
				'lens-15-deg'  => 'لنز متمرکز ۱۵ درجه',
				'lens-45-deg'  => 'لنز نیمه‌پخش ۴۵ درجه',
				'lens-120-deg' => 'پخش کامل ۱۲۰ درجه (Flood)',
			),
		),
		'pa_body_material' => array(
			'label' => __( 'جنس بدنه و سازه', 'erfan-sanat' ),
			'terms' => array(
				'aluminum-diecast' => 'آلومینیوم دایکاست و اکسترود',
				'galvanized-iron'  => 'فولاد گالوانیزه با رنگ کوره الکترواستاتیک',
				'polycarbonate'    => 'پلی‌کربنات نشکن آنتی‌یووی (Anti-UV PC)',
			),
		),
	);
}

/**
 * Returns the blueprint of hierarchical product categories (`product_cat`).
 *
 * @return array<string, array<string, mixed>>
 */
function erfan_sanat_get_product_categories_blueprint(): array {
	return array(
		'urban-lighting-elements' => array(
			'name'     => 'المان‌های نورپردازی شهری',
			'desc'     => 'طراحی و تولید سازه‌های نوری حجمی، لوسترهای شهری، درختان نوری و تونل‌های نوری هوشمند.',
			'children' => array(
				'square-elements'       => 'المان‌های نوری میادین و خورشیدنما',
				'urban-chandeliers'     => 'لوسترهای شهری و فضای باز',
				'pole-mounted-elements' => 'المان‌های نصبی پایه چراغ و بلوار',
				'light-trees'           => 'درختان نوری هوشمند',
				'light-tunnels'         => 'تونل‌های نوری شهری',
			),
		),
		'decorative-light-strings' => array(
			'name'     => 'ریسه‌های نوری تزیینی و شهری',
			'desc'     => 'انواع ریسه‌های پیکسلی بلوطی، فندقی، سوزنی و نئون فلکسی با درجه حفاظت IP67.',
			'children' => array(
				'pixel-strings-berry' => 'ریسه بلوطی و فندقی پیکسلی',
				'neon-flex'           => 'ریسه نئون فلکسی دوطرفه',
				'strip-lights'        => 'ریسه خطی و شلنگی صنعتی',
				'string-fairy-lights' => 'ریسه سوزنی LED شهری',
			),
		),
		'architectural-facade-lighting' => array(
			'name'     => 'نورپردازی نما و معماری',
			'desc'     => 'وال‌واشرهای خطی، پروژکتورها، چراغ‌های دفنی و جت‌لایت‌های مخصوص نمای ساختمان و پل.',
			'children' => array(
				'wall-washers'    => 'وال‌واشر LED خطی',
				'flood-lights'    => 'پروژکتور نما و فضای باز',
				'inground-lights' => 'چراغ دفنی ضدآب',
				'jet-lights'      => 'جت‌لایت نوری نما',
			),
		),
		'pixel-point-lights' => array(
			'name'     => 'پوینت‌لایت و پیکسل نوری',
			'desc'     => 'پیکسل‌های نقطه‌ای آدرس‌پذیر DMX و SPI به همراه تیوب‌های دیجیتال سه‌بعدی.',
			'children' => array(
				'dmx-point-lights' => 'پوینت‌لایت صنعتی DMX',
				'spi-point-lights' => 'پوینت‌لایت پیکسلی SPI',
				'digital-tubes-3d' => 'تیوب دیجیتال سه‌بعدی (3D Tube)',
			),
		),
		'controllers-power-supplies' => array(
			'name'     => 'کنترلر، منبع تغذیه و تجهیزات جانبی',
			'desc'     => 'جعبه کنترل مرکزی هوشمند WiFi/NRF، کنترلرهای DMX/ArtNet، پاور سوییچینگ و قاب نگهدارنده PLT.',
			'children' => array(
				'dmx-artnet-controllers'       => 'کنترلرهای DMX و ArtNet',
				'spi-led-controllers'          => 'باکس کنترل هوشمند SPI و NRF',
				'switching-power-supplies'     => 'منبع تغذیه سوییچینگ صنعتی',
				'waterproof-connectors-cables' => 'کانکتور ضدآب، کابل و قاب PLT',
			),
		),
	);
}

/**
 * Returns the blueprint of project categories and locations.
 *
 * @return array<string, array<string, string>>
 */
function erfan_sanat_get_project_taxonomies_blueprint(): array {
	return array(
		'project_cat' => array(
			'urban-beautification'         => 'زیباسازی و المان‌های شهری',
			'light-tunnels-walkways'       => 'تونل‌های نوری و مسیرهای پیاده‌راه',
			'bridges-monuments'            => 'نورپردازی پل‌ها و ابنیه شاخص',
			'parks-landscapes'             => 'پارک‌ها، بوستان‌ها و فضای سبز',
			'occasional-lighting-projects' => 'نورپردازی مناسبتی و جشنواره‌ها',
		),
		'project_location' => array(
			'isfahan'      => 'اصفهان',
			'tehran'       => 'تهران',
			'mashhad'      => 'مشهد',
			'shiraz'       => 'شیراز',
			'south-coasts' => 'سواحل جنوب (کیش، چابهار، بوشهر)',
			'other-cities' => 'سایر شهرهای کشور (کرمان، قم، انزلی، البرز)',
		),
	);
}

/**
 * Returns the blueprint of blog categories and technical tags.
 *
 * @return array<string, array<string, string>>
 */
function erfan_sanat_get_blog_taxonomies_blueprint(): array {
	return array(
		'category' => array(
			'software-controllers-tutorials' => 'آموزش نرم‌افزار و کنترلرهای نوری',
			'lighting-standards'             => 'استانداردهای روشنایی و درجه حفاظت',
			'troubleshooting-wiring'         => 'عیب‌یابی، کابل‌کشی و نصب فنی',
			'company-news-events'            => 'اخبار و رویدادهای عرفان صنعت',
		),
		'post_tag' => array(
			'ws2811-controller'        => 'کنترلر WS2811',
			'dmx-addressing'           => 'آدرس‌دهی DMX',
			'voltage-drop-calculation' => 'محاسبه افت ولتاژ',
		),
	);
}

/**
 * Ensures all required taxonomy terms exist in the database.
 */
function erfan_sanat_seed_required_terms(): void {
	// 1. Seed Product Categories (`product_cat`)
	if ( taxonomy_exists( 'product_cat' ) ) {
		foreach ( erfan_sanat_get_product_categories_blueprint() as $parent_slug => $parent_data ) {
			$existing_parent = term_exists( $parent_slug, 'product_cat' );
			if ( ! $existing_parent ) {
				$existing_parent = wp_insert_term(
					$parent_data['name'],
					'product_cat',
					array(
						'slug'        => $parent_slug,
						'description' => $parent_data['desc'] ?? '',
					)
				);
			}
			$parent_id = is_array( $existing_parent ) ? (int) $existing_parent['term_id'] : (int) $existing_parent;

			if ( $parent_id > 0 && ! empty( $parent_data['children'] ) ) {
				foreach ( $parent_data['children'] as $child_slug => $child_name ) {
					if ( ! term_exists( $child_slug, 'product_cat' ) ) {
						wp_insert_term(
							$child_name,
							'product_cat',
							array(
								'slug'   => $child_slug,
								'parent' => $parent_id,
							)
						);
					}
				}
			}
		}
	}

	// 2. Seed Global Product Attributes (`pa_*`)
	foreach ( erfan_sanat_get_global_attributes_blueprint() as $tax_name => $attr_data ) {
		if ( taxonomy_exists( $tax_name ) ) {
			foreach ( $attr_data['terms'] as $term_slug => $term_label ) {
				if ( ! term_exists( $term_slug, $tax_name ) ) {
					wp_insert_term( $term_label, $tax_name, array( 'slug' => $term_slug ) );
				}
			}
		}
	}

	// 3. Seed Project Taxonomies (`project_cat`, `project_location`)
	foreach ( erfan_sanat_get_project_taxonomies_blueprint() as $tax_name => $terms ) {
		if ( taxonomy_exists( $tax_name ) ) {
			foreach ( $terms as $term_slug => $term_label ) {
				if ( ! term_exists( $term_slug, $tax_name ) ) {
					wp_insert_term( $term_label, $tax_name, array( 'slug' => $term_slug ) );
				}
			}
		}
	}

	// 4. Seed Blog Categories and Tags
	foreach ( erfan_sanat_get_blog_taxonomies_blueprint() as $tax_name => $terms ) {
		if ( taxonomy_exists( $tax_name ) ) {
			foreach ( $terms as $term_slug => $term_label ) {
				if ( ! term_exists( $term_slug, $tax_name ) ) {
					wp_insert_term( $term_label, $tax_name, array( 'slug' => $term_slug ) );
				}
			}
		}
	}
}
add_action( 'after_switch_theme', 'erfan_sanat_seed_required_terms', 20 );
