<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */

get_header();

$banner_image = velocitychild_resolve_image_value_to_url(velocitytheme_option('home_banner', 0), 'full');
if (!$banner_image) {
	$banner_image = trailingslashit(get_stylesheet_directory_uri()) . 'img/homebanner.webp';
}

$title_banner    = (string) velocitytheme_option('title_banner', 'Agen<br/>Properti');
$subtitle_banner = (string) velocitytheme_option('subtitle_banner', 'Finding your dream home in affordable price');
$button_banner   = (string) velocitytheme_option('button1_banner', 'Hubungi Kami');
$link_banner     = (string) velocitytheme_option('link1_banner', '#');
$after_button    = (string) velocitytheme_option('after_button', 'Kami siap membantu Anda menemukan properti impian Anda.');

$judul_layanan = (string) velocitytheme_option('judul_layanan', 'Layanan Kami');
$layanan_items = velocitychild_get_home_layanan_items();

$judul_listing = (string) velocitytheme_option('judul_listing', 'Listing Terbaru');
$judul_artikel = (string) velocitytheme_option('judul_artikel', 'Seputar Property');
$artikel       = absint(velocitytheme_option('artikel_select', ''));
?>

<div class="home-wrapper" id="page-wrapper">
	<div class="banner-area">
		<div class="banner-image position-relative m-0 p-md-5 p-3" style="background-image: url('<?php echo esc_url($banner_image); ?>');">
			<div class="overlay position-absolute d-lg-none d-block top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255,0.2);"></div>
			<div class="container row m-auto align-items-center my-5">
				<div class="col-md-6 text-white" style="position: relative; z-index: 99;">
					<h1 class="title"><?php echo wp_kses_post($title_banner); ?></h1>
					<h6 class="subtitle mb-4"><?php echo esc_html($subtitle_banner); ?></h6>
					<div class="mt-4">
						<a href="<?php echo esc_url($link_banner); ?>" class="text-uppercase fw-bold btn btn-lg rounded-0 btn-dark rounded-1 text-white me-3" style="min-width: 150px;"><?php echo esc_html($button_banner); ?></a>
					</div>
					<h4 class="mt-2 fw-bold"><?php echo esc_html($after_button); ?></h4>
				</div>
				<div class="col-md-6 d-none d-md-block"></div>
			</div>
		</div>
	</div>

	<div class="frame-layanan">
		<div class="container py-5 my-5">
			<h2 class="judul-home mb-4"><?php echo esc_html($judul_layanan); ?></h2>
			<div class="row m-0 justify-content-center">
				<?php
				if (!empty($layanan_items)) {
					foreach ($layanan_items as $item) {
						$icon    = isset($item['layanan_icon']) ? (string) $item['layanan_icon'] : velocitychild_get_default_service_icon();
						$title   = isset($item['layanan_title']) ? (string) $item['layanan_title'] : '';
						$content = isset($item['layanan_content']) ? (string) $item['layanan_content'] : '';
						$link    = isset($item['layanan_link']) ? (string) $item['layanan_link'] : '';

						echo '<div class="col-lg-4 col-md-6 col-12 mb-3 px-md-4">';
						echo '<div class="layanan-item text-light text-center p-3 mx-auto">';
						echo '<div class="card-layanan">';
						echo '<div class="card-front">';
						echo '<div class="layanan-icon" aria-hidden="true">' . velocitychild_get_bootstrap_icon_html($icon) . '</div>';
						echo '<div class="p-2">';
						echo '<h3 class="card-title fw-bold">' . esc_html($title) . '</h3>';
						echo '<p class="card-text p-3">' . esc_html(wp_trim_words(wp_strip_all_tags($content), 10, '...')) . '</p>';
						echo '</div>';
						echo '</div>';

						echo '<div class="card-back">';
						echo '<div class="card-text p-3">' . wp_kses_post($content) . '</div>';
						if (!empty($link)) {
							echo '<a href="' . esc_url($link) . '" class="btn btn-sm btn-outline-light mt-2">Selengkapnya</a>';
						}
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>

	<div class="frame-listing bg-color-secondary py-5">
		<div class="container py-5">
			<h2 class="judul-home mb-4"><?php echo esc_html($judul_listing); ?></h2>
			<div class="row m-0 justify-content-center">
				<?php
				$args = array(
					'post_type'      => 'property',
					'posts_per_page' => 3,
					'orderby'        => 'date',
					'order'          => 'DESC',
				);
				$query = new WP_Query($args);
				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						echo do_shortcode('[property-loop post_id="' . get_the_ID() . '" class="col-md-4 col-12 px-md-3 mb-3"]');
					}
					wp_reset_postdata();
				}
				?>
			</div>
		</div>
	</div>

	<div class="frame-artikel">
		<div class="container py-5 my-5">
			<h2 class="judul-home mb-4"><?php echo esc_html($judul_artikel); ?></h2>
			<div class="row m-0 justify-content-center">
				<?php
				$args = array(
					'post_status'    => 'publish',
					'post_type'      => 'post',
					'posts_per_page' => 3,
					'orderby'        => 'date',
				);

				if ($artikel > 0) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => $artikel,
						),
					);
				}

				$query = new WP_Query($args);
				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						$title   = get_the_title();
						$content = wp_strip_all_tags(get_the_content());
						echo '<article class="col-md-4 col-12 mb-3">';
						echo '<div class="card h-100 border-0 artikel-item">';
						echo velocitychild_get_post_thumbnail_html(get_the_ID(), array('ratio' => '4x3', 'wrapper_class' => 'artikel-image', 'img_class' => 'img-fluid w-100 h-100 object-fit-cover'));
						echo '<div class="artikel-content pt-3">';
						echo '<span class="artikel-date text-muted"><i>' . esc_html(get_the_date()) . '</i></span>';
						echo '<h3 class="card-title fw-bold my-2">';
						echo '<a href="' . esc_url(get_permalink()) . '" class="text-decoration-none text-dark">' . esc_html(wp_trim_words($title, 10, '...')) . '</a>';
						echo '</h3>';
						echo '<p class="card-text">' . esc_html(wp_trim_words($content, 15, '...')) . '</p>';
						echo '</div>';
						echo '</div>';
						echo '</article>';
					}
					wp_reset_postdata();
				}
				?>
			</div>
		</div>
	</div>
</div><!-- #page-wrapper -->

<?php
get_footer();
