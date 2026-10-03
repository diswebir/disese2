<?php
/**
 * Accessible Mobile Drawer Navigation
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone_display = (string) es_opt( 'contact_phone_main', '۰۳۱-۹۱۰۹۱۰۱۱' );
$phone_tel     = (string) es_opt( 'contact_phone_tel_link', '03191091011' );
?>
<div id="es-mobile-drawer" class="es-mobile-drawer" aria-hidden="true">
	<div class="es-mobile-drawer-backdrop" data-close-drawer="true"></div>
	<div class="es-mobile-drawer-panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'منوی موبایل', 'erfan-sanat' ); ?>">
		<div class="es-mobile-drawer-head">
			<div class="es-brand-link">
				<span class="es-brand-mark"><?php echo esc_html( (string) es_opt( 'brand_badge_text', 'ES' ) ); ?></span>
				<span class="es-brand-text">
					<strong><?php esc_html_e( 'عرفان صنعت اصفهان', 'erfan-sanat' ); ?></strong>
				</span>
			</div>
			<button type="button" class="es-icon-btn es-mobile-drawer-close" aria-label="<?php esc_attr_e( 'بستن منو', 'erfan-sanat' ); ?>">
				<?php echo erfan_sanat_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>

		<form role="search" method="get" class="es-mobile-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="es-mobile-search-field" class="screen-reader-text"><?php esc_html_e( 'جستجو', 'erfan-sanat' ); ?></label>
			<input type="search" id="es-mobile-search-field" name="s" placeholder="<?php esc_attr_e( 'جستجوی تجهیزات نورپردازی...', 'erfan-sanat' ); ?>" />
			<button type="submit" aria-label="<?php esc_attr_e( 'جستجو', 'erfan-sanat' ); ?>">
				<?php echo erfan_sanat_icon( 'search', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</form>

		<nav class="es-mobile-nav" aria-label="<?php esc_attr_e( 'ناوبری موبایل', 'erfan-sanat' ); ?>">
			<?php
			if ( has_nav_menu( 'mobile' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'mobile',
						'container'      => false,
						'menu_class'     => 'es-mobile-nav-list',
					)
				);
			} else {
				erfan_sanat_fallback_primary_menu();
			}
			?>
		</nav>

		<div class="es-mobile-drawer-footer">
			<a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="es-btn es-btn-primary es-btn-block">
				<?php echo erfan_sanat_icon( 'phone', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_html( erfan_sanat_persian_digits( $phone_display ) ); ?></span>
			</a>
		</div>
	</div>
</div>
