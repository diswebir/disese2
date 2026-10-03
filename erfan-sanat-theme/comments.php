<?php
/**
 * Comments & Technical Q&A Template
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="es-comments-area" aria-label="<?php esc_attr_e( 'دیدگاه‌ها و پرسش‌های فنی', 'erfan-sanat' ); ?>">
	<?php if ( have_comments() ) : ?>
		<h3 class="es-comments-title">
			<?php
			$comment_count = get_comments_number();
			printf(
				/* translators: %s: comment count */
				esc_html__( '%s دیدگاه و پرسش فنی ثبت‌شده', 'erfan-sanat' ),
				esc_html( erfan_sanat_persian_digits( $comment_count ) )
			);
			?>
		</h3>

		<ol class="es-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="es-no-comments"><?php esc_html_e( 'بخش دیدگاه‌ها برای این مطلب بسته شده است.', 'erfan-sanat' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'          => __( 'دیدگاه یا پرسش فنی خود را بنویسید', 'erfan-sanat' ),
			'title_reply_before'   => '<h3 id="reply-title" class="es-comment-reply-title">',
			'title_reply_after'    => '</h3>',
			'label_submit'         => __( 'ثبت دیدگاه', 'erfan-sanat' ),
			'class_submit'         => 'es-btn es-btn-primary',
		)
	);
	?>
</section>
