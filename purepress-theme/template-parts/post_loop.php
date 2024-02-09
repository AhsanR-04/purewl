<?php
// post grid
 function post_grid_shortcode($atts){
  extract(shortcode_atts(array(
    'posts_per_page' => 6,
    'post_offset' => 0,
    'category' => '',
    'template' => 'card',
    'class' => '',
    'image_class' => '',
    'view' => 'archive',

    'post_type' => 'post',// Default value for post_type
    'parent_cat' => '',  // add parent category if required
    'categories' => '', // add category slug separated by comma if required
    'taxonomy_per_page' => 4,
  ), $atts));

  $args = array(
    'posts_per_page' => $posts_per_page,
    'offset' => $post_offset,
    'category_name' => $category,
    'class' => $class,
    'image_class' => $image_class,
    'view' => $view
  );

  // Check if post_type is 'taxonomy'
  if (isset($atts['post_type']) && $atts['post_type'] === 'taxonomy') {
    // Display categories or child categories
    $output = '';
    $view = isset($atts['view']) ? $atts['view'] : 'archive';

    if (!empty($atts['parent_cat'])) {
      // Display child categories by parent slugs
      $parent_slugs = explode(',', $atts['parent_cat']);

      foreach ($parent_slugs as $parent_slug) {
        $parent_category = get_category_by_slug(trim($parent_slug));

        if ($parent_category) {
          $child_categories = get_categories(array('parent' => $parent_category->term_id));

          foreach ($child_categories as $child_category) {
            $category_image = get_term_meta($child_category->term_id, 'category_image', true);

            switch ($view) {
              case 'archive':
                $output .= '<div class="' . $class . '"> 
                  <div class="category-item ">';
                    if ($category_image) {
                      $output .= '<img class="category-img img-fluid rounded" src="' . esc_url($category_image) . '" alt="Category Image">';
                    }
                    $output .= ' <div class="category-title"> '.$category->name . ' </div> 
                  </div>             
                </div>';
                break;
  
              case 'slider':
                $output .= '<swiper-slide class="' . $class . '"> 
                  <div class="category-item ">';
                    if ($category_image) {
                      $output .= '<img class="category-img img-fluid rounded" src="' . esc_url($category_image) . '" alt="Category Image">';
                    }
                    $output .= ' <div class="category-title"> '.$category->name . ' </div> 
                  </div>             
                </swiper-slide>';
                break;
            }
          }
        } else {
          $output .= 'Parent category not found for slug: ' . $parent_slug;
        }
      }
    } elseif (!empty($atts['categories'])) {
      // Display categories by given slugs
      $category_slugs = explode(',', $atts['categories']);
      foreach ($category_slugs as $category_slug) {
        $category = get_category_by_slug($category_slug);
        if ($category) {
          $category_image = get_term_meta($category->term_id, 'category_image', true); 
          
          switch ($view) {
            case 'archive':
              $output .= '<div class="' . $class . '"> 
                <div class="category-item ">';
                  if ($category_image) {
                    $output .= '<img class="category-img img-fluid rounded" src="' . esc_url($category_image) . '" alt="Category Image">';
                  }
                  $output .= ' <div class="category-title"> '.$category->name . ' </div> 
                </div>             
              </div>';
              break;

            case 'slider':
              $output .= '<swiper-slide class="' . $class . '"> 
                <div class="category-item ">';
                  if ($category_image) {
                    $output .= '<img class="category-img img-fluid rounded" src="' . esc_url($category_image) . '" alt="Category Image">';
                  }
                  $output .= ' <div class="category-title"> '.$category->name . ' </div> 
                </div>             
              </swiper-slide>';
              break;
          }
        } else {
          $output .= 'Category not found for slug: ' . $category_slug;
        }
      }
    } else {
      // if top two condition not found then Display recent categories
      $categories = get_categories(array('number' => $atts['taxonomy_per_page']));
      if (!empty($categories)) {
        foreach ($categories as $category) {
          $category_image = get_term_meta($category->term_id, 'category_image', true);

          switch ($view) {
            case 'archive':
              $output .= '<div class="' . $class . '"> 
                <div class="category-item text-center">';
                  if ($category_image) {
                    $output .= '<img height="150" width="150" class="category-img img-fluid rounded mb-2" src="' . esc_url($category_image) . '" alt="Category Image">';
                  }
                  $output .= ' <div class="category-title "> '.$category->name . ' </div> 
                </div>             
              </div>';
              break;

            case 'slider':
              $output .= '<swiper-slide class="' . $class . '"> 
                <div class="category-item text-center">';
                  if ($category_image) {
                    $output .= '<img height="150" width="150" class="category-img img-fluid rounded mb-2" src="' . esc_url($category_image) . '" alt="Category Image">';
                  }
                  $output .= ' <div class="category-title "> '.$category->name . ' </div> 
                </div>             
              </swiper-slide>';
              break;
          }
        }
      } else {
        $output .= 'No categories found.';
      }
    }

    return $output;
  } else {

    $posts = new WP_Query($args);
    $i = 0;
    while ($posts->have_posts()) {
      $posts->the_post();
      switch ($template) {
        case 'cover':
          get_template_part('template-parts/loop-template/cover', null, $args);
          break;

        case 'card':
          get_template_part('template-parts/loop-template/card', null, $args);
          break;

        case 'list':
          get_template_part('template-parts/loop-template/list', null, $args);
          break;
      }
      $i++;
    }
  }

  wp_reset_query();
}
add_shortcode('post_grid', 'post_grid_shortcode');

// for archive
// ****************************
// <div class="containter">
// <div class="row ">
//  echo do_shortcode('[post_grid template="cover" image_class="aspect_ratio_4" post_offset="2" posts_per_page="4"  class="col-md-3 mb-3 grid-2"]'); 
// </div>
// </div>
// ****************************

// for slider
// ****************************
// <swiper-container class="mySwiper" autoplay-delay="1500" autoplay-disable-on-interaction="false"
// navigation="false" loop="true" freeMode="true" breakpoints='{
//   "640": {"slidesPerView": 2, "spaceBetween": 10},
//   "768": {"slidesPerView": 3, "spaceBetween": 10},
//   "1024": {"slidesPerView": 4, "spaceBetween": 10}
// }'>
// <?php echo do_shortcode('[post_grid template="list" view="slider" category="design,career" image_class="aspect_ratio_1" posts_per_page="6"  class="  mb-3"]'); 
// </swiper-container>
// ****************************

// for category
// ****************************
// <div class="container">
//     <div class="row gx-5">
//     <?php echo do_shortcode('[post_grid post_type="taxonomy"  parent_cat=""  taxonomy_per_page="4"  class="col-md-3" ]'); 
//     </div>
//   </div>