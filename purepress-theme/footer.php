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
<footer id="footer" class="site-footer bg-black text-white py-4">

	<div class="container border-bottom border-dark">
		<div class="row">
			<div class="col-md-5 d-flex flex-column my-2">
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

			<div class="col-md-3 my-2">
				<?php
				dynamic_sidebar('footer_4');
				?>
			</div>
		</div>
	</div>
	<div class="container">
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