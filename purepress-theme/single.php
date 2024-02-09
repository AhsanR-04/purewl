<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package purepress
 */
get_header();
?>

<main id="primary" class=" site-main">
	<div class="container-narrow mx-auto">
		<div class="container">
			<div class="row g-3 g-lg-5 mb-5">
				<article id="post-<?php the_ID(); ?>" class="col-lg-9 col-md-12 ">
					<?php
					while (have_posts()):
						the_post();

						get_template_part('template-parts/single/content', get_post_type());

					endwhile; // End of the loop. ?>

				</article>

				<aside class="col-lg-3 border-start py-5">
					<div class="sticky-sm-top top-15 z-1">
						<?php dynamic_sidebar('article_sidebar'); ?>
					</div>
				</aside>
			</div>
		</div>

		<!-- related-post -->
		<section class="container-narrow mb-5 ">
			<div class="related-title fs-3 mb-2 fw-bold">Related Post</div>
			<div class="row">
				<?php get_template_part('template-parts/related-post'); ?>
			</div>
		</section>

	</div>

	<!-- comment section -->
	<section class="container-fuild py-5 bg-body-tertiary ">
		<div class="container-narrow comment-section mx-auto">
			<?php
			if (comments_open() || get_comments_number()) {
				comments_template();
			}
			?>
		</div>
	</section>
</main>

<?php
get_footer();
?>