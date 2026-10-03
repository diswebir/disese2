<?php
/**
 * Performance Optimizations & Query Tuning
 *
 * Disables bloat when configured, adds defer/lazy attributes,
 * and avoids unnecessary database queries.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Disables WordPress emoji scripts and styles on the frontend.
 */
function erfan_sanat_optimize_wp_head(): void {
	if ( is_admin() ) {
		return;
	}

	if ( es_opt( 'perf_disable_wp_emojis', true ) ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	}
}
add_action( 'init', 'erfan_sanat_optimize_wp_head' );

/**
 * Dequeues unused default WordPress block library and classic-theme styles on frontend.
 */
function erfan_sanat_dequeue_unused_frontend_assets(): void {
	if ( is_admin() ) {
		return;
	}
	if ( es_opt( 'perf_disable_block_css', true ) ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'erfan_sanat_dequeue_unused_frontend_assets', 100 );

/**
 * Adds defer attribute to theme script tag if WordPress version doesn't apply strategy automatically.
 *
 * @param string $tag    HTML script tag.
 * @param string $handle Enqueued script handle.
 * @return string
 */
function erfan_sanat_script_loader_tag( string $tag, string $handle ): string {
	if ( is_admin() || 'erfan-sanat-theme' !== $handle ) {
		return $tag;
	}
	if ( es_opt( 'perf_defer_theme_js', true ) && ! str_contains( $tag, ' defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'erfan_sanat_script_loader_tag', 10, 2 );

/**
 * Ensures attachment images have decoding="async" and loading="lazy" where appropriate.
 *
 * @param array<string, string> $attr       Image attributes.
 * @param WP_Post               $attachment Attachment post.
 * @return array<string, string>
 */
function erfan_sanat_optimize_image_attributes( array $attr, $attachment ): array {
	if ( es_opt( 'perf_lazy_load_images', true ) ) {
		if ( empty( $attr['loading'] ) ) {
			$attr['loading'] = 'lazy';
		}
		$attr['decoding'] = 'async';
	}
	if ( empty( $attr['alt'] ) && $attachment instanceof WP_Post ) {
		$attr['alt'] = get_the_title( $attachment->ID );
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'erfan_sanat_optimize_image_attributes', 10, 2 );

/**
 * Optimizes archive query counts and filtering for Projects and Products.
 *
 * @param WP_Query $query Current query instance.
 */
function erfan_sanat_optimize_archive_queries( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_post_type_archive( 'project' ) || $query->is_tax( array( 'project_cat', 'project_location' ) ) ) {
		$per_page = max( 3, min( 36, absint( es_opt( 'projects_per_page', 9 ) ) ) );
		$query->set( 'posts_per_page', $per_page );

		$cat_filter = isset( $_GET['project_cat'] ) ? sanitize_key( wp_unslash( $_GET['project_cat'] ) ) : '';
		$loc_filter = isset( $_GET['project_location'] ) ? sanitize_key( wp_unslash( $_GET['project_location'] ) ) : '';
		$tax_query  = array();

		if ( '' !== $cat_filter && ! $query->is_tax( 'project_cat' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'project_cat',
				'field'    => 'slug',
				'terms'    => $cat_filter,
			);
		}
		if ( '' !== $loc_filter && ! $query->is_tax( 'project_location' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'project_location',
				'field'    => 'slug',
				'terms'    => $loc_filter,
			);
		}
		if ( ! empty( $tax_query ) ) {
			$query->set( 'tax_query', $tax_query );
		}
	}

	if ( $query->is_post_type_archive( 'product' ) || $query->is_tax( 'product_cat' ) ) {
		$per_page = max( 4, min( 48, absint( es_opt( 'products_per_page', 12 ) ) ) );
		$query->set( 'posts_per_page', $per_page );
	}
}
add_action( 'pre_get_posts', 'erfan_sanat_optimize_archive_queries' );
