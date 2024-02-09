<?php
/*
Template Name: Home v1 blog Template
*/
get_header(); ?>
<main class="homepage">
<section class="py-4 mb-2 " >
  <div class="container">
    <div class="row gx-5">
    <?php echo do_shortcode('[post_grid post_type="taxonomy"  parent_cat=""  taxonomy_per_page="4"  class="col-md-3" ]'); ?>
    </div>
  </div>
</section>

 <section class="py-4 mb-2" data-bs-theme="dark">
 		<div class="container">
 			<swiper-container class="mySwiper" autoplay-delay="1500" autoplay-disable-on-interaction="false"
 				navigation="false" loop="true" freeMode="true" breakpoints='{
 	 "640": {"slidesPerView": 2, "spaceBetween": 10},
 	 "768": {"slidesPerView": 3, "spaceBetween": 10},
 	 "1024": {"slidesPerView": 4, "spaceBetween": 10}
 }'>

 <?php echo do_shortcode('[post_grid view="slider" post_type="taxonomy" parent_cat="" taxonomy_per_page="6"  class="mb-3"]'); ?>
 			</swiper-container>
 			 
 		</div>
 	</section>

<section class="py-4 mb-2">
  <div class="container">
    <div class="row ">
      <?php echo do_shortcode('[post_grid template="cover"  image_class="aspect_ratio_16" posts_per_page="2"  class="col-md-6  mb-3"]'); ?>
    </div>

    <div class="row ">
      <?php echo do_shortcode('[post_grid template="cover" image_class="aspect_ratio_4" post_offset="2" posts_per_page="4"  class="col-md-3 mb-3 grid-2"]'); ?>
    </div>
  </div>
</section>


<section class="py-2 mb-2">
  <div class="container">
    <div class="row">
      <h2 class="text-center pb-2">Latest News</h2>
    </div>

    <div class="row ">
      <?php echo do_shortcode('[post_grid template="card" image_class="aspect_ratio_4" posts_per_page="4"  class="col-md-3 mb-3 mb-3"]'); ?>
    </div>
  </div>
</section>


<section class="py-2 mb-2">
  <div class="container">
    <div class="row">
      <h2 class="text-center pb-2">Latest Movies</h2>
    </div>

    <div class="row ">
      <?php echo do_shortcode('[post_grid template="card" image_class="aspect_ratio_4" posts_per_page="4"  class="col-md-3 mb-3"]'); ?>
    </div>
  </div>
</section>


<section class="py-2 mb-2">
  <div class="container">
    <div class="row">
      <h2 class="text-center pb-2">Latest TV-Show</h2>
    </div>

    <div class="row ">
      <?php echo do_shortcode('[post_grid template="card" image_class="aspect_ratio_4" posts_per_page="4"  class="col-md-3 mb-3"]'); ?>
    </div>
  </div>
</section>


<section class="py-4 bg-black" data-bs-theme="dark">
  <div class="container">
    <swiper-container class="mySwiper" autoplay-delay="1500" autoplay-disable-on-interaction="false" navigation="false"
      loop="true" freeMode="true" breakpoints='{
    "640": {"slidesPerView": 2, "spaceBetween": 10},
    "768": {"slidesPerView": 3, "spaceBetween": 10},
    "1024": {"slidesPerView": 4, "spaceBetween": 10} }'>

      <?php echo do_shortcode('[post_grid template="list" view="slider" category="career" image_class="aspect_ratio_1" posts_per_page="6"  class="  mb-3"]'); ?>
    </swiper-container>

  </div>
</section>


</main>
<?php get_footer(); ?>