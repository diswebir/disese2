<?php
/**
 * Main Site Header Component
 *
 * Reproduces the Arena reference header hierarchy with RTL brand identity,
 * desktop navigation, search trigger, cart status, and consultation CTA.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_name  = (string) es_opt( 'company_legal_name', 'عرفان صنعت اصفهان' );
$tagline       = (string) es_opt( 'company_tagline', 'نورپردازی شهری و المان‌های نوری' );
$badge_text    = (string) es_opt( 'brand_badge_text', 'ES' );
$cta_text      = (string) es_opt( 'header_cta_text', 'دریافت مشاوره رایگان' );
$cta_url       = (string) es_opt( 'header_cta_url', '#consultation' );
$show_search   = (bool) es_opt( 'header_show_search', true );
$cart_count    = erfan_sanat_get_cart_count();
$cart_url      = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' );
?>
<header id="masthead" class="es-site-header" role="banner">
	<?php get_template_part( 'template-parts/header/top-bar' ); ?>

	<div class="es-header-main">
		<div class="es-container es-header-inner">
			<div class="es-header-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-brand-link" rel="home">
					<span class="es-brand-mark" aria-hidden="true"><?php echo esc_html( $badge_text ); ?></span>
					<span class="es-brand-text">
						<strong class="es-brand-title"><?php esc_html_e( 'عرفان صنعت اصفهان', 'erfan-sanat' ); ?></strong>
						<small class="es-brand-subtitle"><?php echo esc_html( $tagline ); ?></small>
					</span>
				</a>
			</div>

			<nav id="site-navigation" class="es-primary-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'erfan-sanat' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'es-nav-list',
							'fallback_cb'    => 'erfan_sanat_fallback_primary_menu',
						)
					);
				} else {
					erfan_sanat_fallback_primary_menu();
				}
				?>
			</nav>

			<div class="es-header-actions">
				<?php if ( $show_search ) : ?>
					<button
						type="button"
						class="es-icon-btn es-search-toggle"
						aria-expanded="false"
						aria-controls="es-search-modal"
						aria-label="<?php esc_attr_e( 'جستجو در محصولات و پروژه‌ها', 'erfan-sanat' ); ?>"
					>
						<?php echo erfan_sanat_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				<?php endif; ?>

				<a
					href="<?php echo esc_url( $cart_url ); ?>"
					class="es-icon-btn es-cart-btn"
					aria-label="<?php esc_attr_e( 'سبد خرید', 'erfan-sanat' ); ?>"
				>
					<?php echo erfan_sanat_icon( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="es-cart-badge"><?php echo esc_html( erfan_sanat_persian_digits( $cart_count ) ); ?></span>
				</a>

				<a href="<?php echo esc_url( $cta_url ); ?>" class="es-btn es-btn-primary es-header-cta">
					<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( $cta_text ); ?></span>
				</a>

				<button
					type="button"
					class="es-icon-btn es-mobile-menu-toggle"
					aria-expanded="false"
					aria-controls="es-mobile-drawer"
					aria-label="<?php esc_attr_e( 'باز کردن منوی موبایل', 'erfan-sanat' ); ?>"
				>
					<?php echo erfan_sanat_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</div>
		</div>
	</div>

	<?php if ( $show_search ) : ?>
		<div id="es-search-modal" class="es-search-modal" aria-hidden="true">
			<div class="es-container es-search-modal-inner">
				<form role="search" method="get" class="es-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="es-header-search-input" class="screen-reader-text">
						<?php esc_html_e( 'جستجوی محصول، پروژه یا مقاله فنی', 'erfan-sanat' ); ?>
					</label>
					<input
						type="search"
						id="es-header-search-input"
						name="s"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						placeholder="<?php esc_attr_e( 'جستجو در محصولات (ریسه بلوطی، درخت نوری، خورشیدنما، لوستر فروغ...)', 'erfan-sanat' ); ?>"
						class="es-search-input"
					/>
					<button type="submit" class="es-btn es-btn-primary">
						<?php echo erfan_sanat_icon( 'search', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php esc_html_e( 'جستجو', 'erfan-sanat' ); ?></span>
					</button>
					<button type="button" class="es-icon-btn es-search-close" aria-label="<?php esc_attr_e( 'بستن جستجو', 'erfan-sanat' ); ?>">
						<?php echo erfan_sanat_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				</form>
			</div>
		</div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>
</header>
