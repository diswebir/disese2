<?php
/**
 * Homepage Section 3: Urban Lighting Projects Showcase
 *
 * Reproduces the Arena reference 3 featured architectural cards (۰۱ تونل نوری, ۰۲ گوی نورانی, ۰۳ المان نوری)
 * plus dynamic recent `project` CPT items.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$projects_archive_url = erfan_sanat_get_page_url( 'projects' );

$featured_pillars = array(
	array(
		'num'      => '۰۱',
		'title'    => 'تونل نوری',
		'subtitle' => 'کمانی، نیم‌آرک، ۹۰ درجه، مربعی و قلبی',
		'desc'     => 'مسیرهای عبوری با جلوه‌ای جادویی؛ از ورودی بوستان‌ها تا جشنواره‌های شهری',
		'image'    => ES_THEME_URI . 'assets/images/light-tunnel.jpg',
		'url'      => erfan_sanat_get_term_url( 'light-tunnels-walkways', 'project_cat', $projects_archive_url ),
	),
	array(
		'num'      => '۰۲',
		'title'    => 'گوی نورانی',
		'subtitle' => 'المان حجمی نورافکن',
		'desc'     => 'کره‌های درخشان نقطه‌کانونی میادین و فضاهای باز شهری',
		'image'    => ES_THEME_URI . 'assets/images/light-sphere.jpg',
		'url'      => erfan_sanat_get_term_url( 'urban-beautification', 'project_cat', $projects_archive_url ),
	),
	array(
		'num'      => '۰۳',
		'title'    => 'المان نوری',
		'subtitle' => 'سازه‌های نوری اختصاصی',
		'desc'     => 'طراحی و ساخت المان‌های نوری منحصربه‌فرد با هویت بصری ماندگار',
		'image'    => ES_THEME_URI . 'assets/images/light-element.jpg',
		'url'      => $projects_archive_url,
	),
);

$recent_projects = new WP_Query(
	array(
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
?>
<section id="projects" class="es-section es-projects-section">
	<div class="es-container">
		<div class="es-section-header">
			<div>
				<span class="es-section-eyebrow"><?php esc_html_e( 'نمونه‌کارهای برتر', 'erfan-sanat' ); ?></span>
				<h2 class="es-section-title"><?php echo esc_html( (string) es_opt( 'projects_archive_title', 'پروژه‌های نورپردازی شهری' ) ); ?></h2>
				<p class="es-section-subtitle">
					<?php echo esc_html( (string) es_opt( 'projects_archive_subtitle', 'نمونه پروژه‌های نورپردازی حرفه‌ای شهری؛ هر پروژه، روایتی از هنر، مهندسی و نور است که هویت بصری شهر را برای همیشه دگرگون می‌کند.' ) ); ?>
				</p>
			</div>
			<a href="<?php echo esc_url( $projects_archive_url ); ?>" class="es-btn es-btn-outline">
				<span><?php esc_html_e( 'مشاهده آرشیو کامل پروژه‌ها', 'erfan-sanat' ); ?></span>
				<?php echo erfan_sanat_icon( 'arrow-left', 'es-icon-sm' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>

		<div class="es-pillars-grid">
			<?php foreach ( $featured_pillars as $pillar ) : ?>
				<a href="<?php echo esc_url( $pillar['url'] ); ?>" class="es-pillar-card">
					<div class="es-pillar-media">
						<img src="<?php echo esc_url( $pillar['image'] ); ?>" alt="<?php echo esc_attr( $pillar['title'] ); ?>" loading="lazy" width="800" height="600" />
						<div class="es-pillar-overlay"></div>
					</div>
					<div class="es-pillar-content">
						<span class="es-pillar-num"><?php echo esc_html( $pillar['num'] ); ?></span>
						<h3 class="es-pillar-title"><?php echo esc_html( $pillar['title'] ); ?></h3>
						<span class="es-pillar-sub"><?php echo esc_html( $pillar['subtitle'] ); ?></span>
						<p class="es-pillar-desc"><?php echo esc_html( $pillar['desc'] ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<?php if ( $recent_projects->have_posts() ) : ?>
			<div class="es-projects-dynamic-block">
				<h3 class="es-subsection-heading"><?php esc_html_e( 'جدیدترین پروژه‌های اجراشده در شهرهای کشور', 'erfan-sanat' ); ?></h3>
				<div class="es-cards-grid es-grid-3">
					<?php
					$idx = 1;
					while ( $recent_projects->have_posts() ) :
						$recent_projects->the_post();
						get_template_part(
							'template-parts/cards/card-project',
							null,
							array(
								'post_id' => get_the_ID(),
								'index'   => $idx++,
							)
						);
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
