<?php
/**
 * Template part for displaying loop posts
 */

$category = get_the_category()[0];
$cat_link = get_category_link($category);
$cat_name = $category->name;
$post_id = get_the_ID();
$thumbnail_id = get_post_thumbnail_id($post_id);
$thumbnail_html = wp_get_attachment_image($thumbnail_id, 'medium_large');
$title = get_the_title();
$author_name = get_the_author_meta('display_name');

$column_class = (isset($args['class'])) ? $args['class'] : '';
$img_class = (isset($args['image_class'])) ? $args['image_class'] : '';

$html_view = (isset($args['view'])) ? $args['view'] : '';
?>


<?php switch ($html_view) {
    case 'archive': ?>
        <article id="post-<?php the_ID(); ?>" class="<?php echo $column_class ?>">

            <a href="<?php echo esc_url(get_permalink()); ?>" class="list-item">
                <div class="card p-0 border-0 overflow-hidden">
                    <div class="row g-0">

                        <div class="col-md-4 col-sm-4 col-4">
                            <div class="post-image rounded overflow-hidden <?php echo $img_class ?>">
                                <?php
                                if ($thumbnail_html) {
                                    echo $thumbnail_html;
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-8 col-8 d-flex flex-column justify-content-center">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title  fs-6 lh-sm fw-bold">
                                    <?php echo esc_html($title); ?>
                                </h5>
                                <p class="card-text m-0  opacity-50 fs-6 lh-1">
                                    <?php echo esc_html($author_name); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </article>

        <?php
        break;

    case 'slider': ?>
        <swiper-slide>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="list-item">
                <div class="card p-0 border-0 overflow-hidden bg-transparent">
                    <div class="row g-0">

                        <div class="col-md-4 col-sm-4 col-4">
                            <div class="post-image rounded overflow-hidden <?php echo $img_class ?>">
                                <?php
                                if ($thumbnail_html) {
                                    echo $thumbnail_html;
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-8 col-8 d-flex flex-column justify-content-center">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="card-title  fs-6 lh-sm fw-bold">
                                    <?php echo esc_html($title); ?>
                                </h5>
                                <p class="card-text m-0  opacity-50 fs-6 lh-1">
                                    <?php echo esc_html($author_name); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </swiper-slide>

        <?php
        break;
} ?>