<?php
/**
 * Main Fallback Index Template (`index.php`)
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="es-section">
	<div class="es-container">
		<?php if ( have_posts() ) : ?>
			<div class="es-cards-grid es-grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					$ptype = get_post_type();
					if ( 'product' === $ptype ) {
						get_template_part( 'template-parts/cards/card-product', null, array( 'post_id' => get_the_ID() ) );
					} elseif ( 'project' === $ptype ) {
						get_template_part( 'template-parts/cards/card-project', null, array( 'post_id' => get_the_ID() ) );
					} else {
						get_template_part( 'template-parts/cards/card-post', null, array( 'post_id' => get_the_ID() ) );
					}
				endwhile;
				?>
			</div>
			<?php get_template_part( 'template-parts/global/pagination' ); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/global/empty-state' ); ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
