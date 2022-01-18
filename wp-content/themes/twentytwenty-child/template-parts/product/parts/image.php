<?php
if (has_post_thumbnail() && !post_password_required()) {

    $featured_media_inner_classes = '';

    // Make the featured media thinner on archive pages.
    if (!is_singular()) {
        $featured_media_inner_classes .= ' medium';
    }
?>

    <figure class="featured-media">
        <div class="featured-media-inner section-inner<?php echo $featured_media_inner_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output 
                                                        ?>">
            <?php
            the_post_thumbnail();
            ?>
        </div><!-- .featured-media-inner -->
    </figure><!-- .featured-media -->

<?php
}
