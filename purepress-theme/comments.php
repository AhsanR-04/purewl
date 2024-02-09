<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package purepress
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
  return;
}
?>

<div id="comments" class="comments-area ">

  <?php
  // You can start editing here -- including this comment!
  if (have_comments()) : ?>

  <div class="comment-box mb-4 rounded">
    <div class="h4 fw-bold comments-title mb-4">
      <?php
      $comments_number = get_comments_number();
      if ('1' === $comments_number) {
        /* translators: %s: post title */
        printf(_x('One Comment &ldquo;%s&rdquo;', 'comments title', 'purepress'), get_the_title());
      } else {
        printf(
        /* translators: 1: number of comments, 2: post title */
          _nx(
            '%1$s Comment on &ldquo;%2$s&rdquo;',
            '%1$s Comments on &ldquo;%2$s&rdquo;',
            $comments_number,
            'comments title',
            'purepress'
          ),
          number_format_i18n($comments_number),
          get_the_title()
        );
      }
      ?>
    </div><!-- .comments-title -->


    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
      ?>
      <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'purepress'); ?></h2>
        <div class="nav-links">

          <div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments', 'purepress')); ?></div>
          <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'purepress')); ?></div>

        </div><!-- .nav-links -->
      </nav><!-- #comment-nav-above -->
    <?php endif; // Check for comment navigation. 
    ?>

    <div class="comment-list">
      <?php
      wp_list_comments(array('callback' => 'purepress_comment', 'avatar_size' => 75));
      ?>
    </div><!-- .comment-list -->
    </div>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? 
      ?>
      <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'purepress'); ?></h2>
        <div class="nav-links pagination justify-content-center">

          <div class="nav-previous page-item"><?php previous_comments_link(esc_html__('Older Comments', 'purepress')); ?></div>
          <div class="nav-next page-item"><?php next_comments_link(esc_html__('Newer Comments', 'purepress')); ?></div>

        </div><!-- .nav-links -->
      </nav><!-- #comment-nav-below -->
    <?php
    endif; // Check for comment navigation.

  endif; // Check for have_comments().


  // If comments are closed and there are comments, let's leave a little note, shall we?
  if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>

    <p class="no-comments alert alert-info"><?php esc_html_e('Comments are closed.', 'purepress'); ?></p>
  <?php
  endif; ?>

<?php
	$required_text = ( $req ? ' ' . sprintf( __( '(required)', 'purepress' ) ) : '' );
	comment_form(
	    array(
	        'class_form' => 'bootstrap-5-comment-form',
	        'comment_field' => '<div class="form-floating mb-3">' .
	                            '<textarea class="form-control" placeholder="' . esc_attr_x( 'Leave a comment here', 'comment form placeholder', 'purepress' ) . '" id="floatingTextarea2" name="comment" style="height: 200px;" aria-required="true"></textarea>' .
	                            '<label for="floatingTextarea2">' . _x( 'Comments', 'noun' ) . '</label>' .
	                            '</div>',
	        'fields' => array(
	            'author' =>
	                '<div class="form-floating mb-3">' .
	                '<input type="text" class="form-control" id="author" name="author" placeholder="' . esc_attr_x( 'Name', 'comment form placeholder', 'purepress' ) . '" />' .
	                '<label for="author">' . _x( 'Name', 'noun' ) . '</label>' .
	                '</div>',
	            'email' =>
	                '<div class="form-floating mb-3">' .
	                '<input type="email" class="form-control" id="email" name="email" placeholder="' . esc_attr_x( 'Email', 'comment form placeholder', 'purepress' ) . '" />' .
	                '<label for="email">' . _x( 'Email', 'noun' ) . '</label>' .
	                '</div>',
	            'url' =>
	                '<div class="form-floating mb-3">' .
	                '<input type="text" class="form-control" id="url" name="url" placeholder="' . esc_attr_x( 'Website', 'comment form placeholder', 'purepress' ) . '" />' .
	                '<label for="url">' . _x( 'Website', 'noun' ) . '</label>' .
	                '</div>',
	        ),
	        'must_log_in' => '<p class="must-log-in">' .
	                            sprintf(
	                                /* translators: %s: login URL */
	                                __( 'You must be <a href="%s">logged in</a> to post a comment.', 'purepress' ),
	                                wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
	                            ) . '</p>',
	        'logged_in_as' => '<p class="logged-in-as">' .
	                            sprintf(
	                                /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout link */
	                                __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>', 'purepress' ),
	                                get_edit_user_link(),
	                                esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'purepress' ), $user_identity ) ),
	                                $user_identity,
	                                wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
	                            ) . '</p>',
	        'comment_notes_before' => '<p class="comment-notes">' .
	                                    __( 'Your email address will not be published.', 'purepress' ) . $required_text .
	                                    '</p>',
	        'comment_notes_after' => '',
	        'id_submit' => 'submit-comment',
	        'class_submit' => 'btn btn-dark',
	    )
	);
?>

</div><!-- #comments -->