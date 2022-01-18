<?php
$product = $args['product'];
?>
<a href="<?php echo get_permalink(); ?>" <?php post_class('product'); ?> id="post-<?php the_ID(); ?>">
    <?php
    if ($product->is_on_sale()) echo '<div class="product__badge">ON SALE!!!</div>';

    get_template_part('template-parts/product/parts/image', null, ['product' => $product]);
    get_template_part('template-parts/product/parts/title', null, ['product' => $product]);
    get_template_part('template-parts/product/parts/price', null, ['product' => $product]);
    ?>

</a><!-- .post -->