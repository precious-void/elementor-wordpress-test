<?php

namespace TwentyTwentyChild\Admin\Abstracts;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

abstract class Field
{
    /**
     * id attribute 
     * @var string
     */
    protected $id = '';

    /**
     * name attribute 
     * @var string
     */
    protected $name = '';

    /**
     * type attribute 
     * @var string
     */
    protected static $type = 'text';

    /**
     * value key attribute 
     * @var string
     */
    protected static $value_key = 'value';


    /**
     * Value of the input 
     * @var string
     */
    protected $value = '';

    /**
     * Label
     * @var string
     */
    protected $label = '';

    /**
     * All the attributes
     * @var array
     */
    protected $attributes = [];


    public function __construct($id, $name, $label = '', $additional_attributes = [])
    {
        $this->id           = $id;
        $this->name         = $name;
        $this->label       = $label;
        $this->set_value();

        $this->attributes   = array_merge($additional_attributes, [
            'id'    => $this->id,
            'name'  => $this->name,
            static::$value_key => $this->value,
            'type'  => static::$type,
        ]);

        add_action('the_content', [$this, 'set_value']);
        add_action('save_post', [$this, 'save_field']);
    }

    public function set_value()
    {
        global $post;
        $this->value = get_post_meta($post->ID, $this->name, true);
        $this->attributes[static::$value_key] = $this->value;
    }

    /**
     * Gets html of the Field
     * @return string
     */
    abstract public function get_html();

    /**
     * Sets the type of the input
     * @param string $type
     * @return void
     */
    public function set_type($type)
    {
        $this->attributes['type'] = $type;
    }

    /**
     * Get value of input
     * @return string
     */
    public function get_value()
    {
        return $this->value;
    }


    public function get_input_html()
    {
        $attrs = $this->attributes;

        if (isset($attrs[static::$value_key]) && is_string($attrs[static::$value_key])) {
            $attrs[static::$value_key] = htmlspecialchars($attrs[static::$value_key]);
        }

        return sprintf('<input %s/>', $this->escape_attributes($attrs));
    }

    /**
     * escape html attribites and converts 
     * @param array $attrs
     * @return string
     */
    private function escape_attributes($attrs)
    {
        $html = '';

        foreach ($attrs as $k => $v) {
            if ($k === "checked") {
                if (!$v) continue;
                $v = "checked";
            } elseif ($k !== 'value') {
                $v = trim($v);
            }
            $html .= sprintf(' %s="%s"', esc_attr($k), esc_attr($v));
        }

        return trim($html);
    }

    /**
     * Pre save check if we are in inline mode or not
     * @param int $post_id
     * @return void
     */
    public function save_field($post_id)
    {
        if (isset($_POST['action']) && $_POST['action'] === 'inline-save') return $post_id;
        $this->on_save($post_id);
    }

    /**
     * Save function
     * @param int $post_id
     * @return int
     */
    abstract public function on_save($post_id);
}
