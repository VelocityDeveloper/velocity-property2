<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);
add_action('customize_register', 'velocitychild_customize_register', 30);
add_action('customize_controls_enqueue_scripts', 'velocitychild_customize_control_assets');
add_filter('justg_theme_default_settings', 'velocitychild_default_settings', 20);

if (!function_exists('velocitychild_default_settings')) {
	/**
	 * Extend parent default settings with child keys.
	 *
	 * @param array<string, mixed> $defaults Parent defaults.
	 * @return array<string, mixed>
	 */
	function velocitychild_default_settings($defaults) {
		$child_defaults = array(
			'home_banner'     => 0,
			'subtitle_banner' => 'Finding your dream home in affordable price',
			'title_banner'    => 'Agen<br/>Properti',
			'button1_banner'  => 'Hubungi Kami',
			'link1_banner'    => '#',
			'after_button'    => 'Kami siap membantu Anda menemukan properti impian Anda.',
			'judul_layanan'   => 'Layanan Kami',
			'layanan_repeater' => array(),
			'judul_listing'   => 'Listing Terbaru',
			'judul_artikel'   => 'Seputar Property',
			'artikel_select'  => '',
		);

		return array_merge($defaults, $child_defaults);
	}
}

if (!function_exists('velocity_categories')) {
	/**
	 * Get category choices for customizer select.
	 *
	 * @param string $tax Taxonomy slug.
	 * @return array<string, string>
	 */
	function velocity_categories($tax = 'category') {
		$args = array(
			'taxonomy'   => $tax,
			'hide_empty' => false,
		);
		$cats = array(
			'' => 'Show All',
		);

		$categories = get_terms($args);

		if (!is_wp_error($categories)) {
			foreach ($categories as $category) {
				$cats[(string) $category->term_id] = $category->name;
			}
		}

		return $cats;
	}
}

if (!function_exists('velocitychild_customize_control_assets')) {
	/**
	 * Enqueue assets for customizer repeater control.
	 *
	 * @return void
	 */
	function velocitychild_customize_control_assets() {
		$theme   = wp_get_theme();
		$version = $theme ? $theme->get('Version') : '1.0.0';

		$repeater_css_path = get_stylesheet_directory() . '/css/customizer-repeater.css';
		$repeater_js_path  = get_stylesheet_directory() . '/js/customizer-repeater.js';
		$repeater_css_ver  = file_exists($repeater_css_path) ? filemtime($repeater_css_path) : $version;
		$repeater_js_ver   = file_exists($repeater_js_path) ? filemtime($repeater_js_path) : $version;

		wp_enqueue_media();

		wp_enqueue_style(
			'velocitychild-customizer-repeater',
			get_stylesheet_directory_uri() . '/css/customizer-repeater.css',
			array(),
			$repeater_css_ver
		);

		wp_enqueue_script(
			'velocitychild-customizer-repeater',
			get_stylesheet_directory_uri() . '/js/customizer-repeater.js',
			array('jquery', 'customize-controls', 'media-editor', 'media-views'),
			$repeater_js_ver,
			true
		);
	}
}

if (!function_exists('velocitychild_decode_repeater_value')) {
	/**
	 * Decode repeater value if stored as JSON string.
	 *
	 * @param mixed $value Repeater raw value.
	 * @return array<int, array<string, mixed>>
	 */
	function velocitychild_decode_repeater_value($value) {
		if (is_string($value)) {
			$decoded = json_decode($value, true);
			if (json_last_error() === JSON_ERROR_NONE) {
				$value = $decoded;
			}
		}

		if (!is_array($value)) {
			return array();
		}

		return $value;
	}
}

if (!function_exists('velocitychild_resolve_image_value_to_url')) {
	/**
	 * Resolve stored image value to URL.
	 *
	 * @param mixed  $value Image ID or URL.
	 * @param string $size  Image size.
	 * @return string
	 */
	function velocitychild_resolve_image_value_to_url($value, $size = 'full') {
		if (is_numeric($value)) {
			$image_id = absint($value);
			if ($image_id > 0) {
				$image_url = wp_get_attachment_image_url($image_id, $size);
				if ($image_url) {
					return $image_url;
				}
			}
		}

		$image_url = esc_url_raw((string) $value);
		if (!empty($image_url)) {
			return $image_url;
		}

		return '';
	}
}

if (!function_exists('velocitychild_sanitize_banner_title')) {
	/**
	 * Sanitize banner title allowing simple line break tag.
	 *
	 * @param mixed $value Raw value.
	 * @return string
	 */
	function velocitychild_sanitize_banner_title($value) {
		return wp_kses((string) $value, array('br' => array()));
	}
}

if (!function_exists('velocitychild_sanitize_artikel_select')) {
	/**
	 * Sanitize article category setting.
	 *
	 * @param mixed $value Raw value.
	 * @return int|string
	 */
	function velocitychild_sanitize_artikel_select($value) {
		$value = absint($value);
		return $value > 0 ? $value : '';
	}
}

if (!function_exists('velocitychild_get_layanan_repeater_fields')) {
	/**
	 * Repeater fields for layanan section.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	function velocitychild_get_layanan_repeater_fields() {
		return array(
			'layanan_icon' => array(
				'type'        => 'select',
				'label'       => __('Layanan Icon', 'justg'),
				'description' => sprintf(
					__('Referensi icon: <a href="%s" target="_blank" rel="noopener noreferrer">icons.getbootstrap.com</a>', 'justg'),
					esc_url('https://icons.getbootstrap.com/')
				),
				'default'     => velocitychild_get_default_service_icon(),
				'choices'     => velocitychild_get_bootstrap_icon_choices(),
			),
			'layanan_title' => array(
				'type'    => 'text',
				'label'   => __('Judul Layanan', 'justg'),
				'default' => '',
			),
			'layanan_content' => array(
				'type'    => 'textarea',
				'label'   => __('Deskripsi Layanan', 'justg'),
				'default' => '',
			),
			'layanan_link' => array(
				'type'    => 'url',
				'label'   => __('Link Layanan', 'justg'),
				'default' => '',
			),
		);
	}
}

if (!function_exists('velocitychild_sanitize_layanan_repeater')) {
	/**
	 * Sanitize layanan repeater values.
	 *
	 * @param mixed $value Raw value.
	 * @return array<int, array<string, mixed>>
	 */
	function velocitychild_sanitize_layanan_repeater($value) {
		$items = velocitychild_decode_repeater_value($value);
		$clean = array();

		foreach ($items as $item) {
			if (!is_array($item)) {
				continue;
			}

			$icon    = isset($item['layanan_icon']) ? velocitychild_normalize_service_icon($item['layanan_icon']) : velocitychild_get_default_service_icon();
			$title   = isset($item['layanan_title']) ? sanitize_text_field((string) $item['layanan_title']) : '';
			$content = isset($item['layanan_content']) ? wp_kses_post((string) $item['layanan_content']) : '';
			$link    = isset($item['layanan_link']) ? esc_url_raw((string) $item['layanan_link']) : '';

			if ('' === $title && '' === trim(wp_strip_all_tags($content)) && '' === $link) {
				continue;
			}

			$clean[] = array(
				'layanan_icon'    => $icon,
				'layanan_title'   => $title,
				'layanan_content' => $content,
				'layanan_link'    => $link,
			);
		}

		return $clean;
	}
}

if (!function_exists('velocitychild_get_legacy_layanan_items')) {
	/**
	 * Backward compatibility for old layanan repeater.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	function velocitychild_get_legacy_layanan_items() {
		$value = velocitytheme_option('layanan_repeater', array());
		return velocitychild_sanitize_layanan_repeater($value);
	}
}

if (!function_exists('velocitychild_get_home_layanan_items')) {
	/**
	 * Get layanan repeater items with normalized icon values.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	function velocitychild_get_home_layanan_items() {
		$items_raw = get_theme_mod('layanan_repeater', null);
		if (null === $items_raw) {
			$items = velocitychild_get_legacy_layanan_items();
		} else {
			$items = velocitychild_sanitize_layanan_repeater($items_raw);
		}

		$output = array();
		foreach ($items as $item) {
			$icon = isset($item['layanan_icon']) ? velocitychild_normalize_service_icon($item['layanan_icon']) : velocitychild_get_default_service_icon();

			$output[] = array(
				'layanan_icon'    => $icon,
				'layanan_title'   => isset($item['layanan_title']) ? (string) $item['layanan_title'] : '',
				'layanan_content' => isset($item['layanan_content']) ? (string) $item['layanan_content'] : '',
				'layanan_link'    => isset($item['layanan_link']) ? (string) $item['layanan_link'] : '',
			);
		}

		return $output;
	}
}

if (!class_exists('Velocitychild_Repeater_Control') && class_exists('WP_Customize_Control')) {
	/**
	 * Generic repeater control for WordPress customizer.
	 */
	class Velocitychild_Repeater_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'velocity_repeater';

		/**
		 * Repeater fields definition.
		 *
		 * @var array<string, array<string, string>>
		 */
		public $fields = array();

		/**
		 * Item label for repeater entries.
		 *
		 * @var string
		 */
		public $item_label = '';

		/**
		 * Add button label.
		 *
		 * @var string
		 */
		public $add_button_label = '';

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Manager.
		 * @param string               $id      Control ID.
		 * @param array                $args    Control args.
		 * @param array                $options Options.
		 */
		public function __construct($manager, $id, $args = array(), $options = array()) {
			if (isset($args['fields'])) {
				$this->fields = (array) $args['fields'];
				unset($args['fields']);
			}
			if (isset($args['item_label'])) {
				$this->item_label = (string) $args['item_label'];
				unset($args['item_label']);
			}
			if (isset($args['add_button_label'])) {
				$this->add_button_label = (string) $args['add_button_label'];
				unset($args['add_button_label']);
			}
			parent::__construct($manager, $id, $args);
		}

		/**
		 * Render control content.
		 *
		 * @return void
		 */
		protected function render_content() {
			if (empty($this->fields)) {
				return;
			}

			$value = $this->value();
			if (is_string($value)) {
				$decoded = json_decode($value, true);
				$value   = (json_last_error() === JSON_ERROR_NONE) ? $decoded : array();
			}

			if (!is_array($value)) {
				$value = array();
			}

			$encoded_value = wp_json_encode($value);
			if (empty($encoded_value)) {
				$encoded_value = '[]';
			}
			?>
			<div class="velocity-repeater-control">
				<?php if (!empty($this->label)) : ?>
					<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
				<?php endif; ?>
				<?php if (!empty($this->description)) : ?>
					<p class="description"><?php echo wp_kses_post($this->description); ?></p>
				<?php endif; ?>

				<div class="velocity-repeater" data-fields="<?php echo esc_attr(wp_json_encode($this->fields)); ?>" data-default-label="<?php echo esc_attr($this->item_label ? $this->item_label : __('Item', 'justg')); ?>">
					<input type="hidden" class="velocity-repeater-store" <?php $this->link(); ?> value="<?php echo esc_attr($encoded_value); ?>">
					<div class="velocity-repeater-items">
						<?php
						if (!empty($value)) {
							foreach ($value as $item) {
								echo $this->get_single_item_markup($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
						}
						?>
					</div>
					<button type="button" class="button button-primary velocity-repeater-add"><?php echo esc_html($this->add_button_label ? $this->add_button_label : __('Tambah Item', 'justg')); ?></button>
					<script type="text/html" class="velocity-repeater-template">
						<?php echo $this->get_single_item_markup(array()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</script>
				</div>
			</div>
			<?php
		}

		/**
		 * Render a repeater item.
		 *
		 * @param array<string, mixed> $item_values Item value.
		 * @return string
		 */
		private function get_single_item_markup($item_values = array()) {
			ob_start();
			$summary = $this->item_label ? $this->item_label : __('Item', 'justg');
			?>
			<div class="velocity-repeater-item">
				<button type="button" class="velocity-repeater-toggle" aria-expanded="true">
					<span class="velocity-repeater-item-label"><?php echo esc_html($summary); ?></span>
					<span class="velocity-repeater-toggle-icon" aria-hidden="true"></span>
				</button>
				<div class="velocity-repeater-item-body">
					<?php foreach ($this->fields as $field_key => $field) :
						$field_type    = isset($field['type']) ? $field['type'] : 'text';
						$field_label   = isset($field['label']) ? $field['label'] : '';
						$field_default = isset($field['default']) ? $field['default'] : '';
						$field_desc    = isset($field['description']) ? $field['description'] : '';
						$field_value   = isset($item_values[$field_key]) ? $item_values[$field_key] : $field_default;

						if ('image' === $field_type) :
							$image_value = (string) $field_value;
							$image_id    = absint($field_value);
							$image_url   = '';

							if ($image_id > 0) {
								$image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
							} elseif (filter_var($image_value, FILTER_VALIDATE_URL)) {
								$image_url = $image_value;
							}
							?>
							<div class="velocity-repeater-field">
								<span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span>
								<div class="velocity-repeater-image-field">
									<input type="hidden" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>" value="<?php echo esc_attr($image_value); ?>">
									<div class="velocity-repeater-image-preview<?php echo $image_url ? ' has-image' : ''; ?>">
										<?php if ($image_url) : ?>
											<img src="<?php echo esc_url($image_url); ?>" alt="">
										<?php endif; ?>
									</div>
									<div class="velocity-repeater-image-actions">
										<button type="button" class="button velocity-repeater-media-select"><?php esc_html_e('Pilih Gambar', 'justg'); ?></button>
										<button type="button" class="button-link button-link-delete velocity-repeater-media-remove"><?php esc_html_e('Hapus', 'justg'); ?></button>
									</div>
								</div>
								<?php if (!empty($field_desc)) : ?>
									<span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span>
								<?php endif; ?>
							</div>
						<?php elseif ('textarea' === $field_type) : ?>
							<label class="velocity-repeater-field">
								<span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span>
								<textarea data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>"><?php echo esc_textarea((string) $field_value); ?></textarea>
								<?php if (!empty($field_desc)) : ?>
									<span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span>
								<?php endif; ?>
							</label>
						<?php elseif ('select' === $field_type) : ?>
							<?php $choices = isset($field['choices']) && is_array($field['choices']) ? $field['choices'] : array(); ?>
							<label class="velocity-repeater-field">
								<span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span>
								<select data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>">
									<?php foreach ($choices as $choice_value => $choice_label) : ?>
										<option value="<?php echo esc_attr((string) $choice_value); ?>" <?php selected((string) $field_value, (string) $choice_value); ?>><?php echo esc_html((string) $choice_label); ?></option>
									<?php endforeach; ?>
								</select>
								<?php if (!empty($field_desc)) : ?>
									<span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span>
								<?php endif; ?>
							</label>
						<?php else : ?>
							<label class="velocity-repeater-field">
								<span class="velocity-repeater-field-label"><?php echo esc_html($field_label); ?></span>
								<input type="<?php echo esc_attr($field_type); ?>" data-field="<?php echo esc_attr($field_key); ?>" data-default="<?php echo esc_attr($field_default); ?>" value="<?php echo esc_attr((string) $field_value); ?>">
								<?php if (!empty($field_desc)) : ?>
									<span class="description customize-control-description"><?php echo wp_kses_post($field_desc); ?></span>
								<?php endif; ?>
							</label>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="velocity-repeater-actions">
						<button type="button" class="button velocity-repeater-clone"><?php esc_html_e('Clone', 'justg'); ?></button>
						<button type="button" class="button button-secondary velocity-repeater-remove"><?php esc_html_e('Hapus', 'justg'); ?></button>
					</div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
	}
}

if (!function_exists('velocitychild_customize_register')) {
	/**
	 * Child theme customizer settings without Kirki.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 * @return void
	 */
	function velocitychild_customize_register(WP_Customize_Manager $wp_customize) {
		$textdomain = 'justg';

		$site_identity_section = $wp_customize->get_section('title_tagline');
		if ($site_identity_section) {
			// Keep Site Identity in default WordPress location (no custom panel).
			$site_identity_section->panel = '';
		}

		if (!$wp_customize->get_panel('panel_property')) {
			$wp_customize->add_panel(
				'panel_property',
				array(
					'priority'    => 20,
					'title'       => esc_html__('Home Settings', $textdomain),
					'description' => '',
				)
			);
		} else {
			$panel_property = $wp_customize->get_panel('panel_property');
			if ($panel_property) {
				$panel_property->title = esc_html__('Home Settings', $textdomain);
			}
		}

		$wp_customize->add_section(
			'section_homebanner',
			array(
				'panel'    => 'panel_property',
				'title'    => __('Home Banner', $textdomain),
				'priority' => 10,
			)
		);

		$wp_customize->add_setting(
			'home_banner',
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'home_banner',
				array(
					'label'      => esc_html__('Home Banner Utama', $textdomain),
					'section'    => 'section_homebanner',
					'mime_type'  => 'image',
				)
			)
		);

		$wp_customize->add_setting(
			'subtitle_banner',
			array(
				'default'           => 'Finding your dream home in affordable price',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'subtitle_banner',
			array(
				'type'    => 'text',
				'label'   => __('Sub Title Banner', $textdomain),
				'section' => 'section_homebanner',
			)
		);

		$wp_customize->add_setting(
			'title_banner',
			array(
				'default'           => 'Agen Properti',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'title_banner',
			array(
				'type'        => 'text',
				'label'       => __('Title Banner', $textdomain),
				'section'     => 'section_homebanner',
			)
		);

		$wp_customize->add_setting(
			'button1_banner',
			array(
				'default'           => 'Hubungi Kami',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'button1_banner',
			array(
				'type'    => 'text',
				'label'   => __('Button Banner', $textdomain),
				'section' => 'section_homebanner',
			)
		);

		$wp_customize->add_setting(
			'link1_banner',
			array(
				'default'           => '#',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'link1_banner',
			array(
				'type'    => 'url',
				'label'   => __('Link Banner', $textdomain),
				'section' => 'section_homebanner',
			)
		);

		$wp_customize->add_setting(
			'after_button',
			array(
				'default'           => 'Kami siap membantu Anda menemukan properti impian Anda.',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'after_button',
			array(
				'type'    => 'text',
				'label'   => __('Text After Button', $textdomain),
				'section' => 'section_homebanner',
			)
		);

		$wp_customize->add_section(
			'section_layanan',
			array(
				'panel'    => 'panel_property',
				'title'    => __('Layanan', $textdomain),
				'priority' => 20,
			)
		);

		$wp_customize->add_setting(
			'judul_layanan',
			array(
				'default'           => 'Layanan Kami',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'judul_layanan',
			array(
				'type'        => 'text',
				'label'       => __('Judul Layanan', $textdomain),
				'description' => esc_html__('Tuliskan judul layanan.', $textdomain),
				'section'     => 'section_layanan',
			)
		);

		$wp_customize->add_setting(
			'layanan_repeater',
			array(
				'default'           => velocitychild_get_legacy_layanan_items(),
				'sanitize_callback' => 'velocitychild_sanitize_layanan_repeater',
			)
		);
		$wp_customize->add_control(
			new Velocitychild_Repeater_Control(
				$wp_customize,
				'layanan_repeater',
				array(
					'label'            => esc_html__('Layanan Control', $textdomain),
					'section'          => 'section_layanan',
					'priority'         => 10,
					'fields'           => velocitychild_get_layanan_repeater_fields(),
					'item_label'       => esc_html__('Layanan Anda', $textdomain),
					'add_button_label' => esc_html__('Tambah Layanan', $textdomain),
				)
			)
		);

		$wp_customize->add_section(
			'section_listing',
			array(
				'panel'    => 'panel_property',
				'title'    => __('Listing', $textdomain),
				'priority' => 30,
			)
		);
		$wp_customize->add_setting(
			'judul_listing',
			array(
				'default'           => 'Listing Terbaru',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'judul_listing',
			array(
				'type'        => 'text',
				'label'       => __('Judul Listing', $textdomain),
				'description' => esc_html__('Tuliskan judul listing.', $textdomain),
				'section'     => 'section_listing',
			)
		);

		$wp_customize->add_section(
			'section_artikel',
			array(
				'panel'    => 'panel_property',
				'title'    => __('Artikel', $textdomain),
				'priority' => 40,
			)
		);
		$wp_customize->add_setting(
			'judul_artikel',
			array(
				'default'           => 'Seputar Property',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'judul_artikel',
			array(
				'type'        => 'text',
				'label'       => __('Judul Artikel', $textdomain),
				'description' => esc_html__('Tuliskan judul artikel.', $textdomain),
				'section'     => 'section_artikel',
			)
		);

		$wp_customize->add_setting(
			'artikel_select',
			array(
				'default'           => '',
				'sanitize_callback' => 'velocitychild_sanitize_artikel_select',
			)
		);
		$wp_customize->add_control(
			'artikel_select',
			array(
				'type'        => 'select',
				'label'       => esc_html__('Select Artikel', $textdomain),
				'section'     => 'section_artikel',
				'choices'     => velocity_categories('category'),
				'description' => esc_html__('Pilih Kategori', $textdomain),
			)
		);

		// Remove unused parent/legacy panels and controls.
		$wp_customize->remove_panel('global_panel');
		$wp_customize->remove_panel('panel_header');
		$wp_customize->remove_panel('panel_footer');
		$wp_customize->remove_panel('panel_antispam');
		$wp_customize->remove_section('header_image');
	}
}

function velocitychild_theme_setup()
{
	// Load justg_child_enqueue_parent_style after theme setup
	add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

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
add_filter('excerpt_more', 'velocity_custom_excerpt_more');
if (!function_exists('velocity_custom_excerpt_more')) {
	function velocity_custom_excerpt_more($more)
	{
		return '...';
	}
}

// excerpt length
add_filter('excerpt_length', 'velocity_excerpt_length');
function velocity_excerpt_length($length)
{
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
