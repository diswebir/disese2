<?php
/**
 * Technical Blog Article FAQ Accordion Component
 *
 * Renders `_es_faq_schema_repeater` items interactively alongside the JSON-LD FAQPage schema.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$faqs    = get_post_meta( $post_id, '_es_faq_schema_repeater', true );

if ( ! is_array( $faqs ) || empty( $faqs ) ) {
	return;
}
?>
<section class="es-faq-section" aria-label="<?php esc_attr_e( 'سوالات متداول فنی', 'erfan-sanat' ); ?>">
	<h3 class="es-faq-heading"><?php esc_html_e( 'سوالات متداول مهندسی و اجرایی', 'erfan-sanat' ); ?></h3>
	<div class="es-faq-accordion">
		<?php foreach ( $faqs as $idx => $faq ) : ?>
			<?php
			if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
				continue;
			}
			?>
			<details class="es-faq-item" <?php echo 0 === $idx ? 'open' : ''; ?>>
				<summary class="es-faq-question">
					<span><?php echo esc_html( $faq['question'] ); ?></span>
					<span class="es-faq-chevron" aria-hidden="true">+</span>
				</summary>
				<div class="es-faq-answer">
					<p><?php echo nl2br( esc_html( $faq['answer'] ) ); ?></p>
				</div>
			</details>
		<?php endforeach; ?>
	</div>
</section>
