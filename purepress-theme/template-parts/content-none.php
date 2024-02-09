<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package purepress
 */

?>
<section class="no-results not-found text-center py-5">
	<div class="page-header ">
		<h1 class="page-title"><?php esc_html_e( 'Welcome to Purepress WP Theme', 'purepress' ); ?></h1>
	</div><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to start working ? <a href="%1$s">Get started here</a>.', 'purepress' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url() )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'purepress' ); ?></p>
			<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    			<label class="w-100">
    			    <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'your-theme-text-domain'); ?></span>
    			    <input type="search" class="search-field w-100 p-2 " placeholder="<?php echo esc_attr_x('Hit enter to search or ESC to close', 'placeholder', 'your-theme-text-domain'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    			</label>
    		</form>
			<?php
		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'purepress' ); ?></p>
			<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    			<label class="w-100">
    			    <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'your-theme-text-domain'); ?></span>
    			    <input type="search" class="search-field w-100 p-2 " placeholder="<?php echo esc_attr_x('Hit enter to search or ESC to close', 'placeholder', 'your-theme-text-domain'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    			</label>
    		</form>
			<?php
		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
