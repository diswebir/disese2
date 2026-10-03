<?php
/**
 * Single Product Technical Specifications, Official Product Identity Card (GS1/HS/ISIC/CPC),
 * Wiring Schematic & Related Urban Lighting Projects
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id    = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : (int) get_the_ID();
$purchase_data = erfan_sanat_get_product_purchase_data( $product_id );
$attrs_summary = erfan_sanat_get_product_attributes_summary( $product_id );
$national_code = (string) ( get_post_meta( $product_id, '_es_national_code', true ) ?: ( '2901485' . str_pad( (string) $product_id, 5, '0', STR_PAD_LEFT ) ) );
$gs1_code      = (string) ( get_post_meta( $product_id, '_es_gs1_code', true ) ?: ( '62609814' . str_pad( (string) $product_id, 5, '0', STR_PAD_LEFT ) ) );
$hs_code       = (string) ( get_post_meta( $product_id, '_es_hs_code', true ) ?: '94054290' );
$isic_code     = (string) ( get_post_meta( $product_id, '_es_isic_code', true ) ?: '2740' );
$cpc_code      = (string) ( get_post_meta( $product_id, '_es_cpc_code', true ) ?: '46539' );
?>
<section id="product-specs-section" class="es-product-specs-section" data-es-specs-tabs>
	<div class="es-specs-tabs-bar" role="tablist" aria-label="<?php esc_attr_e( 'اطلاعات مهندسی و شناسنامه محصول', 'erfan-sanat' ); ?>">
		<button type="button" class="es-specs-tab is-active" role="tab" aria-selected="true" data-spec-tab="specs">
			<?php esc_html_e( 'مشخصات فنی و مهندسی', 'erfan-sanat' ); ?>
		</button>
		<button type="button" class="es-specs-tab" role="tab" aria-selected="false" data-spec-tab="identity">
			<?php esc_html_e( 'شناسنامه رسمی محصول (GS1 / ISIC)', 'erfan-sanat' ); ?>
		</button>
		<button type="button" class="es-specs-tab" role="tab" aria-selected="false" data-spec-tab="schematic">
			<?php esc_html_e( 'نقشه سیم‌کشی و نصب', 'erfan-sanat' ); ?>
		</button>
		<button type="button" class="es-specs-tab" role="tab" aria-selected="false" data-spec-tab="projects">
			<?php esc_html_e( 'پروژه‌های مرتبط اجراشده', 'erfan-sanat' ); ?>
		</button>
	</div>

	<div class="es-specs-tab-panel is-active" role="tabpanel" data-spec-panel="specs">
		<div class="es-specs-table-card">
			<h3><?php esc_html_e( 'جدول ویژگی‌ها و مشخصات فنی مهندسی', 'erfan-sanat' ); ?></h3>
			<table class="es-specs-table">
				<tbody>
					<?php foreach ( $attrs_summary as $tax_key => $attr_row ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $attr_row['label'] ); ?></th>
							<td><?php echo esc_html( implode( ' ، ', $attr_row['values'] ) ); ?></td>
						</tr>
					<?php endforeach; ?>

					<?php if ( ! empty( $purchase_data['wattage'] ) ) : ?>
						<tr>
							<th scope="row"><?php esc_html_e( 'توان مصرفی نامی', 'erfan-sanat' ); ?></th>
							<td><?php echo esc_html( erfan_sanat_persian_digits( $purchase_data['wattage'] ) . ' ' . __( 'وات', 'erfan-sanat' ) ); ?></td>
						</tr>
					<?php endif; ?>

					<?php if ( ! empty( $purchase_data['chip_brand'] ) ) : ?>
						<tr>
							<th scope="row"><?php esc_html_e( 'برند چیپ LED', 'erfan-sanat' ); ?></th>
							<td><?php echo esc_html( $purchase_data['chip_brand'] ); ?></td>
						</tr>
					<?php endif; ?>

					<tr>
						<th scope="row"><?php esc_html_e( 'گارانتی و خدمات پس از فروش', 'erfan-sanat' ); ?></th>
						<td><?php echo esc_html( (string) es_opt( 'wc_warranty_badge_text', '۲۴ ماه گارانتی تعویض + ۵ سال خدمات پس از فروش' ) ); ?></td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'استاندارد مدیریت کیفیت', 'erfan-sanat' ); ?></th>
						<td>ISO 9001:2015 — <?php esc_html_e( 'تولید شرکت دانش‌بنیان عرفان صنعت اصفهان', 'erfan-sanat' ); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="es-specs-tab-panel" role="tabpanel" data-spec-panel="identity" hidden>
		<div class="es-specs-table-card">
			<h3><?php esc_html_e( 'شناسنامه ملی و طبقه‌بندی استاندارد کالا (ویژه مناقصات و تدارکات دولتی)', 'erfan-sanat' ); ?></h3>
			<table class="es-specs-table">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'کد ملی کالا (ایران‌کد)', 'erfan-sanat' ); ?></th>
						<td dir="ltr"><code><?php echo esc_html( $national_code ); ?></code></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'بارکد بین‌المللی (GS1)', 'erfan-sanat' ); ?></th>
						<td dir="ltr"><code><?php echo esc_html( $gs1_code ); ?></code></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'کد تعرفه گمرکی (HS Code)', 'erfan-sanat' ); ?></th>
						<td dir="ltr"><code><?php echo esc_html( $hs_code ); ?></code></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'کد آیسیک (ISIC)', 'erfan-sanat' ); ?></th>
						<td dir="ltr"><code><?php echo esc_html( $isic_code ); ?></code></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'کد طبقه‌بندی محوری محصول (CPC)', 'erfan-sanat' ); ?></th>
						<td dir="ltr"><code><?php echo esc_html( $cpc_code ); ?></code></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="es-specs-tab-panel" role="tabpanel" data-spec-panel="schematic" hidden>
		<div class="es-schematic-card">
			<h3><?php esc_html_e( 'نقشه فنی سیم‌کشی و دیاگرام نصب', 'erfan-sanat' ); ?></h3>
			<div class="es-schematic-frame">
				<img
					src="<?php echo esc_url( $purchase_data['schematic_url'] ); ?>"
					alt="<?php echo esc_attr( sprintf( __( 'نقشه سیم‌کشی %s', 'erfan-sanat' ), get_the_title( $product_id ) ) ); ?>"
					loading="lazy"
					width="900"
					height="560"
				/>
			</div>
			<p class="es-schematic-caption">
				<?php esc_html_e( 'رعایت استاندارد سطح مقطع کابل، فیوز محافظ و آب‌بندی اتصالات با گلند و رزین صنعتی جهت حفظ گارانتی ۲۴ ماهه الزامی است.', 'erfan-sanat' ); ?>
			</p>
		</div>
	</div>

	<div class="es-specs-tab-panel" role="tabpanel" data-spec-panel="projects" hidden>
		<div class="es-specs-table-card">
			<h3><?php esc_html_e( 'پروژه‌های شهری مرتبط با این محصول', 'erfan-sanat' ); ?></h3>
			<?php
			$rel_projects = new WP_Query(
				array(
					'post_type'      => 'project',
					'post_status'    => 'publish',
					'posts_per_page' => 3,
					'no_found_rows'  => true,
				)
			);
			if ( $rel_projects->have_posts() ) :
				?>
				<div class="es-cards-grid es-grid-3">
					<?php
					while ( $rel_projects->have_posts() ) :
						$rel_projects->the_post();
						get_template_part( 'template-parts/cards/card-project', null, array( 'post_id' => get_the_ID() ) );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
