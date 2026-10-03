<?php
/**
 * 404 Not Found Template (`404.php`)
 *
 * Reproduces the Erfan Sanat 404 page with search bar, popular tags, and quick navigation.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$suggested_terms = array(
	'درخت نوری'  => home_url( '/?s=درخت+نوری' ),
	'خورشیدنما'  => home_url( '/?s=خورشیدنما' ),
	'ریسه بلوطی' => home_url( '/?s=ریسه+بلوطی' ),
	'لوستر فروغ' => home_url( '/?s=لوستر+فروغ' ),
	'تونل نوری'  => home_url( '/?s=تونل+نوری' ),
	'پوینت لایت' => home_url( '/?s=پوینت+لایت' ),
	'IP68'       => home_url( '/?s=IP68' ),
);
?>
<section class="es-section es-404-section">
	<div class="es-container">
		<div class="es-404-card">
			<span class="es-404-code" aria-hidden="true">۴۰۴</span>
			<h1 class="es-404-title"><?php esc_html_e( 'محتوای مورد نظر یافت نشد', 'erfan-sanat' ); ?></h1>
			<p class="es-404-desc">
				<?php esc_html_e( 'صفحه‌ای که به دنبال آن هستید ممکن است جابه‌جا شده باشد. می‌توانید به صفحه اصلی بازگردید یا از کادر جستجوی زیر برای یافتن محصول و پروژه مورد نظر استفاده نمایید.', 'erfan-sanat' ); ?>
			</p>

			<form role="search" method="get" class="es-inline-search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label for="es-404-search" class="screen-reader-text"><?php esc_html_e( 'جستجو', 'erfan-sanat' ); ?></label>
				<input type="search" id="es-404-search" name="s" placeholder="<?php esc_attr_e( 'جستجوی محصول یا پروژه نورپردازی...', 'erfan-sanat' ); ?>" />
				<button type="submit" class="es-btn es-btn-primary">
					<?php echo erfan_sanat_icon( 'search', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'جستجو', 'erfan-sanat' ); ?></span>
				</button>
			</form>

			<div class="es-404-tags">
				<span><?php esc_html_e( 'جستجوهای پرطرفدار:', 'erfan-sanat' ); ?></span>
				<?php foreach ( $suggested_terms as $label => $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" class="es-tech-pill"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</div>

			<div class="es-404-actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-btn es-btn-primary">
					<?php esc_html_e( 'بازگشت به برگه اصلی', 'erfan-sanat' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="es-btn es-btn-outline">
					<?php esc_html_e( 'فروشگاه محصولات', 'erfan-sanat' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="es-btn es-btn-outline">
					<?php esc_html_e( 'آرشیو پروژه‌ها', 'erfan-sanat' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
