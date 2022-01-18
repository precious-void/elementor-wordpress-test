<?php
require_once __DIR__ . '/inc/theme.php';

use TwentyTwentyChild\Modules\Product;

function test_product_shortcode()
{
    $args = array(
        'post_type' => 'products',
        'order' => 'ASC',
        'posts_per_page' => 1,
    );
    $query = new WP_Query($args);
    $product = new Product($query->posts[0]);

    echo '<h2>Shortcode test</h2>';
    do_shortcode('[product id="' . $product->get_id() . '" bg_color="#eee"]');
    echo '<hr>';
}


add_filter("theme_product_shortcode_output", "modify_shortcode_output");
function modify_shortcode_output($html)
{
    $html .= "<button>Click me</button>";
    return $html;
}
