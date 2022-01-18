<?php

namespace TwentyTwentyChild\Modules;

class Product_Shortcode
{
    public function __construct()
    {
        add_shortcode('product', [$this, 'shortcode_injector']);
    }

    public function shortcode_injector($atts)
    {
        $html = apply_filters("theme_product_shortcode_output", $this->get_shortcode_output($atts));
        echo $html;
    }

    public function get_shortcode_output($atts)
    {
        $a = shortcode_atts(array(
            'id' => 0,
            'bg_color' => '#fff',
        ), $atts);

        if ($a['id'] > 0) {
            $product = new Product((int) $a['id']);
            return get_template_part('template-parts/product/item', null, [
                'is_short_code' => true,
                'product' => $product,
                'bg_color' => $a['bg_color']
            ]);
        }

        return "";
    }
}
