<?php

require get_template_directory() . '/inc/variables.php';
require get_template_directory() . '/inc/theme-functions.php';
require get_template_directory() . '/inc/main-menu.php';
require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/actions.php';
require get_template_directory() . '/inc/filters.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/tiny-mce.php';
require get_template_directory() . '/inc/gallery.php';
require get_template_directory() . '/inc/gravity-forms.php';
require get_template_directory() . '/inc/popups.php';
require get_template_directory() . '/inc/venues.php';

/**
 * Theme Setup
 */
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support(
	'html5',
	[
		'search-form',
		'gallery',
		'caption',
		'style',
		'script',
	]
);
add_theme_support(
	'custom-logo',
	[
		'height'      => 100,
		'width'       => 300,
		'flex-width'  => true,
		'flex-height' => true,
	]
);

add_action('after_setup_theme', function () {
	register_nav_menus(MAIN_MENU);

	add_image_size(IMG_SIZE_SM, 384, 384, false);

	add_editor_style(get_core_enqueue_path('main.css', false));
});

add_action('init', function () {
	add_post_type_support('page', 'excerpt');
});

/**
 * Widgets
 */
add_action('widgets_init', function () {
	$register_footer_widget_counter = 1;
	while ($register_footer_widget_counter <= FOOTER_SIDEBAR_QUANTITY) {
		register_sidebar(
			[
				'name'          => esc_html__("Footer Widget $register_footer_widget_counter", 'core'),
				'id'            => "footer-sidebar-$register_footer_widget_counter",
				'before_sidebar' => '<div id="%1$s" class="col-md">',
				'after_sidebar' => '</div>',
				'before_widget' => '<div class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="h5">',
				'after_title'   => '</h2>',
			]
		);
		$register_footer_widget_counter++;
	}
});

/**
 * Front-end CSS and JS
 */
add_action('wp_enqueue_scripts', function () {
	//Dequeue
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_script('comment-reply');

	//Core Files
	wp_enqueue_style('main', get_core_enqueue_path('main.css'), [], null);
	wp_enqueue_script('main', get_core_enqueue_path('main.js'), [], null, ['strategy' => 'defer']);

	//SVG Sprite
	wp_enqueue_script('sprite', get_core_enqueue_path('sprite.js'), [], null, ['strategy' => 'async']);

	//Parallax
	wp_enqueue_script('parallax', get_core_enqueue_path('parallax.js'), [], null, ['in_footer' => true, 'strategy' => 'async']);

	//Swiper
	wp_enqueue_style('swiper', get_core_enqueue_path('swiper.css'), [], null);
	wp_enqueue_script('swiper', get_core_enqueue_path('swiper.js'), [], null, ['in_footer' => true, 'strategy' => 'async']);
});

/**
 * Admin Panel CSS and JS
 */
add_action('admin_enqueue_scripts', function () {
	wp_enqueue_style('admin', get_core_enqueue_path('admin.css'), [], null);
	wp_enqueue_script('admin', get_core_enqueue_path('admin.js'), ['acf', 'jquery'], null, ['strategy' => 'defer']);
});
