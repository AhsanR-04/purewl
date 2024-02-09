<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package purepress
 */

get_header();
?>

<main id="primary" class="site-main">

	<div class="container py-5">
		<div class="row">
			<div class="col-lg-12 text-center d-flex flex-column align-items-center">
				<h1 class="fw-bold my-0" style="font-size: 250px;font-family: 'Roboto', sans-serif;color: #000; ">404
				</h1>
				<h2 class="text-capitalize fw-bold "
					style="font-size: 54px;font-family: 'Roboto', sans-serif;color: #000;">page
					not found</h2>
				<a class="cta text-capitalize text-decoration-none text-white d-block  px-4 py-3 rounded mt-3 "
					href="<?php echo site_url(); ?>"
					style="font-family: 'Roboto', sans-serif; background-color: #00e174; width: fit-content;">
					back home
					<svg class="ms-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-arrow-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd"
							d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
					</svg>
				</a>
			</div>
		</div>
	</div>

</main><!-- #main -->

<?php
get_footer();
