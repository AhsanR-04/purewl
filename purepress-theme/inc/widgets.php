<?php

function purepress_theme_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('article_sidebar', 'purepress_theme'),
			'id' => 'article_sidebar',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('archive_sidebar', 'purepress_theme'),
			'id' => 'archive_sidebar',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('footer_1', 'purepress_theme'),
			'id' => 'footer-1',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('footer_2', 'purepress_theme'),
			'id' => 'footer-2',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('footer_3', 'purepress_theme'),
			'id' => 'footer-3',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('footer_4', 'purepress_theme'),
			'id' => 'footer-4',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('footer_5', 'purepress_theme'),
			'id' => 'footer-5',
			'description' => esc_html__('Add widgets here.', 'purepress_theme'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'purepress_theme_widgets_init');