<?php
$product = $args['product'];
echo $product->get_description();
$youtube_link_id = $product->get_youtube_link_id();
if (!empty($youtube_link_id)) {
    get_template_part('template-parts/product/parts/video', null, ['youtube_link_id' => $youtube_link_id]);
}
