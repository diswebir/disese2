<?php
/**
 * Accessibility (WCAG 2.1 AA) Enhancements
 *
 * Implements skip-to-content link, RTL body classes, keyboard navigation attributes,
 * and semantic landmark helpers.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs the accessible Skip-to-Content link right after `wp_body_open`.
 */
function erfan_sanat_skip_to_content_link(): void {
	?>
	<a class="es-skip-link screen-reader-text" href="#main-content">
		<?php esc_html_e( 'پرش به محتوای اصلی', 'erfan-sanat' ); ?>
	</a>
	<?php
}
add_action( 'wp_body_open', 'erfan_sanat_skip_to_content_link', 5 );

/**
 * Adds RTL, sticky header, and enterprise theme body classes.
 *
 * @param array<int, string> $classes Existing body classes.
 * @return array<int, string>
 */
function erfan_sanat_body_classes( array $classes ): array {
	$classes[] = 'es-theme-body';
	$classes[] = 'rtl';

	if ( es_opt( 'header_sticky', true ) ) {
		$classes[] = 'es-has-sticky-header';
	}

	return array_values( array_unique( $classes ) );
}
add_filter( 'body_class', 'erfan_sanat_body_classes' );

/**
 * Adds aria-current="page" to active navigation menu links.
 *
 * @param array<string, string> $atts Menu link attributes.
 * @param WP_Post               $item Menu item object.
 * @return array<string, string>
 */
function erfan_sanat_nav_menu_link_attributes( array $atts, $item ): array {
	if ( ! empty( $item->current ) ) {
		$atts['aria-current'] = 'page';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'erfan_sanat_nav_menu_link_attributes', 10, 2 );
