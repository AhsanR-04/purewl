<?php
/*
Template Name: full-width-template
*/
get_header();
?>

<main id="primary" class="site-main">

	<div class="container-fluid p-0 m-0">
      <?php
		   the_content();
	   ?>
	</div>

</main><!-- #main -->

<?php
get_footer();