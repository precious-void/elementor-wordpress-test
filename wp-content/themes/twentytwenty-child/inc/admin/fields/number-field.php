<?php

namespace TwentyTwentyChild\Admin\Fields;

use TwentyTwentyChild\Admin\Abstracts\Field as Field;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Number_Field extends Field
{
    protected static $type = 'number';

    public function get_html()
    {
        $html = '<div class="input-wrapper">';

        if ($this->label) {
            $html .= '<label for="' . $this->id . '">' . $this->label . '</label>';
        }

        $html .= $this->get_input_html() . '</div>';

        return $html;
    }

    public function on_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        update_post_meta($post_id, $this->name, (int) $_POST[$this->name]);

        return $post_id;
    }
}
