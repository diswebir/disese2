<?php
/**
 * SEO, Breadcrumbs, Open Graph & Structured Data (JSON-LD) Architecture
 *
 * Compatible with third-party SEO plugins (Yoast SEO, Rank Math, SEOPress).
 * Outputs native Open Graph, Organization/LocalBusiness JSON-LD, BreadcrumbList JSON-LD,
 * and FAQPage JSON-LD from `_es_faq_schema_repeater`.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detects whether a dedicated third-party SEO plugin is active.
 *
 * @return bool
 */
function erfan_sanat_has_seo_plugin(): bool {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/**
 * Builds an array of breadcrumb items `[{label, url}]` for the current route.
 *
 * @return array<int, array{label: string, url: string}>
 */
function erfan_sanat_get_breadcrumbs(): array {
	$crumbs   = array();
	$crumbs[] = array(
		'label' => __( 'صفحه اصلی', 'erfan-sanat' ),
		'url'   => home_url( '/' ),
	);

	if ( is_front_page() ) {
		return $crumbs;
	}

	if ( is_post_type_archive( 'product' ) ) {
		$crumbs[] = array(
			'label' => __( 'محصولات نورپردازی', 'erfan-sanat' ),
			'url'   => home_url( '/shop/' ),
		);
	} elseif ( is_tax( 'product_cat' ) ) {
		$crumbs[] = array(
			'label' => __( 'محصولات نورپردازی', 'erfan-sanat' ),
			'url'   => home_url( '/shop/' ),
		);
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			if ( $term->parent > 0 ) {
				$parent = get_term( $term->parent, 'product_cat' );
				if ( $parent instanceof WP_Term ) {
					$crumbs[] = array(
						'label' => $parent->name,
						'url'   => (string) get_term_link( $parent ),
					);
				}
			}
			$crumbs[] = array(
				'label' => $term->name,
				'url'   => (string) get_term_link( $term ),
			);
		}
	} elseif ( is_singular( 'product' ) ) {
		$crumbs[] = array(
			'label' => __( 'محصولات نورپردازی', 'erfan-sanat' ),
			'url'   => home_url( '/shop/' ),
		);
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( is_array( $terms ) && ! empty( $terms ) ) {
			$primary_term = reset( $terms );
			$crumbs[]     = array(
				'label' => $primary_term->name,
				'url'   => (string) get_term_link( $primary_term ),
			);
		}
		$crumbs[] = array(
			'label' => get_the_title(),
			'url'   => (string) get_permalink(),
		);
	} elseif ( is_post_type_archive( 'project' ) ) {
		$crumbs[] = array(
			'label' => __( 'پروژه‌های نورپردازی شهری', 'erfan-sanat' ),
			'url'   => (string) get_post_type_archive_link( 'project' ),
		);
	} elseif ( is_tax( array( 'project_cat', 'project_location' ) ) ) {
		$crumbs[] = array(
			'label' => __( 'پروژه‌های نورپردازی شهری', 'erfan-sanat' ),
			'url'   => (string) get_post_type_archive_link( 'project' ),
		);
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$crumbs[] = array(
				'label' => $term->name,
				'url'   => (string) get_term_link( $term ),
			);
		}
	} elseif ( is_singular( 'project' ) ) {
		$crumbs[] = array(
			'label' => __( 'پروژه‌های نورپردازی شهری', 'erfan-sanat' ),
			'url'   => (string) get_post_type_archive_link( 'project' ),
		);
		$crumbs[] = array(
			'label' => get_the_title(),
			'url'   => (string) get_permalink(),
		);
	} elseif ( is_home() || is_category() || is_tag() ) {
		$crumbs[] = array(
			'label' => __( 'مقالات فنی و وبلاگ', 'erfan-sanat' ),
			'url'   => home_url( '/blog/' ),
		);
		if ( is_category() || is_tag() ) {
			$term = get_queried_object();
			if ( $term instanceof WP_Term ) {
				$crumbs[] = array(
					'label' => $term->name,
					'url'   => (string) get_term_link( $term ),
				);
			}
		}
	} elseif ( is_singular( 'post' ) ) {
		$crumbs[] = array(
			'label' => __( 'مقالات فنی و وبلاگ', 'erfan-sanat' ),
			'url'   => home_url( '/blog/' ),
		);
		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			$crumbs[] = array(
				'label' => $cats[0]->name,
				'url'   => get_category_link( $cats[0]->term_id ),
			);
		}
		$crumbs[] = array(
			'label' => get_the_title(),
			'url'   => (string) get_permalink(),
		);
	} elseif ( is_search() ) {
		$crumbs[] = array(
			'label' => sprintf( __( 'نتایج جستجو برای: %s', 'erfan-sanat' ), get_search_query() ),
			'url'   => '',
		);
	} elseif ( is_404() ) {
		$crumbs[] = array(
			'label' => __( 'صفحه یافت نشد (۴۰۴)', 'erfan-sanat' ),
			'url'   => '',
		);
	} elseif ( is_page() ) {
		$crumbs[] = array(
			'label' => get_the_title(),
			'url'   => (string) get_permalink(),
		);
	}

	return $crumbs;
}

/**
 * Outputs Open Graph tags and JSON-LD structured data in `<head>`.
 */
function erfan_sanat_output_seo_meta_and_schema(): void {
	if ( is_admin() ) {
		return;
	}

	// 1. Open Graph & Meta Description (only if no SEO plugin is active).
	if ( ! erfan_sanat_has_seo_plugin() && es_opt( 'seo_enable_og_tags', true ) ) {
		$title       = wp_get_document_title();
		$description = (string) es_opt( 'company_short_bio', '' );
		$og_type     = is_singular() ? 'article' : 'website';
		$og_url      = is_singular() ? (string) get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
		$og_image    = esc_url( (string) es_opt( 'hero_bg_image', ES_THEME_URI . 'assets/images/hero.jpg' ) );

		if ( is_singular() ) {
			$post_id = (int) get_the_ID();
			if ( has_excerpt( $post_id ) ) {
				$description = wp_strip_all_tags( get_the_excerpt( $post_id ) );
			}
			$context  = get_post_type( $post_id ) ?: 'post';
			$og_image = erfan_sanat_get_post_image_url( $post_id, $context );
		}

		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:locale" content="fa_IR">' . "\n";
		echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $og_url ) . '">' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( (string) es_opt( 'company_legal_name', 'عرفان صنعت اصفهان' ) ) . '">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
	}

	$schemas = array();

	// 2. Organization / LocalBusiness JSON-LD.
	if ( es_opt( 'seo_enable_org_schema', true ) ) {
		$schemas[] = array(
			'@context'     => 'https://schema.org',
			'@type'        => 'Organization',
			'name'         => (string) es_opt( 'company_legal_name', 'شرکت دانش‌بنیان عرفان صنعت اصفهان' ),
			'url'          => home_url( '/' ),
			'logo'         => (string) es_opt( 'brand_logo_image', ES_THEME_URI . 'assets/images/logo.svg' ),
			'description'  => (string) es_opt( 'company_short_bio', '' ),
			'telephone'    => (string) es_opt( 'contact_phone_tel_link', '03191091011' ),
			'email'        => (string) es_opt( 'contact_email', 'info@erfansanat.com' ),
			'address'      => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => (string) es_opt( 'contact_address', '' ),
				'addressLocality' => 'اصفهان',
				'postalCode'      => (string) es_opt( 'contact_postal_code', '8418148678' ),
				'addressCountry'  => 'IR',
			),
		);
	}

	// 3. BreadcrumbList JSON-LD on inner pages.
	if ( ! is_front_page() && es_opt( 'seo_enable_breadcrumbs', true ) ) {
		$crumbs     = erfan_sanat_get_breadcrumbs();
		$item_elems = array();
		foreach ( $crumbs as $index => $crumb ) {
			$elem = array(
				'@type'    => 'ListItem',
				'position' => $index + 1,
				'name'     => $crumb['label'],
			);
			if ( ! empty( $crumb['url'] ) ) {
				$elem['item'] = $crumb['url'];
			}
			$item_elems[] = $elem;
		}
		$schemas[] = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $item_elems,
		);
	}

	// 4. FAQPage JSON-LD on single blog posts with `_es_faq_schema_repeater`.
	if ( is_singular( 'post' ) && es_opt( 'blog_enable_faq_schema', true ) ) {
		$faqs = get_post_meta( (int) get_the_ID(), '_es_faq_schema_repeater', true );
		if ( is_array( $faqs ) && ! empty( $faqs ) ) {
			$main_entity = array();
			foreach ( $faqs as $faq ) {
				if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) {
					$main_entity[] = array(
						'@type'          => 'Question',
						'name'           => (string) $faq['question'],
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => (string) $faq['answer'],
						),
					);
				}
			}
			if ( ! empty( $main_entity ) ) {
				$schemas[] = array(
					'@context'   => 'https://schema.org',
					'@type'      => 'FAQPage',
					'mainEntity' => $main_entity,
				);
			}
		}
	}

	// 5. Product JSON-LD on single products when WooCommerce structured data is not already outputting it.
	if ( is_singular( 'product' ) && ! class_exists( 'WC_Structured_Data' ) ) {
		$pid   = (int) get_the_ID();
		$pdata = erfan_sanat_get_product_purchase_data( $pid );
		$prod_schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Product',
			'name'        => get_the_title( $pid ),
			'description' => wp_strip_all_tags( get_the_excerpt( $pid ) ?: get_the_title( $pid ) ),
			'image'       => erfan_sanat_get_post_image_url( $pid, 'product' ),
			'brand'       => array(
				'@type' => 'Brand',
				'name'  => 'عرفان صنعت اصفهان',
			),
		);
		if ( is_numeric( $pdata['regular_price'] ) && (float) $pdata['regular_price'] > 0 ) {
			$prod_schema['offers'] = array(
				'@type'         => 'Offer',
				'priceCurrency' => 'IRR',
				'price'         => (float) $pdata['regular_price'] * 10,
				'availability'  => 'https://schema.org/InStock',
				'url'           => (string) get_permalink( $pid ),
			);
		}
		$schemas[] = $prod_schema;
	}

	foreach ( $schemas as $schema_obj ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $schema_obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'erfan_sanat_output_seo_meta_and_schema', 20 );
