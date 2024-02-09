<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package purepress
 */
get_header();
?>

<main id="primary" class="site-main">

<header class="page-header py-5 bg-body-tertiary mb-4">
		<h1 class="page-title text-center">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'purepress' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
</header><!-- .page-header -->

	<div class="container">
		<div class="row">
				<?php if ( have_posts() ) : ?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
				
					purepress_pagination();
				
				else :
					?>

					<div class="py-5 text-center">
						<p><?php esc_html_e( 'No content found. Please try again with some different keywords.', 'purepress' ); ?></p>
						<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
							<label class="w-100">
								<span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'your-theme-text-domain'); ?></span>
								<input type="search" class="search-field w-100 p-2 " placeholder="<?php echo esc_attr_x('Hit enter to search or ESC to close', 'placeholder', 'your-theme-text-domain'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
							</label>
						</form>
					</div>
					
				<?php
					
				
				endif;
				?>
		</div>
	</div>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
