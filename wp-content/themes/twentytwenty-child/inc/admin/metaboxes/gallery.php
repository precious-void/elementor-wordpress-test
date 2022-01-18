<?php

namespace TwentyTwentyChild\Admin\Metaboxes;

use TwentyTwentyChild\Admin\Abstracts\Meta_Box as Meta_Box;
use TwentyTwentyChild\Admin\Fields\Text_Field;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Gallery extends Meta_Box
{
    public function set_fields()
    {
        $field = new Text_Field('product_image_gallery', 'product_gallery', '');
        $field->set_type('hidden');

        $this->fields = [$field];
    }

    public function enqueue_meta_box_scripts()
    {
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-sortable');

        if (!did_action('wp_enqueue_media'))
            wp_enqueue_media();

        wp_enqueue_script('gallery-box-scripts', THEME_ASSETS . '/gallery-box.js', array('jquery', 'jquery-ui-sortable'));
    }

    public function meta_box_injection($args)
    {
        global $post;

        $field = $this->get_fields()[0];
        $images = $this->get_gallery_images($field->get_value());

        ob_start();
        include __DIR__ . '/views/gallery-meta-box.php';
        $html_content = ob_get_clean();

        echo $html_content;
    }

    private function get_gallery_images($value)
    {
        return get_posts(array(
            'post_type' => 'attachment',
            'orderby' => 'post__in',
            'order' => 'ASC',
            'post__in' => explode(',', $value),
            'numberposts' => -1,
            'post_mime_type' => 'image'
        ));
    }
}
