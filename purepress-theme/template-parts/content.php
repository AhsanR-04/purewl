<?php
/**
 * Template part for displaying posts
 */

$category = get_the_category()[0];
$cat_link = get_category_link($category);
$cat_name = $category->name;
$post_id = get_the_ID();
$thumbnail_id = get_post_thumbnail_id($post_id);
$thumbnail_html = wp_get_attachment_image($thumbnail_id, 'medium_large');
$title = get_the_title();
$author_name = get_the_author_meta('display_name'); // Get the author's display name
?>

<article id="post-<?php the_ID(); ?>" class="col-lg-4 col-md-6 col-12 mb-4">
    <a href="<?php echo esc_url(get_permalink()); ?>" class="cover-item">
        <div class="card border-0 overflow-hidden">
            <div class="post-image aspect_ratio_16">
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
                    <p class="card-text m-0 text-light fs-6 text-capitalize">
                        By <?php echo esc_html($author_name); ?>
                    </p>
                    <div class="card-title text-light fs-5 fw-bold">
                        <?php echo esc_html($title); ?>
                    </div>
                </div>

            </div>
        </div>
    </a>
</article><!-- #post-<?php the_ID(); ?> -->