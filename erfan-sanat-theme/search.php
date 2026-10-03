<?php
/**
 * Search Results Template (`search.php`)
 *
 * Displays unified search results across Products, Urban Lighting Projects, and Technical Articles.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="es-page-hero">
	<div class="es-container">
		<span class="es-section-eyebrow"><?php esc_html_e( 'جستجوی هوشمند در کاتالوگ و پایگاه دانش', 'erfan-sanat' ); ?></span>
		<h1 class="es-page-title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'نتایج جستجو برای: «%s»', 'erfan-sanat' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>

		<form role="search" method="get" class="es-inline-search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="es-search-page-input" class="screen-reader-text"><?php esc_html_e( 'عبارت جستجو', 'erfan-sanat' ); ?></label>
			<input type="search" id="es-search-page-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'جستجوی مجدد...', 'erfan-sanat' ); ?>" />
			<button type="submit" class="es-btn es-btn-primary">
				<?php echo erfan_sanat_icon( 'search', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'جستجو', 'erfan-sanat' ); ?></span>
			</button>
		</form>
	</div>
</section>

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
			<?php
			get_template_part(
				'template-parts/global/empty-state',
				null,
				array(
					'title'   => __( 'موردی مطابق با عبارت جستجوشده یافت نشد', 'erfan-sanat' ),
					'message' => __( 'پیشنهاد می‌کنیم از کلیدواژه‌هایی مانند «ریسه بلوطی»، «خورشیدنما»، «تونل نوری»، «لوستر فروغ» یا «IP67» استفاده نمایید.', 'erfan-sanat' ),
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
