<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package purepress
 */

?>
<footer id="footer" class="site-footer text-white mt-3" style="background-color: #081420;">

	<div class="container p-5 rounded text-center shadow-lg " style="background-color:#6f25e6; transform: translatey(-100px);">
		
			<div class="cta-heading h2 fw-bold">
				Leverage PureWL’s Reliable White Label VPN Solution
			</div>
			<div class="cta-para r fs-6">
				PureWL aims to empower businesses, allowing them to use innovative technologies to safeguard their interests
				or complement their offerings with a custom VPN solution. Most importantly, PureWL can do so with complete
				transparency and unparalleled dedication.
			</div>
			<button type="button" class="btn btn-light fw-bold rounded-pill px-4 py-3 mt-3">Connect with us</button>
	</div>

	<div class="container border-bottom border-dark mb-2 pb-4">
		<div class="row">
			<div class="col-md-4 d-flex flex-column my-2">
				<?php
				dynamic_sidebar('footer_1');
				?>
			</div>
			<div class="col-md-2 my-2">
				<?php
				dynamic_sidebar('footer_2');
				?>
			</div>
			<div class="col-md-2 my-2">
				<?php
				dynamic_sidebar('footer_3');
				?>
			</div>

			<div class="col-md-4 my-2">
				<?php
				dynamic_sidebar('footer_4');
				?>
			</div>
		</div>
	</div>

	<div class="container ">
		<div class="row">
			<div class="col-lg-12 text-center py-2">
				<?php
				dynamic_sidebar('footer_5');
				?>
			</div>
		</div>
	</div>
</footer>
</div>

<?php wp_footer(); ?>
</body>

</html>