<?php
$product = $args['product'];

if (has_post_thumbnail() && !post_password_required()) {

    $featured_media_inner_classes = '';

    // Make the featured media thinner on archive pages.
    if (!is_singular()) {
        $featured_media_inner_classes .= ' medium';
    }
    $images = $product->get_gallery();
?>
    <div class="single-product__gallery">
        <div class="main-image">
            <?php the_post_thumbnail(); ?>
        </div>
        <?php
        foreach ($images as $image) {
            echo '<div>' . wp_get_attachment_image($image->ID, 'thumbnail') . '</div>';
        }
        ?>
    </div>
<?php
}
