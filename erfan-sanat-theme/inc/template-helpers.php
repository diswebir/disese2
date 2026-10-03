<?php
/**
 * Reusable Template Helpers, SVG Icon System, Persian Numerals & Formatting
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Converts English numerals (0-9) to Persian numerals (۰-۹) when enabled.
 *
 * @param string|int|float $input Text or number to convert.
 * @return string
 */
function erfan_sanat_persian_digits( $input ): string {
	$str = (string) $input;
	if ( ! es_opt( 'enable_persian_digits', true ) ) {
		return $str;
	}
	$en = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$fa = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	return str_replace( $en, $fa, $str );
}

/**
 * Formats a numeric price in Iranian Toman with Persian numerals.
 *
 * @param int|float|string $amount Numeric price in Toman.
 * @return string
 */
function erfan_sanat_format_toman( $amount ): string {
	if ( '' === (string) $amount || ! is_numeric( $amount ) ) {
		return '';
	}
	$formatted = number_format( (float) $amount, 0, '.', ',' );
	return erfan_sanat_persian_digits( $formatted ) . ' ' . __( 'تومان', 'erfan-sanat' );
}

/**
 * Returns inline self-hosted SVG icons by key.
 *
 * @param string $name  Icon identifier.
 * @param string $class Optional CSS class.
 * @return string Safe SVG markup.
 */
function erfan_sanat_icon( string $name, string $class = 'es-icon' ): string {
	$cls   = esc_attr( trim( 'es-svg-icon ' . $class ) );
	$icons = array(
		'phone'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
		'search'      => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
		'cart'        => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
		'menu'        => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
		'close'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
		'shield'      => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>',
		'spark'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
		'bulb'        => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>',
		'award'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
		'check'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
		'arrow-left'  => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
		'download'    => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>',
		'location'    => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
		'calendar'    => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
		'clock'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
		'mail'        => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
		'wifi'        => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>',
		'droplet'     => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>',
		'video'       => '<svg class="' . $cls . '" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
	);

	return $icons[ $name ] ?? $icons['spark'];
}

/**
 * Returns the list of Iranian provinces for project & proforma inquiry forms.
 *
 * @return array<int, string>
 */
function erfan_sanat_get_iran_provinces(): array {
	return array(
		'اصفهان',
		'تهران',
		'خراسان رضوی',
		'فارس',
		'البرز',
		'آذربایجان شرقی',
		'خوزستان',
		'قم',
		'گیلان',
		'مازندران',
		'کرمان',
		'یزد',
		'هرمزگان',
		'سیستان و بلوچستان',
		'آذربایجان غربی',
		'اردبیل',
		'ایلام',
		'بوشهر',
		'چهارمحال و بختیاری',
		'خراسان جنوبی',
		'خراسان شمالی',
		'زنجان',
		'سمنان',
		'قزوین',
		'کردستان',
		'کرمانشاه',
		'کهگیلویه و بویراحمد',
		'گلستان',
		'لرستان',
		'مرکزی',
		'همدان',
	);
}

/**
 * Resolves a fallback local image URL for a post/product/project when no featured image is set.
 *
 * @param int    $post_id Post ID.
 * @param string $context Context ('product', 'project', 'post').
 * @return string Escaped URL.
 */
function erfan_sanat_get_post_image_url( int $post_id, string $context = 'product' ): string {
	if ( has_post_thumbnail( $post_id ) ) {
		$thumb_url = get_the_post_thumbnail_url( $post_id, 'large' );
		if ( $thumb_url ) {
			return esc_url( $thumb_url );
		}
	}

	$custom_img = get_post_meta( $post_id, '_es_fallback_image', true );
	if ( is_string( $custom_img ) && '' !== $custom_img ) {
		return esc_url( $custom_img );
	}

	$pool = array(
		'product' => array(
			'light-tree.jpg',
			'sun-light.jpg',
			'chandelier.jpg',
			'string-lights.jpg',
			'point-light.jpg',
			'light-element.jpg',
		),
		'project' => array(
			'light-tunnel.jpg',
			'light-sphere.jpg',
			'light-element.jpg',
			'light-tree.jpg',
		),
		'post'    => array(
			'wiring-schematic.jpg',
			'point-light.jpg',
			'light-tunnel.jpg',
		),
	);

	$list  = $pool[ $context ] ?? $pool['product'];
	$index = abs( $post_id ) % count( $list );
	return esc_url( ES_THEME_URI . 'assets/images/' . $list[ $index ] );
}

/**
 * Resolves a media meta value (attachment ID or URL) to a usable URL.
 *
 * @param mixed $meta_value Attachment ID or URL string.
 * @return string
 */
function erfan_sanat_resolve_media_url( $meta_value ): string {
	if ( empty( $meta_value ) ) {
		return '';
	}
	if ( is_numeric( $meta_value ) ) {
		$url = wp_get_attachment_url( absint( $meta_value ) );
		return $url ? esc_url( $url ) : '';
	}
	if ( is_string( $meta_value ) ) {
		return esc_url( $meta_value );
	}
	return '';
}

/**
 * Fallback menu renderer when no custom WordPress menu is assigned to the primary location.
 */
function erfan_sanat_fallback_primary_menu(): void {
	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
	if ( ! $shop_url || $shop_url === home_url( '/' ) ) {
		$shop_url = home_url( '/shop/' );
	}
	$projects_url = get_post_type_archive_link( 'project' ) ?: home_url( '/projects/' );
	$blog_url     = home_url( '/blog/' );
	?>
	<ul class="es-nav-list">
		<li class="menu-item <?php echo is_front_page() ? 'current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'صفحه اصلی', 'erfan-sanat' ); ?></a>
		</li>
		<li class="menu-item menu-item-has-children <?php echo ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) || is_singular( 'product' ) ) ? 'current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'محصولات نورپردازی', 'erfan-sanat' ); ?></a>
			<?php if ( es_opt( 'nav_show_product_cats_dropdown', true ) && taxonomy_exists( 'product_cat' ) ) : ?>
				<?php
				$top_cats = get_terms(
					array(
						'taxonomy'   => 'product_cat',
						'parent'     => 0,
						'hide_empty' => false,
						'number'     => 6,
					)
				);
				if ( ! is_wp_error( $top_cats ) && ! empty( $top_cats ) ) :
					?>
					<ul class="sub-menu">
						<?php foreach ( $top_cats as $cat ) : ?>
							<?php if ( 'uncategorized' === $cat->slug ) { continue; } ?>
							<li>
								<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
									<?php echo esc_html( $cat->name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			<?php endif; ?>
		</li>
		<li class="menu-item <?php echo ( is_post_type_archive( 'project' ) || is_tax( array( 'project_cat', 'project_location' ) ) || is_singular( 'project' ) ) ? 'current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $projects_url ); ?>"><?php esc_html_e( 'پروژه‌های شهری', 'erfan-sanat' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'خدمات نورپردازی', 'erfan-sanat' ); ?></a>
		</li>
		<li class="menu-item <?php echo ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) ? 'current-menu-item' : ''; ?>">
			<a href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'مقالات فنی', 'erfan-sanat' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'درباره ما', 'erfan-sanat' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/#consultation' ) ); ?>"><?php esc_html_e( 'تماس با ما', 'erfan-sanat' ); ?></a>
		</li>
	</ul>
	<?php
}
