<?php
if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}, 99 );


// Function to dequeue Gutenberg CSS for bootstrap 5
function disable_gutenberg_css() {
	wp_dequeue_style('wp-block-library'); // Dequeue Gutenberg block library styles
	wp_dequeue_style('wp-block-library-theme'); // Dequeue Gutenberg block library theme styles
	wp_dequeue_style( 'global-styles');
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'wp-emoji-styles' );
	wp_dequeue_script( 'wp-emoji' );
}

// Hook into the 'wp_enqueue_scripts' action
add_action('wp_enqueue_scripts', 'disable_gutenberg_css');


