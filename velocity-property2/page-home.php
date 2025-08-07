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
$container         = velocitytheme_option('justg_container_type', 'container');
?>

<div class="home-wrapper" id="page-wrapper">
    <div class="banner-area">
        <?php
            $banner = velocitytheme_option('home_banner', '');
            if ($banner) {
                $url_banner = wp_get_attachment_image_url($banner, 'full');
            } else {
                $url_banner = get_stylesheet_directory_uri() . '/img/homebanner.webp';
            }
        ?>
        <div class="banner-image position-relative m-0 p-md-5 p-3" style="background-image: url('<?php echo esc_url($url_banner); ?>');">
            <div class="overlay position-absolute d-lg-none d-block top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255,0.2);"></div>
            <div class="container row m-auto align-items-center my-5">
                <div class="col-md-6 text-white"style="position: relative;z-index: 99;">
                    <h1 class="title"><?php echo velocitytheme_option('title_banner');?></h1>
                    <h6 class="subtitle mb-4"><?php echo velocitytheme_option('subtitle_banner');?></h6>
                    <div class="mt-4">
                        <a href="<?php echo esc_url(velocitytheme_option('link1_banner')); ?>" class="text-uppercase fw-bold btn btn-lg rounded-0  btn-dark rounded-1 text-color-theme me-3" style="min-width: 150px;"><?php echo velocitytheme_option('button1_banner');?></a>
                    </div>
                    <h4 class="mt-2 fw-bold"><?php echo velocitytheme_option('after_button');?></h4>
                </div>
                <div class="col-md-6 d-none d-md-block">

                </div>
            </div>
        </div>
    </div>

    <div class="frame-layanan">
        <div class="container py-5">
            <h2 class="judul-home mb-4"><?php echo velocitytheme_option('judul_layanan');?></h2>
            <?php $layanan= velocitytheme_option('layanan_repeater');?>
            <div class="row m-0">
                <?php
                if ($layanan) {
                    foreach ($layanan as $item) {
                        echo '<div class="col-lg-4 col-md-6 col-12 mb-3 px-md-4">';
                            echo '<div class="layanan-item text-light text-center p-3 mx-auto">';
                                echo '<div class="card-layanan">';
                                    echo '<div class="card-front">';
                                        echo '<img src="' . wp_get_attachment_image_url($item['layanan_image'], 'full') . '" width="100" height="100" alt="' . esc_attr($item['layanan_title']) . '"/>';
                                        echo '<div class="p-2">';
                                            echo '<h3 class="card-title fw-bold">' . esc_html($item['layanan_title']) . '</h3>';
                                            echo '<p class="card-text p-3">' . wp_trim_words($item['layanan_content'], 10, '...') . '</p>';
                                        echo '</div>';
                                    echo '</div>';

                                    echo '<div class="card-back">';
                                        echo '<p class="card-text p-3">' . $item['layanan_content'] . '</p>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div><!-- .container -->
    </div>

    <div class="frame-listing bg-color-secondary">
        <div class="container py-5">
            <h2 class="judul-home mb-4"><?php echo velocitytheme_option('judul_listing');?></h2>
            <div class="row m-0">
                <?php
                $args = [
                    'post_type' => 'property',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ];
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
        </div><!-- .container -->
    </div>

    <div class="frame-artikel">
        <div class="container py-5">
            <h2 class="judul-home mb-4"><?php echo velocitytheme_option('judul_artikel');?></h2>
            <div class="row m-0">
                <?php $artikel = velocitytheme_option('artikel_select');
                $args = [
                        'post_status' => 'publish',
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                ];
                if ($artikel) {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $artikel,
                        ],
                    ];
                }
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $title = get_the_title();
                        $content = get_the_content();
                        echo '<article class="col-md-4 col-12 mb-3">';
                            echo '<div class="card h-100 border-0 artikel-item">';
                                if (has_post_thumbnail()) {
                                    echo '<div class="artikel-image">';
                                    echo '<a href="' . get_permalink() . '" class="text-decoration-none text-dark">';
                                        echo '<img src="' . get_the_post_thumbnail_url(get_the_ID(), 'full') . '" class="img-fluid" alt="' . get_the_title() . '">';
                                    echo '</a>';
                                    echo '</div>';
                                }
                                echo '<div class="artikel-content p-3">';
                                    echo '<span class="artikel-date text-muted"><i>' . get_the_date() . '</i></span>';
                                    echo '<h3 class="card-title fw-bold my-2">';
                                        echo '<a href="' . get_permalink() . '" class="text-decoration-none text-dark">' . wp_trim_words($title, 10, '...') . '</a>';
                                    echo '</h3>';
                                    echo '<p class="card-text">' . wp_trim_words($content, 15, '...') . '</p>';
                                echo '</div>';
                            echo '</div>';
                        echo '</article>';
                    }
                    wp_reset_postdata();
                }
                ?>
    </div>

</div><!-- #page-wrapper -->

<?php
get_footer();
