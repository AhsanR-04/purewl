<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package purepress
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
		if (is_page_template('full-width-template.php')) {
			echo '<div class="container-fluid my-5">';
		} else {
			echo '<div class="container my-5">';
		}

		while (have_posts()):
			the_post();
			the_content();
		endwhile; // End of the loop.
	?>
	</div>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
