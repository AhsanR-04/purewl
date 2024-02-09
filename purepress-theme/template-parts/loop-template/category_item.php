<?php
/**
 * Template part for displaying loop posts
 */

$column_class = (isset($args['class'])) ? $args['class'] : '';
$html_view = (isset($args['view'])) ? $args['view'] : '';

$category = get_category_by_slug($category_slug);
?>


<?php switch ($html_view) {
    case 'archive': ?>
        <div class="<?php echo $column_class ?>">
            <div class="card bg-body-tertiary border-0 mb-3">
                <div class="category-item"><?php $category->name ?></div>
            </div>
        </div>

        <?php
        break;

    case 'slider': ?>
        <swiper-slide>
            <div class="cat-item">
                <div class="card bg-body-tertiary border-0 mb-3">
                    <div class="card-body">
                        <a class="card-text m-0 text-dark d-block fs-6 lh-1" href="<?php echo esc_html($cat_link); ?>">
                            <?php echo esc_html($cat_name); ?>
                        </a>
                    </div>
                </div>
            </div>
        </swiper-slide>
        <?php
        break;
} ?>