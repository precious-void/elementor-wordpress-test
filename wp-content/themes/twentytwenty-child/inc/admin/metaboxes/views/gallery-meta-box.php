<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<div id="product_images_container">
    <ul class="product_images">
        <?php
        $hidden = array();
        if (!empty($images)) {
            foreach ($images as $image) {
                $attachment_id = $image->ID;
                $attachment = wp_get_attachment_image($attachment_id, 'thumbnail');
                $hidden[] = $attachment_id;
        ?>
                <li class="image" data-attachment_id="<?php echo esc_attr($attachment_id); ?>">
                    <?php echo $attachment; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                    ?>
                    <ul class="actions">
                        <li>
                            <a href="#" class="delete tips" data-tip="<?php esc_attr_e('Delete image', 'woocommerce'); ?>"><?php esc_html_e('Delete', THEME_SLUG); ?></a>
                        </li>
                    </ul>
                    <?php
                    ?>
                </li>
        <?php
            }
        }
        ?>
    </ul>
    <div class="error"></div>
    <div style="clear:both"></div>
</div>

<?php
echo $field->get_html();
?>

<p class="add_product_images hide-if-no-js">
    <a href="#" data-choose="<?php esc_attr_e('Add images to product gallery', 'woocommerce'); ?>" data-update="<?php esc_attr_e('Add to gallery', 'woocommerce'); ?>" data-delete="<?php esc_attr_e('Delete image', 'woocommerce'); ?>" data-text="<?php esc_attr_e('Delete', 'woocommerce'); ?>"><?php esc_html_e('Add product gallery images', 'woocommerce'); ?></a>
</p>