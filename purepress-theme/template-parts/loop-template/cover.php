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
            <a href="<?php echo esc_url(get_permalink()); ?>" class="cover-item">
                <div class="card border-0 overflow-hidden">
                    <div class="post-image <?php echo $img_class ?>">
                        <?php
                        if ($thumbnail_html) {
                            echo $thumbnail_html;
                        }
                        ?>
                    </div>
                    <div class="card-img-overlay card-overlay d-flex flex-column justify-content-between">

                        <p><span class="badge text-bg-light">
                                <?php echo esc_html($cat_name); ?>
                            </span></p>

                        <div class="card-info">
                            <p class="card-text m-0 text-light fs-6">
                                <?php echo esc_html($author_name); ?>
                            </p>
                            <h5 class="card-title text-light fs-6">
                                <?php echo esc_html($title); ?>
                            </h5>
                        </div>

                    </div>
                </div>
            </a>
        </article>

        <?php
        break;

    case 'slider': ?>
        <swiper-slide>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="cover-item">
                <div class="card border-0 overflow-hidden">
                    <div class="post-image <?php echo $img_class ?>">
                        <?php
                        if ($thumbnail_html) {
                            echo $thumbnail_html;
                        }
                        ?>
                    </div>
                    <div class="card-img-overlay card-overlay d-flex flex-column justify-content-between">

                        <p><span class="badge text-bg-light">
                                <?php echo esc_html($cat_name); ?>
                            </span></p>

                        <div class="card-info">
                            <p class="card-text m-0 text-light fs-6">
                                <?php echo esc_html($author_name); ?>
                            </p>
                            <h5 class="card-title text-light fs-6">
                                <?php echo esc_html($title); ?>
                            </h5>
                        </div>

                    </div>
                </div>
            </a>
        </swiper-slide>

        <?php
        break;
} ?>