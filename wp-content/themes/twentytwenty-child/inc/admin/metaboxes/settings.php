<?php

namespace TwentyTwentyChild\Admin\Metaboxes;

use TwentyTwentyChild\Admin\Abstracts\Meta_Box as Meta_Box;
use TwentyTwentyChild\Admin\Fields\Number_Field;
use TwentyTwentyChild\Admin\Fields\Checkbox_Field;
use TwentyTwentyChild\Admin\Fields\Link_Field;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Settings extends Meta_Box
{
    public function set_fields()
    {
        $this->fields = [
            new Number_Field('product_price', 'product_price', 'Price', ['required' => true]),
            new Number_Field('product_sale_price', 'product_sale_price',  'Sale Price', ['required' => true]),
            new Checkbox_Field('product_is_on_sale', 'product_is_on_sale',  'Is on sale', ['required' => true]),
            new Link_Field('product_youtube_link', 'product_youtube_link', 'YouTube link', ['required' => true]),
        ];
    }

    public function enqueue_meta_box_scripts()
    {
        wp_enqueue_script('settings-box-scripts', THEME_ASSETS . '/settings-box.js', array('jquery'));
    }

    public function meta_box_injection($args)
    {
        foreach ($this->fields as $field) {
            echo $field->get_html();
        }
    }
}
