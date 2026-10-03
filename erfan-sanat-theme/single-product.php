<?php
/**
 * WooCommerce Single Product Template (`single-product.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'content-single-product' );

	$related_products = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => array( (int) get_the_ID() ),
			'no_found_rows'  => true,
		)
	);
	if ( $related_products->have_posts() ) :
		?>
		<section class="es-section es-related-section">
			<div class="es-container">
				<h2 class="es-subsection-heading"><?php esc_html_e( 'محصولات مکمل و مشابه', 'erfan-sanat' ); ?></h2>
				<div class="es-cards-grid es-grid-3">
					<?php
					while ( $related_products->have_posts() ) :
						$related_products->the_post();
						get_template_part( 'content-product' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_footer();
