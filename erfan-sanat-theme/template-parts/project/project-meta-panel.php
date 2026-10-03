<?php
/**
 * Single Project Engineering Metadata Panel
 *
 * Displays `_es_project_client`, `_es_completion_date`, `_es_total_pixel_count`,
 * `_es_total_power_kw`, `_es_project_map_coords`, `_es_project_drone_video`,
 * `project_cat`, `project_location`, and products used in this project.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$client     = (string) ( get_post_meta( $project_id, '_es_project_client', true ) ?: 'شهرداری و سازمان زیباسازی' );
$comp_date  = (string) ( get_post_meta( $project_id, '_es_completion_date', true ) ?: '۱۴۰۴/۰۶/۱۵' );
$pixels     = absint( get_post_meta( $project_id, '_es_total_pixel_count', true ) ?: 4800 );
$power_kw   = (float) ( get_post_meta( $project_id, '_es_total_power_kw', true ) ?: 3.5 );
$coords     = (string) get_post_meta( $project_id, '_es_project_map_coords', true );
$drone_url  = erfan_sanat_resolve_media_url( get_post_meta( $project_id, '_es_project_drone_video', true ) );
$cats       = get_the_terms( $project_id, 'project_cat' );
$locs       = get_the_terms( $project_id, 'project_location' );
?>
<aside class="es-project-meta-panel" aria-label="<?php esc_attr_e( 'شناسنامه فنی پروژه', 'erfan-sanat' ); ?>">
	<h3 class="es-panel-title"><?php esc_html_e( 'شناسنامه فنی و اجرایی پروژه', 'erfan-sanat' ); ?></h3>

	<dl class="es-project-meta-list">
		<div class="es-meta-pair">
			<dt><?php esc_html_e( 'کارفرمای پروژه:', 'erfan-sanat' ); ?></dt>
			<dd><?php echo esc_html( $client ); ?></dd>
		</div>

		<?php if ( is_array( $locs ) && ! empty( $locs ) ) : ?>
			<div class="es-meta-pair">
				<dt><?php esc_html_e( 'محل اجرای پروژه:', 'erfan-sanat' ); ?></dt>
				<dd>
					<?php foreach ( $locs as $loc_term ) : ?>
						<a href="<?php echo esc_url( (string) get_term_link( $loc_term ) ); ?>" class="es-term-chip">
							<?php echo esc_html( $loc_term->name ); ?>
						</a>
					<?php endforeach; ?>
				</dd>
			</div>
		<?php endif; ?>

		<?php if ( is_array( $cats ) && ! empty( $cats ) ) : ?>
			<div class="es-meta-pair">
				<dt><?php esc_html_e( 'نوع پروژه:', 'erfan-sanat' ); ?></dt>
				<dd>
					<?php foreach ( $cats as $cat_term ) : ?>
						<a href="<?php echo esc_url( (string) get_term_link( $cat_term ) ); ?>" class="es-term-chip">
							<?php echo esc_html( $cat_term->name ); ?>
						</a>
					<?php endforeach; ?>
				</dd>
			</div>
		<?php endif; ?>

		<div class="es-meta-pair">
			<dt><?php esc_html_e( 'تاریخ تکمیل پروژه:', 'erfan-sanat' ); ?></dt>
			<dd><?php echo esc_html( erfan_sanat_persian_digits( $comp_date ) ); ?></dd>
		</div>

		<div class="es-meta-pair">
			<dt><?php esc_html_e( 'تعداد کل نقاط نوری / پیکسل:', 'erfan-sanat' ); ?></dt>
			<dd><?php echo esc_html( erfan_sanat_persian_digits( number_format( $pixels ) ) . ' ' . __( 'پیکسل هوشمند', 'erfan-sanat' ) ); ?></dd>
		</div>

		<div class="es-meta-pair">
			<dt><?php esc_html_e( 'مجموع توان مصرفی پروژه:', 'erfan-sanat' ); ?></dt>
			<dd><?php echo esc_html( erfan_sanat_persian_digits( (string) $power_kw ) . ' ' . __( 'کیلووات (kW)', 'erfan-sanat' ) ); ?></dd>
		</div>

		<div class="es-meta-pair">
			<dt><?php esc_html_e( 'مجری و طراح سازه:', 'erfan-sanat' ); ?></dt>
			<dd><?php esc_html_e( 'شرکت دانش‌بنیان عرفان صنعت اصفهان', 'erfan-sanat' ); ?></dd>
		</div>

		<?php if ( '' !== $coords ) : ?>
			<div class="es-meta-pair">
				<dt><?php esc_html_e( 'مختصات جغرافیایی:', 'erfan-sanat' ); ?></dt>
				<dd dir="ltr"><code><?php echo esc_html( $coords ); ?></code></dd>
			</div>
		<?php endif; ?>
	</dl>

	<?php
	$used_products = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'no_found_rows'  => true,
		)
	);
	if ( $used_products->have_posts() ) :
		?>
		<div class="es-project-used-products">
			<h4><?php esc_html_e( 'تجهیزات به‌کاررفته در این پروژه:', 'erfan-sanat' ); ?></h4>
			<ul class="es-used-products-list">
				<?php
				while ( $used_products->have_posts() ) :
					$used_products->the_post();
					?>
					<li>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</div>
	<?php endif; ?>

	<div class="es-project-panel-actions">
		<?php if ( '' !== $drone_url ) : ?>
			<a href="<?php echo esc_url( $drone_url ); ?>" class="es-btn es-btn-outline es-btn-block" target="_blank" rel="noopener noreferrer">
				<?php echo erfan_sanat_icon( 'video', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php esc_html_e( 'مشاهده ویدیو هوایی پروژه', 'erfan-sanat' ); ?></span>
			</a>
		<?php endif; ?>
		<a href="#consultation" class="es-btn es-btn-primary es-btn-block">
			<span><?php esc_html_e( 'سفارش اجرای پروژه مشابه', 'erfan-sanat' ); ?></span>
			<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	</div>
</aside>
