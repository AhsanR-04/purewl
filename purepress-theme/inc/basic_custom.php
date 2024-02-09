<?php
if (!defined('ABSPATH')) {
	die('No direct script access allowed');
}

if (!function_exists('write_log')) {
	function write_log($log)
	{
		if (true === WP_DEBUG) {
			if (is_array($log) || is_object($log)) {
				error_log(print_r($log, true));
			} else {
				error_log($log);
			}
		}
	}
}



if (!function_exists('custom_breadcrumb_output')) {
	function custom_breadcrumb_output($output)
	{
		$breadcrum = $output;
		$last_item = end($breadcrum['itemListElement']);
		if (isset($last_item['item']['name'])) {
			$last_key = key($breadcrum['itemListElement']);
			$last_name = $last_item['item']['name'];
			$focuskw = get_post_meta(get_the_ID(), '_yoast_wpseo_focuskw', true);
			if ($focuskw) {
				$breadcrum['itemListElement'][$last_key]['item']['name'] = $focuskw;
			}
		}
		return $breadcrum;
	}
	add_filter('saswp_modify_breadcrumb_output', 'custom_breadcrumb_output');
}


if (!function_exists('wp_comment_remove_anchors')) {
	add_filter('comment_text', 'wp_comment_remove_anchors');
	function wp_comment_remove_anchors($comment_text)
	{
		return preg_replace('/\<a\s*href\s*=\s*(.*)\s*\>/', '', $comment_text);
	}
}


/*		 
	  function add_x_robots_tag_header( $headers ) 
	  {
	  $headers['X-Robots-Tag'] = 'index';
	  return $headers;
	  }
	  add_filter( 'wp_headers', 'add_x_robots_tag_header' );
  */


function add_x_robots_tag_header($headers)
{
	if (is_category() || is_tag()) {
		$headers['X-Robots-Tag'] = 'noindex';
	}

	if (is_single() || is_page()) {
		$headers['X-Robots-Tag'] = 'index';
	}

	return $headers;
}

add_filter('wp_headers', 'add_x_robots_tag_header');




/**********************************	
	  SCHEMA ABOUT
  **********************************/
function custom_schema_type($schema_data)
{
	$author_json = array();
	$authors = get_users(array('role' => 'editor', 'orderby' => 'post_count', 'order' => 'DESC'));
	if ($authors) {
		foreach ($authors as $author) {

			$json_arr = array
			(
				'@type' => 'Person',
				'@id' => esc_url(get_author_posts_url($author->ID)),
				'name' => esc_html($author->display_name),
				'alternateName' => esc_html($author->display_name),
			);
			$same_as = array();
			$avatar_url = get_avatar_url($author->user_email);
			$author_title = get_the_author_meta('title', $author->ID);
			$published_posts = count_user_posts($author->ID);

			$author_id = $author->ID;
			$email = get_the_author_meta('email', $author_id);
			$telephone = get_the_author_meta('telephone', $author_id);
			$twitter = get_the_author_meta('twitter', $author_id);
			$facebook = get_the_author_meta('facebook', $author_id);
			$instagram = get_the_author_meta('instagram', $author_id);
			$pinterest = get_the_author_meta('pinterest', $author_id);
			$linkedin = get_the_author_meta('linkedin', $author_id);


			if (!empty($twitter)) {
				$same_as[] = $twitter;
			}
			if (!empty($facebook)) {
				$same_as[] = $twitter;
			}
			if (!empty($instagram)) {
				$same_as[] = $instagram;
			}
			if (!empty($pinterest)) {
				$same_as[] = $pinterest;
			}
			if (!empty($linkedin)) {
				$same_as[] = $linkedin;
			}

			if (count($same_as) > 0) {
				$json_arr['sameAs'] = $same_as;
			}

			if (!empty($avatar_url)) {

				$json_arr['image'] = array(
					'@type' => 'ImageObject',
					'url' => $avatar_url
				);
			}

			$json_arr['knowsAbout'] = array(
				'@type' => 'Thing',
				'@id' => 'https://www.wikidata.org/wiki/Q42909',
				'name' => 'Reporter',
				'alternateName' => 'Reporter',
			);
			$author_json[] = $json_arr;
		}
	}

	if (count($author_json) > 0) {
		$schema_data['author'] = $author_json;
	}

	return $schema_data;
}
add_filter('saswp_modify_about_page_output', 'custom_schema_type');

function modify_new_schema($new_schema)
{
	$lat_schema = $new_schema;
	$lat_schema['comment'] = ["@type" => "Comment", "text" => $lat_schema['description']];
	return $lat_schema;
}
add_filter('saswp_modify_news_article_schema_output', 'modify_new_schema');	/* News		Schema */
add_filter('saswp_modify_article_schema_output', 'modify_new_schema');	/* Article 	Schema */
add_filter('saswp_modify_webpage_schema_output', 'modify_new_schema');	/* WebPage 	Schema */



function modify_sitenavigation_schema($schema_nav)
{
	if (isset($schema_nav['@graph'])) {
		$moreIndex = array_search('More', array_column($schema_nav['@graph'], 'name'));
		if ($moreIndex !== false) {
			if (empty($schema_nav['@graph'][$moreIndex]['url']) || is_null($schema_nav['@graph'][$moreIndex]['url'])) {
				$schema_nav['@graph'][$moreIndex]['url'] = $schema_nav['@graph'][$moreIndex]['@id'];
			}
		}
	}
	return $schema_nav;
}
add_filter('saswp_modify_sitenavigation_output', 'modify_sitenavigation_schema');



function disable_feed()
{
	status_header(410);
	header('X-Robots-Tag: noindex');
	die(__('No feed available, please visit the <a href="' . esc_url(home_url('/')) . '">homepage</a>.'));
}

function disable_all_feeds()
{
	add_action('do_feed', 'disable_feed', 1);
	add_action('do_feed_rdf', 'disable_feed', 1);
	add_action('do_feed_rss', 'disable_feed', 1);
	add_action('do_feed_rss2', 'disable_feed', 1);
	add_action('do_feed_atom', 'disable_feed', 1);
	add_action('do_feed_rss2_comments', 'disable_feed', 1);
	add_action('do_feed_atom_comments', 'disable_feed', 1);
}
add_action('init', 'disable_all_feeds');

function remove_feed_links()
{
	return;
}
add_filter('feed_links_show_posts_feed', 'remove_feed_links');
add_filter('feed_links_show_comments_feed', 'remove_feed_links');

add_filter('category_feed_link', 'remove_feed_links');
add_filter('author_feed_link', 'remove_feed_links');
add_filter('tag_feed_link', 'remove_feed_links');


function remove_extra_links_and_meta_tags()
{

	remove_action('wp_head', 'rest_output_link_wp_head');		/* Remove WordPress REST API link */
	remove_action('wp_head', 'wp_oembed_add_discovery_links');	/* Remove JSON link */
	remove_action('wp_head', 'rsd_link');						/* Remove RSD link */
	remove_action('wp_head', 'wlwmanifest_link');				/* Remove wlwmanifest link */
	remove_action('wp_head', 'wp_generator');					/* Remove generator meta tag */
	remove_action('wp_head', 'wp_oembed_add_host_js'); 			/* Remove oEmbed links */

	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'feed_links', 2);

}
add_action('init', 'remove_extra_links_and_meta_tags');



if (!function_exists('disable_lazy_load_featured_images_single_post')) {
	// Disable lazy load for featured image only
	function disable_lazy_load_featured_images_single_post($attr, $attachment = null)
	{
		//write_log( '$attr' );
		//write_log( $attr );
		if (is_singular('post')) {
			if (isset($attr['class']) && isset($attr['loading'])) {
				if ($attr['class'] == 'attachment-full size-full not-transparent') {
					unset($attr['loading']);
				}
			}
		}
		return $attr;
	}
	add_filter('wp_get_attachment_image_attributes', 'disable_lazy_load_featured_images_single_post', 10, 2);
}



if (!function_exists('wpml_duplicate_post_catcher')) {
	add_action('publish_post', 'wpml_duplicate_post_catcher', 10, 3);
	function wpml_duplicate_post_catcher($post_id, $post)
	{
		if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'make_duplicates')) {
			wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
		}
	}
}
/*
	  function wpml_auto_redirect_deleted_post($query)
	  {
	  $lang 		 = (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en';
	  $req 		= $query->request;
	  $url 		= ($lang != 'en') ? home_url('/' . $lang . '/' . $req) : home_url($req);
	  
	  #write_log( $query );
	  
	  $manual_arr =  array(  home_url( 'news/top-gun-maverick-sets-new-massive-records' ) );
	  
	  if (in_array($url, $manual_arr)) 
	  {
	  global $wp_query;
	  $wp_query = new WP_Query();
	  $wp_query->set_404();
	  status_header(410);
	  nocache_headers();
	  }
	  }
	  add_action('wp', 'wpml_auto_redirect_deleted_post');
  */

function redirect_old_permalink()
{
	global $post, $wp;
	#if (is_object($post) && $post->ID && get_post_status($post->ID) == 'publish') {
	if (is_single() && is_object($post) && $post->post_type == 'post' && get_post_status($post->ID) == 'publish') {
		$current_url = home_url(add_query_arg(array(), $wp->request));
		$new_url = get_permalink($post);
		$old_permalink_parts = explode('/', $current_url);
		$new_permalink_parts = explode('/', $new_url);
		$old_category = $old_permalink_parts[4];
		$new_category = $new_permalink_parts[4];
		if ($old_category !== $new_category) {
			wp_redirect($new_url, 301);
			exit;
		}
	}
}
add_action('template_redirect', 'redirect_old_permalink');


if (!function_exists('create_author_profile_shortcode_func')) {
	function create_author_profile_shortcode_func()
	{
		$output = '<div class="authors-row">' . PHP_EOL;
		$authors = get_users(array('role' => 'editor', 'orderby' => 'post_count', 'order' => 'DESC'));
		foreach ($authors as $author) {
			// Get the author's avatar URL
			$avatar_url = get_avatar_url($author->user_email);
			// Get the author's title
			$author_title = get_the_author_meta('title', $author->ID);
			// Get the total published posts by the author
			$published_posts = count_user_posts($author->ID);
			$output .= '<a href="' . esc_url(get_author_posts_url($author->ID)) . '">
					<div class="author">' . PHP_EOL;
			if (!empty($avatar_url)) {
				$output .= '<div class="author-avatar">
						<img src="' . esc_url($avatar_url) . '" alt="' . esc_attr($author->display_name) . '">
						<div class="author-info">
						<h2 class="author-name">' . esc_html($author->display_name) . '</h2>
						<div class="author-posts">
						' . esc_html__('Total Published Posts: ', 'salient') . $published_posts .
					'</div>
						</div>
						</div>' . PHP_EOL;
			}
			if (!empty($author_title)) {
				$output .= '<div class="author-title">' . esc_html($author_title) . '</div>' . PHP_EOL;
			}
			if (!empty($author->description)) {
				$output .= '<div class="author-bio">' . wp_kses_post($author->description) . '</div>' . PHP_EOL;
			}
			$output .= '</div>' . PHP_EOL;
			$output .= '</a>' . PHP_EOL;
		}
		$output .= '</div>' . PHP_EOL;

		return $output;
	}
	add_shortcode('author_profile_bio', 'create_author_profile_shortcode_func');
}


function add_x_default_to_hreflangs($hreflangs)
{
	$has_x_default = false;
	$current_language = (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en';
	foreach ($hreflangs as $hreflang) {
		if (isset($hreflang['x-default'])) {
			$has_x_default = true;
			break;
		}
	}

	if (!$has_x_default) {
		if (is_singular()) {
			$canonical_url = get_permalink();
		} elseif (is_author() || is_category() || is_tag()) {
			// For author, category, or tag pages
			$canonical_url = false;

			if (is_author()) {
				// For author pages
				$author_id = get_query_var('author');
				if ($author_id) {
					$author_url = get_author_posts_url($author_id);
					$canonical_url = $author_url;
				}
			} elseif (is_category() || is_tag()) {
				// For category and tag pages
				$term = get_queried_object();
				if ($term instanceof WP_Term) {
					$canonical_url = get_term_link($term);
				}
			}
		}

		if (!empty($canonical_url)) {

			if (is_author()) {
				$hreflangs['x-default'] = modifyURLCond($canonical_url, 'exclude');
			} else {
				// Add x-default hreflang with canonical URL
				$hreflangs['x-default'] = $canonical_url;
			}

			$add_del = ($current_language != 'en') ? 'en-' . $current_language : $current_language;
			// Adjust the hreflang for the current language if it's the site's root URL
			if (isset($hreflangs[$add_del]) && $hreflangs[$add_del] === home_url()) {
				$hreflangs[$add_del] = $canonical_url;
			}
		}
	}

	return $hreflangs;
}

add_filter('wpml_hreflangs', 'add_x_default_to_hreflangs', 20, 1);


function modifyURLCond($url, $action, $countries = ['au', 'nz', 'uk', 'ca'])
{
	$pattern = '/\/(' . implode('|', $countries) . ')\//';
	$replace = ($action === 'exclude') ? '/' : '/' . implode('/', $countries) . '/';
	return preg_replace($pattern, $replace, $url);
}

function custom_wpseo_title($title)
{
	global $page, $paged;
	$site_title = get_bloginfo('name');
	// Check if it's a paginated page
	if ($page > 1 || $paged > 1) {
		#$title = $title. ' Page ' . max($page, $paged);
		$title = $title . ' Page ' . $paged;
	}

	$final_title = $title . ' | ' . $site_title;
	return $final_title;
}
add_filter('wpseo_title', 'custom_wpseo_title');
add_filter('wpseo_opengraph_title', 'custom_wpseo_title');

function custom_wpseo_metadesc($metadesc)
{
	global $page, $paged;
	$site_title = get_bloginfo('name');

	// Check if it's a paginated page
	if ($page > 1 || $paged > 1) {
		#$metadesc = $metadesc. ' Page ' . max($page, $paged);
		$metadesc = $metadesc . ' Page ' . $paged;
	}

	return $metadesc . ' | ' . $site_title;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc');
add_filter('wpseo_opengraph_desc', 'custom_wpseo_metadesc');


function faq_review_bottom_part_cat()
{
	$response = '';
	if (is_category()) {
		global $wpdb;
		$current_category = get_queried_object();
		$category_id = $current_category->term_id;
		$page_number = get_query_var('paged') ? get_query_var('paged') : 1;
		$table_name = $wpdb->prefix . 'faq_review';

		$cache_key = 'faq_review_' . $category_id . '_page_' . $page_number;
		#delete_transient($cache_key);
		$cached_results = get_transient($cache_key);

		if (false === $cached_results) {
			$query = $wpdb->prepare("SELECT * FROM {$table_name} WHERE cat_id = %d AND page = %d", $category_id, $page_number);
			$results = $wpdb->get_results($query, OBJECT);
			set_transient($cache_key, $results, 60 * 60 * 12);
		} else {
			// If found in the cache, use the cached results
			$results = $cached_results;
		}
		if ($results) {
			$resp = array();
			foreach ($results as $result) {
				$type = $result->d_type;
				$question = $result->Q;
				$answer = $result->A;
				$star = $result->star;
				switch ($type) {
					case 'faq':
						$resp['faq'][] = array('q' => $question, 'a' => $answer);
						break;
					case 'review':
						$resp['review'][] = array('q' => $question, 'a' => $answer, 's' => $star);
						break;
				}
			}

			$faqs = (isset($resp['faq'])) ? custom_generateYoastFAQBlock($resp['faq']) : '';
			$response = ($faqs != '') ? '<div class="container">' . PHP_EOL . '<div class="faq_section_tax">' . PHP_EOL . '<h2 class="tax_faq_heading">FAQs</h2>' . PHP_EOL . $faqs . PHP_EOL . '</div>' . PHP_EOL . '</div>' . PHP_EOL : '';


			#$reviews	= (isset($resp['review'])) ? generateHTMLFromReviews( $resp['review'] ) : '';
			#$response 	.= ($reviews != '') ? '<div class="container">'.PHP_EOL.'<div class="review_section_tax">'.PHP_EOL .'<h2 class="tax_review_heading">Reviews</h2>'.PHP_EOL . $reviews. PHP_EOL .'</div>'.PHP_EOL.'</div>'.PHP_EOL  : '';
		}
	}
	echo $response;
}
add_action('pure_cat_after_loop', 'faq_review_bottom_part_cat');


function custom_generateYoastFAQBlock($data)
{
	if (is_array($data) && !empty($data)) {
		$html = '<!-- wp:yoast/faq-block { "questions": [';
		// Build JSON for questions and answers
		$jsonQuestions = [];
		foreach ($data as $key => $item) {
			$jsonQuestions[] = sprintf('{
					"id": "faq-question-%d",
					"question": %s,
					"answer": %s
					}',
				$key,
				json_encode($item['q']),
				json_encode($item['a'])
			);
		}

		$html .= implode(',', $jsonQuestions);
		// Complete the HTML block
		$html .= ' ] } -->';
		$html .= '<div class="schema-faq wp-block-yoast-faq-block"><div class="schema-faq-sections">';

		// Generate HTML for questions and answers
		foreach ($data as $key => $item) {
			$html .= '<div class="schema-faq-section" id="faq-question-' . $key . '">';
			$html .= '<h3 class="schema-faq-question">' . $item['q'] . '</h3>';
			$html .= '<p class="schema-faq-answer">' . $item['a'] . '</p>';
			$html .= '</div>';
		}
		$html .= '</div></div>';
		$html .= '<!-- /wp:yoast/faq-block -->';
		return $html;
	} else {
		return ''; // Return an empty string if the input array is not valid
	}
}


function generateHTMLFromReviews($reviews)
{
	if (empty($reviews)) {
		return '';
	}

	$html = '<div class="flexy-container flexy-col-3 review-slider" data-flexy="no" data-autoplay="1">
			<div class="flexy">
			<div class="flexy-view" data-flexy-view="boxed">
			<div class="flexy-items">';
	foreach ($reviews as $index => $review) {
		$html .= '<div class="review_box">
				<div class="review-content item-' . ($index + 1) . '">
				<p>' . $review['a'] . '</p>
				<div class="rating meta">
				<img src="https://secure.gravatar.com/avatar/f75553b9ec5e56bfda601fef7863c407?s=64&d=mm&r=g"  class="review_img" />
				<span class="reviewer_name">' . $review['q'] . '</span>
				</div>
				</div>
				</div>';
	}

	$html .= '</div>
			<span class="flexy-arrow-prev">
			<svg width="16" height="10" viewBox="0 0 16 10">
			<path d="M15.3 4.3h-13l2.8-3c.3-.3.3-.7 0-1-.3-.3-.6-.3-.9 0l-4 4.2-.2.2v.6c0 .1.1.2.2.2l4 4.2c.3.4.6.4.9 0 .3-.3.3-.7 0-1l-2.8-3h13c.2 0 .4-.1.5-.2s.2-.3.2-.5-.1-.4-.2-.5c-.1-.1-.3-.2-.5-.2z" />
			</svg>
			</span>
			<span class="flexy-arrow-next">
			<svg width="16" height="10" viewBox="0 0 16 10">
			<path d="M.2 4.5c-.1.1-.2.3-.2.5s.1.4.2.5c.1.1.3.2.5.2h13l-2.8 3c-.3.3-.3.7 0 1 .3.3.6.3.9 0l4-4.2.2-.2V5v-.3c0-.1-.1-.2-.2-.2l-4-4.2c-.3-.4-.6-.4-.9 0-.3.3-.3.7 0 1l2.8 3H.7c-.2 0-.4.1-.5.2z" />
			</svg>
			</span>
			</div>
			</div>
			</div>';

	return $html;
}



function custom_related_posts_shortcode($atts)
{
	$atts = shortcode_atts(
		array(
			'type' => 'normal',
			'count' => 3
		),
		$atts,
		'custom_related_posts'
	);

	global $post;

	// Get related posts based on post type
	if ($atts['type'] === 'category') {
		$related_posts = get_posts(
			array(
				'category__in' => wp_get_post_categories($post->ID),
				'post__not_in' => array($post->ID),
				'posts_per_page' => $atts['count']
			)
		);
	} elseif ($atts['type'] === 'tag') {
		$related_posts = get_posts(
			array(
				'tag__in' => wp_get_post_tags($post->ID),
				'post__not_in' => array($post->ID),
				'posts_per_page' => $atts['count']
			)
		);
	} else {
		$related_posts = get_posts(
			array(
				'post__not_in' => array($post->ID),
				'posts_per_page' => $atts['count']
			)
		);
	}

	// Display related posts
	if ($related_posts) {
		$output = '<div class="custom-related-post">';

		foreach ($related_posts as $post) {
			setup_postdata($post);

			$thumbnail = get_the_post_thumbnail($post->ID, 'wide');
			$title = get_the_title();

			$output .= '<div class="related-items">
					<a class="related-post-img" href="' . get_permalink() . '">' . $thumbnail . '</a>
					<a class="related-post-title" href="' . get_permalink() . '">' . $title . '</a>
					</div>';
		}

		$output .= '</div>';
		wp_reset_postdata();

		return $output;
	}

	return '';
}
add_shortcode('custom_related_posts', 'custom_related_posts_shortcode');

if (!function_exists('custom_breadcrumb_output') && function_exists('yoast_breadcrumb')) {
	function custom_breadcrumb_output($output)
	{
		$breadcrum = $output;
		$keys = array_keys($breadcrum);
		$last = end($keys);
		if (isset($breadcrum[$last]['text']) && (is_single() && 'post' == get_post_type())) {
			$focuskw = get_post_meta(get_the_ID(), '_yoast_wpseo_focuskw', true);
			if ($focuskw) {
				$breadcrum[$last]['text'] = ucfirst($focuskw);
			}
		}
		return $breadcrum;
	}
	add_filter('wpseo_breadcrumb_links', 'custom_breadcrumb_output');
}

function remove_hentry($classes)
{
	if (is_singular('post') || is_singular('page')) {
		$classes = array_diff($classes, array('hentry'));
	}
	return $classes;
}
add_filter('post_class', 'remove_hentry');

// Add custom slider Shortcode Start
function create_channelSlider()
{
	$img_url = get_site_url() . '/wp-content/uploads/2023/03/';
	$arr = array(
		array(
			'image' => $img_url . 'sbs-1.webp',
			'link' => array('en' => '2654', 'au' => '2894', 'ca' => '2895', 'nz' => '2896', 'uk' => '2896'),
			'title' => 'SBS'
		),
		array(
			'image' => $img_url . 'pbs.webp',
			'link' => array('en' => '2942', 'au' => '4692', 'ca' => '3014', 'nz' => '3171', 'uk' => '3172'),
			'title' => 'PBS'
		),
		array(
			'image' => $img_url . 'nbc.webp',
			'link' => array('en' => '700', 'au' => '1142', 'ca' => '1143', 'nz' => '1154', 'uk' => '1158'),
			'title' => 'NBC'
		),
		array(
			'image' => $img_url . 'lifetime.webp',
			'link' => array('en' => '710', 'au' => '1367', 'ca' => '1368', 'nz' => '1378', 'uk' => '1383'),
			'title' => 'Lifetime'
		),

		array(
			'image' => $img_url . 'itex.webp',
			'link' => array('en' => '707', 'au' => '1350', 'ca' => '1351', 'nz' => '1361', 'uk' => '1366'),
			'title' => 'itvx'
		),

		array(
			'image' => $img_url . 'hgt.webp',
			'link' => array('en' => '709', 'au' => '1316', 'ca' => '1317', 'nz' => '1327', 'uk' => '1332'),
			'title' => 'HGTV'
		),

		array(
			'image' => $img_url . 'hallmark-1.webp',
			'link' => array('en' => '713', 'au' => '1299', 'ca' => '1300', 'nz' => '1310', 'uk' => '1315'),
			'title' => 'Hallmark'
		),

		array(
			'image' => $img_url . 'fubo.webp',
			'link' => array('en' => '2939', 'au' => '3181', 'ca' => '3316', 'nz' => '3317', 'uk' => '3318'),
			'title' => 'Fubotv'
		),

		array(
			'image' => $img_url . 'freeform.webp',
			'link' => array('en' => '2731', 'au' => '2847', 'ca' => '2848', 'nz' => '2849', 'uk' => '2850'),
			'title' => 'Freeform'
		)
	);

	$html = '';
	$my_current_lang = (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en';
	// if ($my_current_lang != "uk") {
	$html = '
			<div class="flexy-container OTT_Guides" data-flexy="no" data-autoplay="2">
			<div class="flexy">
			<div class="flexy-view" data-flexy-view="boxed">
			<div class="flexy-items ">
			
			';
	$slides = '';

	foreach ($arr as $k => $a) {
		$anchor = '';

		// Check if the link for the current language exists
		if (isset($a['link'][$my_current_lang]) && !empty($a['link'][$my_current_lang])) {
			$anchor = $a['link'][$my_current_lang];
		}

		// Generate the anchor link based on the retrieved ID
		$anchor_link = '';
		if (!empty($anchor)) {
			$anchor_link = get_category_link($anchor);
		}

		$html .= '				
				<div>
				<a class="ct-image-container" href="' . $anchor_link . '" data-width="1300" data-height="500" title="' . $a['title'] . '" target="_blank">
				<img width="300" height="115" src="' . $a['image'] . '" class="attachment-medium size-medium wp-post-image" alt="' . $a['title'] . '" decoding="async" loading="lazy"  />
				<noscript>
				<img width="300" height="115" src="' . $a['image'] . '" class="attachment-medium size-medium wp-post-image" alt="' . $a['title'] . '" decoding="async" loading="lazy"  />
				</noscript>
				</a>
				</div>				
				';
	}

	$html .= '	
			</div>
			<span class="flexy-arrow-prev">
			<svg width="16" height="10" viewBox="0 0 16 10">
			<path
			d="M15.3 4.3h-13l2.8-3c.3-.3.3-.7 0-1-.3-.3-.6-.3-.9 0l-4 4.2-.2.2v.6c0 .1.1.2.2.2l4 4.2c.3.4.6.4.9 0 .3-.3.3-.7 0-1l-2.8-3h13c.2 0 .4-.1.5-.2s.2-.3.2-.5-.1-.4-.2-.5c-.1-.1-.3-.2-.5-.2z" />
			</svg>
			</span>
			<span class="flexy-arrow-next">
			<svg width="16" height="10" viewBox="0 0 16 10">
			<path
			d="M.2 4.5c-.1.1-.2.3-.2.5s.1.4.2.5c.1.1.3.2.5.2h13l-2.8 3c-.3.3-.3.7 0 1 .3.3.6.3.9 0l4-4.2.2-.2V5v-.3c0-.1-.1-.2-.2-.2l-4-4.2c-.3-.4-.6-.4-.9 0-.3.3-.3.7 0 1l2.8 3H.7c-.2 0-.4.1-.5.2z" />
			</svg>
			</span>
			
			</div>
			</div>
			</div>
			';
	return $html;
}
add_shortcode('channelSlider', 'create_channelSlider');
// Add custom slider Shortcode end

// top author start // 
function top_authors_in_category()
{
	$output = '';
	$category_id = get_queried_object_id();
	$category = get_category($category_id);

	if ($category && isset($category->name)) {
		$category_name = $category->name;
		$args = array('posts_per_page' => -1, 'cat' => $category_id, 'post_status' => 'publish');
		$posts = get_posts($args);

		$authors = array();
		foreach ($posts as $post) {
			$author_id = $post->post_author;
			$authors[$author_id] = isset($authors[$author_id]) ? $authors[$author_id] + 1 : 1;
		}

		arsort($authors, SORT_NUMERIC);

		$i = 0;

		$output .= '<div class="authors_div_main">
				<h2 class="heading_author_div mb-2 text-center">
				Our Top Authors
				</h2>
				<ul class="authors_ul d-flex p-0 gap-4 justify-content-center  flex-wrap">';

		foreach ($authors as $author_id => $count):
			if ($i == 3)
				break;
			$author_name = get_the_author_meta('display_name', $author_id);
			$author_link = get_author_posts_url($author_id);
			$author_avatar = get_avatar($author_id, 80);

			$output .= '<li class="author-box px-4 py-3 rounded d-flex gap-3 align-items-center bg-light">
				<a class="rounded-circle overflow-hidden" href="' . esc_url($author_link) . '" target="_blank" title="' . esc_attr($author_name) . '">
				' . $author_avatar . '
				</a>				
				<div class=author-content>
				<a class="fw-bold text-dark" href="' . esc_url($author_link) . '" target="_blank" title="' . esc_attr($author_name) . '">
				' . esc_html($author_name) . ' 
				</a>
				<div class="fs-6">Total Published Posts: ' . $count . '</div>
				<div>
				</li>' . PHP_EOL;
			$i++;
		endforeach;
		$output .= '</ul>
				</div>' . PHP_EOL;
	}

	return $output;
}

function category_authors_shortcode()
{
	if (is_category()) {
		ob_start();
		echo top_authors_in_category();
		return ob_get_clean();
	}
}
add_shortcode('category_authors', 'category_authors_shortcode');

function override_yoast_faqs($block_content, $block)
{

	if (is_single() && isset($block['blockName']) && 'yoast/faq-block' == $block['blockName']) {
		if (strpos($block_content, '<strong') !== false) {
			return preg_replace('/<strong([^>]+)>(.*?)<\/strong>/', '<h3\1>\2</h3>', $block_content);
		} else {
			return $block_content;
		}
	}
	return $block_content;
}
add_filter('render_block', 'override_yoast_faqs', 10, 2);

if (!function_exists('html_lang_attr_alter')) {
	function html_lang_attr_alter($language_attributes)
	{
		if ($language_attributes == 'lang="en-US"') {
			$language_attributes = 'lang="en"';
		}
		return $language_attributes;
	}
	add_filter('language_attributes', 'html_lang_attr_alter');
}

function get_meta_category_by_id($object_id, $type = 'category')
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'yoast_indexable';
	$sql = $wpdb->prepare("SELECT description FROM $table_name WHERE object_id = %d AND object_sub_type = %s LIMIT 1", $object_id, $type);
	$result = $wpdb->get_var($sql);
	return $result;
}

function before_desc_add_meta_desc()
{
	if (is_category()) {

		$category_id = get_queried_object_id();
		$result = get_meta_category_by_id($category_id);
		if (isset($result) && $result != '') {
			global $paged;
			$page_numb_rule = ($paged > 1) ? ' - (Page ' . $paged . ')' : '';
			echo '<p class="meta_description">' . $result . $page_numb_rule . '</p>' . PHP_EOL;
		}
	}
}
add_action('pure_cat_before_desc', 'before_desc_add_meta_desc');
