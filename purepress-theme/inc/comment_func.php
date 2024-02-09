<?php

/**
 * Comments
 *
 * @package purepress 
 * @version 5.3.3
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Comment reply
 */
function purepress_reply()
{

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}

add_action('wp_enqueue_scripts', 'purepress_reply');


/**
 * Comments
 */
if (!function_exists('purepress_comment')):
  /**
   * Template for comments and pingbacks.
   *
   * Used as a callback by wp_list_comments() for displaying the comments.
   */
  function purepress_comment($comment, $args, $depth)
  {
    // $GLOBALS['comment'] = $comment;

    if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type): ?>

      <div id="comment-<?php comment_ID(); ?>" <?php comment_class('media alert alert-info'); ?>>
        <div class="comment-body">
          <?php _e('Pingback:', 'purepress'); ?>
          <?php comment_author_link(); ?>
          <?php edit_comment_link(__('Edit', 'purepress'), '<span class="edit-link">', '</span>'); ?>
        </div>

      <?php else: ?>

        <div id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>

          <article id="div-comment-<?php comment_ID(); ?>" class="comment-body mb-4 d-flex py-4 border-bottom">

            <div class="flex-shrink-0 me-3">
              <?php if (0 != $args['avatar_size'])
                echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'img-thumbnail rounded-circle')); ?>
            </div>

            <div class="comment-content w-100">

                  <div class="user-info d-flex flex-wrap justify-content-between align-items-center">
                    <div class="mt-0 text-capitalize">
                      <?php printf(__('%s <span class="says d-none">says:</span>', 'purepress'), sprintf('<p class="h5">%s</p>', get_comment_author())); ?>
                    </div>

                    <div class="comment-meta d-flex align-items-center flex-wrap column-gap-3">
                      <div class="comment-info">
                        <time datetime="<?php comment_time('c'); ?>">
                          <?php printf(_x('%1$s at %2$s', '1: date, 2: time', 'purepress'), get_comment_date('j M Y'), get_comment_time()); ?>
                        </time>
                        <?php edit_comment_link(__('Edit', 'purepress'), '<span class="edit-link">', '</span>'); ?>

                      </div>

                      <?php comment_reply_link(
                        array_merge(
                          $args,
                          array(
                            'add_below' => 'div-comment',
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                            'before' => '<div class="reply comment-reply btn btn-danger py-1 px-3">',
                            'after' => '</div>'
                          )
                        )
                      ); ?>

                    </div>
                  </div>

                  <?php if ('0' == $comment->comment_approved): ?>
                    <p class="comment-awaiting-moderation alert alert-info">
                      <?php _e('Your comment is awaiting moderation.', 'purepress'); ?>
                    </p>
                  <?php endif; ?>
                  
                  <div class="comment mt-2">
                      <?php comment_text(); ?>
                  </div>

            </div><!-- .comment-content -->

          </article><!-- .comment-body -->
        </div><!-- #comment -->

        <?php
    endif;
  }
endif;


/**
 * h2 Reply Title
 */
add_filter('comment_form_defaults', 'custom_reply_title');
function custom_reply_title($defaults)
{
  $defaults['title_reply_before'] = '<span id="reply-title" class="h4"> ';
  $defaults['title_reply_after'] = '</span> ';

  return $defaults;
}


/**
 * Comment Cookie Checkbox
 */
function wp44138_change_comment_form_cookies_consent($fields)
{
  $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
  $fields['cookies'] = '<p class="comment-form-cookies-consent custom-control form-check mb-3">' .
    '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="form-check-input"' . $consent . ' />' .
    '<label for="wp-comment-cookies-consent" class="form-check-label">' . __('Save my name, email, and website in this browser for the next time I comment.', 'purepress') . '</label>' .
    '</p>';

  return $fields;
}

add_filter('comment_form_default_fields', 'wp44138_change_comment_form_cookies_consent');


/**
 * Open comment author link in new tab
 */
add_filter('get_comment_author_link', 'open_comment_author_link_in_new_window');
function open_comment_author_link_in_new_window($author_link)
{
  return str_replace("<a", "<a target='_blank'", $author_link);
}


/**
 * Open links in comments in new tab
 */
if (!function_exists('bs_comment_links_in_new_tab')):
  function bs_comment_links_in_new_tab($text)
  {
    return str_replace('<a', '<a target="_blank" rel=”nofollow”', $text);
  }

  add_filter('comment_text', 'bs_comment_links_in_new_tab');
endif;


/**
 * Comment Button
 */
if (!function_exists('purepress_comment_button')):
  function purepress_comment_button($args)
  {
    $args['class_submit'] = 'btn btn-outline-primary'; // since WP 4.1

    return $args;
  }

  add_filter('comment_form_defaults', 'purepress_comment_button');
endif;
