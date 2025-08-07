<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function velocity_categories($tax='category') {
    $args = [
		'taxonomy' => $tax,
        'hide_empty' => false,
	];
    $cats = [
        '' => 'Show All'
	];

    $categories = get_terms($args);

	if (!is_wp_error($categories)) {
		foreach ($categories as $category) {
			$cats[$category->term_id] = $category->name;
		}
	}
    return $cats;
}


add_action('after_setup_theme', 'velocitychild_theme_setup', 9);
function velocitychild_theme_setup()
{

	// Load justg_child_enqueue_parent_style after theme setup
	add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

	if (class_exists('Kirki')) :

		Kirki::add_panel('panel_velocity', [
			'priority'    => 10,
			'title'       => esc_html__('Velocity Theme', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		// section title_tagline
		Kirki::add_section('title_tagline', [
			'panel'    => 'panel_velocity',
			'title'    => __('Site Identity', 'justg'),
			'priority' => 10,
		]);

		///Section Color
		Kirki::add_section('section_colorvelocity', [
			'panel'    => 'panel_velocity',
			'title'    => __('Color & Background', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme',
			'label'       => __('Theme Color', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => '#176cb7',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-primary',
				],
				[
					'element'   => '.border-color-theme',
					'property'  => '--bs-border-color',
				],
				[
					'element'   => '.bg-color-theme',
					'property'  => 'background-color',
				]
			],
		]);

		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_secondary',
			'label'       => __('Secondary Color', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => '#ccb5fb',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-secondary',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-secondary',
				],
				[
					'element'   => '.border-color-secondary',
					'property'  => '--bs-border-color',
				],
				[
					'element'   => '.bg-color-secondary',
					'property'  => 'background-color',
				]
			],
		]);

		Kirki::add_field('justg_config', [
			'type'        => 'background',
			'settings'    => 'background_themewebsite',
			'label'       => __('Website Background', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => [
				'background-color'      => 'rgba(255,255,255)',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root[data-bs-theme=light] body',
				],
				[
					'element'   => 'body',
				],
			],
		]);

		// panel property
		Kirki::add_panel('panel_property', [
			'priority'    => 10,
			'title'       => esc_html__('Property Setting', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		// section header
		Kirki::add_section('section_homebanner', [
			'panel'    => 'panel_property',
			'title'    => __('Home Banner', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'image',
			'settings'    => 'home_banner',
			'label'       => esc_html__( 'Home Banner Utama', 'justg' ),
			'description' => esc_html__( '', 'justg' ),
			'section'     => 'section_homebanner',
			'default'     => '',
			'choices'     => ['save_as' => 'id',],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'subtitle_banner',
			'label'       => __('Sub Title Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Finding your dream home in affordable price',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'title_banner',
			'label'       => __('Title Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Agen<br/>Properti',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'button1_banner',
			'label'       => __('Button Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Hubungi Kami',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'url',
			'settings'    => 'link1_banner',
			'label'       => __('Link Banner', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => '#',
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'after_button',
			'label'       => __('Text After Button', 'justg'),
			'description' => esc_html__('', 'justg'),
			'section'     => 'section_homebanner',
			'default'     => 'Kami siap membantu Anda menemukan properti impian Anda.',
		]);

		// section layanan
		Kirki::add_section('section_layanan', [
			'panel'    => 'panel_property',
			'title'    => __('Layanan', 'justg'),
			'priority' => 10,
		]);

		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'judul_layanan',
			'label'       => __('Judul Layanan', 'justg'),
			'description' => esc_html__('Tuliskan judul layanan.', 'justg'),
			'section'     => 'section_layanan',
			'default'     => 'Layanan Kami',
		]);

		new \Kirki\Field\Repeater([
			'settings'     => 'layanan_repeater',
			'label'        => esc_html__( 'Layanan Control', 'justg' ),
			'section'      => 'section_layanan',
			'priority'     => 10,
			'row_label'    => [
				'type'  => 'field',
				'value' => esc_html__( 'Layanan Anda', 'justg' ),
				// 'field' => 'link_text',
			],
			'button_label'	=> esc_html__( 'Tambah Layanan', 'justg' ),
			'default'		=> ['', 'justg'],
			'choices'		=> ['limit' => 3],
			'fields'		=> [
				'layanan_image'	=> [
					'type'	=> 'image',
					'label'	=> esc_html__( 'Layanan Image', 'justg' ),
					'description'	=> esc_html__( 'Gambar Layanan', 'justg' ),
					'default'	=> '',
					'choices'	=> ['save_as' => 'id',],
				],
				'layanan_title'	=> [
					'type'	=> 'text',
					'label'	=> esc_html__( 'Judul Layanan', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
				'layanan_content'	=> [
					'type'	=> 'textarea',
					'label'	=> esc_html__( 'Deskripsi Layanan', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
				'layanan_link'	=> [
					'type'	=> 'url',
					'label'	=> esc_html__( 'Link Layanan', 'justg' ),
					'description'	=> esc_html__( '', 'justg' ),
					'default'	=> '',
				],
			],
		]);

		// section listing
		Kirki::add_section('section_listing', [
			'panel'    => 'panel_property',
			'title'    => __('Listing', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'judul_listing',
			'label'       => __('Judul Listing', 'justg'),
			'description' => esc_html__('Tuliskan judul listing.', 'justg'),
			'section'     => 'section_listing',
			'default'     => 'Listing Terbaru',
		]);

		// section artikel
		Kirki::add_section('section_artikel', [
			'panel'    => 'panel_property',
			'title'    => __('Artikel', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'text',
			'settings'    => 'judul_artikel',
			'label'       => __('Judul Artikel', 'justg'),
			'description' => esc_html__('Tuliskan judul artikel.', 'justg'),
			'section'     => 'section_artikel',
			'default'     => 'Seputar Property',
		]);
		new \Kirki\Field\Select([
			'settings'    => 'artikel_select',
			'label'       => esc_html__( 'Select Artikel', 'justg' ),
			'section'     => 'section_artikel',
			'default'     => '',
			'priority'  => 10,
            'multiple'  => 1,
			'placeholder' => esc_html__( 'Pilih Kategori', 'justg' ),
			'choices'     => velocity_categories('category'),
		]);


		// remove panel in customizer 
		Kirki::remove_panel('global_panel');
		Kirki::remove_panel('panel_header');
		Kirki::remove_panel('panel_footer');
		Kirki::remove_panel('panel_antispam');
		Kirki::remove_section('header_image');

	endif;

	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');
	remove_theme_support('widgets-block-editor');
}


///remove breadcrumbs
add_action('wp_head', function () {
	if (!is_single()) {
		remove_action('justg_before_title', 'justg_breadcrumb');
	}
});

if (!function_exists('justg_header_open')) {
	function justg_header_open()
	{
		echo '<header id="wrapper-header">';
		echo '<div id="wrapper-navbar" class="container px-2 px-md-0" itemscope itemtype="http://schema.org/WebSite">';
	}
}
if (!function_exists('justg_header_close')) {
	function justg_header_close()
	{
		echo '</div>';
		echo '</header>';
	}
}

// remove some widgets
add_action('widgets_init', 'remove_some_widgets', 11);
function remove_some_widgets()
{
    unregister_sidebar('footer-widget-4');
}

///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}


// excerpt more
add_filter( 'excerpt_more', 'velocity_custom_excerpt_more' );
if ( ! function_exists( 'velocity_custom_excerpt_more' ) ) {
	function velocity_custom_excerpt_more( $more ) {
		return '...';
	}
}

// excerpt length
add_filter('excerpt_length','velocity_excerpt_length');
function velocity_excerpt_length($length){
	return 20;
}

if (!function_exists('justg_right_sidebar_check')) {
	function justg_right_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('main-sidebar')) {
			return;
		}
		echo '<div class="left-sidebar velocity-widget widget-area px-md-0 col-sm-12 col-md-3 order-3 order-md-1" id="left-sidebar" role="complementary">';
		do_action('justg_before_main_sidebar');
		dynamic_sidebar('main-sidebar');
		do_action('justg_after_main_sidebar');
		echo '</div>';
	}
}