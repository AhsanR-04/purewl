<?php
/**
 * purepress functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package purepress
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Enqueue scripts and styles.
 */

function purepress_scripts() 
{
   // Enqueue Bootstrap CSS
   wp_enqueue_style('bootstrap-css',  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2', 'all');
   // Enqueue Bootstrap JS
   wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);

   // Enqueue SwiperJS Slider
	wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js', array(), null, true);

	// uncomment this if darkmode required for purepress theme...
	// wp_enqueue_script( 'darkmode-script', get_template_directory_uri() . '/js/darkmode.js', array(), true );
	// wp_enqueue_style('darkmode-style',  get_template_directory_uri() . '/assets/css/darkmode.css', array() , true);
	
	wp_enqueue_style( 'purepress-style', get_stylesheet_uri(), array(),  _S_VERSION);
	wp_enqueue_style('custom-theme-style', get_theme_file_uri('/assets/css/my_style.css'), array(), _S_VERSION);
	
	wp_enqueue_script( 'purepress-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) 
	{
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'purepress_scripts' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function purepress_setup() 
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on purepress, use a find and replace
		* to change 'purepress' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'purepress', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'purepress' ),
			'menu-2' => esc_html__( 'Secondary', 'purepress' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'purepress_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function purepress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'purepress_content_width', 640 );
}
add_action( 'after_setup_theme', 'purepress_content_width', 0 );


function custom_attachment_image_class($attr, $attachment, $size)
{
    // Add your custom class to the 'class' attribute
    $attr['class'] .= ' img-fluid';
    return $attr;
}

// Hook into the wp_get_attachment_image_attributes filter
add_filter('wp_get_attachment_image_attributes', 'custom_attachment_image_class', 10, 3);

require_once(get_template_directory().'/inc/template-tags.php');
require_once(get_template_directory().'/inc/customizer.php');
require_once(get_template_directory().'/inc/breadcrumb.php');
require_once(get_template_directory().'/inc/class_walker.php');
require_once(get_template_directory().'/inc/widgets.php');
require_once(get_template_directory().'/inc/pagination.php');
require_once(get_template_directory().'/template-parts/post_loop.php');
require_once(get_template_directory().'/inc/basic_custom.php');
require_once(get_template_directory(). '/inc/comment_func.php');
require_once(get_template_directory(). '/inc/category_img.php');
require_once(get_template_directory(). '/template-parts/darkmode.php');


// remove page from search result 
function exclude_pages_from_search($query) {
	if ($query->is_search && $query->is_main_query()) {
		 $query->set('post_type', 'post'); // Exclude pages by setting post_type to 'post'
	}
}
add_action('pre_get_posts', 'exclude_pages_from_search');


