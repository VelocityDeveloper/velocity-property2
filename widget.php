<?php
//register widget
add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
	function justg_widgets_init()
	{
		$icon = '<div class="widget-title-icon"></div>';
		$before_widget = '<aside id="%1$s" class="widget %2$s">';
		$after_widget = '</aside>';
		$before_title = '<h3 class="widget-title position-relative">'.$icon.'<span class="vd-title">';
		$after_title = '</span></h3>';
		register_sidebar(
			array(
				'name'          => __('Main Sidebar', 'justg'),
				'id'            => 'main-sidebar',
				'description'   => __('Main sidebar widget area', 'justg'),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
				'show_in_rest'   => false,
			)
		);
		register_sidebar(
			array(
				'name'          => __('Secondary Sidebar', 'justg'),
				'id'            => 'secondary-sidebar',
				'description'   => __('Secondary sidebar widget area', 'justg'),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
				'show_in_rest'   => false,
			)
		);
		register_sidebar(
			array(
				'name'          => __('Footer 1', 'justg'),
				'id'            => 'footer-widget-1',
				'description'   => __('Footer sidebar widget area', 'justg'),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
				'show_in_rest'   => false,
			)
		);
		register_sidebar(
			array(
				'name'          => __('Footer 2', 'justg'),
				'id'            => 'footer-widget-2',
				'description'   => __('Footer sidebar widget area', 'justg'),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
				'show_in_rest'   => false,
			)
		);
		register_sidebar(
			array(
				'name'          => __('Footer 3', 'justg'),
				'id'            => 'footer-widget-3',
				'description'   => __('Footer sidebar widget area', 'justg'),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
				'show_in_rest'   => false,
			)
		);
	}
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
if (!function_exists('justg_left_sidebar_check')) {
	function justg_left_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('secondary-sidebar')) {
			return;
		}
		echo '<div class="right-sidebar velocity-widget widget-area px-md-0 col-sm-12 col-md-3 order-4" id="right-sidebar" role="complementary">';
		do_action('justg_before_secondary_sidebar');
		dynamic_sidebar('secondary-sidebar');
		do_action('justg_after_secondary_sidebar');
		echo '</div>';
	}
}