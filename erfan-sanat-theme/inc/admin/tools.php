<?php
/**
 * System Tools, Rewrite Rules Manager & Enterprise Demo Data Seeder
 *
 * Seeds complete, authentic Erfan Sanat Isfahan products (all 3 purchase modes),
 * urban lighting projects, technical blog articles (with FAQ schema), and taxonomies.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Seeds authentic Erfan Sanat content (Products, Projects, Technical Articles, Pages, Taxonomies).
 *
 * @return array<string, int> Summary counts of seeded entities.
 */
function erfan_sanat_seed_enterprise_demo_data(): array {
	erfan_sanat_seed_required_terms();

	$counts = array(
		'products' => 0,
		'projects' => 0,
		'posts'    => 0,
		'pages'    => 0,
	);

	// 1. Seed Products covering online_cart, phone_inquiry, and official_tender.
	$products_blueprint = array(
		array(
			'slug'    => 'baloti-dimensional-full-color',
			'title'   => 'ریسه بلوطی فول کالر هوشمند (۲۰ شعله ۱۰ متری)',
			'excerpt' => 'ریسه بلوطی حبابی فول‌کالر آدرس‌پذیر با حباب پلی‌کربنات نشکن آنتی‌یووی، جوش اولتراسونیک، درجه حفاظت IP67 و قابلیت نمایش ۱۶ میلیون رنگ.',
			'content' => '<p>ریسه بلوطی فول کالر شرکت دانش‌بنیان عرفان صنعت اصفهان، اولین ریسه پیکسلی تولید ملی با استاندارد حفاظت IP67 و قابلیت کنترل هوشمند از طریق اپلیکیشن موبایل و پروتکل بی‌سیم NRF است. در هر حباب ۹ عدد SMD LED با چیپ Epistar تعبیه شده که روشنایی یکنواخت و مصرف انرژی بسیار بهینه‌ای را فراهم می‌سازد.</p><h3>مشخصات فنی و اجرایی</h3><ul><li>جنس حباب: پلی‌کربنات نشکن مقاوم در برابر اشعه UV خورشید</li><li>آب‌بندی صنعتی با جوش اولتراسونیک و تزریق رزین اپوکسی</li><li>مناسب برای سقف‌های نوری، تونل‌های نوری و آذین‌بندی معابر شهری</li></ul>',
			'cats'    => array( 'decorative-light-strings', 'pixel-strings-berry' ),
			'attrs'   => array(
				'pa_voltage'          => array( '12v-dc', '24v-dc' ),
				'pa_ip_rating'        => array( 'ip67' ),
				'pa_control_protocol' => array( 'spi-ws2811' ),
				'pa_light_color'      => array( 'full-color-rgb' ),
				'pa_beam_angle'       => array( 'lens-120-deg' ),
				'pa_body_material'    => array( 'polycarbonate' ),
			),
			'price'   => 18800000,
			'img'     => ES_THEME_URI . 'assets/images/string-lights.jpg',
			'meta'    => array(
				'_es_is_purchasable_online' => '1',
				'_es_order_type'            => 'online_cart',
				'_es_inquiry_phone'         => '031-91091011',
				'_es_custom_price_badge'    => '',
				'_es_min_order_qty'         => 1,
				'_es_production_lead_time'  => 'ارسال فوری از انبار کارخانه',
				'_es_wattage_rating'        => 20,
				'_es_chip_brand'            => 'Epistar Taiwan',
			),
		),
		array(
			'slug'    => 'fandoghi-single-color-led',
			'title'   => 'ریسه فندقی LED شهری ضدضربه (IP67)',
			'excerpt' => 'ریسه فندقی نشکن پلی‌کربنات در طیف‌های تک‌رنگ، هفت‌رنگ و فول‌کالر با کابل تمام مس دولایه مخصوص پروژه‌های شهری.',
			'content' => '<p>ریسه فندقی عرفان صنعت اصفهان با طراحی فشرده و مقاومت مکانیکی بالا، بهترین گزینه برای نورپردازی درختان طبیعی، ستون‌ها، تیرهای چراغ برق و سقف‌های نوری خیابان‌ها است.</p>',
			'cats'    => array( 'decorative-light-strings', 'pixel-strings-berry' ),
			'attrs'   => array(
				'pa_voltage'          => array( '220v-ac', '24v-dc' ),
				'pa_ip_rating'        => array( 'ip67' ),
				'pa_control_protocol' => array( 'spi-ws2811', 'analog-mono' ),
				'pa_light_color'      => array( 'full-color-rgb', 'sun-amber' ),
				'pa_beam_angle'       => array( 'lens-120-deg' ),
				'pa_body_material'    => array( 'polycarbonate' ),
			),
			'price'   => 6100000,
			'img'     => ES_THEME_URI . 'assets/images/string-lights.jpg',
			'meta'    => array(
				'_es_is_purchasable_online' => '1',
				'_es_order_type'            => 'online_cart',
				'_es_inquiry_phone'         => '031-91091011',
				'_es_custom_price_badge'    => '',
				'_es_min_order_qty'         => 2,
				'_es_production_lead_time'  => '۲ تا ۴ روز کاری',
				'_es_wattage_rating'        => 15,
				'_es_chip_brand'            => 'Epistar Taiwan',
			),
		),
		array(
			'slug'    => 'artam-light-tree',
			'title'   => 'المان درخت نوری هوشمند مدل آرتام (دو طبقه)',
			'excerpt' => 'درخت نوری هوشمند شهری با ارتفاع تا ۸.۶ متر، ۱۶ میلیون رنگ RGB، کنترل با اپلیکیشن موبایل و هماهنگی بی‌سیم با پروتکل NRF.',
			'content' => '<p>المان نوری درخت آرتام یکی از شاخص‌ترین سازه‌های حجمی شرکت دانش‌بنیان عرفان صنعت اصفهان برای نصب در میادین اصلی شهرها، بوستان‌ها و بلوارها است. بدنه فلزی با پوشش رنگ کوره‌ای الکترواستاتیک و پیکسل‌های ضدآب IP67 دوام آن را در تمامی اقلیم‌های کشور تضمین می‌کند.</p>',
			'cats'    => array( 'urban-lighting-elements', 'light-trees' ),
			'attrs'   => array(
				'pa_voltage'          => array( '12v-dc', '220v-ac' ),
				'pa_ip_rating'        => array( 'ip67' ),
				'pa_control_protocol' => array( 'spi-ws2811' ),
				'pa_light_color'      => array( 'full-color-rgb' ),
				'pa_beam_angle'       => array( 'lens-120-deg' ),
				'pa_body_material'    => array( 'galvanized-iron', 'polycarbonate' ),
			),
			'price'   => 0,
			'img'     => ES_THEME_URI . 'assets/images/light-tree.jpg',
			'meta'    => array(
				'_es_is_purchasable_online' => '0',
				'_es_order_type'            => 'official_tender',
				'_es_inquiry_phone'         => '031-91091011',
				'_es_custom_price_badge'    => 'استعلام مناقصه و پیش‌فاکتور رسمی',
				'_es_min_order_qty'         => 1,
				'_es_production_lead_time'  => '۱۰ تا ۱۵ روز کاری (تولید سفارشی)',
				'_es_wattage_rating'        => 850,
				'_es_chip_brand'            => 'Epistar / Cree',
			),
		),
		array(
			'slug'    => 'sun-light-48',
			'title'   => 'المان خورشیدنما هوشمند ۴۸ پره (مجهز به تقویم و ساعت نجومی)',
			'excerpt' => 'خورشیدنما ۴۸ و ۳۲ پره با قطر ۳.۳ متر، بیش از ۲۳۰۰ پیکسل فول‌کالر، پروتکل NRF و قابلیت نمایش انیمیشن، دما و اوقات شرعی.',
			'content' => '<p>المان نوری خورشیدنما ۴۸ پره عرفان صنعت با قطر ۳.۳ متر و بیش از ۲۳۰۰ پیکسل هوشمند، نقطه‌کانونی درخشانی برای میادین شهری است که علاوه بر افکت‌های نوری متنوع، مجهز به ساعت و تقویم هوشمند با بروزرسانی از طریق موبایل می‌باشد.</p>',
			'cats'    => array( 'urban-lighting-elements', 'square-elements' ),
			'attrs'   => array(
				'pa_voltage'          => array( '12v-dc', '220v-ac' ),
				'pa_ip_rating'        => array( 'ip67' ),
				'pa_control_protocol' => array( 'spi-ws2811' ),
				'pa_light_color'      => array( 'full-color-rgb' ),
				'pa_beam_angle'       => array( 'lens-120-deg' ),
				'pa_body_material'    => array( 'galvanized-iron', 'polycarbonate' ),
			),
			'price'   => 0,
			'img'     => ES_THEME_URI . 'assets/images/sun-light.jpg',
			'meta'    => array(
				'_es_is_purchasable_online' => '0',
				'_es_order_type'            => 'phone_inquiry',
				'_es_inquiry_phone'         => '031-91091011',
				'_es_custom_price_badge'    => 'استعلام قیمت روز کارخانه',
				'_es_min_order_qty'         => 1,
				'_es_production_lead_time'  => '۷ تا ۱۲ روز کاری',
				'_es_wattage_rating'        => 620,
				'_es_chip_brand'            => 'Epistar Taiwan',
			),
		),
		array(
			'slug'    => 'luster-forogh',
			'title'   => 'لوستر شهری فضای باز مدل فروغ (۳ طبقه رینگی)',
			'excerpt' => 'لوستر شهری سه طبقه با ۲۹۰ متر ریسه سوزنی LED و ۴۰ متر نئون فلکسی دوطرفه، پایه ۵ متری فولادی و درجه حفاظت IP67.',
			'content' => '<p>لوستر شهری فروغ با ارتفاع سازه ۲ متر و پایه ۵ متری، مجهز به ۲۹۰ متر ریسه سوزنی LED زنردار و ۴۰ متر نئون فلکسی دوطرفه با رنگ کوره‌ای الکترواستاتیک، انتخابی باشکوه برای بلوارها، میادین و صحن‌های مذهبی است.</p>',
			'cats'    => array( 'urban-lighting-elements', 'urban-chandeliers' ),
			'attrs'   => array(
				'pa_voltage'          => array( '220v-ac' ),
				'pa_ip_rating'        => array( 'ip67' ),
				'pa_control_protocol' => array( 'analog-mono' ),
				'pa_light_color'      => array( 'sun-amber', 'warm-white-3000k' ),
				'pa_beam_angle'       => array( 'lens-120-deg' ),
				'pa_body_material'    => array( 'galvanized-iron' ),
			),
			'price'   => 0,
			'img'     => ES_THEME_URI . 'assets/images/chandelier.jpg',
			'meta'    => array(
				'_es_is_purchasable_online' => '0',
				'_es_order_type'            => 'phone_inquiry',
				'_es_inquiry_phone'         => '031-91091011',
				'_es_custom_price_badge'    => 'تماس با واحد فروش پروژه‌ها',
				'_es_min_order_qty'         => 1,
				'_es_production_lead_time'  => '۵ تا ۱۰ روز کاری',
				'_es_wattage_rating'        => 340,
				'_es_chip_brand'            => 'Epistar Taiwan',
			),
		),
		array(
			'slug'    => 'point-light-pixel-4cm',
			'title'   => 'پوینت‌لایت پیکسل LED چهار سانتی‌متری فول‌کالر (IP68)',
			'excerpt' => 'پیکسل نقطه‌ای آدرس‌پذیر ۴ سانتی‌متری با قاب نگهدارنده آلومینیومی PLT، آب‌بندی کامل رزین صنعتی IP68 و ولتاژ ایمن ۱۲ ولت.',
			'content' => '<p>پوینت‌لایت پیکسل ۴ سانتی‌متری عرفان صنعت مجهز به آی‌سی هوشمند آدرس‌پذیر و درجه حفاظت IP68، مخصوص اجرای تونل‌های نوری، نمای رسانه (Media Facade) و نورپردازی پل‌ها در شرایط جوی سخت است.</p>',
			'cats'    => array( 'pixel-point-lights', 'spi-point-lights', 'dmx-point-lights' ),
			'attrs'   => array(
				'pa_voltage'          => array( '12v-dc' ),
				'pa_ip_rating'        => array( 'ip68' ),
				'pa_control_protocol' => array( 'spi-ws2811', 'dmx512' ),
				'pa_light_color'      => array( 'full-color-rgb' ),
				'pa_beam_angle'       => array( 'lens-120-deg' ),
				'pa_body_material'    => array( 'polycarbonate', 'aluminum-diecast' ),
			),
			'price'   => 4850000,
			'img'     => ES_THEME_URI . 'assets/images/point-light.jpg',
			'meta'    => array(
				'_es_is_purchasable_online' => '1',
				'_es_order_type'            => 'online_cart',
				'_es_inquiry_phone'         => '031-91091011',
				'_es_custom_price_badge'    => '',
				'_es_min_order_qty'         => 5,
				'_es_production_lead_time'  => 'ارسال فوری',
				'_es_wattage_rating'        => 1,
				'_es_chip_brand'            => 'Epistar Taiwan',
			),
		),
	);

	foreach ( $products_blueprint as $prod ) {
		$existing = get_page_by_path( $prod['slug'], OBJECT, 'product' );
		$post_id  = $existing ? $existing->ID : wp_insert_post(
			array(
				'post_type'    => 'product',
				'post_name'    => $prod['slug'],
				'post_title'   => $prod['title'],
				'post_excerpt' => $prod['excerpt'],
				'post_content' => $prod['content'],
				'post_status'  => 'publish',
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			wp_set_object_terms( $post_id, $prod['cats'], 'product_cat' );
			foreach ( $prod['attrs'] as $tax => $slugs ) {
				if ( taxonomy_exists( $tax ) ) {
					wp_set_object_terms( $post_id, $slugs, $tax );
				}
			}
			update_post_meta( $post_id, '_regular_price', $prod['price'] > 0 ? $prod['price'] : '' );
			update_post_meta( $post_id, '_price', $prod['price'] > 0 ? $prod['price'] : '' );
			update_post_meta( $post_id, '_es_fallback_image', $prod['img'] );
			foreach ( $prod['meta'] as $m_key => $m_val ) {
				update_post_meta( $post_id, $m_key, $m_val );
			}
			++$counts['products'];
		}
	}

	// 2. Seed Urban Lighting Projects (`project` CPT).
	$projects_blueprint = array(
		array(
			'slug'    => 'kerman-90-degree-light-tunnel',
			'title'   => 'تونل نوری ۹۰ درجه هوشمند شهر کرمان',
			'excerpt' => 'طراحی و اجرای مسیر تونل نوری ۵۰ دهانه با زاویه ۹۰ درجه، قاب نگهدارنده آلومینیومی PLT و همگام‌سازی بی‌سیم با پروتکل NRF.',
			'content' => '<p>پروژه تونل نوری ۹۰ درجه در شهر کرمان با ۵۰ دهانه فلزی مستحکم، فونداسیون بیس‌پلیت تقویت‌شده، سینی کابل گالوانیزه و ریسه‌های پیکسل ۴ سانتی فول‌کالر با ولتاژ ایمن ۱۲ ولت و درجه حفاظت IP67 اجرا شده است.</p>',
			'cats'    => array( 'light-tunnels-walkways', 'urban-beautification' ),
			'locs'    => array( 'other-cities' ),
			'img'     => ES_THEME_URI . 'assets/images/light-tunnel.jpg',
			'meta'    => array(
				'_es_project_client'       => 'شهرداری و سازمان زیباسازی کرمان',
				'_es_completion_date'      => '۱۴۰۴/۰۹/۱۹',
				'_es_total_pixel_count'    => 12500,
				'_es_total_power_kw'       => 6.4,
				'_es_before_after_gallery' => array(
					ES_THEME_URI . 'assets/images/light-tunnel.jpg',
					ES_THEME_URI . 'assets/images/point-light.jpg',
				),
				'_es_project_drone_video'  => 'https://www.aparat.com/erfansanat',
				'_es_project_map_coords'   => '30.2839, 57.0834',
			),
		),
		array(
			'slug'    => 'esfahan-shohada-square-sphere',
			'title'   => 'المان حجمی گوی نورانی و سقف نوری مکعبی اصفهان',
			'excerpt' => 'اجرای کره‌های درخشان نقطه‌کانونی میدان و سقف نوری مکعبی با ریسه‌های پلی‌کربنات ضدآب و کنترل مرکزی هوشمند.',
			'content' => '<p>پروژه نورپردازی شهری در استان اصفهان شامل طراحی و نصب گوی‌های نورانی حجمی و سقف نوری مکعبی با پوشش یکنواخت و مقاومت کامل در برابر تابش مستقیم آفتاب و بارندگی است.</p>',
			'cats'    => array( 'urban-beautification', 'occasional-lighting-projects' ),
			'locs'    => array( 'isfahan' ),
			'img'     => ES_THEME_URI . 'assets/images/light-sphere.jpg',
			'meta'    => array(
				'_es_project_client'       => 'سازمان زیباسازی شهرداری اصفهان',
				'_es_completion_date'      => '۱۴۰۳/۰۲/۲۰',
				'_es_total_pixel_count'    => 9600,
				'_es_total_power_kw'       => 4.8,
				'_es_before_after_gallery' => array(
					ES_THEME_URI . 'assets/images/light-sphere.jpg',
					ES_THEME_URI . 'assets/images/light-element.jpg',
				),
				'_es_project_drone_video'  => 'https://www.aparat.com/erfansanat',
				'_es_project_map_coords'   => '32.6539, 51.6660',
			),
		),
		array(
			'slug'    => 'chabahar-dolphin-light-tunnel',
			'title'   => 'تونل نوری دلفینی ساحل چابهار و سقف نوری قلبی کیش',
			'excerpt' => 'طراحی سازه نوری مقاوم در برابر رطوبت شدید ساحلی و شرجی جنوب کشور با استاندارد حفاظت IP68 و رنگ الکترواستاتیک.',
			'content' => '<p>اجرای پروژه‌های نورپردازی در سواحل جنوب کشور (چابهار و جزیره کیش) نیازمند بالاترین سطح آب‌بندی و مقاومت در برابر خوردگی رطوبتی است که توسط تیم مهندسی عرفان صنعت اصفهان با موفقیت پیاده‌سازی گردید.</p>',
			'cats'    => array( 'light-tunnels-walkways', 'parks-landscapes' ),
			'locs'    => array( 'south-coasts' ),
			'img'     => ES_THEME_URI . 'assets/images/light-element.jpg',
			'meta'    => array(
				'_es_project_client'       => 'منطقه آزاد چابهار و کیش',
				'_es_completion_date'      => '۱۴۰۳/۱۰/۰۱',
				'_es_total_pixel_count'    => 14200,
				'_es_total_power_kw'       => 7.2,
				'_es_before_after_gallery' => array(
					ES_THEME_URI . 'assets/images/light-element.jpg',
					ES_THEME_URI . 'assets/images/light-tunnel.jpg',
				),
				'_es_project_drone_video'  => 'https://www.aparat.com/erfansanat',
				'_es_project_map_coords'   => '25.2919, 60.6430',
			),
		),
	);

	foreach ( $projects_blueprint as $proj ) {
		$existing = get_page_by_path( $proj['slug'], OBJECT, 'project' );
		$post_id  = $existing ? $existing->ID : wp_insert_post(
			array(
				'post_type'    => 'project',
				'post_name'    => $proj['slug'],
				'post_title'   => $proj['title'],
				'post_excerpt' => $proj['excerpt'],
				'post_content' => $proj['content'],
				'post_status'  => 'publish',
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			wp_set_object_terms( $post_id, $proj['cats'], 'project_cat' );
			wp_set_object_terms( $post_id, $proj['locs'], 'project_location' );
			update_post_meta( $post_id, '_es_fallback_image', $proj['img'] );
			foreach ( $proj['meta'] as $m_key => $m_val ) {
				update_post_meta( $post_id, $m_key, $m_val );
			}
			++$counts['projects'];
		}
	}

	// 3. Seed Technical Blog Posts (`post`).
	$posts_blueprint = array(
		array(
			'slug'    => 'ip67-vs-ip68-ingress-protection-rating',
			'title'   => 'گواهی IP67 و IP68 چیست؟ راهنمای جامع انتخاب استاندارد حفاظت در نورپردازی شهری',
			'excerpt' => 'بررسی تخصصی تفاوت درجه حفاظت IP65، IP67 و IP68 در تجهیزات روشنایی شهری، وال‌واشرها و ریسه‌های پیکسلی.',
			'content' => '<p>در تجهیزات الکترونیکی و نورپردازی شهری که در فضای باز نصب می‌شوند، استاندارد بین‌المللی IEC 60529 (کد IP) میزان نفوذناپذیری محصول در برابر گردوغبار و آب را مشخص می‌کند. در محصولات عرفان صنعت اصفهان با بهره‌گیری از جوش اولتراسونیک و رزین پلی‌اورتان صنعتی، حفاظت واقعی IP67 و IP68 حاصل شده است.</p>',
			'cats'    => array( 'lighting-standards' ),
			'tags'    => array( 'ws2811-controller', 'voltage-drop-calculation' ),
			'img'     => ES_THEME_URI . 'assets/images/point-light.jpg',
			'meta'    => array(
				'_es_reading_time_min'      => 7,
				'_es_technical_reviewer'    => 'مهندس علی حیدری — سرپرست فنی عرفان صنعت',
				'_es_software_project_file' => ES_THEME_URI . 'assets/images/sample-datasheet.pdf',
				'_es_faq_schema_repeater'   => array(
					array(
						'question' => 'تفاوت اصلی استاندارد IP67 و IP68 در ریسه‌های نورپردازی چیست؟',
						'answer'   => 'IP67 مقاومت محصول را در برابر غوطه‌وری موقت تا عمق ۱ متر به مدت ۳۰ دقیقه تضمین می‌کند، در حالی که IP68 برای غوطه‌وری مداوم و شرایط فوق‌مرطوب ساحلی یا آب‌نماها طراحی شده است.',
					),
					array(
						'question' => 'چگونه از افت ولتاژ در تونل‌های نوری طولانی جلوگیری می‌شود؟',
						'answer'   => 'با استفاده از کابل تمام مس استاندارد، تغذیه دوطرفه خطوط پیکسلی و انتخاب صحیح ولتاژ ۱۲ یا ۲۴ ولت DC متناسب با متراژ هر دهانه.',
					),
				),
			),
		),
		array(
			'slug'    => 'ws2811-dmx512-controller-wiring-guide',
			'title'   => 'آموزش تخصصی سربندی، آدرس‌دهی DMX512 و همگام‌سازی کنترلرهای پیکسلی WS2811 با NRF',
			'excerpt' => 'راهنمای گام‌به‌گام محاسبه افت ولتاژ، انتخاب پاور سوییچینگ و همگام‌سازی بی‌سیم المان‌های نوری شهری.',
			'content' => '<p>یکی از مزایای کلیدی کنترلرهای هوشمند شرکت دانش‌بنیان عرفان صنعت اصفهان، بهره‌گیری از ماژول ارتباطی بی‌سیم NRF و WiFi است که امکان همگام‌سازی صدها المان نوری را در طول بلوار یا تونل نوری تا فاصله ۲۰۰ متر بدون نیاز به کابل‌کشی دیتا بین پایه‌ها فراهم می‌سازد.</p>',
			'cats'    => array( 'software-controllers-tutorials', 'troubleshooting-wiring' ),
			'tags'    => array( 'ws2811-controller', 'dmx-addressing', 'voltage-drop-calculation' ),
			'img'     => ES_THEME_URI . 'assets/images/wiring-schematic.jpg',
			'meta'    => array(
				'_es_reading_time_min'      => 9,
				'_es_technical_reviewer'    => 'واحد تحقیق و توسعه (R&D) عرفان صنعت اصفهان',
				'_es_software_project_file' => ES_THEME_URI . 'assets/images/sample-datasheet.pdf',
				'_es_faq_schema_repeater'   => array(
					array(
						'question' => 'حداکثر برد همگام‌سازی بی‌سیم پروتکل NRF در کنترلرهای عرفان صنعت چقدر است؟',
						'answer'   => 'در فضای باز شهری، ماژول‌های NRF تا فاصله ۲۰۰ متری بین هر کنترلر را به‌صورت کاملاً همگام پوشش می‌دهند.',
					),
				),
			),
		),
	);

	foreach ( $posts_blueprint as $art ) {
		$existing = get_page_by_path( $art['slug'], OBJECT, 'post' );
		$post_id  = $existing ? $existing->ID : wp_insert_post(
			array(
				'post_type'    => 'post',
				'post_name'    => $art['slug'],
				'post_title'   => $art['title'],
				'post_excerpt' => $art['excerpt'],
				'post_content' => $art['content'],
				'post_status'  => 'publish',
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			$cat_ids = array();
			foreach ( $art['cats'] as $c_slug ) {
				$t = get_term_by( 'slug', $c_slug, 'category' );
				if ( $t ) {
					$cat_ids[] = (int) $t->term_id;
				}
			}
			if ( ! empty( $cat_ids ) ) {
				wp_set_post_categories( $post_id, $cat_ids );
			}
			wp_set_post_tags( $post_id, $art['tags'] );
			update_post_meta( $post_id, '_es_fallback_image', $art['img'] );
			foreach ( $art['meta'] as $m_key => $m_val ) {
				update_post_meta( $post_id, $m_key, $m_val );
			}
			++$counts['posts'];
		}
	}

	// 4. Seed Standard Pages (`contact`, `blog`, `about`, `cart`, `checkout`, `my-account`).
	$pages_blueprint = array(
		'contact' => array(
			'title'    => 'تماس با ما و استعلام قیمت',
			'template' => 'templates/template-contact.php',
			'content'  => '<p>کارشناسان فروش و تیم مهندسی شرکت دانش‌بنیان عرفان صنعت اصفهان آماده ارائه مشاوره رایگان و صدور پیش‌فاکتور رسمی برای شهرداری‌ها، سازمان‌های عمرانی و پیمانکاران سراسر کشور هستند.</p>',
		),
		'blog' => array(
			'title'    => 'وبلاگ و مقالات فنی',
			'template' => 'templates/template-blog.php',
			'content'  => '<p>مقالات تخصصی، استانداردهای نورپردازی شهری و آموزش کنترلرهای هوشمند عرفان صنعت اصفهان.</p>',
		),
		'about' => array(
			'title'    => 'درباره شرکت دانش‌بنیان عرفان صنعت اصفهان',
			'template' => 'templates/template-fullwidth.php',
			'content'  => '<p>شرکت دانش‌بنیان عرفان صنعت اصفهان با بیش از ۲۵ سال تجربه و گواهینامه بین‌المللی ISO 9001:2015، پیشگام در طراحی، تولید و اجرای پروژه‌های روشنایی شهری، المان‌های نوری حجمی و سیستم‌های کنترل هوشمند در ایران است.</p>',
		),
		'cart' => array(
			'title'    => 'سبد خرید تجهیزات نورپردازی',
			'template' => 'default',
			'content'  => '<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->',
		),
		'checkout' => array(
			'title'    => 'تسویه حساب و ثبت نهایی سفارش',
			'template' => 'default',
			'content'  => '<!-- wp:shortcode -->[woocommerce_checkout]<!-- /wp:shortcode -->',
		),
		'my-account' => array(
			'title'    => 'حساب کاربری و پیگیری سفارشات',
			'template' => 'default',
			'content'  => '<!-- wp:shortcode -->[woocommerce_my_account]<!-- /wp:shortcode -->',
		),
	);

	foreach ( $pages_blueprint as $slug => $p_cfg ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
		$page_id  = $existing ? $existing->ID : wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_name'    => $slug,
				'post_title'   => $p_cfg['title'],
				'post_content' => $p_cfg['content'],
				'post_status'  => 'publish',
			)
		);
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			if ( 'default' !== $p_cfg['template'] ) {
				update_post_meta( $page_id, '_wp_page_template', $p_cfg['template'] );
			}
			++$counts['pages'];
		}
	}

	flush_rewrite_rules();

	return $counts;
}
add_action( 'after_switch_theme', 'erfan_sanat_seed_enterprise_demo_data', 20 );

/**
 * Alias for `erfan_sanat_seed_enterprise_demo_data()`.
 *
 * @return array<string, int>
 */
function erfan_sanat_seed_initial_content(): array {
	return erfan_sanat_seed_enterprise_demo_data();
}

/**
 * Handles Tools Page POST actions (seed demo data, seed terms, flush rewrites).
 */
function erfan_sanat_handle_tools_actions(): void {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || empty( $_POST['es_tool_action'] ) ) {
		return;
	}

	$action = sanitize_key( wp_unslash( $_POST['es_tool_action'] ) );
	if ( ! in_array( $action, array( 'seed_demo_data', 'seed_taxonomies', 'flush_rewrites' ), true ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'دسترسی غیرمجاز.', 'erfan-sanat' ), '', array( 'response' => 403 ) );
	}

	$nonce = isset( $_POST['erfan_sanat_tools_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['erfan_sanat_tools_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'erfan_sanat_tools_action' ) ) {
		wp_die( esc_html__( 'خطای امنیتی: توکن نامعتبر است.', 'erfan-sanat' ), '', array( 'response' => 403 ) );
	}

	if ( 'seed_demo_data' === $action ) {
		erfan_sanat_seed_enterprise_demo_data();
		$msg = 'seeded_all';
	} elseif ( 'seed_taxonomies' === $action ) {
		erfan_sanat_seed_required_terms();
		$msg = 'seeded_terms';
	} else {
		erfan_sanat_register_post_types();
		erfan_sanat_register_taxonomies();
		erfan_sanat_register_rewrite_rules();
		flush_rewrite_rules();
		$msg = 'flushed';
	}

	wp_safe_redirect( add_query_arg( array( 'page' => 'erfan-sanat-tools', 'tool_status' => $msg ), admin_url( 'admin.php' ) ) );
	exit;
}
add_action( 'admin_init', 'erfan_sanat_handle_tools_actions' );

/**
 * Renders the System Tools & Demo Data admin screen.
 */
function erfan_sanat_render_tools_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'دسترسی غیرمجاز.', 'erfan-sanat' ) );
	}

	$tool_status = isset( $_GET['tool_status'] ) ? sanitize_key( wp_unslash( $_GET['tool_status'] ) ) : '';
	$inquiries   = get_option( 'erfan_sanat_inquiries_log', array() );
	if ( ! is_array( $inquiries ) ) {
		$inquiries = array();
	}
	?>
	<div class="wrap es-admin-wrap" dir="rtl">
		<h1><?php esc_html_e( 'ابزارهای مهندسی سیستم، ساختار پیوندهای یکتا و داده نمونه', 'erfan-sanat' ); ?></h1>

		<?php if ( 'seeded_all' === $tool_status ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'محصولات، پروژه‌های نورپردازی، مقالات فنی، برگه‌ها و دسته‌بندی‌های عرفان صنعت با موفقیت ایجاد شدند.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php elseif ( 'seeded_terms' === $tool_status ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'تمامی دسته‌بندی‌های محصولات، ویژگی‌های فنی (pa_*) و شهرهای پروژه ثبت شدند.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php elseif ( 'flushed' === $tool_status ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'قواعد بازنویسی آدرس‌ها (Rewrite Rules) با موفقیت بازسازی شد.', 'erfan-sanat' ); ?></strong></p>
			</div>
		<?php endif; ?>

		<div class="es-admin-cards-two-col">
			<div class="es-admin-card">
				<h2><?php esc_html_e( 'راه‌اندازی سریع محتوای سازمانی عرفان صنعت', 'erfan-sanat' ); ?></h2>
				<p><?php esc_html_e( 'ایجاد خودکار دسته‌بندی‌های سلسله‌مراتبی محصولات، ۶ ویژگی فنی جهانی (ولتاژ، IP، پروتکل، رنگ نور، زاویه تابش، جنس بدنه)، محصولات نمونه (آنلاین، استعلام تلفنی و مناقصه)، پروژه‌های نورپردازی و مقالات فنی.', 'erfan-sanat' ); ?></p>
				<form method="post">
					<?php wp_nonce_field( 'erfan_sanat_tools_action', 'erfan_sanat_tools_nonce' ); ?>
					<p>
						<button type="submit" name="es_tool_action" value="seed_demo_data" class="button button-primary button-large">
							<?php esc_html_e( 'درون‌ریزی کامل محتوای نمونه و دسته‌بندی‌ها', 'erfan-sanat' ); ?>
						</button>
						<button type="submit" name="es_tool_action" value="seed_taxonomies" class="button button-large">
							<?php esc_html_e( 'فقط ایجاد دسته‌بندی‌ها و ویژگی‌های فنی', 'erfan-sanat' ); ?>
						</button>
						<button type="submit" name="es_tool_action" value="flush_rewrites" class="button button-large">
							<?php esc_html_e( 'بازسازی پیوندهای یکتا (Flush Rewrites)', 'erfan-sanat' ); ?>
						</button>
					</p>
				</form>
			</div>

			<div class="es-admin-card">
				<h2><?php esc_html_e( 'آخرین درخواست‌های مشاوره و پیش‌فاکتور ثبت‌شده', 'erfan-sanat' ); ?></h2>
				<?php if ( empty( $inquiries ) ) : ?>
					<p><?php esc_html_e( 'هنوز درخواستی از طریق فرم‌های مشاوره ثبت نشده است.', 'erfan-sanat' ); ?></p>
				<?php else : ?>
					<table class="widefat striped">
						<thead>
							<tr>
								<th><?php esc_html_e( 'نام متقاضی', 'erfan-sanat' ); ?></th>
								<th><?php esc_html_e( 'تلفن', 'erfan-sanat' ); ?></th>
								<th><?php esc_html_e( 'سازمان / شهر', 'erfan-sanat' ); ?></th>
								<th><?php esc_html_e( 'نوع درخواست', 'erfan-sanat' ); ?></th>
								<th><?php esc_html_e( 'زمان ثبت', 'erfan-sanat' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( array_slice( $inquiries, 0, 8 ) as $inq ) : ?>
								<tr>
									<td><?php echo esc_html( $inq['name'] ?? '' ); ?></td>
									<td dir="ltr"><?php echo esc_html( $inq['phone'] ?? '' ); ?></td>
									<td><?php echo esc_html( trim( ( $inq['organization'] ?? '' ) . ' - ' . ( $inq['province'] ?? '' ), ' -' ) ); ?></td>
									<td><?php echo esc_html( $inq['type'] ?? 'consultation' ); ?></td>
									<td dir="ltr"><?php echo esc_html( $inq['created_at'] ?? '' ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}
