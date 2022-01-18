<?php

namespace TwentyTwentyChild\Modules;

class Product_Shortcode
{
    public function __construct()
    {
        add_shortcode('product', [$this, 'product_shortcode']);
    }

    public function product_shortcode($atts)
    {
        $a = shortcode_atts(array(
            'id' => 0,
            'bg_color' => '#fff',
        ), $atts);

        if ($a['id'] > 0) {
            $product = new Product((int) $a['id']);
            echo get_template_part('template-parts/product/item', null, [
                'is_short_code' => true,
                'product' => $product,
                'bg_color' => $a['bg_color']
            ]);
        }
    }
}
