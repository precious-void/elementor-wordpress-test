<?php

namespace TwentyTwentyChild\Admin\Fields;

use TwentyTwentyChild\Admin\Abstracts\Field as Field;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Checkbox_Field extends Field
{
    protected static $value_key = 'checked';
    protected static $type = 'checkbox';

    public function get_html()
    {
        $html = '<div class="input-wrapper" style="flex-direction: row;">' . $this->get_input_html();
        if ($this->label) {
            $html .= '<label for="' . $this->id . '">' . $this->label . '</label>';
        }
        $html .=  '</div>';
        return $html;
    }

    public function on_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        update_post_meta($post_id, $this->name, $_POST[$this->name] === 'on' ? 1 : 0);

        return $post_id;
    }
}
