<?php
the_content();
$product = $args['product'];
$youtube_link_id = $product->get_youtube_link_id();
if (!empty($youtube_link)) {
    get_template_part('template-parts/product/parts/video', null, ['product' => $product]);
}
