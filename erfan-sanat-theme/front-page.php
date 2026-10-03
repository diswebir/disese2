<?php
/**
 * Front Page Template (Homepage)
 *
 * Renders the complete 9-section Erfan Sanat homepage matching the Arena reference design
 * and connected to dynamic CPT, WooCommerce, and theme options data.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_search() ) {
	get_template_part( 'search' );
	return;
}

get_header();

get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/city-marquee' );
get_template_part( 'template-parts/home/projects-showcase' );
get_template_part( 'template-parts/home/about-section' );
get_template_part( 'template-parts/home/products-showcase' );
get_template_part( 'template-parts/home/services-interactive' );
get_template_part( 'template-parts/home/why-us-process' );
get_template_part( 'template-parts/home/blog-latest' );
get_template_part( 'template-parts/home/consultation-cta' );

get_footer();
