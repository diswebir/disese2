<?php
/**
 * Homepage Section 2: Municipality & City Trust Marquee
 *
 * Reproduces: "جلب اعتماد شما باعث افتخار ماست — مفتخریم از همکاری با تمام شهرهای کشور"
 * Uses a 3-loop LTR track wrapper with RTL city pills for 100% seamless infinite scrolling.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cities_raw = (string) es_opt( 'home_partner_cities', 'اصفهان، تهران، شیراز، مشهد، کرمان، البرز، تبریز، اهواز، قم، رشت، یزد، اردبیل، خراسان، گیلان، چابهار، کیش' );
$cities     = array_values( array_filter( array_map( 'trim', preg_split( '/[،,]+/u', $cities_raw ) ?: array() ) ) );
if ( empty( $cities ) ) {
	$cities = array( 'اصفهان', 'تهران', 'شیراز', 'مشهد', 'کرمان', 'البرز', 'تبریز', 'اهواز', 'قم', 'رشت', 'یزد', 'اردبیل', 'خراسان', 'گیلان', 'چابهار', 'کیش' );
}
?>
<section class="es-city-marquee-section" aria-label="<?php esc_attr_e( 'شهرهای همکار عرفان صنعت', 'erfan-sanat' ); ?>">
	<div class="es-container">
		<p class="es-marquee-caption">
			<?php esc_html_e( 'جلب اعتماد شما باعث افتخار ماست — مفتخریم از همکاری با تمام شهرهای کشور', 'erfan-sanat' ); ?>
		</p>
	</div>

	<div class="es-marquee-track-wrap" dir="ltr">
		<div class="es-marquee-track">
			<?php for ( $loop = 0; $loop < 3; $loop++ ) : ?>
				<?php foreach ( $cities as $city_name ) : ?>
					<span class="es-city-pill" dir="rtl" <?php echo $loop > 0 ? 'aria-hidden="true"' : ''; ?>>
						<span class="es-city-dot"></span>
						<span><?php echo esc_html( $city_name ); ?></span>
					</span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
</section>
