<?php
$product = $args['product'];
$bg_color = $args['bg_color'];
$is_short_code = $args['is_short_code'];

$classes = ['product'];
if ($is_short_code) array_push($classes, 'product-shortcode');
?>

<a href="<?php echo get_permalink(); ?>" <?php post_class($classes); ?> id="post-<?php the_ID(); ?>" <?php echo $bg_color ? ('style="background: ' . esc_attr($bg_color) . '"') : '' ?>>
    <?php
    if (!$is_short_code && $product->is_on_sale()) echo '<div class="product__badge">ON SALE!!!</div>';

    get_template_part('template-parts/product/parts/image', null, ['product' => $product]);
    get_template_part('template-parts/product/parts/title', null, ['product' => $product]);
    get_template_part('template-parts/product/parts/price', null, ['product' => $product]);
    ?>

</a><!-- .post -->